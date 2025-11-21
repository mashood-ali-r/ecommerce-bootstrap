@extends('layouts.app')

@section('title', 'Product Details - EEZEPC.com')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Products</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row mb-5">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-detail-img mb-3">
                <img id="mainImage" src="https://via.placeholder.com/500x400" alt="Product Image" class="img-fluid rounded shadow-sm">
            </div>
            <div class="product-thumbnails d-flex gap-2">
                @foreach ($product->images as $image)
                    <img src="{{ asset('storage/' . $image->path) }}" alt="Thumbnail" class="thumbnail-img" onclick="changeImage(this.src)">
                @endforeach
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="product-info">
                <h1 class="product-title mb-3">{{ $product->name }}</h1>

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
                        <span class="current-price h3 text-primary me-3">Rs {{ $product->price }}</span>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="product-description mb-4">
                    <h5>Description</h5>
                    <p class="text-muted">{{ $product->description }}</p>
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
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 btn-ripple">
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Basket
                                    </button>
                                </form>
                                <button class="btn btn-outline-danger add-to-wishlist" data-product-id="{{ $product->id }}">
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
                            <strong>{{ $product->sku }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Category:</small><br>
                            <strong>{{ $product->category->name ?? '' }}</strong>
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
                        <p>{{ $product->description }}</p>
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
</script>
@endpush
@endsection
