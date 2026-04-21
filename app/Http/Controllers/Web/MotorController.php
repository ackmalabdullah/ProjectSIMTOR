<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motor;
use Illuminate\Support\Facades\Storage;

class MotorController extends Controller
{
    public function index()
    {
        $motor = Motor::latest()->get();
        return view('motor.index', compact('motor'));
    }

    public function create()
    {
        return view('motor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mpm' => 'required',
            'nama_motor' => 'required',
            'merk' => 'required',
            'tipe' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // upload gambar
        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('motor', 'public');
        }

        Motor::create([
            'kode_mpm' => $request->kode_mpm,
            'nama_motor' => $request->nama_motor,
            'merk' => $request->merk,
            'tipe' => $request->tipe,
            'harga' => $request->harga,
            'gambar' => $gambar,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        return redirect()->route('motor.index')->with('success', 'Motor berhasil ditambah');
    }

    public function show(string $id)
    {
        $motor = Motor::findOrFail($id);
        return view('motor.show', compact('motor'));
    }

    public function edit(string $id)
    {
        $motor = Motor::findOrFail($id);
        return view('motor.edit', compact('motor'));
    }

    public function update(Request $request, string $id)
    {
        $motor = Motor::findOrFail($id);

        $request->validate([
            'kode_mpm' => 'required',
            'nama_motor' => 'required',
            'merk' => 'required',
            'tipe' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // cek kalau upload gambar baru
        if ($request->hasFile('gambar')) {

            // hapus gambar lama
            if ($motor->gambar) {
                Storage::disk('public')->delete($motor->gambar);
            }

            // upload baru
            $gambar = $request->file('gambar')->store('motor', 'public');
        } else {
            $gambar = $motor->gambar;
        }

        $motor->update([
            'kode_mpm' => $request->kode_mpm,
            'nama_motor' => $request->nama_motor,
            'merk' => $request->merk,
            'tipe' => $request->tipe,
            'harga' => $request->harga,
            'gambar' => $gambar,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        return redirect()->route('motor.index')->with('success', 'Motor berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $motor = Motor::findOrFail($id);

        // hapus gambar dari storage
        if ($motor->gambar) {
            Storage::disk('public')->delete($motor->gambar);
        }

        $motor->delete();

        return redirect()->route('motor.index')->with('success', 'Motor berhasil dihapus');
    }
}