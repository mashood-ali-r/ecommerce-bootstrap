@extends('layouts.app')

@section('title', 'Wishlist - EEZEPC.com')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">My Wishlist</h1>
    
    @if(count(session('wishlist', [])) > 0)
        <div class="row">
            @foreach(session('wishlist', []) as $item)
            <div class="col-lg-4 col-md-6 mb-4" id="wishlist-item-{{ $item['id'] }}">
                <div class="card product-card h-100 shadow-sm">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="{{ $item['name'] }}">
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="removeFromWishlist('{{ $item['id'] }}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $item['name'] }}</h6>
                        <p class="card-text price-current mb-3">Rs {{ number_format($item['price']) }}</p>
                        <div class="d-grid gap-2 mt-auto">
                            <a href="{{ route('products.show', $item['id']) }}" class="btn btn-outline-primary btn-sm">View Product</a>
                            <button type="button" class="btn btn-primary w-100 btn-ripple" onclick="moveToCart('{{ $item['id'] }}', '{{ $item['name'] }}', '{{ $item['price'] }}')">
                                <i class="fas fa-shopping-cart me-1"></i>Move to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Your wishlist is empty!</h4>
                    <p class="text-muted">Save items you love for later by clicking the heart icon.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Start Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function removeFromWishlist(productId) {
    if (confirm('Are you sure you want to remove this item from your wishlist?')) {
        fetch('/wishlist/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.getElementById('wishlist-item-' + productId);
                if (item) {
                    item.style.transition = 'opacity 0.3s ease';
                    item.style.opacity = '0';
                    setTimeout(() => {
                        item.remove();
                        if (data.count === 0) {
                            location.reload();
                        }
                    }, 300);
                }
                showMessage(data.message, 'success');
            } else {
                showMessage(data.message || 'Error removing item', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error removing item from wishlist', 'danger');
        });
    }
}

function moveToCart(productId, productName, productPrice) {
    fetch('/wishlist/move-to-cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = document.getElementById('wishlist-item-' + productId);
            if (item) {
                item.style.transition = 'opacity 0.3s ease';
                item.style.opacity = '0';
                setTimeout(() => {
                    item.remove();
                    if (data.wishlist_count === 0) {
                        location.reload();
                    }
                }, 300);
            }
            showMessage(data.message, 'success');
            updateCartCount(data.cart_count);
        } else {
            showMessage(data.message || 'Error moving item to cart', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Error moving item to cart', 'danger');
    });
}

function showMessage(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.body.appendChild(alertDiv);
    setTimeout(() => { if (alertDiv.parentNode) alertDiv.remove(); }, 3000);
}

function updateCartCount(count) {
    const cartBadge = document.querySelector('.nav-link[href*="cart"] .badge');
    if (cartBadge) {
        cartBadge.textContent = count;
    }
}
</script>
@endpush
@endsection
