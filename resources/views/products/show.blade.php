@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="https://via.placeholder.com/500x400" class="img-fluid rounded shadow-sm" alt="Product Image">
        </div>
        <div class="col-md-6">
            <h2>Product Name</h2>
            <p class="text-muted">Category: General</p>
            <h4 class="text-success">$49.99</h4>
            <p class="mt-3">This is a detailed description of the product. You can describe its features, materials, and other information here.</p>

            <button class="btn btn-primary btn-lg mt-3">Add to Cart</button>
            <a href="{{ route('checkout') }}" class="btn btn-outline-success btn-lg mt-3 ms-2">Buy Now</a>
        </div>
    </div>
</div>
@endsection
