<div class="topbar">
    {{-- Menampilkan judul halaman secara dinamis --}}
    <span class="topbar-title" id="topbarTitle">
        @yield('title', 'Dashboard') 
    </span>

    <div class="topbar-right">
        {{-- Tombol Notifikasi --}}
        <button class="notif-btn" title="Notifikasi">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
            </svg>
            <span class="notif-dot"></span>
        </button>

        {{-- Info Profil User --}}
        <div class="topbar-user-info" style="display:flex; align-items:center; gap:10px; cursor:pointer;">
            <div id="topbarAvatar" style="width:34px; height:34px; border-radius:50%; background:var(--red); display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; color:#fff; border: 2px solid var(--gray-1);">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div style="display: flex; flex-direction: column;">
                <span style="font-size:13.5px; font-weight:700; color:var(--dark); line-height: 1.2;">
                    {{ Auth::user()->name ?? 'Administrator' }}
                </span>
                <span style="font-size:11px; color:var(--gray-3); font-weight: 500;">
                    Online
                </span>
            </div>
        </div>
    </div>
</div>