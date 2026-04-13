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

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    @stack('styles')

    <style>
    .sidebar .nav-link {
        padding: 14px 15px !important;
        margin-bottom: 5px;
        border-radius: 6px;
        color: #012970;
        transition: all 0.3s ease;
    }

    .sidebar .nav-link:hover {
        background-color: #f6f9ff;
        color: #4154f1;
    }

    .sidebar .nav-link.active {
        background-color: #4154f1 !important;
        color: #fff !important;
        font-weight: 500;
    }

    .sidebar .nav-link i {
        font-size: 1.25rem;
        width: 28px;
        margin-right: 12px;
        transition: all 0.3s;
    }

    .sidebar .nav-link.active i {
        color: #fff !important;
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