@extends('layouts.app')

@section('title', 'Your Wishlist - EEZEPC.com')

@section('content')
    <div style="background-color: #EAEDED; min-height: 100vh;">
        <div class="container py-4">
            <div class="row">
                <!-- Main Wishlist Content -->
                <div class="col-lg-9">
                    <!-- Wishlist Header Card -->
                    <div class="bg-white p-4 mb-3 rounded shadow-sm">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h1 style="font-size: 28px; font-weight: 400; color: #0F1111; margin-bottom: 0;">Your
                                    Wishlist</h1>
                                @if(count(session('wishlist', [])) > 0)
                                    <p class="text-muted mb-0" style="font-size: 14px;">
                                        {{ count(session('wishlist', [])) }}
                                        item{{ count(session('wishlist', [])) > 1 ? 's' : '' }} saved
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(count(session('wishlist', [])) > 0)
                        <!-- Wishlist Items -->
                        @php $wishlist = session('wishlist', []); @endphp
                        @foreach($wishlist as $item)
                            @php $product = \App\Models\Product::find($item['id']); @endphp
                            <div class="bg-white p-4 mb-3 rounded shadow-sm" id="wishlist-item-{{ $item['id'] }}">
                                <div class="row">
                                    <!-- Product Image -->
                                    <div class="col-md-2 col-3">
                                        <a href="{{ route('products.show', $product->slug ?? $item['id']) }}">
                                            <img src="{{ $product && $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/180x180?text=Product' }}"
                                                alt="{{ $item['name'] }}" class="img-fluid"
                                                style="max-height: 180px; width: 100%; object-fit: contain;">
                                        </a>
                                    </div>

                                    <!-- Product Details -->
                                    <div class="col-md-7 col-9">
                                        <a href="{{ route('products.show', $product->slug ?? $item['id']) }}"
                                            style="color: #007185; text-decoration: none; font-size: 16px; line-height: 1.4;">
                                            {{ $item['name'] }}
                                        </a>

                                        <p class="mb-1 mt-2" style="color: #007600; font-size: 12px;">
                                            <i class="fas fa-check me-1"></i>In Stock
                                        </p>

                                        <p class="mb-2" style="color: #565959; font-size: 12px;">
                                            Eligible for <span style="color: #007185;">FREE Shipping</span>
                                        </p>

                                        <!-- Amazon-style inline action links -->
                                        <div class="d-flex flex-wrap align-items-center mt-3" style="font-size: 12px;">
                                            <div class="d-flex align-items-center me-3 pe-3" style="border-right: 1px solid #DDD;">
                                                <select class="form-select form-select-sm"
                                                    style="width: 80px; font-size: 13px; border-radius: 7px; background-color: #F0F2F2; border: 1px solid #D5D9D9;">
                                                    <option>Qty: 1</option>
                                                    <option>Qty: 2</option>
                                                    <option>Qty: 3</option>
                                                    <option>Qty: 4</option>
                                                    <option>Qty: 5</option>
                                                </select>
                                            </div>
                                            <a href="javascript:void(0)" onclick="removeFromWishlist('{{ $item['id'] }}')"
                                                style="color: #007185; text-decoration: none;" class="me-3 pe-3"
                                                onmouseover="this.style.textDecoration='underline'"
                                                onmouseout="this.style.textDecoration='none'">
                                                Delete
                                            </a>
                                            <span style="color: #DDD; margin-right: 12px;">|</span>
                                            <a href="javascript:void(0)" onclick="moveToCart('{{ $item['id'] }}')"
                                                style="color: #007185; text-decoration: none;"
                                                onmouseover="this.style.textDecoration='underline'"
                                                onmouseout="this.style.textDecoration='none'">
                                                Move to Cart
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                        <div style="font-size: 18px; color: #0F1111; font-weight: 400;">
                                            <span
                                                style="font-size: 13px; position: relative; top: -5px;">Rs</span>{{ number_format($item['price']) }}
                                        </div>
                                        @if($product && $product->compare_price && $product->compare_price > $item['price'])
                                            <div style="font-size: 13px; color: #565959;">
                                                List: <span style="text-decoration: line-through;">Rs
                                                    {{ number_format($product->compare_price) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Subtotal in bottom -->
                        <div class="bg-white p-3 rounded shadow-sm text-end">
                            @php
                                $total = array_sum(array_column(session('wishlist', []), 'price'));
                            @endphp
                            <span style="font-size: 18px; color: #0F1111;">
                                Subtotal ({{ count(session('wishlist', [])) }}
                                item{{ count(session('wishlist', [])) > 1 ? 's' : '' }}):
                                <span style="font-weight: 700;">Rs {{ number_format($total) }}</span>
                            </span>
                        </div>

                    @else
                        <!-- Empty Wishlist -->
                        <div class="bg-white p-5 rounded shadow-sm text-center">
                            <div class="mb-4">
                                <i class="far fa-heart" style="font-size: 80px; color: #DDD;"></i>
                            </div>
                            <h2 style="font-size: 24px; font-weight: 400; color: #0F1111; margin-bottom: 16px;">Your Wishlist is
                                empty</h2>
                            <p style="color: #565959; font-size: 14px; max-width: 400px; margin: 0 auto 24px;">
                                Save items you love by clicking the heart icon on any product page.
                                Your wishlist makes it easy to find and buy your favorite items later.
                            </p>
                            <a href="{{ route('products.index') }}"
                                style="display: inline-block; padding: 8px 24px; background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; border-radius: 3px; color: #0F1111; text-decoration: none; font-size: 14px;">
                                <i class="fas fa-shopping-bag me-1"></i>Start Shopping
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-3 mt-3 mt-lg-0">
                    @if(count(session('wishlist', [])) > 0)
                        <!-- Add All to Cart Card -->
                        <div class="bg-white p-4 rounded shadow-sm">
                            @php
                                $total = array_sum(array_column(session('wishlist', []), 'price'));
                            @endphp
                            <p style="font-size: 18px; color: #0F1111; margin-bottom: 16px;">
                                Subtotal ({{ count(session('wishlist', [])) }}
                                item{{ count(session('wishlist', [])) > 1 ? 's' : '' }}):
                                <span style="font-weight: 700;">Rs {{ number_format($total) }}</span>
                            </p>
                            <button onclick="moveAllToCart()"
                                style="width: 100%; padding: 10px; background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; border-radius: 8px; font-size: 14px; cursor: pointer; color: #0F1111;">
                                Add all to Cart
                            </button>
                            <a href="{{ route('products.index') }}"
                                style="display: block; text-align: center; margin-top: 12px; color: #007185; font-size: 13px; text-decoration: none;"
                                onmouseover="this.style.textDecoration='underline'"
                                onmouseout="this.style.textDecoration='none'">
                                Continue Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function clearAllWishlist() {
                if (!confirm('Remove all items from wishlist?')) return;

                fetch('{{ route("wishlist.clear") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        // Check if response is redirect (success) or JSON
                        if (response.redirected) {
                            window.location.href = response.url;
                        } else {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Error clearing wishlist', 'danger');
                    });
            }

            function removeFromWishlist(productId) {
                const item = document.getElementById('wishlist-item-' + productId);
                if (!item) return;

                item.style.opacity = '0.5';
                item.style.pointerEvents = 'none';

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
                        if (data.success) {
                            item.style.transition = 'all 0.3s ease';
                            item.style.transform = 'translateX(-20px)';
                            item.style.opacity = '0';
                            setTimeout(() => {
                                item.remove();
                                if (data.count === 0) {
                                    location.reload();
                                }
                                updateSubtotals();
                            }, 300);
                            showToast('Item removed from wishlist', 'success');
                        } else {
                            item.style.opacity = '1';
                            item.style.pointerEvents = 'auto';
                            showToast(data.message || 'Error removing item', 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        item.style.opacity = '1';
                        item.style.pointerEvents = 'auto';
                        showToast('Error removing item', 'danger');
                    });
            }

            function moveToCart(productId) {
                const item = document.getElementById('wishlist-item-' + productId);
                if (!item) return;

                item.style.opacity = '0.5';
                item.style.pointerEvents = 'none';

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
                        if (data.success) {
                            item.style.transition = 'all 0.3s ease';
                            item.style.transform = 'translateX(20px)';
                            item.style.opacity = '0';
                            setTimeout(() => {
                                item.remove();
                                if (data.wishlist_count === 0) {
                                    location.reload();
                                }
                                updateSubtotals();
                            }, 300);
                            showToast('Item added to cart!', 'success');
                            updateNavbarCartCount(data.cart_count);
                        } else {
                            item.style.opacity = '1';
                            item.style.pointerEvents = 'auto';
                            showToast(data.message || 'Error moving to cart', 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        item.style.opacity = '1';
                        item.style.pointerEvents = 'auto';
                        showToast('Error moving to cart', 'danger');
                    });
            }

            function moveAllToCart() {
                const items = document.querySelectorAll('[id^="wishlist-item-"]');
                let delay = 0;
                items.forEach((item) => {
                    const productId = item.id.replace('wishlist-item-', '');
                    setTimeout(() => moveToCart(productId), delay);
                    delay += 300;
                });
            }

            function updateSubtotals() {
                // Reload page to update subtotals - simpler approach
                setTimeout(() => {
                    const items = document.querySelectorAll('[id^="wishlist-item-"]');
                    if (items.length === 0) {
                        location.reload();
                    }
                }, 500);
            }

            function updateNavbarCartCount(count) {
                const cartSpan = document.querySelector('a[href*="cart"] span');
                if (cartSpan) {
                    cartSpan.textContent = count;
                }
            }

            function showToast(message, type) {
                // Remove existing toasts
                document.querySelectorAll('.amz-toast').forEach(t => t.remove());

                const toast = document.createElement('div');
                toast.className = 'amz-toast';
                toast.style.cssText = `
                                    position: fixed;
                                    top: 80px;
                                    right: 20px;
                                    z-index: 9999;
                                    background: ${type === 'success' ? '#067D62' : '#D13212'};
                                    color: white;
                                    padding: 12px 20px;
                                    border-radius: 4px;
                                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                                    font-size: 14px;
                                    animation: slideIn 0.3s ease;
                                `;
                toast.innerHTML = `
                                    <div style="display: flex; align-items: center;">
                                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}" style="margin-right: 10px;"></i>
                                        <span>${message}</span>
                                    </div>
                                `;
                document.body.appendChild(toast);
                setTimeout(() => {
                    toast.style.animation = 'slideOut 0.3s ease forwards';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        </script>

        <style>
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }

                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }

                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        </style>
    @endpush
@endsection