<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Store')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (for cart icon, etc.) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Optional: custom CSS -->
    <style>
        /* Ensure body takes full height for sticky footer */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1; /* Pushes footer down */
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Optional header/banner -->
    @include('partials.header')

    <!-- Main content -->
    <main class="container mt-4">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
