@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">

    <!-- Trending Section -->
    <div class="bg-light py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="mb-0 fw-bold">Trending</h6>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-wrap">
                        <span class="badge bg-secondary me-2 mb-1">9070 XT</span>
                        <span class="badge bg-secondary me-2 mb-1">Nintendo Switch 2 Mario</span>
                        <span class="badge bg-secondary me-2 mb-1">ZOWIE</span>
                        <span class="badge bg-secondary me-2 mb-1">Philips Shaver</span>
                        <span class="badge bg-secondary me-2 mb-1">Samsung A56</span>
                        <span class="badge bg-secondary me-2 mb-1">PlayStation 5</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fresh Picks Section -->
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Fresh Picks!</h3>
            <a href="#" class="btn btn-outline-primary">View All</a>
        </div>

        <div class="row">
            @foreach ($featuredProducts as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        <div class="position-relative">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="{{ $product->name }}">
                            <span class="badge new-badge position-absolute top-0 start-0 m-2">New</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">{{ $product->name }}</h6>
                            <p class="card-text price-current mb-3">Rs {{ $product->price }}</p>
                            <div class="d-grid gap-2 mt-auto">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">View Product</a>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-primary w-100 btn-ripple">Add to basket</button>
                                    </form>
                                    <button class="btn btn-outline-danger add-to-wishlist" data-product-id="{{ $product->id }}">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- What's Hot Section -->
    <div class="bg-light py-5">
        <div class="container">
            <h3 class="fw-bold mb-4">What's Hot</h3>
    <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/200x150" class="img-fluid rounded mb-3" alt="iPad x EEZEPC">
                        <h6>iPad x EEZEPC</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/200x150" class="img-fluid rounded mb-3" alt="FC26 x EEZEPC">
                        <h6>FC26 x EEZEPC</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/200x150" class="img-fluid rounded mb-3" alt="EEZEPC x Lenovo">
                        <h6>EEZEPC x Lenovo</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/200x150" class="img-fluid rounded mb-3" alt="Infinix eezepc">
                        <h6>Infinix eezepc</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Deals Section -->
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Flash Deals</h3>
            <a href="#" class="btn btn-outline-primary">View All</a>
        </div>

        <div class="row">
            <!-- Flash Deal Product 1 -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Apple iPhone Air 256GB">
                        <span class="badge flash-deal-badge position-absolute top-0 start-0 m-2">-3%</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">Apple iPhone Air 256GB – Sky Blue (PTA Approved)</h6>
                        <p class="card-text">
                            <small class="price-original">Rs 479,990</small>
                            <span class="price-current ms-2">Rs 464,990</span>
                        </p>
                        <div class="d-grid gap-2 mt-auto">
                            <a href="{{ route('products.show', 'apple-iphone-air-256gb') }}" class="btn btn-outline-primary btn-sm">View Product</a>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="apple-iphone-air-256gb">
                                <button type="submit" class="btn btn-primary w-100 btn-ripple">Add to basket</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash Deal Product 2 -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="LG 50″ 4K UHD AI TV">
                        <span class="badge flash-deal-badge position-absolute top-0 start-0 m-2">-2%</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">LG 50″ 4K UHD AI TV UA84 HDR10 Smart TV (2025)</h6>
                        <p class="card-text">
                            <small class="price-original">Rs 167,990</small>
                            <span class="price-current ms-2">Rs 163,990</span>
                        </p>
                        <div class="d-grid gap-2 mt-auto">
                            <a href="{{ route('products.show', 'lg-50-4k-tv') }}" class="btn btn-outline-primary btn-sm">View Product</a>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="lg-50-4k-tv">
                                <button type="submit" class="btn btn-primary w-100 btn-ripple">Add to basket</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash Deal Product 3 -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Google Pixel 10 Pro XL">
                        <span class="badge flash-deal-badge position-absolute top-0 start-0 m-2">-7%</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">Google Pixel 10 Pro XL (16GB, 256GB, Obsidian)</h6>
                        <p class="card-text">
                            <small class="price-original">Rs 334,990</small>
                            <span class="price-current ms-2">Rs 312,990</span>
                        </p>
                        <div class="d-grid gap-2 mt-auto">
                            <a href="{{ route('products.show', 'google-pixel-10-pro-xl') }}" class="btn btn-outline-primary btn-sm">View Product</a>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="google-pixel-10-pro-xl">
                                <button type="submit" class="btn btn-primary w-100 btn-ripple">Add to basket</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash Deal Product 4 -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Samsung Galaxy Buds Core">
                        <span class="badge flash-deal-badge position-absolute top-0 start-0 m-2">-26%</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">Samsung Galaxy Buds Core True Wireless Earbuds – Black</h6>
                        <p class="card-text">
                            <small class="price-original">Rs 13,590</small>
                            <span class="price-current ms-2">Rs 9,990</span>
                        </p>
                        <div class="d-grid gap-2 mt-auto">
                            <a href="{{ route('products.show', 'samsung-buds-core') }}" class="btn btn-outline-primary btn-sm">View Product</a>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="samsung-buds-core">
                                <button type="submit" class="btn btn-primary w-100 btn-ripple">Add to basket</button>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

    <!-- Gear Up This Month Section -->
    <div class="bg-light py-5">
        <div class="container">
            <h3 class="fw-bold mb-4">Gear Up This Month</h3>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/200x150" class="img-fluid rounded mb-3" alt="Haier x EEZEPC">
                        <h6>Haier x EEZEPC</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/200x150" class="img-fluid rounded mb-3" alt="Xiaomi x EEZEPC">
                        <h6>Xiaomi x EEZEPC</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/200x150" class="img-fluid rounded mb-3" alt="Anker x EEZEPC">
                        <h6>Anker x EEZEPC</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/200x150" class="img-fluid rounded mb-3" alt="Andaseat">
                        <h6>Andaseat</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
