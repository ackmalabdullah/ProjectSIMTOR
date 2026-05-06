<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Menampilkan daftar pelanggan dari collection 'users' (MongoDB).
     * Hanya menampilkan user dengan role 'user' (bukan admin).
     */
    public function index(Request $request)
    {
        $query = Users::where('role', 'user');

        // Search filter (opsional, dari query string ?search=...)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        $pelanggan = $query->orderBy('created_at', 'desc')->get();

        return view('pelanggan.index', compact('pelanggan'));
    }
}