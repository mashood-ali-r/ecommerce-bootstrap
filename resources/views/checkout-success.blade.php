@extends('layouts.app')

@section('title', 'Order Confirmed - EEZEPC.com')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Message -->
            <div class="text-center mb-4">
                <div class="success-checkmark mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                </div>
                <h1 class="text-success mb-3">Order Placed Successfully!</h1>
                <p class="lead text-muted">Thank you for your purchase. Your order has been received and is being processed.</p>
            </div>

            <!-- Order Details Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Order Number:</strong></p>
                            <p class="text-primary">{{ $order['order_number'] }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-1"><strong>Order Date:</strong></p>
                            <p>{{ $order['created_at'] }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Customer Information -->
                    <h6 class="mb-3"><i class="fas fa-user me-2"></i>Customer Information</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Name:</strong> {{ $order['customer_name'] }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $order['customer_email'] }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $order['customer_phone'] }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Shipping Address:</strong></p>
                            <p>{{ $order['shipping_address'] }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Order Items -->
                    <h6 class="mb-3"><i class="fas fa-box me-2"></i>Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order['items'] as $id => $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td class="text-center">{{ $item['quantity'] }}</td>
                                    <td class="text-end">Rs {{ number_format($item['price']) }}</td>
                                    <td class="text-end">Rs {{ number_format($item['price'] * $item['quantity']) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">Rs {{ number_format($order['subtotal']) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                    <td class="text-end">Rs {{ number_format($order['shipping']) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tax:</strong></td>
                                    <td class="text-end">Rs {{ number_format($order['tax']) }}</td>
                                </tr>
                                <tr class="table-success">
                                    <td colspan="3" class="text-end"><h5 class="mb-0">Total:</h5></td>
                                    <td class="text-end"><h5 class="mb-0">Rs {{ number_format($order['total']) }}</h5></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <hr>

                    <!-- Payment Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Payment Method:</strong></p>
                            <p class="text-capitalize">
                                @if($order['payment_method'] == 'cod')
                                    Cash on Delivery
                                @elseif($order['payment_method'] == 'bank_transfer')
                                    Bank Transfer
                                @else
                                    Credit/Debit Card
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Order Status:</strong></p>
                            <span class="badge bg-warning text-dark">Pending</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What's Next -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>What's Next?</h5>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <li class="mb-2">You will receive an order confirmation email at <strong>{{ $order['customer_email'] }}</strong></li>
                        <li class="mb-2">We will process your order and prepare it for shipping</li>
                        <li class="mb-2">You will receive a shipping confirmation with tracking details</li>
                        <li>Your order will be delivered to your address within 3-5 business days</li>
                    </ol>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center">
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-2">
                    <i class="fas fa-home me-2"></i>Continue Shopping
                </a>
                <button onclick="window.print()" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-print me-2"></i>Print Order
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Animate success icon on load
document.addEventListener('DOMContentLoaded', function() {
    const checkmark = document.querySelector('.success-checkmark i');
    checkmark.style.transform = 'scale(0)';
    checkmark.style.transition = 'transform 0.5s ease';
    
    setTimeout(() => {
        checkmark.style.transform = 'scale(1)';
    }, 100);
});
</script>
@endpush
@endsection
