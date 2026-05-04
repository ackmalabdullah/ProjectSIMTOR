<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    //// ================= SINGLE SOURCE DATA =================
    public function getData()
    {
        return [
            ['id'=>1,'nama'=>'Budi Santoso','motor'=>'Honda Beat','gaji'=>5000000,'keluar'=>2500000,'tenor'=>24,'status'=>'Approved'],
            ['id'=>2,'nama'=>'Siti Aminah','motor'=>'Honda Vario 125','gaji'=>3200000,'keluar'=>2800000,'tenor'=>36,'status'=>'Approved'],
            ['id'=>3,'nama'=>'Joko Widodo','motor'=>'Honda PCX 160','gaji'=>8500000,'keluar'=>3000000,'tenor'=>12,'status'=>'Approved'],
            ['id'=>4,'nama'=>'Rina Kusuma','motor'=>'Honda Genio','gaji'=>4100000,'keluar'=>3200000,'tenor'=>36,'status'=>'Pending'],
        ];
    }

    // ================= HALAMAN UTAMA =================
    public function index()
    {
        return view('rekomendasi.index');
    }

    // ================= DATA BERDASARKAN TENOR =================
    public function getByTenor($tenor)
    {
        $data = collect($this->getData())
            ->where('tenor', (int)$tenor)
            ->values();

        return response()->json([
            'tenor' => (int)$tenor,
            'total' => $data->count(),
            'data'  => $data
        ]);
    }

    // ================= EXPORT SEMUA =================
    public function export()
    {
        $data = $this->getData();

        $filename = "rekomendasi_semua.csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID','Nama','Motor','Gaji','Pengeluaran','Tenor','Status']);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row['id'],
                    $row['nama'],
                    $row['motor'],
                    $row['gaji'],
                    $row['keluar'],
                    $row['tenor'],
                    $row['status']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ================= EXPORT BERDASARKAN TENOR =================
    public function exportByTenor($tenor)
    {
        if (!in_array($tenor, ['12','24','36'])) {
            return abort(400, 'Tenor tidak valid');
        }

        $data = collect($this->getData())
            ->where('tenor', (int)$tenor)
            ->values();

        $filename = "rekomendasi_tenor_{$tenor}.csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID','Nama','Motor','Gaji','Pengeluaran','Tenor','Status']);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row['id'],
                    $row['nama'],
                    $row['motor'],
                    $row['gaji'],
                    $row['keluar'],
                    $row['tenor'],
                    $row['status']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ================= DETAIL USER =================
    public function show($id)
    {
        $data = collect($this->getData())->keyBy('id');

        if (!isset($data[$id])) {
            return response()->json([
                'error' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json($data[$id]);
    }
}
