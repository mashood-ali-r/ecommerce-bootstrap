@extends('layouts.app')

@section('title', $product->name . ' - EEZEPC.com')

@section('content')
    <!-- Amazon-Style Product Detail Page -->
    <div class="bg-white">
        <div class="container py-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"
                            style="color: #007185;">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none"
                            style="color: #007185;">Products</a></li>
                    @if($product->category)
                        <li class="breadcrumb-item"><a
                                href="{{ route('products.index', ['category' => $product->category->id]) }}"
                                class="text-decoration-none" style="color: #007185;">{{ $product->category->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active text-muted">{{ Str::limit($product->name, 40) }}</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Left Column: Product Images -->
                <div class="col-lg-5 mb-4">
                    <div class="position-sticky" style="top: 80px;">
                        <!-- Main Image -->
                        <div class="border rounded bg-white p-3 mb-3 text-center" style="min-height: 400px;">
                            <img id="mainImage"
                                src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/500x500?text=' . urlencode($product->name) }}"
                                alt="{{ $product->name }}" class="img-fluid"
                                style="max-height: 400px; object-fit: contain; cursor: zoom-in;">
                        </div>
                        <!-- Thumbnail Strip -->
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <div class="thumbnail-container active"
                                onclick="selectThumbnail(this, '{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/500x500' }}')">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/80x80' }}"
                                    alt="Thumbnail 1" class="thumbnail-img">
                            </div>
                            @if($product->images && $product->images->count() > 0)
                                @foreach($product->images as $image)
                                    <div class="thumbnail-container"
                                        onclick="selectThumbnail(this, '{{ asset('storage/' . $image->path) }}')">
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="Thumbnail" class="thumbnail-img">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Middle Column: Product Info -->
                <div class="col-lg-4 mb-4">
                    <!-- Product Title -->
                    <h1 class="h4 mb-2" style="color: #0f1111; font-weight: 400; line-height: 1.3;">{{ $product->name }}
                    </h1>

                    <!-- Brand/Store Link -->
                    <p class="mb-2">
                        <a href="#" class="text-decoration-none" style="color: #007185; font-size: 14px;">Visit the EEZEPC
                            Store</a>
                    </p>

                    <!-- Rating -->
                    <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                        <div class="me-2">
                            @php $rating = rand(35, 50) / 10; @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($rating))
                                    <i class="fas fa-star" style="color: #ffa41c; font-size: 14px;"></i>
                                @elseif($i - 0.5 <= $rating)
                                    <i class="fas fa-star-half-alt" style="color: #ffa41c; font-size: 14px;"></i>
                                @else
                                    <i class="far fa-star" style="color: #ffa41c; font-size: 14px;"></i>
                                @endif
                            @endfor
                        </div>
                        <a href="#reviews" class="text-decoration-none"
                            style="color: #007185; font-size: 14px;">{{ number_format($rating, 1) }} <span
                                class="text-muted">({{ rand(50, 500) }} ratings)</span></a>
                    </div>

                    <!-- Price Section -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-baseline flex-wrap">
                            <span class="me-2" style="font-size: 14px; color: #565959;">Price:</span>
                            <span style="font-size: 28px; color: #B12704; font-weight: 400;">Rs
                                {{ number_format($product->price) }}</span>
                        </div>
                        @if($product->compare_price && $product->compare_price > $product->price)
                            <div class="mt-1">
                                <span class="text-decoration-line-through text-muted me-2">Rs
                                    {{ number_format($product->compare_price) }}</span>
                                <span class="badge" style="background-color: #CC0C39; font-size: 12px;">
                                    {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                                    off
                                </span>
                            </div>
                        @endif
                        <p class="small text-muted mb-0 mt-1">Inclusive of all taxes</p>
                    </div>

                    <!-- Key Features / About This Item -->
                    <div class="mb-4">
                        <h3 class="h6 fw-bold mb-2" style="color: #0f1111;">About this item</h3>
                        <ul class="ps-3 mb-0" style="font-size: 14px; color: #333;">
                            @if($product->description)
                                @foreach(array_slice(explode('.', $product->description), 0, 5) as $sentence)
                                    @if(trim($sentence))
                                        <li class="mb-1">{{ trim($sentence) }}</li>
                                    @endif
                                @endforeach
                            @else
                                <li class="mb-1">High-quality product with premium materials</li>
                                <li class="mb-1">Designed for optimal performance</li>
                                <li class="mb-1">Includes manufacturer warranty</li>
                                <li class="mb-1">Modern and sleek design</li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Right Column: Buy Box -->
                <div class="col-lg-3">
                    <div class="border rounded p-3" style="background: #fff;">
                        <!-- Price Again -->
                        <div class="mb-3">
                            <span style="font-size: 18px; color: #B12704;">Rs {{ number_format($product->price) }}</span>
                        </div>

                        <!-- Delivery Info -->
                        <div class="mb-3" style="font-size: 14px;">
                            <div class="mb-1">
                                <i class="fas fa-truck me-2" style="color: #007185;"></i>
                                <span style="color: #007185; font-weight: 500;">FREE Delivery</span>
                                <span class="text-muted"> on orders over Rs 5,000</span>
                            </div>
                            <div class="text-muted small">
                                <i class="fas fa-map-marker-alt me-2"></i>Deliver to Pakistan
                            </div>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-3">
                            @if($product->stock > 0)
                                <span style="font-size: 18px; color: #007600;">In Stock</span>
                            @else
                                <span style="font-size: 18px; color: #B12704;">Out of Stock</span>
                            @endif
                        </div>

                        <!-- Quantity Selector -->
                        <div class="mb-3">
                            <label class="small text-muted mb-1">Quantity:</label>
                            <select id="quantity" class="form-select form-select-sm"
                                style="width: 80px; border-radius: 8px;">
                                @for($i = 1; $i <= min(10, $product->stock ?? 10); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Add to Cart Button -->
                        <form action="{{ route('cart.add') }}" method="POST" class="mb-2">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <button type="submit" class="btn w-100 mb-2"
                                style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; border-radius: 20px; font-size: 13px;">
                                Add to Cart
                            </button>
                        </form>

                        <!-- Buy Now Button -->
                        <a href="{{ route('checkout') }}" class="btn w-100 mb-3"
                            style="background: linear-gradient(to bottom, #ffac33, #ff8f00); border: 1px solid #d67a00; border-radius: 20px; font-size: 13px; color: #111;">
                            Buy Now
                        </a>

                        <!-- Wishlist Button -->
                        <button type="button" id="wishlistBtn" onclick="addToWishlist()"
                            class="btn btn-outline-secondary w-100 mb-3" style="border-radius: 20px; font-size: 13px;">
                            <i class="far fa-heart me-1"></i> Add to Wishlist
                        </button>

                        <!-- Secure Transaction -->
                        <div class="small text-muted mb-3">
                            <i class="fas fa-lock me-1"></i> Secure transaction
                        </div>

                        <!-- Seller Info -->
                        <div class="small border-top pt-2" style="font-size: 12px;">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Sold by</span>
                                <a href="#" style="color: #007185;">EEZEPC Official</a>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Fulfilled by</span>
                                <span style="color: #007185;">EEZEPC</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Description Tabs -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="border-top pt-4">
                        <h2 class="h5 fw-bold mb-3" style="color: #0f1111;">Product Details</h2>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm" style="font-size: 14px;">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted" style="width: 40%;">SKU</td>
                                            <td>{{ $product->sku ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Category</td>
                                            <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Brand</td>
                                            <td>{{ $product->brand ?? 'EEZEPC' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Availability</td>
                                            <td>{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Full Description -->
                        <div class="mt-4">
                            <h3 class="h6 fw-bold mb-2">Description</h3>
                            <p class="text-muted" style="font-size: 14px; line-height: 1.6;">
                                {{ $product->description ?? 'No description available for this product.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="border-top pt-4">
                            <h2 class="h5 fw-bold mb-3" style="color: #0f1111;">Customers who viewed this item also viewed</h2>
                            <div class="d-flex overflow-auto pb-3 gap-3">
                                @foreach($relatedProducts as $related)
                                    <a href="{{ route('products.show', $related->slug) }}" class="text-decoration-none"
                                        style="min-width: 180px; max-width: 180px;">
                                        <div class="text-center p-2">
                                            <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://via.placeholder.com/150x150' }}"
                                                alt="{{ $related->name }}" class="img-fluid mb-2"
                                                style="height: 150px; object-fit: contain;">
                                            <p class="small mb-1 text-dark"
                                                style="line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $related->name }}</p>
                                            <div style="color: #B12704; font-weight: 500;">Rs {{ number_format($related->price) }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            .thumbnail-container {
                width: 60px;
                height: 60px;
                border: 2px solid #ddd;
                border-radius: 4px;
                padding: 4px;
                cursor: pointer;
                transition: border-color 0.2s;
            }

            .thumbnail-container:hover,
            .thumbnail-container.active {
                border-color: #e77600;
            }

            .thumbnail-img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            #mainImage {
                transition: opacity 0.2s;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function selectThumbnail(element, imgSrc) {
                // Remove active from all thumbnails
                document.querySelectorAll('.thumbnail-container').forEach(t => t.classList.remove('active'));
                // Add active to clicked
                element.classList.add('active');
                // Change main image with fade effect
                const mainImg = document.getElementById('mainImage');
                mainImg.style.opacity = '0.5';
                setTimeout(() => {
                    mainImg.src = imgSrc;
                    mainImg.style.opacity = '1';
                }, 150);
            }

            function addToWishlist() {
                const btn = document.getElementById('wishlistBtn');
                const originalHTML = btn.innerHTML;

                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Adding...';
                btn.disabled = true;

                fetch('{{ route("wishlist.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        id: '{{ $product->id }}',
                        name: '{{ addslashes($product->name) }}',
                        price: {{ $product->price }}
                })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            btn.innerHTML = '<i class="fas fa-heart text-danger me-1"></i> Added to Wishlist';
                            btn.classList.remove('btn-outline-secondary');
                            btn.classList.add('btn-outline-danger');
                            showToast(data.message, 'success');
                        } else {
                            btn.innerHTML = originalHTML;
                            btn.disabled = false;
                            showToast(data.message, 'warning');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                        showToast('Error adding to wishlist', 'danger');
                    });
            }

            function showToast(message, type) {
                const toast = document.createElement('div');
                toast.className = `alert alert-${type} position-fixed shadow-lg`;
                toast.style.cssText = 'top: 80px; right: 20px; z-index: 9999; min-width: 280px; animation: slideIn 0.3s ease;';
                toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                    <span>${message}</span>
                    <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        </script>
    @endpush
@endsection