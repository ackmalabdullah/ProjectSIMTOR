import joblib
import pandas as pd

df = joblib.load("model/data_motor.pkl")

pd.set_option('display.max_columns', None)
pd.set_option('display.max_rows', None)
pd.set_option('display.width', None)

print(df)