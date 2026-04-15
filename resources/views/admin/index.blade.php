@extends('layouts.app')

@section('title', 'Manajemen Admin')

@section('content')
    <div class="pagetitle">
        <h1>Manajemen Admin</h1>
        <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Admin</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title">Daftar Admin</h5><a href="{{ route('admin.create') }}" class="btn btn-primary">Tambah Admin Baru</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                  <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Di buat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($admins as $admin)
                            <tr>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->username }}</td>
                                    <td>{{ optional($admin->created_at)->format('d M Y H:i') ?? '-' }}</td>
                                    <td>
                                        @if((string) $currentAdmin->getKey() === (string) $admin->getKey())
                                        <a href="{{ route('admin.edit', $admin->getKey()) }}" class="btn btn-sm btn-warning">Edit Profil</a>
                                        @else
                                            <span class="text-muted">Tidak bisa diedit</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                  <td colspan="5" class="text-center">Belum ada admin terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection