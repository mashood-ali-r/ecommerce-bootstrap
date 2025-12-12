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
                                        <!-- Quantity Dropdown -->
                                        <form action="{{ route('cart.update') }}" method="POST" class="d-inline me-3">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <select name="quantity" 
                                                    style="width: 80px; padding: 5px 8px; font-size: 13px; border-radius: 7px; background-color: #F0F2F2; border: 1px solid #D5D9D9; cursor: pointer;"
                                                    onchange="this.form.submit()">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>Qty: {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </form>
                                        
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
                                    @if($item['quantity'] > 1)
                                        <div style="font-size: 12px; color: #565959;">
                                            Total: Rs {{ number_format($subtotal) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="text-end pt-2">
                            <span style="font-size: 18px; color: #0F1111;">
                                Subtotal ({{ array_sum(array_column($cart, 'quantity')) }} items): 
                                <span style="font-weight: 700;">Rs {{ number_format($total) }}</span>
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
                            Subtotal ({{ array_sum(array_column($cart, 'quantity')) }} items): 
                            <span style="font-weight: 700;">Rs {{ number_format($total) }}</span>
                        </p>
                        <div class="d-flex align-items-start mb-3">
                            <input type="checkbox" class="me-2 mt-1" id="gift" style="accent-color: #007185;">
                            <label for="gift" style="font-size: 13px; color: #0F1111;">This order contains a gift</label>
                        </div>
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
@endsection
