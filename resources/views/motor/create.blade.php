@extends('layouts.app')

@section('title', 'Tambah Motor')

@section('content')
<div class="pagetitle">
    <h1>Tambah Motor</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Form Tambah Motor</h5>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('motor.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Kode MPM</label>
                    <input type="text" name="kode_mpm" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Motor</label>
                    <input type="text" name="nama_motor" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Merk</label>
                    <input type="text" name="merk" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipe</label>
                    <input type="text" name="tipe" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Motor</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Simpan Motor</button>
                <a href="{{ route('motor.index') }}" class="btn btn-secondary">Batal</a>

            </form>
        </div>
    </div>
</section>
@endsection