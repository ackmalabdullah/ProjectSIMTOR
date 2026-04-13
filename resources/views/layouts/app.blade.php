<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — Honda Jember</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet" />

    {{-- Compiled CSS & JS (Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body>

    {{-- Pembungkus Utama agar Sidebar & Content sejajar sesuai CSS .app-layout --}}
    <div class="app-layout">

        {{-- Sidebar: Pastikan di dalam sidebar.blade.php menggunakan class .sidebar --}}
        @include('app.partials.sidebar')

        {{-- Area Konten Utama --}}
        <div class="main-content">

            {{-- Topbar: Pastikan di dalam topbar.blade.php menggunakan class .topbar --}}
            @include('app.partials.topbar')

            {{-- Isi Halaman --}}
            <main class="page-inner fade-up">
                @yield('content')
            </main>

        </div> {{-- End .main-content --}}

    </div> {{-- End .app-layout --}}

    {{-- Notifikasi Toast --}}
    @include('app.partials.toast')

    {{-- Penampung Modal --}}
    @stack('modals')

    {{-- Skrip JavaScript --}}
    @stack('scripts')

</body>
</html>