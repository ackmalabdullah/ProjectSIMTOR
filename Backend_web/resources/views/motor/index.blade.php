@extends('layouts.app')

@section('title', 'Data Motor - NiceAdmin')

@section('content')
    <div class="pagetitle">
        <h1>Data Motor</h1>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Daftar Motor</h5>

                <a href="{{ route('motor.create') }}" class="btn btn-primary mb-3">
                    <i class="bi bi-plus-circle"></i> Tambah Motor
                </a>

                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gambar</th>
                                <th>Kode MPM</th>
                                <th>Nama Motor</th>
                                <th>Merk</th>
                                <th>Tipe</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($motor as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}" width="80"
                                                class="img-thumbnail">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->kode_mpm }}</td>
                                    <td>{{ $item->nama_motor }}</td>
                                    <td>{{ $item->merk }}</td>
                                    <td>{{ $item->tipe }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->status == 'tersedia' ? 'success' : 'danger' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('motor.edit', $item->_id) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('motor.destroy', $item->_id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-hapus">
                                                Hapus
                                            </button>
                                            @if (session('success'))
                                                <script>
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Berhasil!',
                                                        text: '{{ session('success') }}',
                                                        timer: 2000,
                                                        showConfirmButton: false
                                                    });
                                                </script>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="py-4">
                                            <i class="bi bi-inbox" style="font-size: 48px; color: #ced4da;"></i>
                                            <p class="text-muted mt-2">Belum ada data motor</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.querySelectorAll('.btn-hapus').forEach(button => {
                button.addEventListener('click', function() {

                    let form = this.closest('form');

                    Swal.fire({
                        title: 'Yakin hapus?',
                        text: "Data tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });

                });
            });

        });
    </script>
@endpush
