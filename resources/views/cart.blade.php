@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Your Cart</h2>

    @if(isset($cart) && count($cart) > 0)
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Product Name</th>
                    <th style="width:120px;">Quantity</th>
                    <th>Price (PKR)</th>
                    <th>Subtotal</th>
                    <th style="width:120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php 
                        $subtotal = $item['price'] * $item['quantity']; 
                        $total += $subtotal; 
                    @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>

                        <!-- Quantity / Update form -->
                        <td>
                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm me-2">
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            </form>
                        </td>

                        <td>{{ number_format($item['price'], 2) }}</td>
                        <td>{{ number_format($subtotal, 2) }}</td>

                        <!-- Remove form -->
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td colspan="2"><strong>{{ number_format($total, 2) }} PKR</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="mt-3">
            <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
        </div>
    @else
        <p class="mt-4">Your cart is empty!</p>
    @endif
</div>
@endsection
