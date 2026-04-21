@extends('layouts.app')

@section('title', 'Manajemen Pelanggan - Admin Honda')

@push('styles')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
  :root{--red:#cc0000;--red-light:#fff0f0;--red-mid:#ffd6d6;--font:'Plus Jakarta Sans',sans-serif;}

  .pel-wrap{font-family:var(--font); background:#fff; padding:10px; color:#1a1a1a;}
  .divider-line{width:40px; height:3px; background:var(--red); border-radius:2px; margin-bottom:16px;}

  /* Toolbar */
  .toolbar{display:flex; align-items:center; gap:8px; margin-bottom:16px; flex-wrap:wrap;}
  .search-wrap{position:relative; flex:1; max-width:280px;}
  .search-wrap svg{position:absolute; left:10px; top:50%; transform:translateY(-50%); width:14px; height:14px; stroke:#aaa; fill:none;}
  .search-input{padding:8px 10px 8px 32px; border:1.5px solid #e8e8e8; border-radius:8px; font-size:13px; outline:none; width:100%;}
  .search-input:focus{border-color:var(--red);}

  /* Table */
  .table-wrap{border:1.5px solid #f0f0f0; border-radius:12px; overflow:hidden; background:#fff;}
  .custom-table{width:100%; border-collapse:collapse; font-size:13px;}
  .custom-table thead{background:var(--red);}
  .custom-table th{padding:12px; text-align:left; font-size:11px; font-weight:600; color:#fff; text-transform:uppercase; letter-spacing:0.5px;}
  .custom-table td{padding:12px; border-bottom:1px solid #f5f5f5; vertical-align:middle;}
  .custom-table tbody tr:hover{background:#fff8f8; cursor:pointer;}
  .custom-table tbody tr:last-child td{border-bottom:none;}

  /* UI Elements */
  .no-text{font-size:11px; font-weight:600; color:var(--red);}
  .user-cell{display:flex; align-items:center; gap:10px;}
  .ava{width:32px; height:32px; border-radius:50%; background:var(--red); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#fff; flex-shrink:0;}
  .u-name{font-weight:600; color:#1a1a1a; font-size:13px;}
  .u-email{font-size:11px; color:#aaa;}
  .date-pill{background:#f5f5f5; border-radius:5px; padding:3px 8px; font-size:11px; font-weight:600; color:#666;}
  .status-badge{padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;}
  .status-active{background:#e6f9f0; color:#1a7f52; border:1px solid #b2ecd4;}
  .status-inactive{background:#fff0f0; color:var(--red); border:1px solid var(--red-mid);}
  .empty-state{text-align:center; padding:48px 20px; color:#aaa;}
  .empty-state i{font-size:2.5rem; margin-bottom:12px; display:block; color:#ddd;}

  /* Modal */
  .modal-overlay{display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;}
  .modal-overlay.open{display:flex;}
  .custom-modal{background:#fff; border-radius:12px; width:440px; max-width:95vw; overflow:hidden; box-shadow:0 10px 25px rgba(0,0,0,0.12);}
  .modal-head{background:var(--red); padding:16px 20px; display:flex; justify-content:space-between; align-items:center; color:#fff;}
  .modal-head h6{margin:0; font-weight:600; font-size:14px;}
  .modal-close{background:none; border:none; color:#fff; cursor:pointer; font-size:1.3rem; line-height:1; padding:0;}
  .modal-body{padding:20px;}
  .detail-row{display:flex; justify-content:space-between; align-items:center; padding:9px 0; border-bottom:1px solid #f5f5f5; font-size:13px;}
  .detail-row:last-child{border-bottom:none;}
  .dk{color:#999; font-size:12px;} .dv{font-weight:600; color:#1a1a1a;}
  .avatar-large{width:56px; height:56px; border-radius:50%; background:var(--red); display:flex; align-items:center; justify-content:center; font-size:22px; font-weight:700; color:#fff; margin:0 auto 16px; box-shadow:0 4px 10px rgba(204,0,0,0.2);}
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Manajemen Pelanggan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Pelanggan</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="pel-wrap">
        <div class="divider-line"></div>

        {{-- Session Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Toolbar --}}
        <div class="toolbar">
            <div class="search-wrap">
                <svg viewBox="0 0 24 24" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input class="search-input" type="text" id="searchInput"
                    placeholder="Cari nama atau email..." oninput="doFilter()">
            </div>

            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="badge bg-light text-danger border border-danger-subtle" id="countBadge">
                    {{ count($pelanggan) }} pelanggan
                </span>
                <button onclick="exportCSV()" class="btn btn-danger btn-sm px-3 shadow-sm">
                    <i class="bi bi-download me-1"></i> Ekspor CSV
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-wrap">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>Email</th>
                        <th>Terdaftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tBody">
                    @forelse($pelanggan as $index => $user)
                    <tr onclick='showDetail(@json($user))'>
                        <td><span class="no-text">{{ $index + 1 }}</span></td>
                        <td>
                            <div class="user-cell">
                                <div class="ava">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div>
                                    <div class="u-name">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="u-email">{{ $user->email }}</td>
                        <td>
                            <span class="date-pill">
                                {{ optional($user->created_at)->format('d M Y') ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="status-badge status-active">
                                    <i class="bi bi-check-circle-fill me-1"></i>Terverifikasi
                                </span>
                            @else
                                <span class="status-badge status-inactive">
                                    <i class="bi bi-x-circle-fill me-1"></i>Belum Verifikasi
                                </span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="event.stopPropagation(); showDetail(@json($user))">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="bi bi-people"></i>
                                <p class="mb-0">Belum ada pelanggan terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($pelanggan) && method_exists($pelanggan, 'links'))
            <div class="d-flex justify-content-end mt-3">
                {{ $pelanggan->links() }}
            </div>
        @endif
    </div>
</section>

{{-- Modal Detail Pelanggan --}}
<div class="modal-overlay" id="modalOverlay">
    <div class="custom-modal">
        <div class="modal-head">
            <h6 id="modalTitle">Detail Pelanggan</h6>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="avatar-large" id="modalAvatar">?</div>
            <div id="modalBody"></div>
        </div>
        <div class="p-3 border-top d-flex justify-content-end gap-2">
            <button class="btn btn-light btn-sm border" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Data pelanggan dari Laravel (untuk filter & export)
    const rawData = {!! json_encode($pelanggan instanceof \Illuminate\Pagination\LengthAwarePaginator ? $pelanggan->items() : $pelanggan->toArray()) !!};

    function doFilter() {
        const q = document.getElementById('searchInput').value.toLowerCase().trim();

        if (!q) {
            renderTable(rawData);
            return;
        }

        const filtered = rawData.filter(item =>
            (item.name  && item.name.toLowerCase().includes(q)) ||
            (item.email && item.email.toLowerCase().includes(q))
        );
        renderTable(filtered);
    }

    function renderTable(data) {
        const tb = document.getElementById('tBody');

        if (data.length === 0) {
            tb.innerHTML = `
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-search"></i>
                            <p class="mb-0">Data pelanggan tidak ditemukan.</p>
                        </div>
                    </td>
                </tr>`;
            document.getElementById('countBadge').textContent = '0 pelanggan';
            return;
        }

        tb.innerHTML = data.map((item, i) => {
            const initial  = item.name ? item.name.charAt(0).toUpperCase() : '?';
            const tgl      = item.created_at
                ? new Date(item.created_at).toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' })
                : '-';
            const verified = item.email_verified_at;
            const badge    = verified
                ? `<span class="status-badge status-active"><i class="bi bi-check-circle-fill me-1"></i>Terverifikasi</span>`
                : `<span class="status-badge status-inactive"><i class="bi bi-x-circle-fill me-1"></i>Belum Verifikasi</span>`;

            return `
                <tr onclick='showDetail(${JSON.stringify(item)})'>
                    <td><span class="no-text">${i + 1}</span></td>
                    <td>
                        <div class="user-cell">
                            <div class="ava">${initial}</div>
                            <div><div class="u-name">${item.name}</div></div>
                        </div>
                    </td>
                    <td class="u-email">${item.email}</td>
                    <td><span class="date-pill">${tgl}</span></td>
                    <td>${badge}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger"
                            onclick="event.stopPropagation(); showDetail(${JSON.stringify(item)})">
                            Detail
                        </button>
                    </td>
                </tr>`;
        }).join('');

        document.getElementById('countBadge').textContent = data.length + ' pelanggan';
    }

    function showDetail(item) {
        const initial = item.name ? item.name.charAt(0).toUpperCase() : '?';
        const tgl = item.created_at
            ? new Date(item.created_at).toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' })
            : '-';
        const verified = item.email_verified_at
            ? new Date(item.email_verified_at).toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' })
            : null;

        document.getElementById('modalTitle').textContent = item.name || 'Detail Pelanggan';
        document.getElementById('modalAvatar').textContent = initial;

        document.getElementById('modalBody').innerHTML = `
            <div class="detail-row">
                <span class="dk">Nama Lengkap</span>
                <span class="dv">${item.name}</span>
            </div>
            <div class="detail-row">
                <span class="dk">Email</span>
                <span class="dv">${item.email}</span>
            </div>
            <div class="detail-row">
                <span class="dk">Tanggal Daftar</span>
                <span class="dv">${tgl}</span>
            </div>
            <div class="detail-row">
                <span class="dk">Status Email</span>
                <span class="dv">
                    ${verified
                        ? `<span class="status-badge status-active"><i class="bi bi-check-circle-fill me-1"></i>Terverifikasi (${verified})</span>`
                        : `<span class="status-badge status-inactive"><i class="bi bi-x-circle-fill me-1"></i>Belum Verifikasi</span>`
                    }
                </span>
            </div>`;

        document.getElementById('modalOverlay').classList.add('open');
    }

    function closeModal() {
        document.getElementById('modalOverlay').classList.remove('open');
    }

    function exportCSV() {
        if (rawData.length === 0) {
            alert('Tidak ada data untuk diekspor.');
            return;
        }

        let csv = '\ufeffNo,Nama,Email,Tanggal Daftar,Status\n';
        rawData.forEach((row, i) => {
            const tgl = row.created_at
                ? new Date(row.created_at).toLocaleDateString('id-ID')
                : '-';
            const status = row.email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi';
            csv += `${i + 1},"${row.name}","${row.email}","${tgl}","${status}"\n`;
        });

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.setAttribute('href', URL.createObjectURL(blob));
        link.setAttribute('download', 'Data_Pelanggan_' + new Date().toLocaleDateString('id-ID').replace(/\//g, '-') + '.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Tutup modal jika klik di luar area
    window.onclick = function(event) {
        const modal = document.getElementById('modalOverlay');
        if (event.target === modal) closeModal();
    };
</script>
@endpush