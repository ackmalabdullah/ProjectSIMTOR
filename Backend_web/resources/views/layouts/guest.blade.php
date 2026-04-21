<!DOCTYPE html>
<html lang="id">

<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>

<body>

    <div class="guest-wrapper">
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
