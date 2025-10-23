@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Our Products</h1>

    <div class="row">
        <!-- Product Card 1 -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="Product 1">
                <div class="card-body">
                    <h5 class="card-title">Product One</h5>
                    <p class="card-text">This is a short description for Product One.</p>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="1">
                        <input type="hidden" name="name" value="Product One">
                        <input type="hidden" name="price" value="10.00">
                        <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Card 2 -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="Product 2">
                <div class="card-body">
                    <h5 class="card-title">Product Two</h5>
                    <p class="card-text">This is a short description for Product Two.</p>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="2">
                        <input type="hidden" name="name" value="Product Two">
                        <input type="hidden" name="price" value="15.00">
                        <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Card 3 -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="Product 3">
                <div class="card-body">
                    <h5 class="card-title">Product Three</h5>
                    <p class="card-text">This is a short description for Product Three.</p>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="3">
                        <input type="hidden" name="name" value="Product Three">
                        <input type="hidden" name="price" value="20.00">
                        <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
