@extends('layouts.app')

@section('title', 'Checkout - EEZEPC.com')

@section('content')
    <div class="bg-light min-vh-100 py-4">
        <div class="container">
            <!-- Checkout Header -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-baseline">
                    <span class="fw-bold" style="font-size: 28px; color: #0f1111;">EEZEPC</span>
                    <span class="fw-bold" style="font-size: 28px; color: #ff9900;">.com</span>
                </a>
                <h1 class="h4 mb-0" style="color: #0f1111;">Checkout (<span
                        id="itemCount">{{ array_sum(array_column($cart, 'quantity')) }}</span> items)</h1>
                <i class="fas fa-lock text-muted"></i>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="row">
                    <!-- Left Column - Forms -->
                    <div class="col-lg-8">
                        <!-- Step 1: Delivery Address -->
                        <div class="bg-white rounded p-4 mb-3 checkout-section">
                            <div class="d-flex align-items-start">
                                <div class="step-number me-3">1</div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-3" style="color: #0f1111;">Delivery Address</h5>

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-medium">Full Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control checkout-input @error('full_name') is-invalid @enderror"
                                                name="full_name" value="{{ old('full_name', auth()->user()->name ?? '') }}"
                                                placeholder="Enter your full name" required>
                                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-medium">Mobile Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="tel"
                                                class="form-control checkout-input @error('phone') is-invalid @enderror"
                                                name="phone" value="{{ old('phone') }}" placeholder="03XX-XXXXXXX"
                                                id="phone" required>
                                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-medium">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email"
                                                class="form-control checkout-input @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                                                placeholder="email@example.com" required>
                                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-medium">Street Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control checkout-input @error('address') is-invalid @enderror"
                                                name="address" value="{{ old('address') }}"
                                                placeholder="House no, Street, Area" required>
                                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-medium">City <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select checkout-input @error('city') is-invalid @enderror"
                                                name="city" required>
                                                <option value="">Select City</option>
                                                <option value="Karachi" {{ old('city') == 'Karachi' ? 'selected' : '' }}>
                                                    Karachi</option>
                                                <option value="Lahore" {{ old('city') == 'Lahore' ? 'selected' : '' }}>Lahore
                                                </option>
                                                <option value="Islamabad" {{ old('city') == 'Islamabad' ? 'selected' : '' }}>
                                                    Islamabad</option>
                                                <option value="Rawalpindi" {{ old('city') == 'Rawalpindi' ? 'selected' : '' }}>Rawalpindi</option>
                                                <option value="Faisalabad" {{ old('city') == 'Faisalabad' ? 'selected' : '' }}>Faisalabad</option>
                                                <option value="Multan" {{ old('city') == 'Multan' ? 'selected' : '' }}>Multan
                                                </option>
                                                <option value="Peshawar" {{ old('city') == 'Peshawar' ? 'selected' : '' }}>
                                                    Peshawar</option>
                                                <option value="Quetta" {{ old('city') == 'Quetta' ? 'selected' : '' }}>Quetta
                                                </option>
                                                <option value="Other" {{ old('city') == 'Other' ? 'selected' : '' }}>Other
                                                </option>
                                            </select>
                                            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-medium">Postal Code</label>
                                            <input type="text"
                                                class="form-control checkout-input @error('postal_code') is-invalid @enderror"
                                                name="postal_code" value="{{ old('postal_code') }}"
                                                placeholder="e.g., 75300">
                                            @error('postal_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Payment Method -->
                        <div class="bg-white rounded p-4 mb-3 checkout-section">
                            <div class="d-flex align-items-start">
                                <div class="step-number me-3">2</div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-3" style="color: #0f1111;">Payment Method</h5>

                                    <!-- Cash on Delivery -->
                                    <div class="payment-option mb-2">
                                        <input type="radio" class="form-check-input" name="payment_method" id="cod"
                                            value="cod" checked>
                                        <label class="form-check-label w-100" for="cod">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-money-bill-wave me-3"
                                                    style="font-size: 24px; color: #067D62;"></i>
                                                <div>
                                                    <span class="fw-medium">Cash on Delivery</span>
                                                    <p class="text-muted small mb-0">Pay when your order arrives</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Bank Transfer -->
                                    <div class="payment-option mb-2">
                                        <input type="radio" class="form-check-input" name="payment_method"
                                            id="bank_transfer" value="bank_transfer">
                                        <label class="form-check-label w-100" for="bank_transfer">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-university me-3"
                                                    style="font-size: 24px; color: #232f3e;"></i>
                                                <div>
                                                    <span class="fw-medium">Bank Transfer</span>
                                                    <p class="text-muted small mb-0">Transfer directly to our bank account
                                                    </p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Credit/Debit Card -->
                                    <div class="payment-option">
                                        <input type="radio" class="form-check-input" name="payment_method" id="credit_card"
                                            value="credit_card">
                                        <label class="form-check-label w-100" for="credit_card">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-credit-card me-3"
                                                    style="font-size: 24px; color: #1a73e8;"></i>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium">Credit / Debit Card</span>
                                                    <p class="text-muted small mb-0">Visa, Mastercard, etc.</p>
                                                </div>
                                                <div class="d-flex gap-1">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/100px-Visa_Inc._logo.svg.png"
                                                        alt="Visa" style="height: 20px;">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/100px-Mastercard-logo.svg.png"
                                                        alt="Mastercard" style="height: 20px;">
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Review Items -->
                        <div class="bg-white rounded p-4 checkout-section">
                            <div class="d-flex align-items-start">
                                <div class="step-number me-3">3</div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-3" style="color: #0f1111;">Review Items and Delivery</h5>

                                    @foreach($cart as $id => $item)
                                        <div class="d-flex gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                            @php $product = \App\Models\Product::find($id); @endphp
                                            <img src="{{ $product && $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/80x80' }}"
                                                alt="{{ $item['name'] }}" class="rounded"
                                                style="width: 80px; height: 80px; object-fit: contain; background: #f8f8f8;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1" style="font-size: 14px; color: #0f1111;">{{ $item['name'] }}
                                                </h6>
                                                <p class="mb-1" style="font-size: 18px; color: #B12704; font-weight: 500;">Rs
                                                    {{ number_format($item['price']) }}</p>
                                                <p class="mb-0 small text-muted">Qty: {{ $item['quantity'] }}</p>
                                            </div>
                                            <div class="text-end">
                                                <span class="fw-bold" style="color: #0f1111;">Rs
                                                    {{ number_format($item['price'] * $item['quantity']) }}</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Estimated Delivery -->
                                    <div class="bg-light rounded p-3 mt-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-truck me-3" style="color: #067D62; font-size: 20px;"></i>
                                            <div>
                                                <span class="fw-medium" style="color: #067D62;">Estimated delivery:
                                                    {{ now()->addDays(3)->format('D, M j') }} -
                                                    {{ now()->addDays(5)->format('D, M j') }}</span>
                                                <p class="text-muted small mb-0">Standard shipping included</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Order Summary -->
                    <div class="col-lg-4">
                        <div class="bg-white rounded p-4 sticky-top" style="top: 100px;">
                            <!-- Place Order Button -->
                            <button type="submit" class="btn w-100 mb-3 py-2" id="placeOrderBtn"
                                style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; border-radius: 8px; font-size: 14px;">
                                Place your order
                            </button>

                            <p class="small text-muted text-center mb-3">
                                By placing your order, you agree to EEZEPC's <a href="#" style="color: #007185;">terms of
                                    service</a> and <a href="#" style="color: #007185;">privacy policy</a>.
                            </p>

                            <hr>

                            <h6 class="fw-bold mb-3" style="color: #0f1111;">Order Summary</h6>

                            <div class="d-flex justify-content-between mb-2" style="font-size: 14px;">
                                <span>Items ({{ array_sum(array_column($cart, 'quantity')) }}):</span>
                                <span>Rs {{ number_format($subtotal) }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2" style="font-size: 14px;">
                                <span>Shipping & handling:</span>
                                <span>Rs {{ number_format($shipping) }}</span>
                            </div>

                            @if($shipping == 0)
                                <div class="d-flex justify-content-between mb-2" style="font-size: 14px; color: #067D62;">
                                    <span>Shipping discount:</span>
                                    <span>-Rs 0</span>
                                </div>
                            @endif

                            <hr>

                            <div class="d-flex justify-content-between mb-2" style="font-size: 14px;">
                                <span>Total before tax:</span>
                                <span>Rs {{ number_format($subtotal + $shipping) }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3" style="font-size: 14px;">
                                <span>Estimated tax (5%):</span>
                                <span>Rs {{ number_format($tax) }}</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between" style="font-size: 18px; color: #B12704;">
                                <span class="fw-bold">Order Total:</span>
                                <span class="fw-bold">Rs {{ number_format($total) }}</span>
                            </div>

                            <!-- Security Trust Badges -->
                            <div class="text-center mt-4 pt-3 border-top">
                                <div class="d-flex justify-content-center gap-3 mb-2">
                                    <i class="fas fa-lock text-muted"></i>
                                    <i class="fas fa-shield-alt text-muted"></i>
                                    <i class="fas fa-truck text-muted"></i>
                                </div>
                                <small class="text-muted">Secure checkout · Free returns · Fast delivery</small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <style>
            .step-number {
                width: 32px;
                height: 32px;
                background: #232f3e;
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 14px;
                flex-shrink: 0;
            }

            .checkout-input {
                border: 1px solid #a6a6a6;
                border-radius: 4px;
                padding: 8px 12px;
                font-size: 14px;
            }

            .checkout-input:focus {
                border-color: #e77600;
                box-shadow: 0 0 0 3px rgba(228, 121, 17, 0.15);
            }

            .payment-option {
                border: 1px solid #d5d5d5;
                border-radius: 8px;
                padding: 12px 16px;
                cursor: pointer;
                transition: all 0.2s;
            }

            .payment-option:hover {
                border-color: #e77600;
            }

            .payment-option input[type="radio"]:checked+label {
                color: #0f1111;
            }

            .payment-option:has(input:checked) {
                border-color: #e77600;
                background: #fef8f2;
            }

            .checkout-section {
                border: 1px solid #ddd;
            }

            @media (max-width: 991px) {
                .col-lg-4 .sticky-top {
                    position: relative !important;
                    top: 0 !important;
                    margin-top: 20px;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Phone number formatting
            document.getElementById('phone').addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 4) {
                    value = value.substring(0, 4) + '-' + value.substring(4, 11);
                }
                e.target.value = value;
            });

            // Form validation
            document.getElementById('checkoutForm').addEventListener('submit', function (e) {
                const btn = document.getElementById('placeOrderBtn');
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                btn.disabled = true;

                const phone = document.getElementById('phone').value;
                const phoneRegex = /^03\d{2}-?\d{7}$/;

                if (!phoneRegex.test(phone.replace(/-/g, ''))) {
                    e.preventDefault();
                    btn.innerHTML = 'Place your order';
                    btn.disabled = false;
                    showError('Please enter a valid Pakistani phone number (03XX-XXXXXXX)');
                    document.getElementById('phone').focus();
                    return false;
                }
            });

            function showError(message) {
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger position-fixed shadow-lg';
                alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                alert.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i>${message}`;
                document.body.appendChild(alert);
                setTimeout(() => alert.remove(), 4000);
            }
        </script>
    @endpush
@endsection