@extends('layouts.app')

@section('title', "Today's Deals - EEZEPC.com")

@section('content')
<div class="bg-light min-vh-100">
    <!-- Deals Header Banner -->
    <div class="text-white py-4" style="background: linear-gradient(135deg, #232f3e 0%, #37475a 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h3 fw-bold mb-2">
                        <i class="fas fa-bolt me-2" style="color: #febd69;"></i>Today's Deals
                    </h1>
                    <p class="mb-0 opacity-75">Limited-time deals on top products. These deals move fast, so grab them while you can!</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-inline-block bg-white text-dark rounded px-3 py-2">
                        <small class="text-muted">Deals end in:</small>
                        <div class="fw-bold" style="font-size: 20px; color: #B12704;" id="countdown">23:59:59</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <!-- Deal Categories Tabs -->
        <div class="bg-white rounded p-3 mb-4">
            <div class="d-flex gap-3 overflow-auto pb-2">
                <a href="#" class="btn btn-sm active" style="background: #232f3e; color: white; white-space: nowrap;">All Deals</a>
                <a href="#" class="btn btn-sm btn-outline-secondary" style="white-space: nowrap;">Electronics</a>
                <a href="#" class="btn btn-sm btn-outline-secondary" style="white-space: nowrap;">Computers</a>
                <a href="#" class="btn btn-sm btn-outline-secondary" style="white-space: nowrap;">Mobile Phones</a>
                <a href="#" class="btn btn-sm btn-outline-secondary" style="white-space: nowrap;">Gaming</a>
            </div>
        </div>

        <!-- Deals Grid -->
        <div class="row g-3">
            @php
                // Get flash deal products or featured products from database
                $dealProducts = \App\Models\Product::where('is_active', true)
                    ->where(function($q) {
                        $q->where('is_flash_deal', true)
                          ->orWhere('is_featured', true);
                    })
                    ->inRandomOrder()
                    ->limit(12)
                    ->get();
                
                // If no deal products, get random products
                if($dealProducts->isEmpty()) {
                    $dealProducts = \App\Models\Product::where('is_active', true)
                        ->inRandomOrder()
                        ->limit(12)
                        ->get();
                }
            @endphp

            @forelse($dealProducts as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="bg-white border rounded h-100 overflow-hidden deal-card">
                    <!-- Deal Badge -->
                    <div class="position-relative">
                        @php 
                            $discount = rand(10, 45);
                            $originalPrice = $product->price * (100 / (100 - $discount));
                        @endphp
                        <span class="badge position-absolute" style="top: 10px; left: 10px; background: #CC0C39; font-size: 14px; z-index: 2;">
                            {{ $discount }}% off
                        </span>
                        
                        <!-- Wishlist Button -->
                        <button class="btn btn-sm position-absolute wishlist-btn-deal" 
                                style="top: 10px; right: 10px; background: rgba(255,255,255,0.9); border-radius: 50%; width: 36px; height: 36px; z-index: 2;"
                                onclick="addDealToWishlist({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, this)">
                            <i class="far fa-heart" style="color: #232f3e;"></i>
                        </button>

                        <!-- Product Image -->
                        <a href="{{ route('products.show', $product->slug) }}" class="d-block text-center p-3" style="background: #fafafa;">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/200x200?text=' . urlencode(Str::limit($product->name, 10)) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid" 
                                 style="height: 180px; object-fit: contain;">
                        </a>
                    </div>

                    <!-- Deal Info -->
                    <div class="p-3">
                        <!-- Deal Timer Bar -->
                        <div class="mb-2">
                            @php $claimed = rand(30, 85); @endphp
                            <div class="progress" style="height: 20px; background: #f5d9d5; border-radius: 10px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $claimed }}%; background: linear-gradient(90deg, #ff4444, #cc0c39); border-radius: 10px;">
                                    <small class="fw-bold">{{ $claimed }}% claimed</small>
                                </div>
                            </div>
                        </div>

                        <!-- Product Name -->
                        <a href="{{ route('products.show', $product->slug) }}" 
                           class="text-decoration-none d-block mb-2" 
                           style="color: #0f1111; font-size: 14px; line-height: 1.3; height: 40px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $product->name }}
                        </a>

                        <!-- Price -->
                        <div class="mb-2">
                            <span style="font-size: 24px; color: #B12704; font-weight: 500;">Rs {{ number_format($product->price) }}</span>
                            <div>
                                <span class="text-muted small">List Price: </span>
                                <span class="text-muted text-decoration-line-through small">Rs {{ number_format($originalPrice) }}</span>
                            </div>
                        </div>

                        <!-- Add to Cart -->
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <button type="submit" class="btn w-100" style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; border-radius: 20px; font-size: 13px;">
                                <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="bg-white rounded p-5 text-center">
                    <i class="fas fa-tag fa-4x text-muted mb-3"></i>
                    <h4 class="mb-2">No deals available right now</h4>
                    <p class="text-muted mb-3">Check back soon for amazing deals!</p>
                    <a href="{{ route('products.index') }}" class="btn" style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734;">
                        Browse All Products
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- More Deals Coming Soon -->
        <div class="bg-white rounded p-4 mt-4 text-center">
            <h5 class="mb-2">More deals loading...</h5>
            <p class="text-muted mb-0">New deals are added throughout the day. Keep checking back!</p>
        </div>
    </div>
</div>

@push('styles')
<style>
    .deal-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .deal-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .wishlist-btn-deal:hover i {
        color: #e47911 !important;
    }
    .wishlist-btn-deal.added i {
        font-weight: 900;
        color: #e47911 !important;
    }
</style>
@endpush

@push('scripts')
<script>
// Countdown Timer
function updateCountdown() {
    const now = new Date();
    const midnight = new Date();
    midnight.setHours(24, 0, 0, 0);
    const diff = midnight - now;
    
    const hours = Math.floor(diff / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
    
    document.getElementById('countdown').textContent = 
        String(hours).padStart(2, '0') + ':' + 
        String(minutes).padStart(2, '0') + ':' + 
        String(seconds).padStart(2, '0');
}
updateCountdown();
setInterval(updateCountdown, 1000);

// Add to Wishlist
function addDealToWishlist(productId, productName, productPrice, btn) {
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
