<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SimulasiKredit;
use App\Models\Motor;

class SimulasiController extends Controller
{
    // 🔥 SIMPAN RIWAYAT
    public function simpan(Request $request)
    {
        try {

            $user = auth()->user();

            $simulasi = SimulasiKredit::create([

                'user_id' => (string) $user->_id,
                'nama_user' => $user->nama,

                'motor_id' => $request->motor_id,
                'nama_motor' => $request->nama_motor,

                'harga_motor' => $request->harga_motor,

                'penghasilan' => $request->penghasilan,

                'dp_persen' => $request->dp_persen,
                'dp_nominal' => $request->dp_nominal,

                'tenor' => $request->tenor,

                'cicilan_per_bulan' => $request->cicilan_per_bulan,

                'persen_gaji' => $request->persen_gaji,

                'status_kelayakan' => $request->status_kelayakan,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Riwayat simulasi berhasil disimpan',
                'data' => $simulasi
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function riwayat()
    {
        try {

            $user = auth()->user();

            $data = SimulasiKredit::where(
                'user_id',
                (string) $user->_id
            )
                ->latest()
                ->get();

            foreach ($data as $item) {

                $motor = Motor::find($item->motor_id);

                $item->gambar = $motor && $motor->gambar
                    ? asset('storage/' . $motor->gambar)
                    : null;
            }

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
