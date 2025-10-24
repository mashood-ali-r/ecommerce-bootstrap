<!-- Main Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-3 brand-logo" href="{{ route('home') }}">
            EEZEPC<span class="text-danger">.com</span>
        </a>
        
        <!-- Search Bar -->
        <form class="d-none d-lg-flex flex-grow-1 mx-5" action="{{ route('products.search') }}" method="GET">
            <div class="input-group search-group">
                <input type="text" class="form-control search-input" name="query" placeholder="Products search">
                <button class="btn btn-primary search-btn" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <!-- Right Side Icons -->
        <div class="d-flex align-items-center">
            <a href="{{ route('account') }}" class="text-dark me-3 position-relative nav-icon">
                <i class="fas fa-user fs-5"></i>
            </a>
            <a href="{{ route('wishlist') }}" class="text-dark me-3 position-relative nav-icon">
                <i class="fas fa-heart fs-5"></i>
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">{{ count(session('wishlist', [])) }}</span>
            </a>
            <a href="{{ route('cart.view') }}" class="btn btn-outline-primary me-2 position-relative cart-btn">
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
                    <a class="nav-link nav-link-hover" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-hover" href="{{ route('products.index') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-hover" href="{{ route('categories') }}">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-hover" href="{{ route('deals') }}">Hot Deals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-hover" href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
