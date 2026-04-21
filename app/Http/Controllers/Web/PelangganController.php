<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;  // Langsung pakai DB

class PelangganController extends Controller
{
    public function index()
    {
        // Sesuaikan 'nama_tabel_pelanggan' dengan tabel sebenarnya
        $pelanggan = DB::table('nama_tabel_pelanggan')->paginate(15);
        return view('pelanggan.index', compact('pelanggan'));
    }
}