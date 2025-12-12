@extends('layouts.app')

@section('title', 'Order Confirmed - EEZEPC.com')

@section('content')
    <div style="background-color: #EAEDED; min-height: 100vh;">
        <div class="container py-4" style="max-width: 1100px;">

            <!-- Success Header Banner -->
            <div class="bg-white rounded shadow-sm p-4 mb-4">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #00A650, #00C853); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check text-white" style="font-size: 28px;"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h1 style="font-size: 28px; font-weight: 400; color: #0F1111; margin-bottom: 4px;">Order Confirmed!
                        </h1>
                        <p style="font-size: 14px; color: #565959; margin-bottom: 0;">
                            Thank you for shopping with EEZEPC. A confirmation email has been sent to
                            <strong>{{ $order->customer_email }}</strong>
                        </p>
                    </div>
                    <div class="col-auto d-none d-md-block">
                        <a href="{{ route('orders.show', $order->order_number) }}"
                            style="display: inline-block; padding: 10px 20px; background: #FFD814; border: 1px solid #FCD200; border-radius: 20px; color: #0F1111; text-decoration: none; font-size: 14px;">
                            View Order Details
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column: Order Details -->
                <div class="col-lg-8">
                    <!-- Delivery Information Card -->
                    <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas fa-truck" style="font-size: 24px; color: #007185;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div style="font-size: 18px; color: #007600; font-weight: 700; margin-bottom: 8px;">
                                    <i class="fas fa-box me-2"></i>
                                    Arriving {{ \Carbon\Carbon::parse($order->created_at)->addDays(3)->format('l, F j') }}
                                </div>
                                <div style="font-size: 14px; color: #565959;">
                                    Shipping to: <strong style="color: #0F1111;">{{ $order->customer_name }}</strong>
                                </div>
                                <div style="font-size: 13px; color: #565959; margin-top: 4px;">
                                    {{ $order->shipping_address }}
                                </div>
                            </div>
                        </div>

                        <hr style="margin: 20px 0; border-color: #E7E7E7;">

                        <!-- Order Items -->
                        <h3 style="font-size: 16px; font-weight: 700; color: #0F1111; margin-bottom: 16px;">
                            Order #{{ $order->order_number }}
                        </h3>

                        @foreach($order->items as $item)
                            <div class="d-flex align-items-start mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div style="width: 80px; height: 80px; flex-shrink: 0; margin-right: 16px;">
                                    <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80x80?text=Product' }}"
                                        alt="{{ $item->product_name }}"
                                        style="width: 100%; height: 100%; object-fit: contain; border-radius: 4px;">
                                </div>
                                <div class="flex-grow-1">
                                    <a href="{{ $item->product ? route('products.show', $item->product->slug) : '#' }}"
                                        style="color: #007185; text-decoration: none; font-size: 14px; line-height: 1.4;"
                                        onmouseover="this.style.textDecoration='underline'"
                                        onmouseout="this.style.textDecoration='none'">
                                        {{ $item->product_name }}
                                    </a>
                                    <div style="font-size: 12px; color: #565959; margin-top: 4px;">
                                        Qty: {{ $item->quantity }}
                                    </div>
                                    <div style="font-size: 14px; color: #B12704; font-weight: 500; margin-top: 4px;">
                                        Rs {{ number_format($item->price * $item->quantity) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- What's Next Card -->
                    <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <h3 style="font-size: 16px; font-weight: 700; color: #0F1111; margin-bottom: 16px;">
                            <i class="fas fa-info-circle me-2" style="color: #007185;"></i>What happens next?
                        </h3>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="text-center p-3">
                                    <div
                                        style="width: 50px; height: 50px; background: #F0F8FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                                        <i class="fas fa-envelope" style="color: #007185; font-size: 20px;"></i>
                                    </div>
                                    <h4 style="font-size: 14px; font-weight: 600; color: #0F1111; margin-bottom: 8px;">Email
                                        Confirmation</h4>
                                    <p style="font-size: 12px; color: #565959; margin: 0;">You'll receive an order
                                        confirmation email with tracking details.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3">
                                    <div
                                        style="width: 50px; height: 50px; background: #FFF8E7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                                        <i class="fas fa-box" style="color: #FF9900; font-size: 20px;"></i>
                                    </div>
                                    <h4 style="font-size: 14px; font-weight: 600; color: #0F1111; margin-bottom: 8px;">Order
                                        Processing</h4>
                                    <p style="font-size: 12px; color: #565959; margin: 0;">We're preparing your order for
                                        shipment.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3">
                                    <div
                                        style="width: 50px; height: 50px; background: #E8F5E9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                                        <i class="fas fa-shipping-fast" style="color: #00A650; font-size: 20px;"></i>
                                    </div>
                                    <h4 style="font-size: 14px; font-weight: 600; color: #0F1111; margin-bottom: 8px;">
                                        Delivery</h4>
                                    <p style="font-size: 12px; color: #565959; margin: 0;">Your package will be delivered to
                                        your doorstep.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Summary & Actions -->
                <div class="col-lg-4">
                    <!-- Order Summary Card -->
                    <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <h3 style="font-size: 16px; font-weight: 700; color: #0F1111; margin-bottom: 16px;">Order Summary
                        </h3>

                        <div class="d-flex justify-content-between mb-2" style="font-size: 14px;">
                            <span style="color: #565959;">Items ({{ $order->items->sum('quantity') }}):</span>
                            <span style="color: #0F1111;">Rs {{ number_format($order->subtotal) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2" style="font-size: 14px;">
                            <span style="color: #565959;">Shipping:</span>
                            <span style="color: #007600;">FREE</span>
                        </div>

                        @if($order->tax > 0)
                            <div class="d-flex justify-content-between mb-2" style="font-size: 14px;">
                                <span style="color: #565959;">Tax:</span>
                                <span style="color: #0F1111;">Rs {{ number_format($order->tax) }}</span>
                            </div>
                        @endif

                        <hr style="margin: 12px 0; border-color: #E7E7E7;">

                        <div class="d-flex justify-content-between" style="font-size: 18px; font-weight: 700;">
                            <span style="color: #B12704;">Order Total:</span>
                            <span style="color: #B12704;">Rs {{ number_format($order->total) }}</span>
                        </div>

                        <div style="font-size: 12px; color: #565959; margin-top: 8px;">
                            Payment Method: {{ ucfirst($order->payment_method ?? 'Cash on Delivery') }}
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('orders.show', $order->order_number) }}"
                                style="display: block; padding: 12px; text-align: center; background: #FFD814; border: 1px solid #FCD200; border-radius: 8px; color: #0F1111; text-decoration: none; font-size: 14px; font-weight: 500;">
                                <i class="fas fa-eye me-2"></i>View Order Details
                            </a>
                            <a href="{{ route('orders.index') }}"
                                style="display: block; padding: 12px; text-align: center; background: #FFF; border: 1px solid #D5D9D9; border-radius: 8px; color: #0F1111; text-decoration: none; font-size: 14px;">
                                <i class="fas fa-list me-2"></i>Your Orders
                            </a>
                            <a href="{{ route('products.index') }}"
                                style="display: block; padding: 12px; text-align: center; background: #FFF; border: 1px solid #D5D9D9; border-radius: 8px; color: #0F1111; text-decoration: none; font-size: 14px;">
                                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>

                    <!-- Need Help Card -->
                    <div class="bg-white rounded shadow-sm p-4">
                        <h3 style="font-size: 14px; font-weight: 700; color: #0F1111; margin-bottom: 12px;">
                            <i class="fas fa-headset me-2" style="color: #007185;"></i>Need Help?
                        </h3>
                        <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px;">
                            <li style="margin-bottom: 8px;">
                                <a href="#" style="color: #007185; text-decoration: none;"
                                    onmouseover="this.style.textDecoration='underline'"
                                    onmouseout="this.style.textDecoration='none'">
                                    <i class="fas fa-question-circle me-2"></i>Track your order
                                </a>
                            </li>
                            <li style="margin-bottom: 8px;">
                                <a href="#" style="color: #007185; text-decoration: none;"
                                    onmouseover="this.style.textDecoration='underline'"
                                    onmouseout="this.style.textDecoration='none'">
                                    <i class="fas fa-undo me-2"></i>Return or replace items
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}" style="color: #007185; text-decoration: none;"
                                    onmouseover="this.style.textDecoration='underline'"
                                    onmouseout="this.style.textDecoration='none'">
                                    <i class="fas fa-phone me-2"></i>Contact customer service
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recommended Products (Optional) -->
            @if(isset($recommendedProducts) && $recommendedProducts->count() > 0)
                <div class="bg-white rounded shadow-sm p-4 mt-4">
                    <h3 style="font-size: 18px; font-weight: 700; color: #0F1111; margin-bottom: 20px;">
                        Customers who bought these items also bought
                    </h3>
                    <div class="d-flex overflow-auto gap-3 pb-2">
                        @foreach($recommendedProducts as $product)
                            <a href="{{ route('products.show', $product->slug) }}"
                                style="min-width: 150px; max-width: 150px; text-decoration: none;">
                                <div class="text-center">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150x150' }}"
                                        alt="{{ $product->name }}"
                                        style="width: 120px; height: 120px; object-fit: contain; margin-bottom: 8px;">
                                    <p
                                        style="font-size: 13px; color: #0F1111; margin-bottom: 4px; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $product->name }}
                                    </p>
                                    <div style="color: #B12704; font-weight: 500; font-size: 14px;">
                                        Rs {{ number_format($product->price) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            @keyframes checkmark {
                0% {
                    transform: scale(0);
                    opacity: 0;
                }

                50% {
                    transform: scale(1.2);
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .bg-white.rounded.shadow-sm.p-4.mb-4:first-of-type .col-auto:first-child>div {
                animation: checkmark 0.5s ease-out;
            }
        </style>
    @endpush
@endsection