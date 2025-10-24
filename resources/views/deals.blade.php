@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 fw-bold">Hot Deals</h2>
            <p class="text-muted">Don't miss out on these amazing deals and discounts!</p>
        </div>
    </div>

    <div class="row">
        <!-- Flash Deal 1 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card product-card h-100 shadow-sm">
                <div class="position-relative">
                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Apple iPhone Air 256GB">
                    <span class="badge flash-deal-badge position-absolute top-0 start-0 m-2">-3%</span>
                </div>
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">Apple iPhone Air 256GB – Sky Blue (PTA Approved)</h6>
                    <p class="card-text">
                        <small class="price-original">Rs 479,990</small>
                        <span class="price-current ms-2">Rs 464,990</span>
                    </p>
                    <button class="btn btn-primary mt-auto">Add to basket</button>
                </div>
            </div>
        </div>

        <!-- Flash Deal 2 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card product-card h-100 shadow-sm">
                <div class="position-relative">
                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Samsung Galaxy Buds Core">
                    <span class="badge flash-deal-badge position-absolute top-0 start-0 m-2">-26%</span>
                </div>
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">Samsung Galaxy Buds Core True Wireless Earbuds – Black</h6>
                    <p class="card-text">
                        <small class="price-original">Rs 13,590</small>
                        <span class="price-current ms-2">Rs 9,990</span>
                    </p>
                    <button class="btn btn-primary mt-auto">Add to basket</button>
                </div>
            </div>
        </div>

        <!-- Flash Deal 3 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card product-card h-100 shadow-sm">
                <div class="position-relative">
                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Xiaomi Smart Projector">
                    <span class="badge flash-deal-badge position-absolute top-0 start-0 m-2">-10%</span>
                </div>
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">Xiaomi Smart Projector L1 Pro Full HD Android TV Projector</h6>
                    <p class="card-text">
                        <small class="price-original">Rs 109,990</small>
                        <span class="price-current ms-2">Rs 98,990</span>
                    </p>
                    <button class="btn btn-primary mt-auto">Add to basket</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Deal Categories -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Deal Categories</h3>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-fire fa-2x text-danger mb-3"></i>
                    <h6>Flash Sales</h6>
                    <p class="small text-muted">Limited time offers</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-percentage fa-2x text-success mb-3"></i>
                    <h6>Clearance</h6>
                    <p class="small text-muted">Up to 50% off</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-gift fa-2x text-primary mb-3"></i>
                    <h6>Bundle Deals</h6>
                    <p class="small text-muted">Buy more, save more</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-star fa-2x text-warning mb-3"></i>
                    <h6>Featured</h6>
                    <p class="small text-muted">Editor's picks</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
