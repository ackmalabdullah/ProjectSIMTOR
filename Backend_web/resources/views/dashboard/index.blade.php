@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="pagetitle">
    <h1>Dashboard</h1>
</div>

<section class="section">

    {{-- CARD --}}
    <div class="row">

        {{-- MOTOR --}}
        <div class="col-lg-3">
            <div class="card info-card sales-card">

                <div class="card-body">
                    <h5 class="card-title">
                        Total Motor
                        <span>| Tersedia</span>
                    </h5>

                    <div class="d-flex align-items-center">

                        <div
                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-bicycle"></i>
                        </div>

                        <div class="ps-3">
                            <h6>{{ $totalMotor }}</h6>

                            <button
                                class="btn btn-danger btn-sm mt-2 btn-detail"
                                data-type="motor">
                                Detail
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- USER --}}
        <div class="col-lg-3">
            <div class="card info-card revenue-card">

                <div class="card-body">
                    <h5 class="card-title">
                        User
                        <span>| Pengguna</span>
                    </h5>

                    <div class="d-flex align-items-center">

                        <div
                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>

                        <div class="ps-3">
                            <h6>{{ $totalUser }}</h6>

                            <button
                                class="btn btn-danger btn-sm mt-2 btn-detail"
                                data-type="user">
                                Detail
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- ADMIN --}}
        <div class="col-lg-3">
            <div class="card info-card customers-card">

                <div class="card-body">
                    <h5 class="card-title">
                        Admin
                        <span>| Sistem</span>
                    </h5>

                    <div class="d-flex align-items-center">

                        <div
                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-badge"></i>
                        </div>

                        <div class="ps-3">
                            <h6>{{ $totalAdmin }}</h6>

                            <button
                                class="btn btn-danger btn-sm mt-2 btn-detail"
                                data-type="admin">
                                Detail
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- SIMULASI --}}
        <div class="col-lg-3">
            <div class="card info-card revenue-card">

                <div class="card-body">
                    <h5 class="card-title">
                        Simulasi
                        <span>| Kredit</span>
                    </h5>

                    <div class="d-flex align-items-center">

                        <div
                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-graph-up"></i>
                        </div>

                        <div class="ps-3">
                            <h6>{{ $totalSimulasi }}</h6>

                            <button
                                class="btn btn-danger btn-sm mt-2 btn-detail"
                                data-type="simulasi">
                                Detail
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="row">

        <div class="col-lg-6">

            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">Proporsi Data</h5>

                    <canvas id="donutChart"></canvas>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card mt-4" id="tableSection" style="display:none;">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="card-title" id="tableTitle">
                    Detail Data
                </h5>

                <a id="btnExport" class="btn btn-danger">
                    <i class="bi bi-download"></i>
                    Download CSV
                </a>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead id="tableHead"></thead>

                    <tbody id="tableBody"></tbody>

                </table>

            </div>

        </div>

    </div>

</section>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function() {

    // ================= CHART =================

    new Chart(document.getElementById('donutChart'), {

        type: 'doughnut',

        data: {
            labels: @json($chartLabels),

            datasets: [{
                data: @json($chartData),
                backgroundColor: [
                    '#dc3545',
                    '#ff4d4d',
                    '#ff8080',
                    '#ffb3b3'
                ]
            }]
        },

        options: {
            cutout: '70%'
        }

    });

    // ================= DATA =================

    const motors = @json($motors);
    const users = @json($users);
    const admins = @json($admins);
    const simulasis = @json($simulasis);

    const tableSection = document.getElementById('tableSection');
    const tableHead = document.getElementById('tableHead');
    const tableBody = document.getElementById('tableBody');
    const tableTitle = document.getElementById('tableTitle');
    const btnExport = document.getElementById('btnExport');

    document.querySelectorAll('.btn-detail').forEach(btn => {

        btn.addEventListener('click', function() {

            let type = this.dataset.type;

            tableSection.style.display = 'block';

            let headers = [];
            let data = [];

            // ================= MOTOR =================

            if(type === 'motor') {

                tableTitle.innerHTML = "Detail Data Motor";

                headers = [
                    'Kode',
                    'Nama Motor',
                    'Merk',
                    'Harga',
                    'Status'
                ];

                data = motors;

                btnExport.href = '/export/motor';
            }

            // ================= USER =================

            if(type === 'user') {

                tableTitle.innerHTML = "Detail Data User";

                headers = [
                    'Nama',
                    'Email',
                    'Pekerjaan',
                    'Gaji'
                ];

                data = users;

                btnExport.href = '/export/user';
            }

            // ================= ADMIN =================

            if(type === 'admin') {

                tableTitle.innerHTML = "Detail Data Admin";

                headers = [
                    'Nama',
                    'Email',
                    'Username'
                ];

                data = admins;

                btnExport.href = '/export/admin';
            }

            // ================= SIMULASI =================

            if(type === 'simulasi') {

                tableTitle.innerHTML = "Detail Data Simulasi";

                headers = [
                    'Nama',
                    'Motor',
                    'Tenor',
                    'Status'
                ];

                data = simulasis;

                btnExport.href = '/export/simulasi';
            }

            // ================= HEAD =================

            tableHead.innerHTML =
                "<tr>" +
                headers.map(h => `<th>${h}</th>`).join('') +
                "</tr>";

            tableBody.innerHTML = "";

            // ================= BODY =================

            data.forEach(item => {

                let row = "<tr>";

                if(type === 'motor') {

                    row += `<td>${item.kode_mpm ?? '-'}</td>`;
                    row += `<td>${item.nama_motor}</td>`;
                    row += `<td>${item.merk}</td>`;
                    row += `<td>Rp ${Number(item.harga).toLocaleString()}</td>`;
                    row += `<td>${item.status}</td>`;
                }

                if(type === 'user') {

                    row += `<td>${item.nama}</td>`;
                    row += `<td>${item.email}</td>`;
                    row += `<td>${item.pekerjaan ?? '-'}</td>`;
                    row += `<td>Rp ${Number(item.gaji_per_bulan ?? 0).toLocaleString()}</td>`;
                }

                if(type === 'admin') {

                    row += `<td>${item.name}</td>`;
                    row += `<td>${item.email}</td>`;
                    row += `<td>${item.username}</td>`;
                }

                if(type === 'simulasi') {

                    row += `<td>${item.nama}</td>`;
                    row += `<td>${item.motor}</td>`;
                    row += `<td>${item.tenor}</td>`;
                    row += `<td>${item.status}</td>`;
                }

                row += "</tr>";

                tableBody.innerHTML += row;
            });

            window.scrollTo({
                top: tableSection.offsetTop - 100,
                behavior: 'smooth'
            });

        });

    });

});

</script>

@endpush