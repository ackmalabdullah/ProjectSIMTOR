@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="pagetitle">
    <h1 class="fw-bold">Dashboard</h1>
</div>

<section class="section">


    {{-- CARD STATISTIK --}}
    <div class="row">

        {{-- MOTOR --}}
        <div class="col-lg-3 mb-4">
            <div class="card dashboard-card border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Motor</h6>
                            <h2 class="fw-bold">{{ $totalMotor }}</h2>

                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i>
                                Stok tersedia
                            </small>
                        </div>

                        <div class="icon-box">
                            <i class="bi bi-bicycle"></i>
                        </div>
                    </div>

                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-danger" style="width: 85%"></div>
                    </div>

                    <button class="btn btn-danger btn-sm mt-3 btn-detail"
                        data-type="motor">
                        Detail
                    </button>

                </div>
            </div>
        </div>

        {{-- USER --}}
        <div class="col-lg-3 mb-4">
            <div class="card dashboard-card border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total User</h6>
                            <h2 class="fw-bold">{{ $totalUser }}</h2>

                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i>
                                User aktif
                            </small>
                        </div>

                        <div class="icon-box">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>

                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-danger" style="width: 70%"></div>
                    </div>

                    <button class="btn btn-danger btn-sm mt-3 btn-detail"
                        data-type="user">
                        Detail
                    </button>

                </div>
            </div>
        </div>

        {{-- ADMIN --}}
        <div class="col-lg-3 mb-4">
            <div class="card dashboard-card border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Admin</h6>
                            <h2 class="fw-bold">{{ $totalAdmin }}</h2>

                            <small class="text-success">
                                <i class="bi bi-shield-check"></i>
                                Admin aktif
                            </small>
                        </div>

                        <div class="icon-box">
                            <i class="bi bi-person-badge"></i>
                        </div>
                    </div>

                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-danger" style="width: 60%"></div>
                    </div>

                    <button class="btn btn-danger btn-sm mt-3 btn-detail"
                        data-type="admin">
                        Detail
                    </button>

                </div>
            </div>
        </div>

        {{-- SIMULASI --}}
        <div class="col-lg-3 mb-4">
            <div class="card dashboard-card border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Simulasi</h6>
                            <h2 class="fw-bold">{{ $totalSimulasi }}</h2>

                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i>
                                Simulasi berhasil
                            </small>
                        </div>

                        <div class="icon-box">
                            <i class="bi bi-graph-up"></i>
                        </div>
                    </div>

                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-danger" style="width: 90%"></div>
                    </div>

                    <button class="btn btn-danger btn-sm mt-3 btn-detail"
                        data-type="simulasi">
                        Detail
                    </button>

                </div>
            </div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="row">

        {{-- DONUT --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Proporsi Data</h5>

                    <canvas id="donutChart"></canvas>

                    <h4 class="mt-4 fw-bold">
                        {{ array_sum($chartData) }} Total Data
                    </h4>
                </div>
            </div>
        </div>

        {{-- LINE CHART --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        Statistik Simulasi Bulanan
                    </h5>

                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- RECENT ACTIVITY --}}
    <div class="row mt-4">

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <h5 class="card-title">
                        Recent Activity
                    </h5>

                    <div class="activity-item mb-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        Admin menambahkan motor baru
                    </div>

                    <div class="activity-item mb-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        User melakukan simulasi kredit
                    </div>

                    <div class="activity-item mb-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        Data rekomendasi diperbarui
                    </div>

                    <div class="activity-item">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        Dashboard berhasil sinkron
                    </div>

                </div>
            </div>
        </div>

        {{-- MOTOR POPULER --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <h5 class="card-title">
                        Motor Terpopuler
                    </h5>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span>Honda Beat</span>
                            <span>90%</span>
                        </div>

                        <div class="progress">
                            <div class="progress-bar bg-danger"
                                style="width:90%">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span>Honda Vario</span>
                            <span>75%</span>
                        </div>

                        <div class="progress">
                            <div class="progress-bar bg-danger"
                                style="width:75%">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <span>PCX</span>
                            <span>60%</span>
                        </div>

                        <div class="progress">
                            <div class="progress-bar bg-danger"
                                style="width:60%">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="card mt-4 border-0 shadow-sm"
        id="tableSection"
        style="display:none;">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <h5 id="tableTitle" class="fw-bold">
                    Detail Data
                </h5>

                <a id="btnExport"
                    class="btn btn-danger btn-sm">
                    <i class="bi bi-download"></i>
                    Download CSV
                </a>

            </div>

            <div class="table-responsive mt-4">

                <table class="table table-bordered align-middle">

                    <thead class="table-danger"
                        id="tableHead">
                    </thead>

                    <tbody id="tableBody">
                    </tbody>

                </table>

            </div>

        </div>
    </div>

</section>

@endsection

@push('styles')
<style>

.dashboard-card{
    border-radius:20px;
    transition:0.3s;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
}

.dashboard-card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.icon-box{
    width:65px;
    height:65px;
    border-radius:18px;
    background:linear-gradient(135deg,#dc3545,#ff6b81);
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
}

.activity-item{
    padding:12px;
    border-radius:12px;
    background:#f8f9fa;
}

.card{
    border-radius:20px;
}

</style>
@endpush

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function() {

    // REALTIME CLOCK
    setInterval(() => {
        document.getElementById('clock').innerHTML =
            new Date().toLocaleTimeString();
    }, 1000);

    // DONUT CHART
    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                data: @json($chartData),
                backgroundColor: [
                    '#dc3545',
                    '#ff4d6d',
                    '#ff758f',
                    '#ffb3c1'
                ]
            }]
        },
        options: {
            cutout: '70%'
        }
    });

    // LINE CHART
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
            datasets: [{
                label: 'Simulasi',
                data: [12,19,8,15,30,40],
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220,53,69,0.1)',
                tension: 0.4,
                fill: true
            }]
        }
    });

    // DATA
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

            if(type === 'motor'){
                headers = ['Nama Motor','Merk','Tipe','Harga'];
                data = motors;
                tableTitle.innerHTML = "Detail Data Motor";
                btnExport.href = '/export/motor';
            }

            if(type === 'user'){
                headers = ['Nama','Email','Pekerjaan'];
                data = users;
                tableTitle.innerHTML = "Detail Data User";
                btnExport.href = '/export/user';
            }

            if(type === 'admin'){
                headers = ['Nama','Email','Username'];
                data = admins;
                tableTitle.innerHTML = "Detail Data Admin";
                btnExport.href = '/export/admin';
            }

            if(type === 'simulasi'){
                headers = ['User ID','Motor ID'];
                data = simulasis;
                tableTitle.innerHTML = "Detail Data Simulasi";
                btnExport.href = '/export/simulasi';
            }

            tableHead.innerHTML =
                "<tr>" +
                headers.map(h => `<th>${h}</th>`).join('') +
                "</tr>";

            tableBody.innerHTML = "";

            data.forEach(item => {

                let row = "<tr>";

                if(type === 'motor'){
                    row += `<td>${item.nama_motor}</td>`;
                    row += `<td>${item.merk}</td>`;
                    row += `<td>${item.tipe}</td>`;
                    row += `<td>Rp ${Number(item.harga).toLocaleString()}</td>`;
                }

                if(type === 'user'){
                    row += `<td>${item.nama}</td>`;
                    row += `<td>${item.email}</td>`;
                    row += `<td>${item.pekerjaan}</td>`;
                }

                if(type === 'admin'){
                    row += `<td>${item.name}</td>`;
                    row += `<td>${item.email}</td>`;
                    row += `<td>${item.username}</td>`;
                }

                if(type === 'simulasi'){
                    row += `<td>${item.user_id}</td>`;
                    row += `<td>${item.motor_id}</td>`;
                }

                row += "</tr>";

                tableBody.innerHTML += row;

            });

            tableSection.scrollIntoView({
                behavior:'smooth'
            });

        });

    });

});

</script>

@endpush