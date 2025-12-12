<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Seller Central') - EEZEPC.com</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --amz-dark: #131921;
            --amz-dark-secondary: #232f3e;
            --amz-orange: #ff9900;
            --amz-orange-hover: #e88a00;
            --amz-light-orange: #febd69;
            --amz-blue: #007185;
            --amz-body-bg: #eaeded;
            --sidebar-width: 240px;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--amz-body-bg);
            min-height: 100vh;
        }

        /* Admin Header - Amazon Seller Central Style */
        .admin-header-bar {
            background: linear-gradient(180deg, var(--amz-dark) 0%, var(--amz-dark-secondary) 100%);
            height: 60px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .admin-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            margin-right: 30px;
        }

        .admin-brand-text {
            font-size: 22px;
            font-weight: 700;
            color: white;
            letter-spacing: -0.5px;
        }

        .admin-brand-accent {
            color: var(--amz-orange);
        }

        .admin-brand-label {
            background: var(--amz-orange);
            color: var(--amz-dark);
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 3px;
            margin-left: 8px;
            text-transform: uppercase;
        }

        /* Admin Navigation */
        .admin-nav {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .admin-nav-link {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            transition: all 0.2s;
            margin-right: 4px;
        }

        .admin-nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .admin-nav-link.active {
            background: var(--amz-dark-secondary);
            color: var(--amz-light-orange);
        }

        .admin-nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-user-info {
            color: white;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .admin-user-avatar {
            width: 32px;
            height: 32px;
            background: var(--amz-orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--amz-dark);
        }

        /* Main Content Area */
        .admin-main {
            margin-top: 60px;
            padding: 20px 30px;
            min-height: calc(100vh - 60px);
        }

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--amz-dark);
            margin: 0;
        }

        .page-breadcrumb {
            font-size: 13px;
            color: #666;
        }

        .page-breadcrumb a {
            color: var(--amz-blue);
            text-decoration: none;
        }

        .page-breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Cards - Amazon Style */
        .admin-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .admin-card-header {
            background: #f8f8f8;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
            font-weight: 600;
            font-size: 16px;
            color: var(--amz-dark);
        }

        .admin-card-body {
            padding: 20px;
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
        }

        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .stat-icon.blue {
            background: #e3f2fd;
            color: #1976d2;
        }

        .stat-icon.green {
            background: #e8f5e9;
            color: #388e3c;
        }

        .stat-icon.orange {
            background: #fff3e0;
            color: #f57c00;
        }

        .stat-icon.purple {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--amz-dark);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 13px;
            color: #666;
            font-weight: 500;
        }

        /* Buttons - Amazon Style */
        .btn-amz-primary {
            background: linear-gradient(180deg, #f7ca65 0%, #f0ad4e 100%);
            border: 1px solid #c79a3b;
            color: var(--amz-dark);
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-amz-primary:hover {
            background: linear-gradient(180deg, #f0ad4e 0%, #e8a540 100%);
            color: var(--amz-dark);
            transform: translateY(-1px);
        }

        .btn-amz-secondary {
            background: linear-gradient(180deg, #f7f8fa 0%, #e7e9ec 100%);
            border: 1px solid #d5d9d9;
            color: var(--amz-dark);
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-amz-secondary:hover {
            background: linear-gradient(180deg, #e7e9ec 0%, #d5d9d9 100%);
            color: var(--amz-dark);
        }

        /* Tables - Amazon Style */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            background: #f8f8f8;
            padding: 12px 15px;
            font-weight: 600;
            font-size: 13px;
            color: #333;
            border-bottom: 2px solid #ddd;
            text-align: left;
        }

        .admin-table td {
            padding: 12px 15px;
            font-size: 14px;
            color: #333;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .admin-table tr:hover {
            background: #f9f9f9;
        }

        /* Forms - Amazon Style */
        .admin-form-label {
            font-weight: 600;
            font-size: 13px;
            color: #333;
            margin-bottom: 5px;
        }

        .admin-form-control {
            border: 1px solid #d5d9d9;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .admin-form-control:focus {
            border-color: var(--amz-orange);
            box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15);
            outline: none;
        }

        /* Quick Actions */
        .quick-action {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-decoration: none;
            color: var(--amz-dark);
            transition: all 0.2s;
        }

        .quick-action:hover {
            background: #f8f8f8;
            border-color: var(--amz-orange);
            color: var(--amz-dark);
        }

        .quick-action i {
            font-size: 18px;
            color: var(--amz-orange);
        }

        /* Alerts */
        .admin-alert {
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .admin-alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
    </style>

    @stack('styles')
</head>

<body>
    @include('partials.loading')

    <!-- Admin Header Bar -->
    <header class="admin-header-bar">
        <!-- Brand -->
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            <span class="admin-brand-text">EEZEPC</span><span class="admin-brand-text admin-brand-accent">.com</span>
            <span class="admin-brand-label">Seller Central</span>
        </a>

        <!-- Navigation -->
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"
                class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box me-1"></i> Products
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags me-1"></i> Categories
            </a>
            <a href="{{ route('home') }}" class="admin-nav-link" target="_blank">
                <i class="fas fa-external-link-alt me-1"></i> View Store
            </a>
        </nav>

        <!-- Right Side -->
        <div class="admin-nav-right">
            <div class="dropdown">
                <a href="#" class="admin-user-info dropdown-toggle text-decoration-none" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="admin-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="min-width: 180px;">
                    <li class="px-3 py-2 border-bottom">
                        <strong>{{ auth()->user()->name ?? 'Admin' }}</strong><br>
                        <small class="text-muted">{{ auth()->user()->email ?? '' }}</small>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('home') }}">
                            <i class="fas fa-home me-2"></i> Go to Store
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <nav class="page-breadcrumb mb-1">
                    <a href="{{ route('admin.dashboard') }}">Seller Central</a> / @yield('breadcrumb', 'Dashboard')
                </nav>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div>
                @yield('page-actions')
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="admin-alert admin-alert-success mb-4">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="admin-alert admin-alert-error mb-4">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Content -->
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>