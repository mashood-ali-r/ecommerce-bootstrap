@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Checkout</h1>

    <form class="col-md-6 mx-auto bg-light p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" placeholder="Enter your name">
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" placeholder="you@example.com">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" rows="3" placeholder="Your shipping address"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select class="form-select">
                <option selected>Choose...</option>
                <option>Credit Card</option>
                <option>Bank Transfer</option>
                <option>Cash on Delivery</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success w-100 mt-3">Place Order</button>
    </form>
</div>
@endsection
