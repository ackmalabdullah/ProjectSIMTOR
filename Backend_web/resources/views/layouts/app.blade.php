<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title', 'Sistem Manajemen Motor')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    @stack('styles')

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    /* ═══ HONDA RED THEME OVERRIDE ═══ */
    :root {
        --honda-red: #cc0000;
        --honda-red-dark: #aa0000;
        --honda-red-light: #fff0f0;
        --honda-red-mid: #ffd6d6;
        --honda-font: 'Plus Jakarta Sans', 'Nunito', sans-serif;
    }

    /* ── SIDEBAR ── */
    .sidebar-nav .nav-link {
        padding: 14px 15px !important;
        margin-bottom: 5px;
        border-radius: 6px;
        color: #444 !important;
        font-family: var(--honda-font);
        transition: all 0.3s ease;
        background: #fff !important;
    }
    .sidebar-nav .nav-link.active {
        background-color: var(--honda-red) !important;
        color: #fff !important;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(204,0,0,0.25);
    }
    .sidebar-nav .nav-link.collapsed {
        background-color: #fff !important;
        color: #444 !important;
    }
    .sidebar-nav .nav-link:hover {
        background-color: var(--honda-red-light) !important;
        color: var(--honda-red) !important;
    }

    .sidebar-nav .nav-link i {
        font-size: 1.25rem;
        width: 28px;
        margin-right: 12px;
        transition: all 0.3s;
        color: var(--honda-red) !important; /* Force icons to be red */
    }
    .sidebar-nav .nav-link.active i {
        color: #fff !important;
    }
    .sidebar-nav .nav-link:hover i {
        color: var(--honda-red) !important;
    }
    .sidebar-nav .nav-link.collapsed i {
        color: var(--honda-red) !important;
    }

    /* ── HEADER ── */
    .header {
        border-bottom: 2px solid var(--honda-red) !important;
    }
    .header .logo span {
        color: var(--honda-red) !important;
        font-family: var(--honda-font);
        font-weight: 700;
    }
    .toggle-sidebar-btn:hover {
        color: var(--honda-red) !important;
    }

    /* ── BREADCRUMB ── */
    .breadcrumb-item a {
        color: var(--honda-red) !important;
    }
    .breadcrumb-item.active {
        color: #666 !important;
    }
    .pagetitle h1 {
        font-family: var(--honda-font);
        font-weight: 700;
        color: #1a1a1a;
    }

    /* ── CARD OVERRIDES ── */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .card-title {
        font-family: var(--honda-font) !important;
        font-weight: 700 !important;
        color: #1a1a1a !important;
        border-bottom: 2px solid var(--honda-red);
        padding-bottom: 10px !important;
    }

    /* ── DASHBOARD INFO CARDS ── */
    .info-card .card-icon {
        background: var(--honda-red-light) !important;
        color: var(--honda-red) !important;
    }
    .info-card .card-icon i {
        color: var(--honda-red) !important;
        font-size: 1.8rem;
    }
    .info-card h6 {
        color: var(--honda-red) !important;
        font-family: var(--honda-font);
        font-weight: 700;
    }

    /* ── TABLE OVERRIDES ── */
    .table thead {
        background: var(--honda-red) !important;
    }
    .table thead th {
        background: var(--honda-red) !important;
        color: #fff !important;
        font-family: var(--honda-font);
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none !important;
        padding: 12px !important;
    }
    .table tbody tr:hover {
        background: var(--honda-red-light) !important;
    }
    .table tbody td {
        vertical-align: middle;
        font-size: 13px;
        padding: 12px !important;
    }

    /* ── BUTTONS OVERRIDE ── */
    .btn-primary {
        background-color: var(--honda-red) !important;
        border-color: var(--honda-red) !important;
    }
    .btn-primary:hover, .btn-primary:focus {
        background-color: var(--honda-red-dark) !important;
        border-color: var(--honda-red-dark) !important;
    }
    .btn-outline-primary {
        color: var(--honda-red) !important;
        border-color: var(--honda-red) !important;
    }
    .btn-outline-primary:hover {
        background-color: var(--honda-red) !important;
        color: #fff !important;
    }
    .btn-outline-danger {
        color: var(--honda-red) !important;
        border-color: var(--honda-red) !important;
    }
    .btn-outline-danger:hover {
        background-color: var(--honda-red) !important;
        color: #fff !important;
    }
    .btn-danger {
        background-color: var(--honda-red) !important;
        border-color: var(--honda-red) !important;
    }
    .btn-danger:hover {
        background-color: var(--honda-red-dark) !important;
    }
    .btn-info {
        background-color: var(--honda-red) !important;
        border-color: var(--honda-red) !important;
    }
    .btn-info:hover {
        background-color: var(--honda-red-dark) !important;
    }
    .btn-warning {
        background-color: #f59e0b !important;
        border-color: #f59e0b !important;
        color: #fff !important;
    }
    .btn-success {
        background-color: var(--honda-red) !important;
        border-color: var(--honda-red) !important;
    }
    .btn-success:hover {
        background-color: var(--honda-red-dark) !important;
    }

    /* ── BADGE OVERRIDE ── */
    .badge.bg-primary {
        background-color: var(--honda-red) !important;
    }
    .badge-number {
        background-color: var(--honda-red) !important;
    }

    /* ── PAGINATION ── */
    .page-link {
        color: var(--honda-red) !important;
    }
    .page-item.active .page-link {
        background-color: var(--honda-red) !important;
        border-color: var(--honda-red) !important;
        color: #fff !important;
    }

    /* ── FORM FOCUS ── */
    .form-control:focus, .form-select:focus {
        border-color: var(--honda-red) !important;
        box-shadow: 0 0 0 0.2rem rgba(204,0,0,0.15) !important;
    }

    /* ── BACK TO TOP ── */
    .back-to-top {
        background: var(--honda-red) !important;
    }
    .back-to-top:hover {
        background: var(--honda-red-dark) !important;
    }

    /* ── FOOTER ── */
    .footer {
        border-top: 2px solid var(--honda-red);
    }
    .footer .copyright strong span {
        color: var(--honda-red);
    }

    /* ── SCROLLBAR ── */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-thumb { background: var(--honda-red-mid); border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--honda-red); }

    /* ── DROPDOWN ACTIVE ── */
    .dropdown-item.active, .dropdown-item:active {
        background-color: var(--honda-red) !important;
    }

    /* ── ALERT ── */
    .alert-success {
        background-color: var(--honda-red-light) !important;
        color: var(--honda-red) !important;
        border-color: var(--honda-red-mid) !important;
    }
</style>
</head>

<body>

    
    @include('layouts.header')

    @include('layouts.sidebar')

    <main id="main" class="main">
        @yield('content')
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Sistem Simulasi Motor</span></strong>. All Rights Reserved
        </div>
        {{-- <div class="credits">
            Designed by <a href="#">Your Company</a>
        </div> --}}
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/assets/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>