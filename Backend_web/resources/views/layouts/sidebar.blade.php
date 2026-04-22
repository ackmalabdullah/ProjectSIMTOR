<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Master Motor -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('motor*') ? 'active' : '' }}" href="{{ url('/motor') }}">
                <i class="bi bi-airplane"></i>
                <span>Master Motor</span>
            </a>
        </li>

        <!-- History Simulasi -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('simulasi/history*') ? 'active' : '' }}" href="{{ url('/simulasi/history') }}">
                <i class="bi bi-calculator"></i>
                <span>History Simulasi</span>
            </a>
        </li>

        <!-- Rekomendasi Motor -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('rekomendasi*') ? 'active' : '' }}" href="{{ url('/rekomendasi') }}">
                <i class="bi bi-star-fill"></i>
                <span>Rekomendasi Motor</span>
            </a>
        </li>

        <!-- Pelanggan -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('pelanggan*') ? 'active' : '' }}" href="{{ url('/pelanggan') }}">
                <i class="bi bi-people-fill"></i>
                <span>Pelanggan</span>
            </a>
        </li>

        <!-- User Management -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin*') ? 'active' : '' }}" href="{{ url('/admin') }}">
                <i class="bi bi-person-square"></i>
                <span>Admin Management</span>
            </a>
        </li>

        <!-- Laporan -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" href="{{ url('/laporan') }}">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Laporan</span>
            </a>
        </li>

    </ul>

</aside>