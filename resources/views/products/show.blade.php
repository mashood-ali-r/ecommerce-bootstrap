@extends('layouts.app')

@section('title', 'Product Details - EEZEPC.com')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Products</a></li>
            <li class="breadcrumb-item active">Product Details</li>
        </ol>
    </nav>

    <div class="row mb-5">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-detail-img mb-3">
                <img id="mainImage" src="https://via.placeholder.com/500x400" alt="Product Image" class="img-fluid rounded shadow-sm">
            </div>
            <div class="product-thumbnails d-flex gap-2">
                <img src="https://via.placeholder.com/80x80" alt="Thumbnail" class="thumbnail-img active" onclick="changeImage(this.src)">
                <img src="https://via.placeholder.com/80x80" alt="Thumbnail" class="thumbnail-img" onclick="changeImage(this.src)">
                <img src="https://via.placeholder.com/80x80" alt="Thumbnail" class="thumbnail-img" onclick="changeImage(this.src)">
                <img src="https://via.placeholder.com/80x80" alt="Thumbnail" class="thumbnail-img" onclick="changeImage(this.src)">
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="product-info">
                <h1 class="product-title mb-3">{{ $productName ?? 'Sample Product' }}</h1>
                
                <!-- Rating -->
                <div class="rating mb-3">
                    <div class="stars">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="far fa-star text-warning"></i>
                        <span class="ms-2 text-muted">(4.2) • 128 reviews</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="price-section mb-4">
                    <div class="d-flex align-items-center">
                        <span class="current-price h3 text-primary me-3">Rs {{ $productPrice ?? '33,990' }}</span>
                        @if(isset($originalPrice))
                        <span class="original-price text-muted text-decoration-line-through">Rs {{ $originalPrice }}</span>
                        @endif
                </div>
                    @if(isset($discount))
                    <span class="badge bg-danger mt-2">{{ $discount }}% OFF</span>
                    @endif
                </div>

                <!-- Product Description -->
                <div class="product-description mb-4">
                    <h5>Description</h5>
                    <p class="text-muted">{{ $productDescription ?? 'This is a high-quality product with excellent features and performance. Perfect for your needs with modern design and advanced technology.' }}</p>
                </div>

                <!-- Features -->
                <div class="product-features mb-4">
                    <h5>Key Features</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>High-quality materials</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Advanced technology</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Modern design</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Warranty included</li>
                    </ul>
                </div>

                <!-- Quantity and Add to Cart -->
                <div class="add-to-cart-section mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label class="form-label">Quantity:</label>
                            <div class="quantity-controls">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(-1)">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="99" class="form-control text-center mx-2" style="width: 80px;">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQuantity(1)">+</button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="d-grid gap-2">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="name" value="{{ $productName ?? 'Sample Product' }}">
                                    <input type="hidden" name="price" value="{{ $productPrice ?? '33990' }}">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 btn-ripple">
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Basket
                                    </button>
                                </form>
                                <button class="btn btn-outline-danger" onclick="addToWishlist()">
                                    <i class="fas fa-heart me-2"></i>Add to Wishlist
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-details-info">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">SKU:</small><br>
                            <strong>{{ $id ?? 'SKU-001' }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Category:</small><br>
                            <strong>Electronics</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                        Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                        Specifications
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                        Reviews (128)
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <div class="p-4">
                        <h5>Product Description</h5>
                        <p>This is a detailed description of the product. It includes all the important features, benefits, and technical specifications that customers need to know before making a purchase decision.</p>
                        <p>The product is designed with the latest technology and meets all industry standards. It comes with a comprehensive warranty and excellent customer support.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    <div class="p-4">
                        <h5>Technical Specifications</h5>
                        <table class="table table-striped">
                            <tbody>
                                <tr><td><strong>Brand</strong></td><td>Samsung</td></tr>
                                <tr><td><strong>Model</strong></td><td>Galaxy Buds 3 FE</td></tr>
                                <tr><td><strong>Color</strong></td><td>Black</td></tr>
                                <tr><td><strong>Connectivity</strong></td><td>Bluetooth 5.3</td></tr>
                                <tr><td><strong>Battery Life</strong></td><td>Up to 30 hours</td></tr>
                                <tr><td><strong>Warranty</strong></td><td>1 Year</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="p-4">
                        <h5>Customer Reviews</h5>
                        <div class="review-item border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <strong>John Doe</strong>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </div>
                            <p class="text-muted mt-2">Excellent product! Great quality and fast delivery.</p>
                        </div>
                        <div class="review-item border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <strong>Jane Smith</strong>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                </div>
                            </div>
                            <p class="text-muted mt-2">Very satisfied with my purchase. Highly recommended!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Product data based on ID
const productData = {
    'samsung-buds-3-fe': {
        name: 'Samsung Galaxy Buds 3 FE – Black',
        price: '33,990',
        description: 'Premium wireless earbuds with active noise cancellation and superior sound quality.',
        features: ['Active Noise Cancellation', '30-hour battery life', 'IPX7 water resistance', 'Wireless charging']
    },
    'corsair-3500x-black': {
        name: 'Corsair 3500X RS-R ARGB Mid-Tower PC Case – Black',
        price: '29,990',
        description: 'High-performance PC case with RGB lighting and excellent airflow.',
        features: ['RGB Lighting', 'Excellent Airflow', 'Tempered Glass', 'Cable Management']
    },
    'apple-iphone-air-256gb': {
        name: 'Apple iPhone Air 256GB – Sky Blue (PTA Approved)',
        price: '464,990',
        originalPrice: '479,990',
        discount: '3',
        description: 'Latest iPhone with advanced features and premium design.',
        features: ['A17 Pro Chip', '48MP Camera', '5G Connectivity', 'Face ID']
    }
};

// Update product info based on ID
document.addEventListener('DOMContentLoaded', function() {
    const productId = '{{ $id }}';
    const product = productData[productId];
    
    if (product) {
        document.querySelector('.product-title').textContent = product.name;
        document.querySelector('.current-price').textContent = 'Rs ' + product.price;
        document.querySelector('.product-description p').textContent = product.description;
        
        if (product.originalPrice) {
            const originalPriceEl = document.createElement('span');
            originalPriceEl.className = 'original-price text-muted text-decoration-line-through';
            originalPriceEl.textContent = 'Rs ' + product.originalPrice;
            document.querySelector('.price-section .d-flex').appendChild(originalPriceEl);
        }
        
        if (product.discount) {
            const discountEl = document.createElement('span');
            discountEl.className = 'badge bg-danger mt-2';
            discountEl.textContent = product.discount + '% OFF';
            document.querySelector('.price-section').appendChild(discountEl);
        }
    }
});

function changeImage(src) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.thumbnail-img').forEach(img => img.classList.remove('active'));
    event.target.classList.add('active');
}

