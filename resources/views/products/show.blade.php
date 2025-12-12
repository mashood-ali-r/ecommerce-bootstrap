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
                        <!-- Product Images Card -->
                        <div class="bg-white rounded-3 shadow-sm border p-4"
                            style="border-color: #e5e7eb !important; border-radius: 12px !important;">
                            @php
                                $primaryImage = $product->primaryImage;
                                $mainImageUrl = $primaryImage ? asset('storage/' . $primaryImage->image_path) : 'https://via.placeholder.com/500x500?text=' . urlencode($product->name);
                            @endphp
                            <!-- Main Image -->
                            <div class="text-center mb-4 position-relative"
                                style="min-height: 400px; display: flex; align-items: center; justify-content: center;">
                                <img id="mainImage" src="{{ $mainImageUrl }}" alt="{{ $product->name }}" class="img-fluid"
                                    style="max-height: 400px; object-fit: contain; cursor: zoom-in; transition: transform 0.3s ease;">
                            </div>

                            <!-- Thumbnail Strip -->
                            <div class="d-flex gap-2 justify-content-center flex-wrap px-2">
                                @if($product->images && $product->images->count() > 0)
                                    @foreach($product->images as $image)
                                        <div class="thumbnail-container {{ $loop->first ? 'active' : '' }}"
                                            onclick="selectThumbnail(this, '{{ asset('storage/' . $image->image_path) }}')">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Thumbnail"
                                                class="thumbnail-img">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="thumbnail-container active">
                                        <img src="https://via.placeholder.com/80x80" alt="No Image" class="thumbnail-img">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Middle Column: Product Info -->
                <div class="col-lg-4 mb-4">
                    <!-- Product Info Card -->
                    <div class="bg-white rounded-3 shadow-sm border p-4 h-100"
                        style="border-color: #e5e7eb !important; border-radius: 12px !important;">
                        <!-- Product Title -->
                        <h1 class="h4 mb-2 fw-bold" style="color: #0f172a; line-height: 1.4; letter-spacing: -0.5px;">
                            {{ $product->name }}</h1>

                        <!-- Brand/Store Link -->
                        <p class="mb-3">
                            <a href="#" class="text-decoration-none fw-medium"
                                style="color: #007185; font-size: 14px;">Visit the EEZEPC Store</a>
                        </p>

                        <!-- Rating -->
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
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
                        <div class="mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-baseline flex-wrap">
                                <span class="me-2 text-muted fw-medium" style="font-size: 14px;">Price:</span>
                                <span style="font-size: 32px; color: #0f1111; font-weight: 500;">Rs
                                    {{ number_format((float) $product->price) }}</span>
                            </div>
                            @if($product->compare_price && $product->compare_price > $product->price)
                                <div class="mt-1">
                                    <span class="text-decoration-line-through text-muted me-2">Rs
                                        {{ number_format($product->compare_price) }}</span>
                                    <span class="badge rounded-pill"
                                        style="background-color: #CC0C39; font-size: 12px; font-weight: 500;">
                                        {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                                        off
                                    </span>
                                </div>
                            @endif
                            <p class="small text-muted mb-0 mt-2"><i class="fas fa-check-circle text-success me-1"></i>
                                Inclusive of all taxes</p>
                        </div>

                        <!-- Key Features -->
                        <div class="mb-2">
                            <h3 class="h6 fw-bold mb-3" style="color: #0f172a;">About this item</h3>
                            <ul class="ps-3 mb-0" style="font-size: 14px; color: #334155; line-height: 1.6;">
                                @if($product->description)
                                    @foreach(array_slice(explode('.', $product->description), 0, 5) as $sentence)
                                        @if(trim($sentence))
                                            <li class="mb-2">{{ trim($sentence) }}</li>
                                        @endif
                                    @endforeach
                                @else
                                    <li class="mb-2">High-quality product with premium materials</li>
                                    <li class="mb-2">Designed for optimal performance</li>
                                    <li class="mb-2">Includes manufacturer warranty</li>
                                    <li class="mb-2">Modern and sleek design</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Buy Box -->
                <div class="col-lg-3">
                    <div class="bg-white rounded-3 shadow-sm border p-4"
                        style="border-color: #e5e7eb !important; border-radius: 12px !important;">
                        <!-- Price Again -->
                        <div class="mb-3">
                            <span style="font-size: 24px; color: #0f1111; font-weight: 600;">Rs
                                {{ number_format((float) $product->price) }}</span>
                        </div>

                        <!-- Delivery Info -->
                        <div class="mb-4" style="font-size: 14px;">
                            <div class="mb-2 d-flex align-items-start">
                                <i class="fas fa-truck mt-1 me-2" style="color: #007185;"></i>
                                <span><span style="color: #007185; font-weight: 600;">FREE Delivery</span> on orders over Rs
                                    5,000</span>
                            </div>
                            <div class="text-muted small d-flex align-items-center">
                                <i class="fas fa-map-marker-alt me-2 text-secondary"></i>Deliver to Pakistan
                            </div>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-4">
                            @if($product->stock > 0)
                                <span class="text-success fw-bold fs-5"><i class="fas fa-check me-2"></i>In Stock</span>
                            @else
                                <span class="text-danger fw-bold fs-5"><i class="fas fa-times me-2"></i>Out of Stock</span>
                            @endif
                        </div>

                        <!-- Quantity Selector -->
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold text-uppercase">Quantity</label>
                            <select id="quantity" class="form-select" style="border-radius: 8px; border-color: #d1d5db;">
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
                            <button type="submit" class="btn w-100 mb-2 shadow-sm"
                                style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #f0c14b; border-radius: 20px; font-weight: 500; font-size: 14px; padding: 10px;">
                                Add to Cart
                            </button>
                        </form>

                        <!-- Buy Now Button -->
                        <a href="{{ route('checkout') }}" class="btn w-100 mb-3 shadow-sm"
                            style="background: linear-gradient(to bottom, #fa8900, #f77d00); border: 1px solid #ca6600; border-radius: 20px; font-weight: 500; font-size: 14px; color: #fff; padding: 10px;">
                            Buy Now
                        </a>

                        @php
                            $inWishlistDetail = array_key_exists($product->id, session('wishlist', []));
                        @endphp
                        <!-- Wishlist Button -->
                        <button type="button" id="wishlistBtn" onclick="addToWishlist()"
                            class="btn w-100 mb-4 {{ $inWishlistDetail ? 'btn-outline-danger' : 'btn-outline-secondary' }}"
                            style="{{ $inWishlistDetail ? 'background: linear-gradient(135deg, #FF6B9D, #FF4081); color: #fff; border: none;' : 'background: #fff; border: 1px solid #d1d5db; color: #0f1111;' }} border-radius: 20px; font-size: 14px; font-weight: 500; transition: all 0.2s; padding: 10px;">
                            <i
                                class="{{ $inWishlistDetail ? 'fas' : 'far' }} fa-heart me-2"></i>{{ $inWishlistDetail ? 'In Wishlist' : 'Add to Wishlist' }}
                        </button>

                        <!-- Secure Transaction -->
                        <div class="small text-muted mb-3 d-flex align-items-center justify-content-center">
                            <i class="fas fa-lock me-1"></i> Secure transaction
                        </div>

                        <!-- Seller Info -->
                        <div class="small border-top pt-3 text-muted">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Sold by</span>
                                <a href="#" class="text-decoration-none fw-medium" style="color: #007185;">EEZEPC
                                    Official</a>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Fulfilled by</span>
                                <span class="fw-medium text-dark">EEZEPC</span>
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
                                            <img src="{{ $related->primaryImage ? asset('storage/' . $related->primaryImage->image_path) : 'https://via.placeholder.com/150x150' }}"
                                                alt="{{ $related->name }}" class="img-fluid mb-2"
                                                style="height: 150px; object-fit: contain;">
                                            <p class="small mb-1 text-dark"
                                                style="line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $related->name }}
                                            </p>
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
                const mainImageSrc = document.getElementById('mainImage').src; // Get current displayed image

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
                            btn.innerHTML = '<i class="fas fa-heart me-1"></i> In Wishlist';
                            btn.classList.remove('btn-outline-secondary');
                            btn.classList.add('btn-outline-danger');
                            // Apply Amazon style active state
                            btn.style.background = 'linear-gradient(135deg, #FF6B9D, #FF4081)';
                            btn.style.color = '#fff';
                            btn.style.border = 'none';

                            if (window.showEezepcToast) {
                                window.showEezepcToast({
                                    type: 'success',
                                    title: 'Added to Wish List',
                                    message: 'One item added to Wish List',
                                    image: mainImageSrc
                                });
                            }
                        } else {
                            btn.innerHTML = originalHTML;
                            btn.disabled = false;

                            if (window.showEezepcToast) {
                                window.showEezepcToast({
                                    type: 'warning',
                                    title: 'Already in Wish List',
                                    message: 'This item is already in your Wish List',
                                    image: mainImageSrc
                                });
                            }
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                        if (window.showEezepcToast) {
                            window.showEezepcToast({ type: 'error', title: 'Error', message: 'Could not add to Wish List' });
                        }
                    });
            }


        </script>
    @endpush
@endsection