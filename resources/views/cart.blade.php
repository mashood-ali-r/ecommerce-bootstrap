@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 1500px;">
    <div class="row">
        <!-- Cart Items Column -->
        <div class="col-lg-9">
            <div class="bg-white p-4 shadow-sm mb-4">
                <div class="d-flex justify-content-between align-items-end border-bottom pb-3 mb-3">
                    <h2 class="h4 mb-0 fw-bold">Shopping Cart</h2>
                    <span class="text-secondary">Price</span>
                </div>

                @if(isset($cart) && count($cart) > 0)
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php 
                            $subtotal = $item['price'] * $item['quantity']; 
                            $total += $subtotal; 
                        @endphp
                        <div class="row mb-4 border-bottom pb-4">
                            <!-- Image -->
                            <div class="col-md-2">
                                <img src="https://source.unsplash.com/random/200x200/?product" class="img-fluid" alt="{{ $item['name'] }}" style="max-height: 150px; object-fit: contain;">
                            </div>
                            
                            <!-- Details -->
                            <div class="col-md-8">
                                <h5 class="mb-1">
                                    <a href="#" class="text-decoration-none text-dark hover-link">{{ $item['name'] }}</a>
                                </h5>
                                <div class="text-success small mb-1">In Stock</div>
                                <div class="small text-secondary mb-2">Eligible for FREE Shipping</div>
                                <div class="d-flex align-items-center gap-3">
                                    <!-- Quantity Form -->
                                    <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <select name="quantity" class="form-select form-select-sm" style="width: 80px; background: #f0f2f2; border-color: #d5d9d9; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;" onchange="this.form.submit()">
                                            @for($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>Qty: {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </form>
                                    
                                    <span class="text-secondary">|</span>
                                    
                                    <!-- Delete Form -->
                                    <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="btn btn-link btn-sm text-decoration-none p-0" style="color: #007185;">Delete</button>
                                    </form>
                                    
                                    <span class="text-secondary">|</span>
                                    <a href="#" class="btn btn-link btn-sm text-decoration-none p-0" style="color: #007185;">Save for later</a>
                                </div>
                            </div>
                            
                            <!-- Price -->
                            <div class="col-md-2 text-end">
                                <span class="fw-bold fs-5">Rs {{ number_format($item['price'], 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="text-end">
                        <span class="fs-5">Subtotal ({{ count($cart) }} items): </span>
                        <span class="fw-bold fs-5">Rs {{ number_format($total, 2) }}</span>
                    </div>
                @else
                    <div class="text-center py-5">
                        <h3 class="h5">Your Amazon Cart is empty.</h3>
                        <p>Check your Saved for later items below or <a href="{{ route('home') }}" class="text-decoration-none">continue shopping</a>.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Checkout Sidebar -->
        <div class="col-lg-3">
            @if(isset($cart) && count($cart) > 0)
                <div class="bg-white p-3 shadow-sm">
                    <div class="mb-3">
                        <span class="fs-5">Subtotal ({{ count($cart) }} items): </span>
                        <span class="fw-bold fs-5 text-danger">Rs {{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <input type="checkbox" class="me-2" id="gift">
                        <label for="gift" class="small">This order contains a gift</label>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn w-100 mb-3" style="background-color: #ffd814; border-color: #fcd200; border-radius: 8px; color: #111;">Proceed to checkout</a>
                </div>
            @endif
            
            <!-- Recommendations -->
            <div class="bg-white p-3 shadow-sm mt-3">
                <h6 class="fw-bold mb-3">Recommended for you</h6>
                <!-- Placeholder for recommendations -->
                <div class="d-flex mb-2">
                    <img src="https://source.unsplash.com/random/50x50/?tech" class="me-2" alt="Product">
                    <div>
                        <a href="#" class="small text-decoration-none" style="color: #007185;">Wireless Mouse</a>
                        <div class="text-danger small fw-bold">Rs 1,200</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

