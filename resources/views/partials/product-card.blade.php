{{-- Product Card Component --}}
<div class="col-lg-3 col-md-4 col-sm-6 mb-4">
    <div class="card product-card h-100 shadow-sm border-0 hover-lift">
        {{-- Product Image --}}
        <div class="position-relative overflow-hidden">
            <a href="{{ route('products.show', $product->slug) }}">
                @php
                    $cardImage = $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : 'https://via.placeholder.com/300x300?text=' . urlencode($product->name);
                @endphp
                <img src="{{ $cardImage }}" class="card-img-top" alt="{{ $product->name }}"
                    style="height: 250px; object-fit: contain; padding: 15px;">
            </a>

            {{-- Badges --}}
            <div class="position-absolute top-0 start-0 m-2">
                @if($product->is_new)
                    <span class="badge bg-success">New</span>
                @endif
                @if($product->is_flash_deal)
                    <span class="badge bg-danger">Flash Deal</span>
                @endif
                @if($product->discount_percentage)
                    <span class="badge bg-warning text-dark">-{{ $product->discount_percentage }}%</span>
                @endif
            </div>

            {{-- Wishlist Button --}}
            @php
                $inWishlist = array_key_exists($product->id, session('wishlist', []));
            @endphp
            <button
                class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle wishlist-btn {{ $inWishlist ? 'active' : '' }}"
                onclick="addToWishlist(this, '{{ $product->id }}', '{{ addslashes($product->name) }}', '{{ $product->price }}', '{{ $cardImage }}')"
                title="{{ $inWishlist ? 'In Wishlist' : 'Add to Wishlist' }}">
                <i class="{{ $inWishlist ? 'fas text-danger' : 'far' }} fa-heart"></i>
            </button>
        </div>

        {{-- Product Info --}}
        <div class="card-body d-flex flex-column">
            {{-- Category --}}
            <small class="text-muted mb-1">
                <i class="fas fa-tag me-1"></i>{{ $product->category->name ?? 'Uncategorized' }}
            </small>

            {{-- Product Name --}}
            <h6 class="card-title mb-2">
                <a href="{{ route('products.show', $product->slug) }}"
                    class="text-dark text-decoration-none product-title-link">
                    {{ Str::limit($product->name, 50) }}
                </a>
            </h6>

            {{-- Rating --}}
            @if($product->rating > 0)
                <div class="rating mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor((float) $product->rating))
                            <i class="fas fa-star text-warning"></i>
                        @elseif($i - 0.5 <= (float) $product->rating)
                            <i class="fas fa-star-half-alt text-warning"></i>
                        @else
                            <i class="far fa-star text-warning"></i>
                        @endif
                    @endfor
                    <small class="text-muted ms-1">({{ $product->reviews_count }})</small>
                </div>
            @endif

            {{-- Price --}}
            <div class="price-section mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="h5 mb-0 text-primary fw-bold">Rs {{ number_format((float) $product->price) }}</span>
                    @if($product->old_price)
                        <span class="text-muted text-decoration-line-through small">Rs
                            {{ number_format((float) $product->old_price) }}</span>
                    @endif
                </div>
            </div>

            {{-- Stock Status --}}
            @if($product->stock > 0)
                <small class="text-success mb-2">
                    <i class="fas fa-check-circle me-1"></i>In Stock ({{ $product->stock }})
                </small>
            @else
                <small class="text-danger mb-2">
                    <i class="fas fa-times-circle me-1"></i>Out of Stock
                </small>
            @endif

            {{-- Add to Cart Button --}}
            <div class="mt-auto">
                @if($product->stock > 0)
                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->slug }}">
                        <input type="hidden" name="name" value="{{ $product->name }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                        <button type="submit" class="btn btn-primary w-100 btn-sm">
                            <i class="fas fa-shopping-cart me-1"></i>Add to Cart
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary w-100 btn-sm" disabled>
                        Out of Stock
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .product-card {
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .product-card img {
        transition: transform 0.3s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-title-link:hover {
        color: #0d6efd !important;
    }

    .wishlist-btn {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .wishlist-btn {
        opacity: 1;
    }

    .wishlist-btn:hover {
        background-color: #dc3545 !important;
        color: white !important;
    }
</style>

<script>
    function addToWishlist(btn, productId, productName, productPrice, productImage) {
        // Optimistic UI update
        const icon = btn.querySelector('i');
        const wasInWishlist = icon.classList.contains('text-danger');

        // Toggle visualization immediately
        if (!wasInWishlist) {
            icon.classList.remove('far');
            icon.classList.add('fas', 'text-danger');
            btn.classList.add('active');
            btn.title = 'In Wishlist';
        } else {
            // If user wants to remove by clicking again (optional, depending on requirements, but standard UX)
            // For now, let's assume clicking again just tells them it's there or does nothing, 
            // but user asked for "outline must be there ... red if added".
            // The controller returns "Already in wishlist" error if added again.
            // Let's keep the backend valid check.
        }

        fetch('/wishlist/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
                    if (window.showEezepcToast) {
                        window.showEezepcToast({
                            type: 'success',
                            title: 'Added to Wish List',
                            message: 'One item added to Wish List',
                            image: productImage
                        });
                    } else {
                        showAlert(data.message, 'success');
                    }
                    updateWishlistCount(data.count);
                } else {
                    if (window.showEezepcToast) {
                        window.showEezepcToast({
                            type: 'warning',
                            title: 'Already in Wish List',
                            message: 'This item is already in your Wish List',
                            image: productImage
                        });
                    } else {
                        showAlert(data.message, 'warning');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (window.showEezepcToast) {
                    window.showEezepcToast({ type: 'error', title: 'Error', message: 'Could not add to Wish List' });
                } else {
                    showAlert('Error adding to wishlist', 'danger');
                }
            });
    }

    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        document.body.appendChild(alertDiv);
        setTimeout(() => { if (alertDiv.parentNode) alertDiv.remove(); }, 3000);
    }

    function updateWishlistCount(count) {
        const badge = document.querySelector('a[href*="wishlist"] .badge');
        if (badge) {
            badge.textContent = count;
        }
    }
</script>