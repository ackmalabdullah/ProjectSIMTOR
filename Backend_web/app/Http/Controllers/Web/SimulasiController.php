<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Simulasi; // Pastikan model sudah dibuat

class SimulasiController extends Controller
{
    public function index()
    {
        // Contoh data dummy untuk simulasi
        $simulasis = [
            (object)[
                'id_simulasi' => 'SIM-001',
                'nama' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'motor' => 'Honda Vario 125',
                'harga' => 22500000,
                'dp' => 3000000
            ],
            (object)[
                'id_simulasi' => 'SIM-002',
                'nama' => 'Siti Rahayu',
                'email' => 'siti@gmail.com',
                'motor' => 'Honda Beat Street',
                'harga' => 18900000,
                'dp' => 2500000
            ],
        ];

        return view('simulasi.index', compact('simulasis'));
    }

    public function show($id)
    {
        // Logika untuk mengambil detail data berdasarkan ID
        return view('simulasi.detail');
    }
}