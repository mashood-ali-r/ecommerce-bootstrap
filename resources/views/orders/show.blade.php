@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' - EEZEPC.com')

@section('content')
    <div class="bg-white min-vh-100">
        <div class="container py-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #007185;">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" style="color: #007185;">Your
                            Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                <div>
                    <h1 class="h4 mb-1" style="color: #0f1111;">Order Details</h1>
                    <p class="text-muted mb-0 small">Order # {{ $order->order_number }}</p>
                </div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Back to Orders
                </a>
            </div>

            <div class="row">
                <!-- Order Info -->
                <div class="col-lg-8 mb-4">
                    <!-- Status Card -->
                    <div class="border rounded p-4 mb-4 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="mb-0" style="color: #0f1111;">Order Status</h5>
                            <span class="badge rounded-pill px-3 py-2" style="background-color: {{ match ($order->status) {
        'pending' => '#ffc107',
        'processing' => '#17a2b8',
        'shipped' => '#007bff',
        'delivered' => '#28a745',
        'cancelled' => '#dc3545',
        default => '#6c757d'
    } }}; color: {{ $order->status === 'pending' ? '#000' : '#fff' }}; font-size: 14px;">
                                <i class="fas fa-{{ match ($order->status) {
        'pending' => 'clock',
        'processing' => 'cog',
        'shipped' => 'truck',
        'delivered' => 'check-circle',
        'cancelled' => 'times-circle',
        default => 'question-circle'
    } }} me-1"></i>
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <!-- Progress Bar -->
                        @php
                            $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($order->status, $statuses);
                            if ($currentIndex === false)
                                $currentIndex = -1;
                        @endphp
                        @if($order->status !== 'cancelled')
                            <div class="d-flex justify-content-between text-center mb-2" style="font-size: 12px;">
                                @foreach($statuses as $index => $status)
                                    <div class="flex-fill">
                                        <i class="fas fa-{{ $index <= $currentIndex ? 'check-circle text-success' : 'circle text-muted' }} mb-1"
                                            style="font-size: 20px;"></i>
                                        <div class="{{ $index <= $currentIndex ? 'fw-bold' : 'text-muted' }}">
                                            {{ ucfirst($status) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ (($currentIndex + 1) / count($statuses)) * 100 }}%"></div>
                            </div>
                        @else
                            <div class="alert alert-danger mb-0">
                                <i class="fas fa-times-circle me-2"></i>This order has been cancelled.
                            </div>
                        @endif
                    </div>

                    <!-- Order Items -->
                    <div class="border rounded overflow-hidden shadow-sm">
                        <div class="p-3" style="background-color: #f0f2f2; border-bottom: 1px solid #ddd;">
                            <h5 class="mb-0" style="color: #0f1111;">
                                <i class="fas fa-box me-2"></i>Order Items ({{ $order->items->count() }})
                            </h5>
                        </div>
                        <div class="p-3">
                            @foreach($order->items as $item)
                                <div class="d-flex align-items-start gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <!-- Product Image -->
                                    <div style="width: 100px; height: 100px; flex-shrink: 0;">
                                        @if($item->product && $item->product->image)
                                            <a href="{{ route('products.show', $item->product->slug) }}">
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product_name }}" class="img-fluid rounded"
                                                    style="width: 100px; height: 100px; object-fit: contain; background: #f8f8f8;">
                                            </a>
                                        @else
                                            <div class="d-flex align-items-center justify-content-center rounded"
                                                style="width: 100px; height: 100px; background: #f8f8f8;">
                                                <i class="fas fa-image text-muted" style="font-size: 28px;"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-grow-1">
                                        @if($item->product)
                                            <a href="{{ route('products.show', $item->product->slug) }}"
                                                class="text-decoration-none" style="color: #007185;">
                                                <h6 class="mb-1" style="font-size: 16px; font-weight: 400;">
                                                    {{ $item->product_name }}
                                                </h6>
                                            </a>
                                        @else
                                            <h6 class="mb-1" style="font-size: 16px; font-weight: 400; color: #0f1111;">
                                                {{ $item->product_name }}
                                            </h6>
                                        @endif
                                        @if($item->product_sku)
                                            <p class="mb-1 text-muted small">SKU: {{ $item->product_sku }}</p>
                                        @endif
                                        <p class="mb-1 text-muted">
                                            Qty: {{ $item->quantity }} × Rs {{ number_format($item->price) }}
                                        </p>
                                        <p class="mb-0 fw-bold" style="color: #B12704; font-size: 18px;">
                                            Rs {{ number_format($item->subtotal) }}
                                        </p>
                                    </div>

                                    <!-- Actions -->
                                    <div class="d-flex flex-column gap-2">
                                        @if($item->product)
                                            <a href="{{ route('products.show', $item->product->slug) }}" class="btn btn-sm"
                                                style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; border-radius: 3px; font-size: 12px; white-space: nowrap;">
                                                <i class="fas fa-redo me-1"></i>Buy Again
                                            </a>
                                            <a href="{{ route('products.show', $item->product->slug) }}"
                                                class="btn btn-sm btn-outline-secondary"
                                                style="border-radius: 3px; font-size: 12px; white-space: nowrap;">
                                                View Product
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="border rounded p-4 mb-4 shadow-sm">
                        <h5 class="mb-3" style="color: #0f1111;">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal:</span>
                            <span>Rs {{ number_format($order->subtotal) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping:</span>
                            <span>{{ $order->shipping > 0 ? 'Rs ' . number_format($order->shipping) : 'FREE' }}</span>
                        </div>
                        @if($order->tax > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tax:</span>
                                <span>Rs {{ number_format($order->tax) }}</span>
                            </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between fw-bold" style="font-size: 18px;">
                            <span style="color: #B12704;">Order Total:</span>
                            <span style="color: #B12704;">Rs {{ number_format($order->total) }}</span>
                        </div>
                        <div class="mt-2 small text-muted">
                            Payment: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="border rounded p-4 mb-4 shadow-sm">
                        <h5 class="mb-3" style="color: #0f1111;">
                            <i class="fas fa-map-marker-alt me-2"></i>Shipping Address
                        </h5>
                        <address class="mb-0" style="font-style: normal; line-height: 1.6;">
                            <strong>{{ $order->customer_name }}</strong><br>
                            {{ $order->shipping_address }}<br>
                            {{ $order->city }}{{ $order->postal_code ? ', ' . $order->postal_code : '' }}<br>
                            <i class="fas fa-phone me-1"></i>{{ $order->customer_phone }}<br>
                            <i class="fas fa-envelope me-1"></i>{{ $order->customer_email }}
                        </address>
                    </div>

                    <!-- Order Notes -->
                    @if($order->order_notes)
                        <div class="border rounded p-4 shadow-sm">
                            <h5 class="mb-3" style="color: #0f1111;">
                                <i class="fas fa-sticky-note me-2"></i>Order Notes
                            </h5>
                            <p class="mb-0 text-muted">{{ $order->order_notes }}</p>
                        </div>
                    @endif

                    <!-- Order Date -->
                    <div class="mt-4 text-center text-muted small">
                        <p class="mb-1">Order placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection