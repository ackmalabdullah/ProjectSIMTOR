import pandas as pd
import numpy as np
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import accuracy_score, classification_report
import joblib

df = pd.read_csv('training_data.csv')

# Fix OTR yang salah (10100000 = nilai angka random, bukan OTR valid)
df = df[df['harga_otr'] > 15_000_000].copy()

# Drop baris tanpa OTR (tidak bisa hitung pct_dp)
df = df.dropna(subset=['harga_otr'])
df['pct_dp'] = df['dp'] / df['harga_otr']

print(f"Total data setelah clean: {len(df)}")
print(f"Motor unik: {df['motor'].nunique()}")

# Encode nama motor
le = LabelEncoder()
df['motor_enc'] = le.fit_transform(df['motor'])

# Fitur & target
X = df[['harga_otr', 'dp', 'pct_dp', 'cicilan', 'motor_enc']]
y = df['tenor']

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

model = RandomForestClassifier(n_estimators=100, random_state=42, n_jobs=-1)
model.fit(X_train, y_train)

y_pred = model.predict(X_test)
acc = accuracy_score(y_test, y_pred)
print(f"\nAkurasi model: {acc:.4f} ({acc*100:.1f}%)")
print("\nDetail per tenor:")
print(classification_report(y_test, y_pred))

# Simpan model
joblib.dump(model, 'model_tenor.pkl')
joblib.dump(le, 'label_encoder.pkl')
df[['motor']].drop_duplicates().sort_values('motor').to_csv('daftar_motor.csv', index=False)

print("\nModel disimpan: model_tenor.pkl, label_encoder.pkl")
