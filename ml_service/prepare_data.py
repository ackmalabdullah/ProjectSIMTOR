import pandas as pd
import numpy as np

xl = pd.read_excel('data_motor.xlsx', sheet_name=None)

# Semua nilai tenor yang mungkin muncul di Excel ini
VALID_TENORS = {11,12,17,18,23,24,29,30,35,36,47,48,59,60}

# Mapping tenor non-standar (motor listrik pakai 11,17,23,29,35,47,59)
# ke tenor standar terdekat agar konsisten
TENOR_NORMALIZE = {11:12, 17:18, 23:24, 29:30, 35:36, 47:48, 59:60}

def detect_dp_col(cols):
    """Cari kolom DP dari berbagai nama yang mungkin muncul."""
    candidates = ['DP', 'DP GROSS', 'UANG']
    for cand in candidates:
        for c in cols:
            cs = str(c).strip().upper()
            if cs == cand:
                return c
    # fallback: kolom yang mengandung 'DP' tapi bukan '%DP'
    for c in cols:
        cs = str(c).strip().upper()
        if 'DP' in cs and '%' not in cs and 'MUKA' not in cs:
            return c
    return None

def get_harga_otr(df, motor_name):
    """Cari harga OTR: dari kolom pertama atau dari baris OTR sheet."""
    # Cek kolom pertama (pola umum)
    for val in df.iloc[:, 0]:
        if isinstance(val, (int, float)) and not np.isnan(float(val)):
            if 10_000_000 < val < 200_000_000:
                return float(val)
    # Cek kolom ke-2 (pola Sonic/Supercub - OTR ada di kolom Unnamed:0 baris ke-2)
    for val in df.iloc[:, 1]:
        if isinstance(val, (int, float)) and not np.isnan(float(val)):
            if 10_000_000 < val < 200_000_000:
                return float(val)
    return None

rows = []
success = []
failed = []

for sheet_name, df in xl.items():
    if df.empty or df.shape[0] < 2:
        failed.append((sheet_name, 'kosong'))
        continue

    cols = df.columns.tolist()
    motor_name = sheet_name.strip()

    # --- Deteksi kolom DP ---
    dp_col = detect_dp_col(cols)
    if dp_col is None:
        # Coba pola Sonic/Supercub: header ada di row 0, DP di row 1+
        row0 = df.iloc[0].tolist()
        if 'DP' in [str(v).strip().upper() for v in row0]:
            # Rebuild dengan row 1 sebagai data mulai
            dp_col_idx = [str(v).strip().upper() for v in row0].index('DP')
            dp_col = cols[dp_col_idx]
        else:
            failed.append((sheet_name, 'tidak ada kolom DP'))
            continue

    # --- Deteksi kolom tenor ---
    # Cek di row 0 dulu (pola umum)
    header_row = df.iloc[0]
    tenor_cols = {}
    for col, val in header_row.items():
        try:
            v = int(val)
            if v in VALID_TENORS:
                tenor_cols[col] = TENOR_NORMALIZE.get(v, v)
        except (ValueError, TypeError):
            pass

    # Jika tidak ketemu, cek di row 1 (pola Sonic/Supercub)
    if not tenor_cols:
        header_row2 = df.iloc[1]
        for col, val in header_row2.items():
            try:
                v = int(val)
                if v in VALID_TENORS:
                    tenor_cols[col] = TENOR_NORMALIZE.get(v, v)
            except (ValueError, TypeError):
                pass
        data_start = 2  # data mulai baris ke-2
    else:
        data_start = 1  # data mulai baris ke-1

    if not tenor_cols:
        failed.append((sheet_name, 'tidak ada kolom tenor'))
        continue

    # --- Cari harga OTR ---
    harga_otr = get_harga_otr(df, motor_name)

    # --- Ekstrak data ---
    count = 0
    for _, row in df.iloc[data_start:].iterrows():
        try:
            dp = float(row[dp_col])
        except (ValueError, TypeError):
            continue
        if np.isnan(dp) or dp <= 0:
            continue

        for col, tenor in tenor_cols.items():
            try:
                cicilan = float(row[col])
            except (ValueError, TypeError):
                continue
            if np.isnan(cicilan) or cicilan <= 0:
                continue

            rows.append({
                'motor': motor_name,
                'harga_otr': harga_otr,
                'dp': dp,
                'pct_dp': round(dp / harga_otr, 4) if harga_otr else None,
                'tenor': tenor,
                'cicilan': cicilan
            })
            count += 1

    if count > 0:
        success.append(f"✅ {motor_name[:40]:40s} | OTR={harga_otr} | {count} baris | tenor={sorted(set(tenor_cols.values()))}")
    else:
        failed.append((sheet_name, 'tidak ada data valid'))

# --- Simpan CSV ---
df_out = pd.DataFrame(rows)
df_out.to_csv('training_data.csv', index=False)

print(f"{'='*60}")
print(f"BERHASIL: {len(success)} sheet | Total baris: {len(rows)}")
print(f"{'='*60}")
for s in success:
    print(s)

print(f"\nGAGAL/SKIP: {len(failed)} sheet")
for name, reason in failed:
    print(f"  ❌ {name.strip()[:40]:40s} -> {reason}")

print(f"\nFile disimpan: training_data.csv")
print(df_out.head(3).to_string())
print(f"\nMotor unik: {df_out['motor'].nunique()}")
print(f"Tenor tersedia: {sorted(df_out['tenor'].unique())}")
