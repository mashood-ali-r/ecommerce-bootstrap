@extends('layouts.app')

@section('title', $product->name ?? 'Product Details')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $product->name ?? 'Product Details' }}</li>
        </ol>
    </nav>

    <div class="row mb-5">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-detail-img">
                <img id="mainImage" src="{{ asset($product->image ?? 'https://via.placeholder.com/500') }}" alt="{{ $product->name ?? 'Product' }}">
            </div>
            <div class="product-thumbnails">
                <img src="{{ asset($product->image ?? 'https://via.placeholder.com/80') }}" alt="Thumbnail" class="active" onclick="changeImage(this.src)">
                <img src="https://via.placeholder.com/80" alt="Thumbnail" onclick="changeImage(this.src)">
                <img src="https://via.placeholder.com/80" alt="Thumbnail" onclick="changeImage(this.src)">
                <img src="https://via.placeholder.com/80" alt="Thumbnail" onclick="changeImage(this.src)">
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="product-detail-info">
                <h1>{{ $product->name ?? 'Dell XPS 15 Laptop - Intel Core i7, 16GB RAM, 512GB SSD, FHD Display' }}</h1>
                
                <div class="rating mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= ($product->rating ?? 4))
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                    <span class="text-muted ms-2">({{ $product->reviews_count ?? 145 }} reviews)</span>
                </div>

                <div class="price d-flex align-items-center mb-3">
                    Rs {{ number_format($product->price ?? 289990) }}
                    @if(isset($product->original_price) || true)
                    <span class="original-price ms-3">Rs {{ number_format($product->original_price ?? 339990) }}</span>
                    <span class="badge bg-danger ms-2">Save Rs {{ number_format(($product->original_price ?? 339990) - ($product->price ?? 289990)) }}</span>
                    @endif
                </div>

                @if(($product->stock ?? 10) > 0)
                <span class="stock-status in-stock">
                    <i class="fas fa-check-circle me-1"></i