function changeQuantity(change) {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const newValue = Math.max(1, Math.min(99, currentValue + change));
    quantityInput.value = newValue;
}

function addToWishlist() {
    const productId = '{{ $id }}';
    const productName = document.querySelector('.product-title').textContent;
    const productPrice = document.querySelector('.current-price').textContent.replace('Rs ', '').replace(',', '');
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<span class="loading-spinner"></span> Adding...';
    button.disabled = true;
    
    // Make AJAX request
    fetch('/wishlist/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            id: productId,
            name: productName,
            price: productPrice
        })
    })
    .then(response => response.json())
    .then(data => {
        // Reset button
        button.innerHTML = originalText;
        button.disabled = false;
        
        if (data.success) {
            // Show success message
            showMessage(data.message, 'success');
            // Update wishlist count in navbar
            updateWishlistCount();
        } else {
            // Show error message
            showMessage(data.message, 'warning');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.innerHTML = originalText;
        button.disabled = false;
        showMessage('Error adding to wishlist', 'danger');
    });
}

function showMessage(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}

function updateWishlistCount() {
    // Update wishlist count in navbar
    const wishlistBadge = document.querySelector('.nav-icon .badge');
    if (wishlistBadge) {
        const currentCount = parseInt(wishlistBadge.textContent) || 0;
        wishlistBadge.textContent = currentCount + 1;
        wishlistBadge.style.transform = 'scale(1.2)';
        wishlistBadge.style.transition = 'transform 0.3s ease';
        setTimeout(() => {
            wishlistBadge.style.transform = 'scale(1)';
        }, 300);
    }
}
</script>
@endpush