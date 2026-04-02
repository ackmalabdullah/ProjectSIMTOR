<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? '' : 'collapsed' }}" href="{{ url('/dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Master Data Motor -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#motor-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-motherboard"></i><span>Master Motor</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="motor-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('/motor') }}">
                        <i class="bi bi-list-ul"></i><span>Semua Motor</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/motor/create') }}">
                        <i class="bi bi-plus-circle"></i><span>Tambah Motor</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/motor/category') }}">
                        <i class="bi bi-tags"></i><span>Kategori Motor</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/motor/stock') }}">
                        <i class="bi bi-box-seam"></i><span>Stok Motor</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Simulasi Kredit -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#simulasi-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-calculator"></i><span>Simulasi Kredit</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="simulasi-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('/simulasi') }}">
                        <i class="bi bi-plus-circle"></i><span>Simulasi Baru</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/simulasi/history') }}">
                        <i class="bi bi-clock-history"></i><span>Riwayat Simulasi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/simulasi/approved') }}">
                        <i class="bi bi-check-circle"></i><span>Disetujui</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/simulasi/rejected') }}">
                        <i class="bi bi-x-circle"></i><span>Ditolak</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Rekomendasi Motor -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#rekomendasi-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-star"></i><span>Rekomendasi</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="rekomendasi-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('/rekomendasi') }}">
                        <i class="bi bi-graph-up"></i><span>Rekomendasi Otomatis</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/rekomendasi/trending') }}">
                        <i class="bi bi-fire"></i><span>Motor Trending</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/rekomendasi/terlaris') }}">
                        <i class="bi bi-trophy"></i><span>Motor Terlaris</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/rekomendasi/promo') }}">
                        <i class="bi bi-gift"></i><span>Promo Spesial</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Pelanggan -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#pelanggan-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people"></i><span>Pelanggan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="pelanggan-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('/pelanggan') }}">
                        <i class="bi bi-person-badge"></i><span>Semua Pelanggan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/pelanggan/create') }}">
                        <i class="bi bi-person-plus"></i><span>Tambah Pelanggan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/pelanggan/verifikasi') }}">
                        <i class="bi bi-shield-check"></i><span>Verifikasi Data</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Transaksi -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#transaksi-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-cart"></i><span>Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="transaksi-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('/transaksi') }}">
                        <i class="bi bi-receipt"></i><span>Semua Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/transaksi/pending') }}">
                        <i class="bi bi-hourglass-split"></i><span>Pending</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/transaksi/selesai') }}">
                        <i class="bi bi-check-all"></i><span>Selesai</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/transaksi/laporan') }}">
                        <i class="bi bi-file-text"></i><span>Laporan</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-heading">Pengaturan</li>

        <!-- User Management -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person-gear"></i><span>User Management</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="user-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('/admin') }}">
                        <i class="bi bi-person-bounding-box"></i><span>Semua User</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/create') }}">
                        <i class="bi bi-person-add"></i><span>Tambah User</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/role') }}">
                        <i class="bi bi-tag"></i><span>Role & Permission</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Pengaturan Sistem -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('/settings') }}">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>
        </li>

        <!-- Backup Database -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('/backup') }}">
                <i class="bi bi-database"></i>
                <span>Backup Database</span>
            </a>
        </li>

        <!-- Laporan -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#laporan-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-earmark-text"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="laporan-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('/laporan/penjualan') }}">
                        <i class="bi bi-bar-chart"></i><span>Laporan Penjualan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/laporan/keuangan') }}">
                        <i class="bi bi-currency-dollar"></i><span>Laporan Keuangan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/laporan/stok') }}">
                        <i class="bi bi-box"></i><span>Laporan Stok</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>

</aside>
