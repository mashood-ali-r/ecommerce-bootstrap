@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <!-- Hero Section -->
    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Welcome to My Store</h1>
            <p class="col-md-8 fs-4">Browse through our collection of high-quality products at unbeatable prices!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Shop Now</a>
        </div>
    </div>

    <!-- Featured Products Section -->
    <h2 class="text-center mb-4">Featured Products</h2>
    <div class="row">
        <!-- Example Product 1 -->
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="Product 1">
                <div class="card-body">
                    <h5 class="card-title">Sample Product 1</h5>
                    <p class="card-text">This is a short description of Product 1.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">View</a>
                </div>
            </div>
        </div>

        <!-- Example Product 2 -->
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="Product 2">
                <div class="card-body">
                    <h5 class="card-title">Sample Product 2</h5>
                    <p class="card-text">This is a short description of Product 2.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">View</a>
                </div>
            </div>
        </div>

        <!-- Example Product 3 -->
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="Product 3">
                <div class="card-body">
                    <h5 class="card-title">Sample Product 3</h5>
                    <p class="card-text">This is a short description of Product 3.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">View</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
