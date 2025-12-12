@extends('layouts.app')

@section('title', 'All Products - EEZEPC.com')

@section('content')
    <div class="bg-light min-vh-100">
        <div class="container-fluid py-3">
            <div class="row">
                <!-- Left Sidebar - Filters (Amazon Style) -->
                <div class="col-lg-2 col-md-3 mb-4">
                    <div class="bg-white p-3 border-0 rounded">
                        <h6 class="fw-bold mb-3" style="font-size: 14px; color: #0f1111;">Department</h6>
                        <ul class="list-unstyled mb-4" style="font-size: 13px;">
                            <li class="mb-1">
                                <a href="{{ route('products.index') }}"
                                    class="text-decoration-none {{ !request('category') ? 'fw-bold' : '' }}"
                                    style="color: {{ !request('category') ? '#c7511f' : '#0f1111' }};">
                                    All Products
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li class="mb-1 ps-2">
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                        class="text-decoration-none {{ (request('category') == $category->id || request('category') == $category->slug) ? 'fw-bold' : '' }}"
                                        style="color: {{ (request('category') == $category->id || request('category') == $category->slug) ? '#c7511f' : '#0f1111' }};">
                                        {{ $category->name }}
                                    </a>
                                    <span class="text-muted small">({{ $category->products_count }})</span>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Price Filter -->
                        <h6 class="fw-bold mb-2 border-top pt-3" style="font-size: 14px; color: #0f1111;">Price</h6>
                        <form method="GET" action="{{ route('products.index') }}" id="priceFilterForm">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif

                            <ul class="list-unstyled mb-3" style="font-size: 13px;">
                                <li class="mb-1">
                                    <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']), [])) }}"
                                        class="text-decoration-none" style="color: #0f1111;">Any Price</a>
                                </li>
                                <li class="mb-1">
                                    <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']), ['max_price' => 10000])) }}"
                                        class="text-decoration-none" style="color: #0f1111;">Under Rs 10,000</a>
                                </li>
                                <li class="mb-1">
                                    <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']), ['min_price' => 10000, 'max_price' => 50000])) }}"
                                        class="text-decoration-none" style="color: #0f1111;">Rs 10,000 - Rs 50,000</a>
                                </li>
                                <li class="mb-1">
                                    <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']), ['min_price' => 50000, 'max_price' => 100000])) }}"
                                        class="text-decoration-none" style="color: #0f1111;">Rs 50,000 - Rs 100,000</a>
                                </li>
                                <li class="mb-1">
                                    <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']), ['min_price' => 100000])) }}"
                                        class="text-decoration-none" style="color: #0f1111;">Over Rs 100,000</a>
                                </li>
                            </ul>

                            <div class="d-flex gap-1 align-items-center" style="font-size: 12px;">
                                <span class="text-muted">Rs</span>
                                <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min"
                                    value="{{ request('min_price') }}" style="width: 70px; font-size: 12px;">
                                <span class="text-muted">-</span>
                                <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max"
                                    value="{{ request('max_price') }}" style="width: 70px; font-size: 12px;">
                                <button type="submit" class="btn btn-sm"
                                    style="background: #f0f0f0; border: 1px solid #ccc; padding: 4px 8px;">Go</button>
                            </div>
                        </form>

                        <!-- Clear Filters -->
                        @if(request()->hasAny(['category', 'search', 'min_price', 'max_price', 'sort']))
                            <div class="border-top mt-3 pt-3">
                                <a href="{{ route('products.index') }}" class="text-decoration-none small"
                                    style="color: #007185;">
                                    <i class="fas fa-times me-1"></i>Clear all filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Main Content - Products Grid -->
                <div class="col-lg-10 col-md-9">
                    <!-- Results Header Bar -->
                    <div
                        class="bg-white p-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2 rounded">
                        <div>
                            <span style="font-size: 14px; color: #565959;">
                                @if(request('search'))
                                    Results for "<span class="fw-bold text-dark">{{ request('search') }}</span>"
                                @else
                                    Showing
                                @endif
                                <span class="text-dark">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}
                                    of {{ $products->total() }} results</span>
                                @if(request('category'))
                                @if(request('category'))
                                    @php 
                                        $catReq = request('category');
                                        $currentCategory = $categories->first(function($c) use ($catReq) {
                                            return $c->id == $catReq || $c->slug == $catReq;
                                        });
                                    @endphp
                                    @if($currentCategory)
                                        in <span class="fw-bold">{{ $currentCategory->name }}</span>
                                    @endif
                                @endif
                                @endif
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small">Sort by:</span>
                            <select class="form-select form-select-sm" style="width: auto; font-size: 13px;"
                                onchange="window.location.href=this.value">
                                <option
                                    value="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'created_at'])) }}"
                                    {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Newest Arrivals
                                </option>
                                <option
                                    value="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}"
                                    {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option
                                    value="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}"
                                    {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option
                                    value="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'name'])) }}"
                                    {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                                <option
                                    value="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'popular'])) }}"
                                    {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            </select>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="row g-3">
                        @forelse($products as $product)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="bg-white border rounded h-100 p-3 product-card-amz d-flex flex-column">
                                    <!-- Product Image -->
                                    <div class="text-center position-relative mb-2">
                                        <a href="{{ route('products.show', $product->slug) }}">
                                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/200x200?text=' . urlencode(Str::limit($product->name, 10)) }}"
                                                alt="{{ $product->name }}" class="img-fluid"
                                                style="height: 180px; object-fit: contain;">
                                        </a>
                                        <!-- Wishlist Heart -->
                                        <button class="btn btn-sm position-absolute wishlist-heart"
                                            style="top: 0; right: 0; background: transparent; border: none;"
                                            onclick="quickAddToWishlist({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, this)">
                                            <i class="far fa-heart" style="font-size: 20px; color: #888;"></i>
                                        </button>
                                        @if($product->compare_price && $product->compare_price > $product->price)
                                            <span class="badge position-absolute" style="top: 5px; left: 5px; background: #CC0C39;">
                                                {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                                                off
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="d-flex flex-column flex-grow-1">
                                        <!-- Product Name -->
                                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none mb-1"
                                            style="color: #0f1111; font-size: 14px; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $product->name }}
                                        </a>

                                        <!-- Rating (Random for demo) -->
                                        @php $rating = rand(35, 50) / 10;
                                        $reviews = rand(20, 300); @endphp
                                        <div class="d-flex align-items-center mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($rating))
                                                    <i class="fas fa-star" style="color: #ffa41c; font-size: 12px;"></i>
                                                @elseif($i - 0.5 <= $rating)
                                                    <i class="fas fa-star-half-alt" style="color: #ffa41c; font-size: 12px;"></i>
                                                @else
                                                    <i class="far fa-star" style="color: #ffa41c; font-size: 12px;"></i>
                                                @endif
                                            @endfor
                                            <a href="{{ route('products.show', $product->slug) }}#reviews"
                                                class="ms-1 text-decoration-none"
                                                style="color: #007185; font-size: 12px;">{{ number_format($reviews) }}</a>
                                        </div>

                                        <!-- Price -->
                                        <div class="mb-2">
                                            <span style="font-size: 20px; color: #0f1111;">Rs</span>
                                            <span
                                                style="font-size: 20px; color: #0f1111; font-weight: 400;">{{ number_format($product->price) }}</span>
                                            @if($product->compare_price && $product->compare_price > $product->price)
                                                <div>
                                                    <span class="text-muted text-decoration-line-through small">Rs
                                                        {{ number_format($product->compare_price) }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Delivery Info -->
                                        <p class="mb-2" style="font-size: 12px; color: #565959;">
                                            <span style="color: #007185;">FREE Delivery</span> by EEZEPC
                                        </p>

                                        <!-- Spacer to push button down -->
                                        <div class="flex-grow-1"></div>

                                        <!-- Add to Cart -->
                                        <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <input type="hidden" name="name" value="{{ $product->name }}">
                                            <input type="hidden" name="price" value="{{ $product->price }}">
                                            <button type="submit" class="btn btn-sm w-100"
                                                style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; border-radius: 20px; font-size: 12px;">
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="bg-white rounded p-5 text-center">
                                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                                    <h4 class="mb-2" style="color: #0f1111;">No results found</h4>
                                    <p class="text-muted mb-3">We couldn't find any products matching your criteria.</p>
                                    <a href="{{ route('products.index') }}" class="btn"
                                        style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734;">
                                        View All Products
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            <nav>
                                <ul class="pagination mb-0">
                                    @if($products->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link" style="border-radius: 8px 0 0 8px;">←
                                                Previous</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}"
                                                style="border-radius: 8px 0 0 8px; color: #0f1111;">← Previous</a></li>
                                    @endif

                                    @foreach($products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)) as $page => $url)
                                        <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}"
                                                style="{{ $page == $products->currentPage() ? 'background-color: #febd69; border-color: #febd69; color: #0f1111;' : 'color: #0f1111;' }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if($products->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}"
                                                style="border-radius: 0 8px 8px 0; color: #0f1111;">Next →</a></li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link"
                                                style="border-radius: 0 8px 8px 0;">Next →</span></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .product-card-amz {
                transition: box-shadow 0.2s ease;
            }

            .product-card-amz:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .wishlist-heart {
                opacity: 0;
                transition: opacity 0.2s;
            }

            .product-card-amz:hover .wishlist-heart {
                opacity: 1;
            }

            .wishlist-heart:hover i {
                color: #e47911 !important;
            }

            .wishlist-heart.added i {
                color: #e47911 !important;
                font-weight: 900;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function quickAddToWishlist(productId, productName, productPrice, btn) {
                const icon = btn.querySelector('i');
                icon.className = 'fas fa-spinner fa-spin';

                fetch('{{ route("wishlist.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        id: productId,
                        name: productName,
                        price: productPrice
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            icon.className = 'fas fa-heart';
                            icon.style.color = '#e47911';
                            btn.classList.add('added');
                            showToast('Added to Wishlist!', 'success');
                        } else {
                            icon.className = 'far fa-heart';
                            showToast(data.message, 'warning');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        icon.className = 'far fa-heart';
                        showToast('Error adding to wishlist', 'danger');
                    });
            }

            function showToast(message, type) {
                const toast = document.createElement('div');
                toast.className = `alert alert-${type} position-fixed shadow-lg border-0`;
                toast.style.cssText = 'top: 80px; right: 20px; z-index: 9999; min-width: 250px; animation: slideIn 0.3s ease;';
                toast.innerHTML = `<div class="d-flex align-items-center"><i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i><span>${message}</span></div>`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 2500);
            }
        </script>
    @endpush
@endsection