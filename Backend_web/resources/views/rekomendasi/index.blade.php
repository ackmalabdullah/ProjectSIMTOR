@extends('layouts.app')

@section('title', 'Rekomendasi Tenor')

@section('content')

@php
$rawData = [
['id'=>1,'nama'=>'Budi Santoso','motor'=>'Honda Beat','gaji'=>5000000,'keluar'=>2500000,'tenor'=>24,'status'=>'Approved'],
['id'=>2,'nama'=>'Siti Aminah','motor'=>'Honda Vario 125','gaji'=>3200000,'keluar'=>2800000,'tenor'=>36,'status'=>'Approved'],
['id'=>3,'nama'=>'Joko Widodo','motor'=>'Honda PCX 160','gaji'=>8500000,'keluar'=>3000000,'tenor'=>12,'status'=>'Approved'],
['id'=>4,'nama'=>'Rina Kusuma','motor'=>'Honda Genio','gaji'=>4100000,'keluar'=>3200000,'tenor'=>36,'status'=>'Pending'],
];
@endphp

<div class="pagetitle d-flex justify-content-between align-items-center">
    <h1>Rekomendasi Tenor</h1>
</div>

<section class="section">

<div class="row mb-4">

<div class="col-md-8">
<div class="card p-4">
<h5 class="mb-3">Distribusi Tenor</h5>

<div id="bars"></div>

<hr>
<small class="text-muted">Insight ML</small>
<p id="insight"></p>

</div>
</div>

<div class="col-md-4">
<div class="card p-4 text-center">
<h5>Proporsi Tenor</h5>
<canvas id="donutChart"></canvas>
<h4 id="totalUser" class="mt-2"></h4>
</div>
</div>

</div>

{{-- DETAIL --}}
<div id="detailSection" style="display:none">

<div class="card p-3 mb-3">
<div class="d-flex justify-content-between align-items-center">

<h5 id="detailTitle"></h5>

<a id="btnExport" href="#" class="btn btn-danger">
<i class="bi bi-download"></i> Export CSV
</a>

</div>
</div>

<div class="card">
<div class="table-responsive">

<table class="table align-middle mb-0">
<thead style="background:#d90000;color:white">
<tr>
<th>ID</th>
<th>Pengguna</th>
<th>Motor</th>
<th>Harga</th>
<th>DP</th>
<th>Cicilan</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody id="tableBody"></tbody>

</table>

</div>
</div>

</div>

</section>

{{-- MODAL --}}
<div class="modal fade" id="detailModal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5>Detail User</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body" id="modalContent"></div>
</div>
</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const rawData = @json($rawData);
let chart;

// ================= DETAIL USER =================
function showDetail(id){
fetch(`/rekomendasi/detail/${id}`)
.then(res=>res.json())
.then(d=>{
document.getElementById('modalContent').innerHTML = d.nama ? `
<b>Nama:</b> ${d.nama}<br>
<b>Motor:</b> ${d.motor}<br>
<b>Gaji:</b> Rp ${d.gaji.toLocaleString()}<br>
<b>Pengeluaran:</b> Rp ${d.keluar.toLocaleString()}<br>
<b>Tenor:</b> ${d.tenor} bulan<br>
<b>Status:</b> ${d.status}
` : 'Data tidak ditemukan';

new bootstrap.Modal(document.getElementById('detailModal')).show();
});
}

// ================= LOAD DETAIL TENOR =================
function loadDetail(tenor){

fetch(`/rekomendasi/data/tenor/${tenor}`)
.then(res=>res.json())
.then(res=>{

let data = res.data;

document.getElementById('detailSection').style.display = 'block';
document.getElementById('detailTitle').innerText = `Detail Tenor ${tenor} Bulan`;
document.getElementById('btnExport').href = `/rekomendasi/export/tenor/${tenor}`;

document.getElementById('tableBody').innerHTML = data.map(d=>{

let cicilan = Math.round((d.gaji - d.keluar)/d.tenor);

return `
<tr>

<td style="color:#d90000;font-weight:600">
SIM-${String(d.id).padStart(3,'0')}
</td>

<td>
<div class="d-flex gap-2 align-items-center">

<div style="width:35px;height:35px;background:#d90000;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center">
${d.nama[0]}
</div>

<div>
<b>${d.nama}</b><br>
<small class="text-muted">${d.nama.toLowerCase()}@gmail.com</small>
</div>

</div>
</td>

<td><span style="border:1px solid #f5b5b5;color:#d90000;padding:4px 10px;border-radius:8px">${d.motor}</span></td>

<td><b>Rp ${(d.gaji*4).toLocaleString()}</b></td>
<td class="text-muted">Rp ${(d.gaji/2).toLocaleString()}</td>
<td style="color:#d90000;font-weight:600">Rp ${cicilan.toLocaleString()}</td>
<td>${d.status}</td>

<td>
<button onclick="showDetail(${d.id})" class="btn btn-sm btn-outline-danger">
Detail
</button>
</td>

</tr>
`;

}).join('');

});
}

// ================= STATS =================
function getStats(){
let total = rawData.length;
let t12 = rawData.filter(d=>d.tenor==12).length;
let t24 = rawData.filter(d=>d.tenor==24).length;
let t36 = rawData.filter(d=>d.tenor==36).length;

return {
total,
t12,t24,t36,
p12: total? (t12/total*100).toFixed(1):0,
p24: total? (t24/total*100).toFixed(1):0,
p36: total? (t36/total*100).toFixed(1):0
};
}

// ================= RENDER =================
function render(){

let s = getStats();

totalUser.innerText = s.total + " User";

bars.innerHTML = `
${bar('12',s.t12,s.p12)}
${bar('24',s.t24,s.p24)}
${bar('36',s.t36,s.p36)}
`;

let max = Math.max(s.t12,s.t24,s.t36);
let best = max==s.t24?'24 bulan':max==s.t12?'12 bulan':'36 bulan';

insight.innerHTML =
`Model menunjukkan mayoritas user cocok di <b>${best}</b> berdasarkan distribusi historis.`;

// DONUT
if(chart) chart.destroy();

chart = new Chart(donutChart,{
type:'doughnut',
data:{
labels:['12 Bulan','24 Bulan','36 Bulan'],
datasets:[{
data:[s.t12,s.t24,s.t36],
backgroundColor:['#d90000','#ff4d4d','#ff9999']
}]
},
options:{
plugins:{
tooltip:{
callbacks:{
label:function(ctx){
let val = ctx.raw;
let persen = ((val/s.total)*100).toFixed(1);
return `${ctx.label}: ${val} user (${persen}%)`;
}
}
}
}
}
});
}

// ================= BAR =================
function bar(label,val,pct){
return `
<div class="mb-4">

<div class="d-flex justify-content-between">
<span>${label} bulan</span>
<span>${val} user (${pct}%)</span>
</div>

<div class="progress mb-2">
<div class="progress-bar" style="width:${pct}%;background:#d90000"></div>
</div>

<button onclick="loadDetail(${label})" class="btn btn-outline-danger btn-sm">
Lihat Detail
</button>

</div>
`;
}

render();

</script>

@endsection