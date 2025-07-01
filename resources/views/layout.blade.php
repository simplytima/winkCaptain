<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WinkCaptain')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</head>
<body>
    <main>
        @yield('content')
        @yield('scripts')
    </main>
</body>
</html>