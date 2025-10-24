@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 fw-bold">Your Basket</h2>
        </div>
    </div>

    @if(isset($cart) && count($cart) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php 
                                $subtotal = $item['price'] * $item['quantity']; 
                                $total += $subtotal; 
                            @endphp
                            <div class="row align-items-center border-bottom py-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/80x80" class="img-thumbnail me-3" alt="{{ $item['name'] }}">
                                        <div>
                                            <h6 class="mb-1">{{ $item['name'] }}</h6>
                                            <small class="text-muted">Rs {{ number_format($item['price'], 2) }}</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="quantity-controls">
                                        <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="button" class="btn btn-outline-secondary btn-sm quantity-btn" onclick="changeQuantity(this, -1)">-</button>
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99"
                                                   class="form-control form-control-sm text-center mx-2 quantity-input" 
                                                   style="width: 60px;" 
                                                   onchange="updateQuantity(this)">
                                            <button type="button" class="btn btn-outline-secondary btn-sm quantity-btn" onclick="changeQuantity(this, 1)">+</button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="col-md-2 text-center">
                                    <strong class="text-primary">Rs {{ number_format($subtotal, 2) }}</strong>
                                </div>
                                
                                <div class="col-md-2 text-center">
                                    <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to remove this item?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>Rs {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span class="text-success">Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax:</span>
                            <span>Rs 0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="text-primary">Rs {{ number_format($total, 2) }}</strong>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Secure checkout with SSL encryption
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Your basket is empty!</h4>
                    <p class="text-muted">Looks like you haven't added any items to your basket yet.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Start Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function changeQuantity(button, change) {
    const form = button.closest('form');
    const input = form.querySelector('input[name="quantity"]');
    const currentValue = parseInt(input.value);
    const newValue = Math.max(1, Math.min(99, currentValue + change));
    
    input.value = newValue;
    form.submit();
}

function updateQuantity(input) {
    const form = input.closest('form');
    const value = parseInt(input.value);
    
    if (value < 1) {
        input.value = 1;
    } else if (value > 99) {
        input.value = 99;
    }
    
    form.submit();
}
</script>
@endsection
