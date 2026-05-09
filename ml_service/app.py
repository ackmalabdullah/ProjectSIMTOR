from flask import Flask, request, jsonify
import pandas as pd
import joblib
import numpy as np

app = Flask(__name__)

# Load model dan data
model = joblib.load('model_tenor.pkl')
le    = joblib.load('label_encoder.pkl')
df_all = pd.read_csv('training_data.csv')

# Hanya pakai data dengan OTR valid
df_all = df_all[df_all['harga_otr'] > 15_000_000].copy()

@app.route('/motor', methods=['GET'])
def daftar_motor():
    """Endpoint: daftar semua motor yang tersedia."""
    motors = sorted(df_all['motor'].unique().tolist())
    return jsonify({'motor': motors, 'total': len(motors)})

@app.route('/rekomendasi', methods=['POST'])
def rekomendasi():
    """
    Endpoint utama: rekomendasi tenor berdasarkan penghasilan.
    
    Body JSON:
    {
        "motor": "NEW BEAT CBS",
        "dp": 2500000,
        "penghasilan": 5000000,
        "pengeluaran": 1000000   (opsional, default 0)
    }
    """
    data = request.get_json()

    # Validasi input
    required = ['motor', 'dp', 'penghasilan']
    for field in required:
        if field not in data:
            return jsonify({'error': f'Field wajib: {field}'}), 400

    motor      = data['motor']
    dp         = float(data['dp'])
    penghasilan = float(data['penghasilan'])
    pengeluaran = float(data.get('pengeluaran', 0))

    # Aturan 30%
    penghasilan_bersih = penghasilan - pengeluaran
    max_cicilan = penghasilan_bersih * 0.30

    # Filter data motor + dp dari tabel
    df_motor = df_all[(df_all['motor'] == motor) & (df_all['dp'] == dp)]

    if df_motor.empty:
        # Cari DP terdekat jika tidak exact match
        df_motor_all = df_all[df_all['motor'] == motor]
        if df_motor_all.empty:
            return jsonify({'error': f'Motor "{motor}" tidak ditemukan'}), 404
        dp_tersedia = df_motor_all['dp'].unique()
        dp_terdekat = dp_tersedia[np.argmin(np.abs(dp_tersedia - dp))]
        df_motor = df_all[(df_all['motor'] == motor) & (df_all['dp'] == dp_terdekat)]
        dp_info = f'DP Rp {dp:,.0f} tidak ada, dipakai DP terdekat: Rp {dp_terdekat:,.0f}'
    else:
        dp_info = None

    # Filter tenor yang cicilannya <= 30% penghasilan bersih
    df_mampu = df_motor[df_motor['cicilan'] <= max_cicilan].sort_values('tenor')
    df_tidak  = df_motor[df_motor['cicilan'] > max_cicilan].sort_values('tenor')

    # Ambil harga OTR
    harga_otr = df_motor['harga_otr'].iloc[0] if not df_motor.empty else None

    rekomendasi_list = []
    for _, row in df_mampu.iterrows():
        pct_dari_penghasilan = (row['cicilan'] / penghasilan_bersih) * 100
        rekomendasi_list.append({
            'tenor': int(row['tenor']),
            'cicilan': int(row['cicilan']),
            'pct_dari_penghasilan_bersih': round(pct_dari_penghasilan, 1),
            'status': '✅ LAYAK'
        })

    tidak_mampu_list = []
    for _, row in df_tidak.iterrows():
        selisih = int(row['cicilan'] - max_cicilan)
        tidak_mampu_list.append({
            'tenor': int(row['tenor']),
            'cicilan': int(row['cicilan']),
            'kelebihan_dari_batas': selisih,
            'status': '❌ MELEBIHI 30%'
        })

    response = {
        'motor': motor,
        'harga_otr': int(harga_otr) if harga_otr else None,
        'dp_digunakan': int(df_motor['dp'].iloc[0]) if not df_motor.empty else None,
        'penghasilan': int(penghasilan),
        'pengeluaran': int(pengeluaran),
        'penghasilan_bersih': int(penghasilan_bersih),
        'max_cicilan_30pct': int(max_cicilan),
        'rekomendasi_tenor': rekomendasi_list,
        'tenor_tidak_mampu': tidak_mampu_list,
        'kesimpulan': f'{len(rekomendasi_list)} tenor tersedia' if rekomendasi_list else 'Tidak ada tenor yang sesuai kemampuan'
    }

    if dp_info:
        response['catatan'] = dp_info

    return jsonify(response)

@app.route('/dp-tersedia', methods=['GET'])
def dp_tersedia():
    """Endpoint: daftar DP yang tersedia untuk motor tertentu."""
    motor = request.args.get('motor', '')
    df_motor = df_all[df_all['motor'] == motor]
    if df_motor.empty:
        return jsonify({'error': f'Motor tidak ditemukan'}), 404
    dp_list = sorted(df_motor['dp'].unique().tolist())
    return jsonify({
        'motor': motor,
        'harga_otr': int(df_motor['harga_otr'].iloc[0]) if pd.notna(df_motor['harga_otr'].iloc[0]) else None,
        'dp_tersedia': [int(d) for d in dp_list]
    })

if __name__ == '__main__':
    print("🚀 API Simulasi Kredit Motor aktif di http://localhost:5000")
    print("Endpoints:")
    print("  GET  /motor          -> daftar semua motor")
    print("  GET  /dp-tersedia?motor=NEW BEAT CBS -> daftar DP motor")
    print("  POST /rekomendasi    -> rekomendasi tenor")
    app.run(debug=True, host='0.0.0.0', port=5000)
