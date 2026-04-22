@extends('layouts.app')

@section('title', 'Data Motor - NiceAdmin')

@section('content')
    <div class="pagetitle">
        <h1>Data Motor</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Motor</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Motor</h5>

                        <!-- Button Tambah Motor -->
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#tambahMotorModal">
                            <i class="bi bi-plus-circle"></i> Tambah Motor
                        </button>

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kode Motor</th>
                                        <th scope="col">Merek</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Tahun</th>
                                        <th scope="col">Warna</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <div class="py-4">
                                                <i class="bi bi-inbox" style="font-size: 48px; color: #ced4da;"></i>
                                                <p class="text-muted mt-2">Belum ada data motor</p>
                                                <p class="text-muted small">Klik tombol "Tambah Motor" untuk menambahkan
                                                    data</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Modal Tambah Motor -->
    <div class="modal fade" id="tambahMotorModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Motor Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kode Motor</label>
                            <input type="text" class="form-control" placeholder="MTR-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Merek</label>
                            <select class="form-select">
                                <option selected>Pilih Merek</option>
                                <option>Yamaha</option>
                                <option>Honda</option>
                                <option>Suzuki</option>
                                <option>Kawasaki</option>
                                <option>Vespa</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Model</label>
                            <input type="text" class="form-control" placeholder="NMAX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun</label>
                            <select class="form-select">
                                <option selected>Pilih Tahun</option>
                                <option>2025</option>
                                <option>2024</option>
                                <option>2023</option>
                                <option>2022</option>
                                <option>2021</option>
                                <option>2020</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Warna</label>
                            <input type="text" class="form-control" placeholder="Hitam">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok</label>
                            <input type="number" class="form-control" value="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select">
                                <option>Tersedia</option>
                                <option>Habis</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3" placeholder="Deskripsi motor..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Gambar Motor</label>
                            <input class="form-control" type="file">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div><!-- End Modal Tambah Motor-->

@endsection

@push('scripts')
    <script>
        // Script untuk DataTable (jika menggunakan simple-datatables)
        document.addEventListener("DOMContentLoaded", () => {
            // Inisialisasi datatable jika ada data
            console.log("Halaman Data Motor siap");
        });
    </script>
@endpush
