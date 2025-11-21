<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app" class="d-flex">
        <nav class="bg-dark text-white vh-100 p-3" style="width: 250px;">
            <a class="navbar-brand text-white" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Orders</a>
                </li>
            </ul>
        </nav>

        <main class="w-100 p-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
