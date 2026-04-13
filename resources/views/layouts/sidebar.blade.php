<aside id="sidebar" class="sidebar">
    {{-- Header Sidebar (Logo) --}}
    <div class="sidebar-logo">
        <div class="logo-mark">H</div>
        <div>
            <div class="logo-text">SimulasiMotor</div>
            <div class="logo-sub">Honda Jember</div>
        </div>
    </div>

    {{-- Navigasi Menu --}}
    <nav class="sidebar-nav">
        <div class="nav-section">Menu Utama</div>

        <a class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            <span>Dashboard</span>
        </a>

        <a class="nav-item {{ request()->is('motor*') ? 'active' : '' }}" href="{{ url('/motor') }}">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.15 8a2 2 0 00-1.72-1H15V5a1 1 0 00-1-1H4a2 2 0 00-2 2v9h2a3 3 0 006 0h4a3 3 0 006 0h1v-5.18A2 2 0 0019.15 8zM7 17a1 1 0 110-2 1 1 0 010 2zm10 0a1 1 0 110-2 1 1 0 010 2z"/></svg>
            <span>Master Motor</span>
        </a>

        <div class="nav-section">Data & Laporan</div>

        <a class="nav-item {{ request()->is('simulasi/history*') ? 'active' : '' }}" href="{{ url('/simulasi/history') }}">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 3a9 9 0 00-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42A8.954 8.954 0 0013 21a9 9 0 000-18zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg>
            <span>History Simulasi</span>
        </a>

        <a class="nav-item {{ request()->is('rekomendasi*') ? 'active' : '' }}" href="{{ url('/rekomendasi') }}">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            <span>Rekomendasi</span>
        </a>

        <a class="nav-item {{ request()->is('pelanggan*') ? 'active' : '' }}" href="{{ url('/pelanggan') }}">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3z"/></svg>
            <span>Data Pelanggan</span>
        </a>

        <div class="nav-section">Sistem</div>

        <a class="nav-item {{ request()->is('admin*') ? 'active' : '' }}" href="{{ url('/admin') }}">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            <span>User Management</span>
        </a>
    </nav>

    {{-- Footer Sidebar (User Info) --}}
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
            <div>
                <div class="user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="user-role">Administrator</div>
            </div>
            {{-- Tombol Logout --}}
            <form action="{{ route('logout') }}" method="POST" style="margin-left: auto;">
                @csrf
                <button type="submit" title="Keluar" style="background:none; border:none; color:rgba(255,255,255,0.4); cursor:pointer;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                </button>
            </form>
        </div>
    </div>
</aside>