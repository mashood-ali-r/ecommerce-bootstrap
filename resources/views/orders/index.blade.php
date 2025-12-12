@extends('layouts.app')

@section('title', 'Your Orders - EEZEPC.com')

@section('content')
    <div class="bg-white min-vh-100">
        <div class="container py-4">
            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                <div>
                    <h1 class="h4 mb-1" style="color: #0f1111;">Your Orders</h1>
                    <p class="text-muted mb-0 small">{{ $orders->count() }} order(s) placed</p>
                </div>
            </div>

            @if($orders->count() > 0)
                <!-- Orders List -->
                <div class="row">
                    @foreach($orders as $order)
                            <div class="col-12 mb-4">
                                <div class="border rounded overflow-hidden bg-white shadow-sm">
                                    <!-- Order Header -->
                                    <div class="d-flex flex-wrap justify-content-between align-items-center p-3"
                                        style="background-color: #f0f2f2; border-bottom: 1px solid #ddd;">
                                        <div class="d-flex flex-wrap gap-4">
                                            <div>
                                                <span class="d-block text-muted small text-uppercase">Order Placed</span>
                                                <span class="fw-medium">{{ $order->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <div>
                                                <span class="d-block text-muted small text-uppercase">Total</span>
                                                <span class="fw-medium">Rs {{ number_format($order->total) }}</span>
                                            </div>
                                            <div>
                                                <span class="d-block text-muted small text-uppercase">Ship To</span>
                                                <span class="fw-medium" style="color: #007185;">{{ $order->customer_name }}</span>
                                            </div>
                                        </div>
                                        <div class="text-md-end mt-2 mt-md-0">
                                            <span class="d-block text-muted small">ORDER # {{ $order->order_number }}</span>
                                            <a href="{{ route('orders.show', $order->order_number) }}"
                                                class="text-decoration-none small" style="color: #007185;">
                                                View order details
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Order Status & Items -->
                                    <div class="p-3">
                                        <!-- Status Badge -->
                                        <div class="mb-3">
                                            <span class="badge rounded-pill px-3 py-2" style="background-color: {{ match ($order->status) {
                            'pending' => '#ffc107',
                            'processing' => '#17a2b8',
                            'shipped' => '#007bff',
                            'delivered' => '#28a745',
                            'cancelled' => '#dc3545',
                            default => '#6c757d'
                        } }}; color: {{ $order->status === 'pending' ? '#000' : '#fff' }};">
                                                <i class="fas fa-{{ match ($order->status) {
                            'pending' => 'clock',
                            'processing' => 'cog fa-spin',
                            'shipped' => 'truck',
                            'delivered' => 'check-circle',
                            'cancelled' => 'times-circle',
                            default => 'question-circle'
                        } }} me-1"></i>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                            @if($order->status === 'shipped')
                                                <span class="text-muted ms-2 small">On the way</span>
                                            @elseif($order->status === 'delivered')
                                                <span class="text-success ms-2 small">
                                                    <i class="fas fa-check me-1"></i>Delivered
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Order Items -->
                                        @foreach($order->items as $item)
                                            <div class="d-flex align-items-start gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                <!-- Product Image -->
                                                <div style="width: 80px; height: 80px; flex-shrink: 0;">
                                                    @if($item->product && $item->product->image)
                                                        <a href="{{ route('products.show', $item->product->slug) }}">
                                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                                alt="{{ $item->product_name }}" class="img-fluid rounded"
                                                                style="width: 80px; height: 80px; object-fit: contain; background: #f8f8f8;">
                                                        </a>
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center rounded"
                                                            style="width: 80px; height: 80px; background: #f8f8f8;">
                                                            <i class="fas fa-image text-muted" style="font-size: 24px;"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Product Info -->
                                                <div class="flex-grow-1">
                                                    @if($item->product)
                                                        <a href="{{ route('products.show', $item->product->slug) }}"
                                                            class="text-decoration-none" style="color: #007185;">
                                                            <h6 class="mb-1" style="font-size: 14px; font-weight: 400;">
                                                                {{ $item->product_name }}
                                                            </h6>
                                                        </a>
                                                    @else
                                                        <h6 class="mb-1" style="font-size: 14px; font-weight: 400; color: #0f1111;">
                                                            {{ $item->product_name }}
                                                        </h6>
                                                    @endif
                                                    <p class="mb-1 text-muted small">
                                                        Qty: {{ $item->quantity }} × Rs {{ number_format($item->price) }}
                                                    </p>
                                                    <p class="mb-0 fw-bold" style="color: #B12704;">
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
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>

            @else
                <!-- Empty Orders -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-box-open" style="font-size: 80px; color: #ddd;"></i>
                    </div>
                    <h2 class="h5 mb-3" style="color: #0f1111;">You haven't placed any orders yet</h2>
                    <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto;">
                        Explore our products and start shopping! Your orders will appear here once you make a purchase.
                    </p>
                    <a href="{{ route('products.index') }}" class="btn"
                        style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734;">
                        <i class="fas fa-shopping-bag me-1"></i>Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection