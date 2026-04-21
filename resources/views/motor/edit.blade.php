@extends('layouts.app')

@section('title', 'Edit Motor')

@section('content')
<div class="pagetitle">
    <h1>Edit Motor</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Form Edit Motor</h5>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('motor.update', $motor->_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kode MPM</label>
                    <input type="text" name="kode_mpm" class="form-control"
                        value="{{ old('kode_mpm', $motor->kode_mpm) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Motor</label>
                    <input type="text" name="nama_motor" class="form-control"
                        value="{{ old('nama_motor', $motor->nama_motor) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Merk</label>
                    <input type="text" name="merk" class="form-control"
                        value="{{ old('merk', $motor->merk) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipe</label>
                    <input type="text" name="tipe" class="form-control"
                        value="{{ old('tipe', $motor->tipe) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control"
                        value="{{ old('harga', $motor->harga) }}" required>
                </div>

                <!-- GAMBAR -->
                <div class="mb-3">
                    <label class="form-label">Gambar Motor</label>

                    @if($motor->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $motor->gambar) }}"
                                 width="120"
                                 class="img-thumbnail">
                        </div>
                    @endif

                    <input type="file" name="gambar" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $motor->deskripsi) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="tersedia" {{ $motor->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ $motor->status == 'habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update Motor</button>
                <a href="{{ route('motor.index') }}" class="btn btn-secondary">Batal</a>

            </form>
        </div>
    </div>
</section>
@endsection