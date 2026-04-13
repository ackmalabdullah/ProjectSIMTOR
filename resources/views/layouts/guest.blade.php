<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.header')
</head>
<body>

    <div class="guest-wrapper">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>