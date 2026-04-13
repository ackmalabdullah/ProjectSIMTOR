<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

{{-- JANGAN DIHAPUS: Ini penting untuk keamanan form/logout Laravel --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', 'SimulasiMotor') — Honda Jember</title>

{{-- Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet"/>

{{-- CSS Utama (Manual via Public Folder) --}}
<link rel="stylesheet" href="{{ asset('css/app.css') }}"/>

@stack('styles')