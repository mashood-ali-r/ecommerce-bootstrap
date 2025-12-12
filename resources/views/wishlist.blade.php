@extends('layouts.app')

@section('title', 'Your Wishlist - EEZEPC.com')

@section('content')
<div class="bg-light min-vh-100">
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: #007185;">Home</a></li>
                <li class="breadcrumb-item active text-muted">Your Wishlist</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Header -->
                <div class="d-flex align-items-end justify-content-between mb-3 border-bottom pb-2">
                    <h1 class="h4 fw-bold mb-0" style="color: #0f1111;">Your Wishlist</h1>
                    @if(count(session('wishlist', [])) > 0)
                        <span class="text-muted small">
                            {{ count(session('wishlist', [])) }} items
                        </span>
                    @endif
                </div>

                @if(count(session('wishlist', [])) > 0)
                    <!-- Wishlist Items List -->
                    <div class="d-flex flex-column gap-3">
                    @foreach(session('wishlist', []) as $item)
                        @php $product = \App\Models\Product::find($item['id']); @endphp
                        
                        <div class="bg-white border rounded-3 p-3 position-relative" id="wishlist-item-{{ $item['id'] }}" 
                            style="border-color: #e5e7eb !important; border-radius: 12px !important; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);">
                            
                            <div class="row g-0">
                                <!-- Image -->
                                <div class="col-md-3 col-sm-4 text-center mb-3 mb-sm-0">
                                    <a href="{{ route('products.show', $product->slug ?? $item['id']) }}" class="d-block">
                                         <img src="{{ $product && $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : 'https://via.placeholder.com/180x180?text=Product' }}"
                                            alt="{{ $item['name'] }}" 
                                            class="img-fluid rounded" 
                                            style="max-height: 180px; object-fit: contain;">
                                    </a>
                                </div>

                                <!-- Details -->
                                <div class="col-md-9 col-sm-8 ps-sm-4">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="mb-1">
                                                <a href="{{ route('products.show', $product->slug ?? $item['id']) }}" 
                                                   class="text-decoration-none text-dark fw-medium fs-5"
                                                   style="line-height: 1.3;">
                                                    {{ $item['name'] }}
                                                </a>
                                            </h5>
                                            
                                            <!-- Rating (Static for consistency if not available) -->
                                            <div class="d-flex align-items-center mb-2">
                                                 @php $rating = rand(35, 50) / 10; @endphp
                                                 <div class="me-2 text-warning small">
                                                    @for($i=1; $i<=5; $i++)
                                                        @if($i <= floor($rating)) <i class="fas fa-star"></i>
                                                        @elseif($i - 0.5 <= $rating) <i class="fas fa-star-half-alt"></i>
                                                        @else <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                 </div>
                                                 <span class="small text-muted">{{ rand(10, 200) }} ratings</span>
                                            </div>

                                            <div class="mb-2">
                                                <span class="fs-5 fw-bold text-dark">Rs {{ number_format($item['price']) }}</span>
                                                @if($product && $product->old_price && $product->old_price > $item['price'])
                                                    <span class="text-decoration-line-through text-muted small ms-1">Rs {{ number_format($product->old_price) }}</span>
                                                    <span class="text-danger small ms-1">
                                                        {{ round((($product->old_price - $item['price']) / $product->old_price) * 100) }}% off
                                                    </span>
                                                @endif
                                            </div>

                                            <p class="mb-2 small">
                                                <span class="text-success fw-bold">In Stock</span>
                                                <span class="text-muted mx-1">|</span>
                                                <span class="text-secondary">Sold by EEZEPC</span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Action Buttons Layout -->
                                    <div class="mt-3 d-flex flex-wrap gap-2 align-items-center">
                                        <button onclick="moveToCart('{{ $item['id'] }}')" 
                                            class="btn btn-sm shadow-sm"
                                            style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; border-radius: 20px; font-size: 13px; color: #111; padding: 6px 16px;">
                                            Add to Cart
                                        </button>
                                        
                                        <button onclick="removeFromWishlist('{{ $item['id'] }}')" 
                                            class="btn btn-sm btn-outline-secondary shadow-sm"
                                            style="border-radius: 20px; font-size: 13px; padding: 6px 12px;">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white border rounded-3 p-5 text-center shadow-sm" 
                         style="border-color: #e5e7eb !important; border-radius: 12px !important;">
                        <h4 class="fw-bold text-dark mb-3">Your Wishlist is empty</h4>
                        <p class="text-muted mb-4">Check out what's trending to fill it up!</p>
                        <a href="{{ route('products.index') }}" class="btn shadow-sm"
                           style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; border-radius: 20px; color: #111;">
                            View Today's Deals
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function removeFromWishlist(productId) {
        const item = document.getElementById('wishlist-item-' + productId);
        if (!item) return;
        
        // Optimistic UI
        item.style.opacity = '0.5';
        
        fetch('{{ route("wishlist.remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                item.remove();
                if(data.count === 0) location.reload();
                if (window.showEezepcToast) {
                    window.showEezepcToast({ type: 'success', title: 'Removed', message: 'Item removed from wishlist' });
                }
            } else {
                item.style.opacity = '1';
            }
        });
    }

    function moveToCart(productId) {
        const item = document.getElementById('wishlist-item-' + productId);
        if (!item) return;

        item.style.opacity = '0.5';
        
        fetch('{{ route("wishlist.moveToCart") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                item.remove();
                if(data.wishlist_count === 0) location.reload();
                
                 // Update cart count
                const cartBadge = document.querySelector('.amz-cart-count');
                if (cartBadge) {
                    cartBadge.textContent = data.cart_count;
                }

                if (window.showEezepcToast) {
                    window.showEezepcToast({ type: 'success', title: 'Moved to Cart', message: 'Item added to cart' });
                }
            } else {
                 item.style.opacity = '1';
                 if (window.showEezepcToast) {
                    window.showEezepcToast({ type: 'error', title: 'Error', message: data.message });
                }
            }
        });
    }
</script>
@endpush
@endsection