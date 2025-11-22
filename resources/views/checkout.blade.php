@extends('layouts.app')

@section('title', 'Checkout - EEZEPC.com')

@section('content')
<div class="container mt-4 mb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.view') }}" class="text-decoration-none">Cart</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
    </nav>

    <h1 class="mb-4">Checkout</h1>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row">
            <!-- Billing Information -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Billing Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" 
                                       placeholder="03XX-XXXXXXX" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Street Address <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city') }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="postal_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                                       id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required>
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">
                                <strong>Cash on Delivery</strong>
                                <p class="text-muted small mb-0">Pay when you receive your order</p>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                            <label class="form-check-label" for="bank_transfer">
                                <strong>Bank Transfer</strong>
                                <p class="text-muted small mb-0">Transfer to our bank account</p>
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card">
                            <label class="form-check-label" for="credit_card">
                                <strong>Credit/Debit Card</strong>
                                <p class="text-muted small mb-0">Pay securely with your card</p>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Order Notes (Optional)</h6>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" name="order_notes" rows="3" 
                                  placeholder="Any special instructions for your order?">{{ old('order_notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <!-- Cart Items -->
                        <div class="order-items mb-3">
                            @foreach($cart as $id => $item)
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item['name'] }}</h6>
                                    <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                                </div>
                                <div class="text-end">
                                    <strong>Rs {{ number_format($item['price'] * $item['quantity']) }}</strong>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Price Breakdown -->
                        <div class="price-breakdown">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <strong>Rs {{ number_format($subtotal) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <strong>Rs {{ number_format($shipping) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                <span>Tax (5%):</span>
                                <strong>Rs {{ number_format($tax) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0">Total:</h5>
                                <h5 class="mb-0 text-primary">Rs {{ number_format($total) }}</h5>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" class="btn btn-success btn-lg w-100 mb-2">
                            <i class="fas fa-check-circle me-2"></i>Place Order
                        </button>

                        <a href="{{ route('cart.view') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i>Back to Cart
                        </a>

                        <!-- Security Badge -->
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i>Secure Checkout
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Form validation
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const phone = document.getElementById('phone').value;
    const phoneRegex = /^03\d{2}-?\d{7}$/;
    
    if (!phoneRegex.test(phone.replace(/-/g, ''))) {
        e.preventDefault();
        alert('Please enter a valid Pakistani phone number (03XX-XXXXXXX)');
        document.getElementById('phone').focus();
        return false;
    }
});

// Auto-format phone number
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 4) {
        value = value.substring(0, 4) + '-' + value.substring(4, 11);
    }
    e.target.value = value;
});
</script>
@endpush
@endsection
