@extends('layouts.app')

@section('title', 'Rekomendasi Tenor')

@section('content')

@php
$rawData = [
    ['nama'=>'Budi Santoso','motor'=>'Honda Beat','gaji'=>5000000,'keluar'=>2500000,'tenor'=>24,'status'=>'Approved'],
    ['nama'=>'Siti Aminah','motor'=>'Honda Vario 125','gaji'=>3200000,'keluar'=>2800000,'tenor'=>36,'status'=>'Approved'],
    ['nama'=>'Joko Widodo','motor'=>'Honda PCX 160','gaji'=>8500000,'keluar'=>3000000,'tenor'=>12,'status'=>'Approved'],
    ['nama'=>'Rina Kusuma','motor'=>'Honda Genio','gaji'=>4100000,'keluar'=>3200000,'tenor'=>36,'status'=>'Pending'],
    ['nama'=>'Ahmad Fauzi','motor'=>'Honda Scoopy','gaji'=>6200000,'keluar'=>2100000,'tenor'=>12,'status'=>'Approved'],
    ['nama'=>'Dewi Rahayu','motor'=>'Honda Beat','gaji'=>3500000,'keluar'=>2900000,'tenor'=>36,'status'=>'Approved'],
    ['nama'=>'Hendra Gunawan','motor'=>'Honda Vario 160','gaji'=>7000000,'keluar'=>2500000,'tenor'=>12,'status'=>'Approved'],
    ['nama'=>'Lina Marlina','motor'=>'Honda CRF150L','gaji'=>4800000,'keluar'=>3100000,'tenor'=>24,'status'=>'Approved'],
    ['nama'=>'Agus Santoso','motor'=>'Honda Revo','gaji'=>2800000,'keluar'=>2400000,'tenor'=>36,'status'=>'Pending'],
    ['nama'=>'Fitri Handayani','motor'=>'Honda Beat Street','gaji'=>5500000,'keluar'=>2200000,'tenor'=>24,'status'=>'Approved'],
];

$total = count($rawData);
$t12 = count(array_filter($rawData, fn($d) => $d['tenor'] == 12));
$t24 = count(array_filter($rawData, fn($d) => $d['tenor'] == 24));
$t36 = count(array_filter($rawData, fn($d) => $d['tenor'] == 36));

$p12 = round(($t12 / $total) * 100, 1);
$p24 = round(($t24 / $total) * 100, 1);
$p36 = round(($t36 / $total) * 100, 1);

function formatRupiah($value) {
    return 'Rp ' . number_format($value / 1000000, 1) . ' Jt';
}
@endphp

<div class="pagetitle">
    <h1>Rekomendasi Tenor</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Rekomendasi Tenor</li>
        </ol>
    </nav>
</div>

<section class="section">

    {{-- STATISTIK --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card p-3">
                <h4>{{ $t12 }}</h4>
                <small>Tenor 12 Bulan</small><br>
                <span class="text-primary">{{ $p12 }}%</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h4>{{ $t24 }}</h4>
                <small>Tenor 24 Bulan</small><br>
                <span class="text-success">{{ $p24 }}%</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h4>{{ $t36 }}</h4>
                <small>Tenor 36 Bulan</small><br>
                <span class="text-warning">{{ $p36 }}%</span>
            </div>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar User per Tenor</h5>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Motor</th>
                            <th>Penghasilan</th>
                            <th>Pengeluaran</th>
                            <th>Tenor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rawData as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row['nama'] }}</td>
                            <td>{{ $row['motor'] }}</td>
                            <td>{{ formatRupiah($row['gaji']) }}</td>
                            <td>{{ formatRupiah($row['keluar']) }}</td>
                            <td>
                                <span class="badge 
                                    {{ $row['tenor'] == 12 ? 'bg-primary' : ($row['tenor'] == 24 ? 'bg-success' : 'bg-warning') }}">
                                    {{ $row['tenor'] }} bln
                                </span>
                            </td>
                            <td>
                                <span class="badge 
                                    {{ $row['status'] == 'Approved' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</section>
@endsection