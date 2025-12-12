@extends('layouts.app')

@section('title', "Today's Deals - EEZEPC.com")

@section('content')
<div style="background-color: #EAEDED; min-height: 100vh;">
    <!-- Hero Banner -->
    <div class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #232f3e 0%, #131921 50%, #232f3e 100%);">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #FF9900, #FEBD69); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                            <i class="fas fa-bolt text-dark" style="font-size: 24px;"></i>
                        </div>
                        <div>
                            <span class="text-white-50" style="font-size: 14px;">LIMITED TIME ONLY</span>
                        </div>
                    </div>
                    <h1 class="text-white mb-3" style="font-size: 42px; font-weight: 700; line-height: 1.2;">
                        Today's <span style="color: #FF9900;">Deals</span>
                    </h1>
                    <p class="text-white-50 mb-4" style="font-size: 16px; max-width: 500px;">
                        Discover incredible savings on top-rated products. New deals drop every day — grab yours before they're gone!
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#deals" class="btn px-4 py-2" style="background: #FF9900; color: #0F1111; font-weight: 600; border-radius: 8px;">
                            <i class="fas fa-fire me-2"></i>Shop Deals
                        </a>
                        <a href="{{ route('products.index') }}" class="btn px-4 py-2" style="background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px;">
                            Browse All Products
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 text-center mt-4 mt-lg-0">
                    <!-- Countdown Timer -->
                    <div class="bg-white rounded-4 p-4 shadow" style="display: inline-block; min-width: 280px;">
                        <p class="text-muted mb-2" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Deals End In</p>
                        <div class="d-flex justify-content-center gap-3" id="countdownContainer">
                            <div class="text-center">
                                <div id="hours" class="fw-bold" style="font-size: 36px; color: #B12704; line-height: 1;">00</div>
                                <small class="text-muted">Hours</small>
                            </div>
                            <div style="font-size: 36px; color: #B12704;">:</div>
                            <div class="text-center">
                                <div id="minutes" class="fw-bold" style="font-size: 36px; color: #B12704; line-height: 1;">00</div>
                                <small class="text-muted">Mins</small>
                            </div>
                            <div style="font-size: 36px; color: #B12704;">:</div>
                            <div class="text-center">
                                <div id="seconds" class="fw-bold" style="font-size: 36px; color: #B12704; line-height: 1;">00</div>
                                <small class="text-muted">Secs</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative Elements -->
        <div class="position-absolute" style="top: 20%; right: 10%; width: 100px; height: 100px; background: rgba(255,153,0,0.1); border-radius: 50%; filter: blur(40px);"></div>
        <div class="position-absolute" style="bottom: 20%; left: 15%; width: 80px; height: 80px; background: rgba(255,153,0,0.15); border-radius: 50%; filter: blur(30px);"></div>
    </div>

    <div class="container py-4" id="deals">

        <!-- Deals Grid -->
        <div class="row g-4">
            @php
                $dealProducts = \App\Models\Product::where('is_active', true)
                    ->where(function($q) {
                        $q->where('is_flash_deal', true)
                          ->orWhere('is_featured', true);
                    })
                    ->inRandomOrder()
                    ->limit(12)
                    ->get();
                
                if($dealProducts->isEmpty()) {
                    $dealProducts = \App\Models\Product::where('is_active', true)
                        ->inRandomOrder()
                        ->limit(12)
                        ->get();
                }
            @endphp

            @forelse($dealProducts as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="bg-white rounded-3 h-100 overflow-hidden deal-card shadow-sm">
                    <!-- Deal Badge & Image -->
                    <div class="position-relative">
                        @php 
                            $discount = rand(15, 50);
                            $originalPrice = $product->price * (100 / (100 - $discount));
                        @endphp
                        
                        <!-- Discount Badge -->
                        <div class="position-absolute" style="top: 12px; left: 12px; z-index: 2;">
                            <span style="background: linear-gradient(135deg, #CC0C39, #E74C3C); color: white; padding: 6px 12px; border-radius: 4px; font-size: 13px; font-weight: 700;">
                                {{ $discount }}% OFF
                            </span>
                        </div>
                        
                        <!-- Wishlist Button -->
                        <button class="btn position-absolute wishlist-btn-deal" 
                                style="top: 12px; right: 12px; background: rgba(255,255,255,0.95); border: none; border-radius: 50%; width: 40px; height: 40px; z-index: 2; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s;"
                                onclick="addDealToWishlist({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, this)">
                            <i class="far fa-heart" style="color: #232f3e; font-size: 16px;"></i>
                        </button>

                        <!-- Product Image -->
                        <a href="{{ route('products.show', $product->slug) }}" class="d-block text-center p-4" style="background: linear-gradient(180deg, #FAFAFA 0%, #F5F5F5 100%);">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/200x200?text=' . urlencode(Str::limit($product->name, 10)) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid" 
                                 style="height: 180px; object-fit: contain; transition: transform 0.3s;">
                        </a>
                    </div>

                    <!-- Deal Info -->
                    <div class="p-3">
                        <!-- Progress Bar -->
                        <div class="mb-3">
                            @php $claimed = rand(40, 92); @endphp
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="font-size: 12px; color: #B12704; font-weight: 600;">
                                    <i class="fas fa-fire me-1"></i>{{ $claimed }}% claimed
                                </span>
                                <span style="font-size: 11px; color: #565959;">Limited stock</span>
                            </div>
                            <div class="progress" style="height: 6px; background: #FFE6E6; border-radius: 3px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $claimed }}%; background: linear-gradient(90deg, #FF6B6B, #CC0C39); border-radius: 3px;"></div>
                            </div>
                        </div>

                        <!-- Product Name -->
                        <a href="{{ route('products.show', $product->slug) }}" 
                           class="text-decoration-none d-block mb-2" 
                           style="color: #0f1111; font-size: 14px; line-height: 1.4; height: 40px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $product->name }}
                        </a>

                        <!-- Rating -->
                        <div class="mb-2">
                            @php $rating = rand(35, 50) / 10; @endphp
                            <span style="color: #FF9900;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($rating))
                                        <i class="fas fa-star" style="font-size: 12px;"></i>
                                    @elseif($i - 0.5 <= $rating)
                                        <i class="fas fa-star-half-alt" style="font-size: 12px;"></i>
                                    @else
                                        <i class="far fa-star" style="font-size: 12px;"></i>
                                    @endif
                                @endfor
                            </span>
                            <span style="font-size: 12px; color: #007185;">({{ rand(50, 500) }})</span>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            <div class="d-flex align-items-baseline gap-2">
                                <span style="font-size: 24px; color: #B12704; font-weight: 400;">
                                    <sup style="font-size: 14px;">Rs</sup>{{ number_format($product->price) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-muted text-decoration-line-through" style="font-size: 13px;">Rs {{ number_format($originalPrice) }}</span>
                                <span style="font-size: 12px; color: #007600; margin-left: 8px;">Save Rs {{ number_format($originalPrice - $product->price) }}</span>
                            </div>
                        </div>

                        <!-- Add to Cart -->
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <button type="submit" class="btn w-100" style="background: linear-gradient(to bottom, #FFD814, #F7CA00); border: 1px solid #F2C200; border-radius: 8px; font-size: 14px; font-weight: 500; color: #0F1111;">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="bg-white rounded-3 p-5 text-center shadow-sm">
                    <div style="width: 80px; height: 80px; background: #FFF3E0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-tag" style="font-size: 32px; color: #FF9900;"></i>
                    </div>
                    <h4 class="mb-2" style="color: #0F1111;">No deals available right now</h4>
                    <p class="text-muted mb-4">Check back soon for amazing deals!</p>
                    <a href="{{ route('products.index') }}" class="btn px-4" style="background: linear-gradient(to bottom, #FFD814, #F7CA00); border: 1px solid #F2C200; border-radius: 8px;">
                        Browse All Products
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Newsletter Section -->
        <div class="bg-white rounded-3 mt-4 shadow-sm" style="padding: 12px 24px;">
            <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-bell" style="color: #FF9900; font-size: 14px;"></i>
                    <span style="color: #0F1111; font-weight: 600; font-size: 13px;">Never Miss a Deal!</span>
                    <span class="text-muted d-none d-md-inline" style="font-size: 12px;">Get notified about new deals before they sell out.</span>
                </div>
                <div class="input-group" style="max-width: 320px;">
                    <input type="email" class="form-control form-control-sm" placeholder="Enter your email" style="border-radius: 6px 0 0 6px; border: 1px solid #D5D9D9; font-size: 12px; height: 32px;">
                    <button class="btn btn-sm" type="button" style="background: #232f3e; color: white; border-radius: 0 6px 6px 0; font-size: 12px; height: 32px; padding: 0 16px;">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .deal-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .deal-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15) !important;
    }
    .deal-card:hover img {
        transform: scale(1.05);
    }
    .wishlist-btn-deal:hover {
        transform: scale(1.1);
        background: #fff !important;
    }
    .wishlist-btn-deal:hover i {
        color: #e47911 !important;
    }
    .wishlist-btn-deal.added i {
        font-weight: 900;
        color: #e47911 !important;
    }
    .rounded-3 { border-radius: 12px !important; }
    .rounded-4 { border-radius: 16px !important; }
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
    
    document.getElementById('hours').textContent = String(hours).padStart(2, '0');
    document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
    document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
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
            showEezepcToast({
                type: 'success',
                title: 'Added to Wishlist!',
                message: productName.substring(0, 40) + '...'
            });
        } else {
            icon.className = 'far fa-heart';
            showEezepcToast({
                type: 'warning',
                title: 'Already in Wishlist',
                message: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        icon.className = 'far fa-heart';
        showEezepcToast({
            type: 'error',
            title: 'Error',
            message: 'Could not add to wishlist'
        });
    });
}
</script>
@endpush
@endsection
