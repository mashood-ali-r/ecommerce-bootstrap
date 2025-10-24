<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EEZEPC.com — Mobile Phones, TVs, Home Appliances, Computers, Laptops, Gaming Consoles & more in Pakistan')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar bg-dark text-white py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small><i class="fas fa-phone-alt me-2"></i>(0302) 2044172</small>
                    <small class="ms-3"><i class="fas fa-envelope me-2"></i>Help: help@eezepc.com</small>
                    <small class="ms-3"><i class="fas fa-envelope me-2"></i>Sales: sales@eezepc.com</small>
                </div>
                <div class="col-md-6 text-end">
                    <small>
                        <a href="#" class="text-white text-decoration-none me-3">Track Order</a>
                        <a href="#" class="text-white text-decoration-none me-3">Loyalty Program</a>
                        <a href="#" class="text-white text-decoration-none me-3">Buy Now Pay Later</a>
                        <a href="#" class="text-white text-decoration-none">Help</a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-3" href="{{ route('home') }}">
                EEZEPC<span class="text-danger">.com</span>
            </a>
            
            <!-- Search Bar -->
            <form class="d-none d-lg-flex flex-grow-1 mx-5" action="{{ route('products.search') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="query" placeholder="Products search">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Right Side Icons -->
            <div class="d-flex align-items-center">
                <a href="{{ route('account') }}" class="text-dark me-3 position-relative">
                    <i class="fas fa-user fs-5"></i>
                </a>
                <a href="{{ route('wishlist') }}" class="text-dark me-3 position-relative">
                    <i class="fas fa-heart fs-5"></i>
                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">0</span>
                </a>
                <a href="{{ route('cart.view') }}" class="btn btn-outline-primary me-2 position-relative">
                    <i class="fas fa-shopping-cart me-1"></i>
                    <span class="badge bg-primary position-absolute top-0 start-100 translate-middle rounded-pill">{{ count(session('cart', [])) }}</span>
                    <span class="d-none d-md-inline">Basket</span>
                </a>
            </div>

            <button class="navbar-toggler ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories') }}">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('deals') }}">Hot Deals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Category Mega Menu -->
    <div class="category-bar bg-light border-bottom d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="nav justify-content-center py-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link text-dark dropdown-toggle" href="#" data-bs-toggle="dropdown">Mobile Phones & Tablets</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Mobile Phones</a></li>
                                <li><a class="dropdown-item" href="#">Tablets</a></li>
                                <li><a class="dropdown-item" href="#">Mobile Accessories</a></li>
                                <li><a class="dropdown-item" href="#">eReaders</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-dark dropdown-toggle" href="#" data-bs-toggle="dropdown">Computer Components</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">PC Components</a></li>
                                <li><a class="dropdown-item" href="#">Networking</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-dark dropdown-toggle" href="#" data-bs-toggle="dropdown">Computers & Office</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Monitors</a></li>
                                <li><a class="dropdown-item" href="#">Laptops</a></li>
                                <li><a class="dropdown-item" href="#">Peripherals</a></li>
                                <li><a class="dropdown-item" href="#">Software</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-dark dropdown-toggle" href="#" data-bs-toggle="dropdown">Consoles & Gaming</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Consoles</a></li>
                                <li><a class="dropdown-item" href="#">Gaming Controllers</a></li>
                                <li><a class="dropdown-item" href="#">Games</a></li>
                                <li><a class="dropdown-item" href="#">Gaming Chairs</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-dark dropdown-toggle" href="#" data-bs-toggle="dropdown">Wearable & Gadgets</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Smart Watches</a></li>
                                <li><a class="dropdown-item" href="#">Virtual Reality</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-dark dropdown-toggle" href="#" data-bs-toggle="dropdown">Home Appliances</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Kitchen Appliances</a></li>
                                <li><a class="dropdown-item" href="#">Air Conditioners</a></li>
                                <li><a class="dropdown-item" href="#">Personal Care</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-dark dropdown-toggle" href="#" data-bs-toggle="dropdown">TV & Audio/Video</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Televisions</a></li>
                                <li><a class="dropdown-item" href="#">Projectors</a></li>
                                <li><a class="dropdown-item" href="#">Home Audio</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">EEZEPC.com</h5>
                    <p class="small">Mobile Phones, TVs, Home Appliances, Computers, Laptops, Gaming Consoles & more in Pakistan</p>
                    <div class="contact-info">
                        <p class="small mb-1"><strong>Got Questions? Contact Us</strong></p>
                        <p class="small mb-1">(0302) 2044172</p>
                        <p class="small mb-1">Monday – Saturday: 11:00 A.M – 6:00 P.M</p>
                        <p class="small mb-1">Help: help@eezepc.com</p>
                        <p class="small mb-1">Sales: sales@eezepc.com</p>
                    </div>
                    <div class="social-links mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Categories</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Smartphones & Tablets</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Home Appliances</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Computer Components</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Computers & Office</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">TV & Audio/Video</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Consoles & Gaming</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Wearable & Gadgets</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Customer Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Contact Us</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Track Order</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Loyalty Program</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Payments</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Tap and Pay</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Policy</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Delivery, Return, and Warranty</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Buy Now Pay Later</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Shipping Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Terms & Conditions</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <hr class="bg-secondary">
            
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small mb-0">&copy; {{ date('Y') }} EEZEPC. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small mb-0">Payments</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('scripts')
</body>
</html>