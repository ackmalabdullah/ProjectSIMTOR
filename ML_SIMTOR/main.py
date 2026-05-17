
# ─────────────────────────────────────────────────────────────────────────────
# main.py — FastAPI Backend Sistem Rekomendasi Tenor Motor
# Install: pip install fastapi uvicorn joblib pandas scikit-learn openpyxl
# Run    : uvicorn main:app --reload
# ─────────────────────────────────────────────────────────────────────────────

from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel, Field, validator
from typing import Optional
import pandas as pd
import joblib
import os

app = FastAPI(
    title="Sistem Rekomendasi Tenor Motor",
    description="API rekomendasi tenor cicilan sepeda motor (konvensional & listrik)",
    version="2.0.0"
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"]
)

MODEL_DIR    = "model"
model        = joblib.load(f"{MODEL_DIR}/rf_tenor_motor.pkl")
encoder      = joblib.load(f"{MODEL_DIR}/label_encoder.pkl")
df_motor     = joblib.load(f"{MODEL_DIR}/data_motor.pkl")
cicilan_dict = joblib.load(f"{MODEL_DIR}/cicilan_dict.pkl")


def cari_sheet_cicilan(nama_motor, cicilan_dict):
    nama_lower = str(nama_motor).strip().lower()
    for key in cicilan_dict:
        if key.strip().lower() == nama_lower:
            return key
    for key in cicilan_dict:
        if nama_lower in key.strip().lower() or key.strip().lower() in nama_lower:
            return key
    return None


class PrediksiRequest(BaseModel):
    nama_motor : str
    penghasilan: float = Field(..., ge=500_000)
    dp_persen  : float = Field(..., ge=10, le=60)


class PrediksiResponse(BaseModel):
    motor              : str
    harga_otr          : int
    penghasilan        : int
    dp_nominal         : int
    tenor_rekomendasi  : int
    cicilan_per_bulan  : int
    persen_dari_gaji   : float
    kategori_motor     : str
    is_electric        : bool
    label_tenor        : str
    status_kelayakan   : str


@app.get("/motors")
def daftar_motor():
    motors = df_motor[["nama_motor", "harga_otr", "kategori_motor", "is_electric"]].to_dict("records")
    return {"total": len(motors), "motors": motors}


@app.post("/predict", response_model=PrediksiResponse)
def predict_tenor(req: PrediksiRequest):
    rows = df_motor[
        df_motor["nama_motor"].str.lower().str.contains(req.nama_motor.strip().lower(), na=False)
    ]
    if rows.empty:
        raise HTTPException(status_code=404, detail=f"Motor '{req.nama_motor}' tidak ditemukan")

    row         = rows.iloc[0]
    harga       = float(row["harga_otr"])
    kategori    = row["kategori_motor"]
    is_electric = bool(row["is_electric"])
    kat_enc     = encoder.transform([kategori])[0]

    dp_nominal = round((harga * (req.dp_persen / 100)) / 100_000) * 100_000
    dp_nominal = max(dp_nominal, 1_000_000)
    rasio      = harga / req.penghasilan
    pokok      = harga - dp_nominal

    sheet_key  = cari_sheet_cicilan(row["nama_motor"], cicilan_dict)
    sheet_data = cicilan_dict.get(sheet_key) if sheet_key else None

    X_input = pd.DataFrame([{
        "harga_otr"          : harga,
        "penghasilan"        : req.penghasilan,
        "dp_persen"          : req.dp_persen,
        "dp_nominal"         : dp_nominal,
        "rasio_harga_gaji"   : rasio,
        "estimasi_cicilan"   : (pokok + pokok * 0.011 * 24) / 24,
        "kategori_motor_enc" : kat_enc,
        "is_electric"        : int(is_electric)
    }])

    tenor = int(model.predict(X_input)[0])

    cicilan = None
    if sheet_data and sheet_data["rows"]:
        closest = min(sheet_data["rows"], key=lambda r: abs(r["dp"] - dp_nominal))
        cicilan = closest["cicilans"].get(tenor)
    if not cicilan:
        cicilan = round((pokok + pokok * 0.011 * tenor) / tenor)

    pct = round(cicilan / req.penghasilan * 100, 1)
    if pct <= 30:
        status = "LAYAK"
    else:
        status = "TIDAK LAYAK"
    label = "T.O.P" if is_electric else "Tenor"

    return PrediksiResponse(
        motor=row["nama_motor"],
        harga_otr=int(harga),
        penghasilan=int(req.penghasilan),
        dp_nominal=int(dp_nominal),
        tenor_rekomendasi=tenor,
        cicilan_per_bulan=int(cicilan),
        persen_dari_gaji=pct,
        kategori_motor=kategori,
        is_electric=is_electric,
        label_tenor=label,
        status_kelayakan=status
    )

@app.get("/")
def root():
    return {"message": "Sistem Rekomendasi Tenor Motor API v2.0", "docs": "/docs"}
