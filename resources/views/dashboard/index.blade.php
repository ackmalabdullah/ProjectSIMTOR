@extends('layouts.app')

@section('title', 'Dashboard - Sistem Manajemen Motor')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">

            <!-- Statistik Cards -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Motor <span>| Tersedia</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-motherboard"></i>
                            </div>
                            <div class="ps-3">
                                <h6>45</h6>
                                <span class="text-success small pt-1 fw-bold">8</span>
                                <span class="text-muted small pt-2 ps-1">unit terjual</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Simulasi Kredit <span>| Bulan Ini</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <div class="ps-3">
                                <h6>23</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span>
                                <span class="text-muted small pt-2 ps-1">meningkat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Pelanggan <span>| Aktif</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>124</h6>
                                <span class="text-success small pt-1 fw-bold">15%</span>
                                <span class="text-muted small pt-2 ps-1">pelanggan baru</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Pendapatan <span>| Bulan Ini</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Rp 125.8 Jt</h6>
                                <span class="text-success small pt-1 fw-bold">8%</span>
                                <span class="text-muted small pt-2 ps-1">meningkat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Sales Table -->
            <div class="col-12">
                <div class="card recent-sales">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi Terbaru</h5>
                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Motor</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#001</td>
                                    <td>Budi Santoso</td>
                                    <td>Yamaha NMAX</td>
                                    <td>Rp 32.5 Jt</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                </tr>
                                <tr>
                                    <td>#002</td>
                                    <td>Siti Aminah</td>
                                    <td>Honda Beat</td>
                                    <td>Rp 18.2 Jt</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>#003</td>
                                    <td>Joko Widodo</td>
                                    <td>Suzuki Address</td>
                                    <td>Rp 16.8 Jt</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Script tambahan untuk dashboard
        console.log('Dashboard loaded');
    </script>
@endpush
