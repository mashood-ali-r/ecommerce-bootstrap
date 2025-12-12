@extends('layouts.app')

@section('title', 'Order Placed - EEZEPC.com')

@section('content')
    <style>
        .amz-success-text {
            color: #007600;
            font-weight: 400;
            font-family: "Amazon Ember", Arial, sans-serif;
        }

        .amz-order-number {
            color: #565959;
            font-size: 14px;
        }

        .amz-link {
            color: #007185;
            text-decoration: none;
        }

        .amz-link:hover {
            color: #c7511f;
            text-decoration: underline;
        }

        .amz-box {
            border: 1px solid #d5d9d9;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
        }

        .amz-delivery-date {
            color: #007600;
            font-size: 18px;
            font-weight: 700;
        }

        .amz-btn-yellow {
            background-color: #ffd814;
            border-color: #fcd200;
            color: #0F1111;
            border-radius: 8px;
            box-shadow: 0 2px 5px 0 rgba(213, 217, 217, .5);
            font-size: 13px;
            height: 29px;
            padding: 0 10px 0 11px;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .amz-btn-yellow:hover {
            background-color: #f7ca00;
            border-color: #f2c200;
            box-shadow: 0 2px 5px 0 rgba(213, 217, 217, .5);
        }
    </style>

    <div class="container mt-4 mb-5" style="max-width: 1000px;">
        <!-- Header Section -->
        <div class="mb-4">
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-check-circle text-success me-2" style="font-size: 24px; color: #007600 !important;"></i>
                <h4 class="amz-success-text mb-0">Order placed, thanks!</h4>
            </div>
            <p class="mb-1 text-secondary">Confirmation will be sent to your email.</p>
            <div>
                @if(Auth::check())
                    <a href="{{ route('account') }}" class="amz-link small">Review or edit your recent orders</a>
                @else
                    <span class="amz-order-number">Order #{{ $order->order_number }}</span>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Delivery & Items -->
            <div class="col-lg-8">
                <div class="amz-box mb-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <span class="amz-delivery-date">Arriving
                                    {{ \Carbon\Carbon::parse($order->created_at)->addDays(3)->format('l, M d') }}</span>
                            </div>
                            <div class="text-secondary small mb-3">
                                Shipping to {{ $order->customer_name }}
                            </div>
                            <!-- Items List -->
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($order->items as $item)
                                    <div class="text-center" style="width: 100px;">
                                        <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://source.unsplash.com/random/100x100/?product' }}"
                                            alt="{{ $item->product_name }}" class="img-fluid rounded mb-2"
                                            style="height: 80px; object-fit: contain;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Actions -->
            <div class="col-lg-4">
                <div class="amz-box bg-light" style="border-color: #d5d9d9; background-color: #f8f8f8;">
                    <p class="mb-3 fw-bold small">Manage your order</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('home') }}" class="btn btn-warning btn-sm w-100 fw-bold"
                            style="background-color: #ffd814; border-color: #fcd200; border-radius: 20px;">Continue
                            shopping</a>

                        <button onclick="window.print()" class="btn btn-light btn-sm w-100 border bg-white shadow-sm"
                            style="border-radius: 20px;">Print order summary</button>
                    </div>
                </div>

                <!-- Recommendations Placeholder -->
                @if($order->items->count() > 0)
                    <div class="mt-4 p-3 border rounded bg-white">
                        <h6 class="small fw-bold mb-3">Buy it again</h6>
                        @foreach($order->items as $item)
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://source.unsplash.com/random/50x50/?product' }}"
                                    class="me-2" style="width: 40px; height: 40px; object-fit: contain;">
                                <a href="#" class="amz-link small text-truncate"
                                    style="max-width: 150px;">{{ $item->product_name }}</a>
                                <div class="ms-auto text-danger small fw-bold">
                                    Rs {{ number_format($item->price) }}
                                </div>
                            </div>
                            @if($loop->iteration >= 2) @break @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection