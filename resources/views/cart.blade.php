@extends('layouts.app')

@section('title', 'Shopping Cart - EEZEPC.com')

@section('content')
<div style="background-color: #EAEDED; min-height: 100vh;">
    <div class="container py-4" style="max-width: 1500px;">
        <div class="row">
            <!-- Cart Items Column -->
            <div class="col-lg-9">
                <div class="bg-white p-4 shadow-sm mb-3 rounded">
                    <div class="d-flex justify-content-between align-items-end border-bottom pb-3 mb-3">
                        <h1 style="font-size: 28px; font-weight: 400; color: #0F1111; margin-bottom: 0;">Shopping Cart</h1>
                        <span style="color: #565959; font-size: 14px;">Price</span>
                    </div>

                    @if(isset($cart) && count($cart) > 0)
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php 
                                $subtotal = $item['price'] * $item['quantity']; 
                                $total += $subtotal;
                                $product = \App\Models\Product::find($id);
                            @endphp
                            <div class="row mb-4 pb-4" style="border-bottom: 1px solid #DDD;" id="cart-item-{{ $id }}">
                                <!-- Image -->
                                <div class="col-md-2 col-3">
                                    <a href="{{ $product ? route('products.show', $product->slug) : '#' }}">
                                        <img src="{{ $product && $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/180x180?text=Product' }}" 
                                             class="img-fluid" alt="{{ $item['name'] }}" 
                                             style="max-height: 180px; width: 100%; object-fit: contain;">
                                    </a>
                                </div>
                                
                                <!-- Details -->
                                <div class="col-md-7 col-6">
                                    <a href="{{ $product ? route('products.show', $product->slug) : '#' }}" 
                                       style="color: #007185; text-decoration: none; font-size: 16px; line-height: 1.4;">
                                        {{ $item['name'] }}
                                    </a>
                                    <p class="mb-1 mt-2" style="color: #007600; font-size: 12px;">
                                        <i class="fas fa-check me-1"></i>In Stock
                                    </p>
                                    <p class="mb-2" style="color: #565959; font-size: 12px;">
                                        Eligible for <span style="color: #007185;">FREE Shipping</span>
                                    </p>
                                    
                                    <!-- Amazon-style inline actions -->
                                    <div class="d-flex flex-wrap align-items-center mt-3" style="font-size: 12px;">
                                        <!-- Quantity Input (AJAX) -->
                                        <div class="d-inline me-3">
                                            <input type="number" value="{{ $item['quantity'] }}" min="1" 
                                                   class="form-control form-control-sm text-center d-inline-block quantity-input" 
                                                   data-id="{{ $id }}"
                                                   style="width: 70px; font-size: 13px; background-color: #F0F2F2;"
                                                   onchange="updateCartQuantity(this, '{{ $id }}')">
                                        </div>
                                        
                                        <span style="color: #DDD; margin-right: 12px;">|</span>
                                        
                                        <!-- Delete Link -->
                                        <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit" 
                                                    style="background: none; border: none; color: #007185; cursor: pointer; font-size: 12px; padding: 0;"
                                                    onmouseover="this.style.textDecoration='underline'" 
                                                    onmouseout="this.style.textDecoration='none'">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Price -->
                                <div class="col-md-3 col-3 text-end">
                                    <span style="font-size: 18px; font-weight: 700; color: #0F1111;">
                                        Rs {{ number_format($item['price']) }}
                                    </span>
                                    @if($item['quantity'] >= 1)
                                        <div style="font-size: 12px; color: #565959;">
                                            Total: <span class="item-subtotal">Rs {{ number_format($subtotal) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="text-end pt-2">
                            <span style="font-size: 18px; color: #0F1111;">
                                Subtotal (<span class="cart-count">{{ array_sum(array_column($cart, 'quantity')) }}</span> items): 
                                <span style="font-weight: 700;" class="cart-total">Rs {{ number_format($total) }}</span>
                            </span>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-shopping-cart" style="font-size: 80px; color: #DDD;"></i>
                            </div>
                            <h2 style="font-size: 24px; font-weight: 400; color: #0F1111; margin-bottom: 16px;">Your EEZEPC Cart is empty</h2>
                            <p style="color: #565959; font-size: 14px; margin-bottom: 24px;">
                                <a href="{{ route('products.index') }}" style="color: #007185; text-decoration: none;"
                                   onmouseover="this.style.textDecoration='underline'" 
                                   onmouseout="this.style.textDecoration='none'">
                                    Shop today's deals
                                </a>
                            </p>
                            <a href="{{ route('products.index') }}" 
                               style="display: inline-block; padding: 8px 24px; background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; border-radius: 3px; color: #0F1111; text-decoration: none; font-size: 14px;">
                                Continue Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Checkout Sidebar -->
            <div class="col-lg-3">
                @if(isset($cart) && count($cart) > 0)
                    <div class="bg-white p-4 shadow-sm rounded">
                        <p style="font-size: 18px; color: #0F1111; margin-bottom: 16px;">
                            Subtotal (<span class="cart-count">{{ array_sum(array_column($cart, 'quantity')) }}</span> items): 
                            <span style="font-weight: 700;" class="cart-total">Rs {{ number_format($total) }}</span>
                        </p>

                        <a href="{{ route('checkout') }}" 
                           style="display: block; width: 100%; padding: 10px; text-align: center; background: #FFD814; border: 1px solid #FCD200; border-radius: 8px; color: #0F1111; text-decoration: none; font-size: 14px;">
                            Proceed to checkout
                        </a>
                    </div>
                    
                    <!-- Security Badge -->
                    <div class="mt-3 text-center" style="font-size: 12px; color: #565959;">
                        <i class="fas fa-lock me-1"></i>
                        Secure transaction
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function updateCartQuantity(input, id) {
        const quantity = input.value;
        if(quantity < 1) return;

        // Visual feedback
        input.style.opacity = '0.5';
        
        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id: id,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            input.style.opacity = '1';
            
            if(data.success) {
                // Update Item Subtotal
                const itemTotalEl = document.querySelector(`#cart-item-${id} .item-subtotal`);
                if(itemTotalEl) itemTotalEl.textContent = 'Rs ' + data.item_subtotal;
                
                // Update Cart Totals
                document.querySelectorAll('.cart-total').forEach(el => {
                    el.textContent = 'Rs ' + data.cart_total;
                });
                
                // Update Counts
                document.querySelectorAll('.cart-count').forEach(el => {
                    el.textContent = data.cart_count;
                });

                if(window.showEezepcToast) {
                    window.showEezepcToast({ type: 'success', title: 'Cart Updated', message: 'Quantity updated' });
                }
            } else {
                 if(window.showEezepcToast) {
                    window.showEezepcToast({ type: 'error', title: 'Error', message: data.message });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            input.style.opacity = '1';
        });
    }
</script>
@endpush
@endsection
