@extends('layouts.app')

@section('content')
    <div class="amz-hero-container">
        <!-- Hero Slider -->
        <div id="heroCarousel" class="carousel slide amz-hero-slider" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                        class="d-block w-100" alt="Gaming Setup" style="height: 600px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                        class="d-block w-100" alt="Tech Deals" style="height: 600px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                        class="d-block w-100" alt="New Arrivals" style="height: 600px; object-fit: cover;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <!-- Gradient Overlay -->
            <div class="amz-hero-overlay"></div>
        </div>

        <!-- Content Grid (Overlaps Hero) -->
        <div class="amz-content-grid">
            <!-- Card 1: Shop by Category (Quad) -->
            <div class="amz-card">
                <h3 class="amz-card-title">Shop by Category</h3>
                <div class="amz-card-content">
                    <div class="amz-quad-grid">
                        @foreach($categories->take(4) as $category)
                            <a href="{{ route('products.index', ['category' => $category->id]) }}" class="amz-quad-item">
                                <img src="https://source.unsplash.com/random/300x300/?{{ $category->slug }}"
                                    class="amz-quad-img" alt="{{ $category->name }}">
                                <span class="amz-quad-label">{{ $category->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('categories') }}" class="amz-card-link">See all categories</a>
            </div>

            <!-- Card 2: Deal of the Day (Single) -->
            <div class="amz-card">
                <h3 class="amz-card-title">Deal of the Day</h3>
                <div class="amz-card-content">
                    @if($flashDeals->count() > 0)
                        @php $deal = $flashDeals->first(); @endphp
                        <a href="{{ route('products.show', $deal->slug) }}" class="d-block h-100">
                            <img src="{{ $deal->image_url ?? 'https://source.unsplash.com/random/600x600/?gadget' }}"
                                class="amz-single-img" alt="{{ $deal->name }}">
                            <div class="mt-2">
                                <span class="badge bg-danger">Up to 50% off</span>
                                <span class="fw-bold text-danger">Top Deal</span>
                            </div>
                            <p class="mb-0 text-truncate">{{ $deal->name }}</p>
                        </a>
                    @else
                        <img src="https://source.unsplash.com/random/600x600/?electronics" class="amz-single-img" alt="Deal">
                    @endif
                </div>
                <a href="{{ route('deals') }}" class="amz-card-link">See all deals</a>
            </div>

            <!-- Card 3: New Arrivals (Quad) -->
            <div class="amz-card">
                <h3 class="amz-card-title">New Arrivals</h3>
                <div class="amz-card-content">
                    <div class="amz-quad-grid">
                        @foreach($newProducts->take(4) as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="amz-quad-item">
                                <img src="{{ $product->image_url ?? 'https://source.unsplash.com/random/300x300/?tech' }}"
                                    class="amz-quad-img" alt="{{ $product->name }}">
                                <span class="amz-quad-label text-truncate">{{ Str::limit($product->name, 15) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('products.index') }}" class="amz-card-link">Shop latest products</a>
            </div>

            <!-- Card 4: Sign In (For Guests) or Featured (For Auth) -->
            <div class="amz-card">
                @auth
                    <h3 class="amz-card-title">Pick up where you left off</h3>
                    <div class="amz-card-content">
                        <div class="amz-quad-grid">
                            @foreach($featuredProducts->take(4) as $product)
                                <a href="{{ route('products.show', $product->slug) }}" class="amz-quad-item">
                                    <img src="{{ $product->image_url ?? 'https://source.unsplash.com/random/300x300/?device' }}"
                                        class="amz-quad-img" alt="{{ $product->name }}">
                                    <span class="amz-quad-label text-truncate">{{ Str::limit($product->name, 15) }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                @else
                    <h3 class="amz-card-title">Sign in for the best experience</h3>
                    <div class="amz-card-content d-flex flex-column justify-content-center align-items-center text-center">
                        <a href="{{ route('login') }}" class="btn btn-warning w-100 mb-3 fw-bold"
                            style="background-color: #f7ca00; border-color: #f7ca00;">Sign in securely</a>
                        <p class="small">New to EEZEPC? <a href="{{ route('register') }}">Start here.</a></p>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Horizontal Scroll Section: Best Sellers -->
        <div class="container-fluid px-4 mb-4">
            <div class="bg-white p-4 shadow-sm">
                <h3 class="amz-card-title mb-3">Best Sellers in Electronics</h3>
                <div class="d-flex overflow-auto pb-3" style="gap: 20px;">
                    @foreach($featuredProducts as $product)
                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark"
                            style="min-width: 200px;">
                            <img src="{{ $product->image_url ?? 'https://source.unsplash.com/random/200x200/?electronics' }}"
                                class="img-fluid mb-2" style="height: 200px; object-fit: contain;">
                            <div class="small text-truncate">{{ $product->name }}</div>
                            <div class="text-danger fw-bold">Rs {{ number_format($product->price) }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection