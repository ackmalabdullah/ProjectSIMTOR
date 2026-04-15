@extends('layouts.app')

@section('title', 'History Simulasi - Admin Honda')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
  :root{--red:#cc0000;--red-light:#fff0f0;--red-mid:#ffd6d6;--font:'Plus Jakarta Sans',sans-serif;}
  
  .sim-wrap{font-family:var(--font); background:#fff; padding:10px; color:#1a1a1a;}
  .divider-line{width:40px; height:3px; background:var(--red); border-radius:2px; margin-bottom:16px;}
  
  /* Toolbar */
  .toolbar{display:flex; align-items:center; gap:8px; margin-bottom:16px; flex-wrap: wrap;}
  .search-wrap{position:relative; flex:1; max-width:260px;}
  .search-wrap svg{position:absolute; left:10px; top:50%; transform:translateY(-50%); width:14px; height:14px; stroke:#aaa; fill:none;}
  .search-input, .filter-sel{padding:8px 10px 8px 32px; border:1.5px solid #e8e8e8; border-radius:8px; font-size:13px; outline:none; width: 100%;}
  .filter-sel{padding-left:10px; cursor:pointer; width: auto; min-width: 130px;}
  .search-input:focus, .filter-sel:focus{border-color:var(--red);}
  
  /* Table */
  .table-wrap{border:1.5px solid #f0f0f0; border-radius:12px; overflow:hidden; background: white;}
  .custom-table{width:100%; border-collapse:collapse; font-size:13px;}
  .custom-table thead{background:var(--red);}
  .custom-table th{padding:12px; text-align:left; font-size:11px; font-weight:600; color:#fff; text-transform:uppercase; letter-spacing:0.5px;}
  .custom-table td{padding:12px; border-bottom:1px solid #f5f5f5; vertical-align:middle;}
  .custom-table tbody tr:hover{background:#fff8f8; cursor:pointer;}

  /* UI Elements */
  .id-text{font-size:11px; font-weight:600; color:var(--red);}
  .user-cell{display:flex; align-items:center; gap:8px;}
  .ava{width:28px; height:28px; border-radius:50%; background:var(--red); display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; color:#fff;}
  .u-name{font-weight:600; color:#1a1a1a; font-size:13px;}
  .u-email{font-size:11px; color:#aaa;}
  .motor-tag{background:var(--red-light); border:1px solid var(--red-mid); border-radius:6px; padding:3px 8px; font-size:12px; color:#990000; font-weight:500;}
  .rp-red{font-weight:700; color:var(--red);}
  .tenor-pill{background:#f5f5f5; border-radius:5px; padding:3px 8px; font-size:11px; font-weight:600; color:#666;}
  
  /* Modal */
  .modal-overlay{display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;}
  .modal-overlay.open{display:flex;}
  .custom-modal{background:#fff; border-radius:12px; width:420px; overflow:hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1);}
  .modal-head{background:var(--red); padding:16px; display:flex; justify-content:space-between; color:#fff;}
  .modal-body{padding:20px;}
  .detail-row{display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f5f5f5; font-size:13px;}
  .dk{color:#999;} .dv{font-weight:600;}
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>History Simulasi</h1>
</div>

<div class="sim-wrap">
    <div class="divider-line"></div>

    <div class="toolbar">
        <div class="search-wrap">
            <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input class="search-input" type="text" id="searchInput" placeholder="Cari nama atau motor..." oninput="doFilter()">
        </div>
        
        <select class="filter-sel" id="tenorFilter" onchange="doFilter()">
            <option value="">Semua tenor</option>
            <option value="12">12 bulan</option>
            <option value="24">24 bulan</option>
            <option value="36">36 bulan</option>
        </select>

        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="badge bg-light text-danger border border-danger-subtle" id="countBadge">{{ count($simulasis) }} data</span>
            <button onclick="exportCSV()" class="btn btn-danger btn-sm px-3 shadow-sm">
                <i class="bi bi-download me-1"></i> Ekspor CSV
            </button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pengguna</th>
                    <th>Motor</th>
                    <th>Harga</th>
                    <th>DP</th>
                    <th>Cicilan</th>
                    <th>Tenor</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tBody">
                @foreach($simulasis as $item)
                <tr onclick='showDetail(@json($item))'>
                    <td><span class="id-text">{{ $item->id_simulasi }}</span></td>
                    <td>
                        <div class="user-cell">
                            <div class="ava">{{ strtoupper(substr($item->nama, 0, 1)) }}</div>
                            <div>
                                <div class="u-name">{{ $item->nama }}</div>
                                <div class="u-email">{{ $item->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="motor-tag">{{ $item->motor }}</span></td>
                    <td><span class="fw-bold text-dark">Rp {{ number_format($item->harga, 0, ',', '.') }}</span></td>
                    <td><span class="text-secondary">Rp {{ number_format($item->dp, 0, ',', '.') }}</span></td>
                    <td><span class="rp-red">Rp {{ number_format($item->harga / ($item->tenor ?? 36), 0, ',', '.') }}*</span></td>
                    <td><span class="tenor-pill">{{ $item->tenor ?? '36' }} bln</span></td>
                    <td><button class="btn btn-sm btn-outline-danger">Detail</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay" id="modalOverlay">
    <div class="custom-modal">
        <div class="modal-head">
            <span id="modalTitle">Detail Simulasi</span>
            <button onclick="closeModal()" style="background:none; border:none; color:#fff; cursor:pointer; font-size: 1.2rem;">&times;</button>
        </div>
        <div class="modal-body" id="modalBody"></div>
        <div class="p-3 border-top d-flex justify-content-end gap-2">
            <button class="btn btn-light btn-sm border" onclick="closeModal()">Tutup</button>
            <button class="btn btn-danger btn-sm" onclick="window.print()">Cetak PDF</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Ambil data asli dari Laravel
    const rawData = {!! json_encode($simulasis) !!};

    function doFilter() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        const t = document.getElementById('tenorFilter').value;
        
        const filtered = rawData.filter(item => {
            // Filter Nama/Motor/Email (Case Insensitive)
            const matchQ = !q || 
                           (item.nama && item.nama.toLowerCase().includes(q)) || 
                           (item.motor && item.motor.toLowerCase().includes(q)) ||
                           (item.email && item.email.toLowerCase().includes(q));
            
            // Filter Tenor (Konversi ke string agar cocok)
            const itemTenor = item.tenor ? String(item.tenor) : "36";
            const matchT = !t || itemTenor === String(t); 
            
            return matchQ && matchT;
        });

        renderTable(filtered);
    }

    function renderTable(data) {
        const tb = document.getElementById('tBody');
        if (data.length === 0) {
            tb.innerHTML = '<tr><td colspan="8" class="text-center py-5 text-muted">Data tidak ditemukan.</td></tr>';
            document.getElementById('countBadge').textContent = '0 data';
            return;
        }

        tb.innerHTML = data.map(item => {
            const tenor = item.tenor || 36;
            const cicilan = Math.round(item.harga / tenor);
            
            return `
                <tr onclick='showDetail(${JSON.stringify(item)})'>
                    <td><span class="id-text">${item.id_simulasi}</span></td>
                    <td>
                        <div class="user-cell">
                            <div class="ava">${item.nama ? item.nama.charAt(0).toUpperCase() : '?'}</div>
                            <div>
                                <div class="u-name">${item.nama}</div>
                                <div class="u-email">${item.email}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="motor-tag">${item.motor}</span></td>
                    <td><span class="fw-bold">Rp ${Number(item.harga).toLocaleString('id-ID')}</span></td>
                    <td><span class="text-secondary">Rp ${Number(item.dp).toLocaleString('id-ID')}</span></td>
                    <td><span class="rp-red">Rp ${cicilan.toLocaleString('id-ID')}*</span></td>
                    <td><span class="tenor-pill">${tenor} bln</span></td>
                    <td><button class="btn btn-sm btn-outline-danger">Detail</button></td>
                </tr>
            `;
        }).join('');
        
        document.getElementById('countBadge').textContent = data.length + ' data';
    }

    function showDetail(item) {
        const modalBody = document.getElementById('modalBody');
        document.getElementById('modalTitle').textContent = 'Detail — ' + (item.id_simulasi || 'ID');
        
        modalBody.innerHTML = `
            <div class="detail-row"><span class="dk">Nama Lengkap</span><span class="dv">${item.nama}</span></div>
            <div class="detail-row"><span class="dk">Email</span><span class="dv">${item.email}</span></div>
            <div class="detail-row"><span class="dk">Tipe Motor</span><span class="dv">${item.motor}</span></div>
            <div class="detail-row"><span class="dk">Harga OTR</span><span class="dv">Rp ${Number(item.harga).toLocaleString('id-ID')}</span></div>
            <div class="detail-row"><span class="dk">Uang Muka (DP)</span><span class="dv">Rp ${Number(item.dp).toLocaleString('id-ID')}</span></div>
            <div class="detail-row"><span class="dk">Tenor</span><span class="dv">${item.tenor || 36} Bulan</span></div>
        `;
        document.getElementById('modalOverlay').classList.add('open');
    }

    function closeModal() {
        document.getElementById('modalOverlay').classList.remove('open');
    }

    function exportCSV() {
        if(rawData.length === 0) return alert('Tidak ada data untuk diekspor');

        let csv = '\ufeffID,Nama,Email,Motor,Harga,DP,Tenor\n';
        rawData.forEach(row => {
            csv += `${row.id_simulasi},${row.nama},${row.email},${row.motor},${row.harga},${row.dp},${row.tenor || 36}\n`;
        });

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        const url = URL.createObjectURL(blob);
        
        link.setAttribute("href", url);
        link.setAttribute("download", "History_Simulasi_Honda_" + new Date().toLocaleDateString() + ".csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Menutup modal jika user klik di luar area modal
    window.onclick = function(event) {
        const modal = document.getElementById('modalOverlay');
        if (event.target == modal) closeModal();
    }
</script>
@endpush