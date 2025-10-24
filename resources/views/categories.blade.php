@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 fw-bold">Categories</h2>
        </div>
    </div>

    <div class="row">
        <!-- Mobile Phones & Tablets -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-mobile-alt fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Mobile Phones & Tablets</h5>
                    <p class="card-text">Latest smartphones, tablets, and mobile accessories</p>
                    <a href="#" class="btn btn-outline-primary">Browse Products</a>
                </div>
            </div>
        </div>

        <!-- Computer Components -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-microchip fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Computer Components</h5>
                    <p class="card-text">PC components, processors, graphics cards, and more</p>
                    <a href="#" class="btn btn-outline-primary">Browse Products</a>
                </div>
            </div>
        </div>

        <!-- Computers & Office -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-laptop fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Computers & Office</h5>
                    <p class="card-text">Laptops, desktops, monitors, and office equipment</p>
                    <a href="#" class="btn btn-outline-primary">Browse Products</a>
                </div>
            </div>
        </div>

        <!-- Consoles & Gaming -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-gamepad fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Consoles & Gaming</h5>
                    <p class="card-text">Gaming consoles, controllers, and gaming accessories</p>
                    <a href="#" class="btn btn-outline-primary">Browse Products</a>
                </div>
            </div>
        </div>

        <!-- Wearable & Gadgets -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-watch fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Wearable & Gadgets</h5>
                    <p class="card-text">Smart watches, VR headsets, and wearable technology</p>
                    <a href="#" class="btn btn-outline-primary">Browse Products</a>
                </div>
            </div>
        </div>

        <!-- Home Appliances -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-home fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Home Appliances</h5>
                    <p class="card-text">Kitchen appliances, air conditioners, and home gadgets</p>
                    <a href="#" class="btn btn-outline-primary">Browse Products</a>
                </div>
            </div>
        </div>

        <!-- TV & Audio/Video -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-tv fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">TV & Audio/Video</h5>
                    <p class="card-text">Televisions, projectors, and home audio systems</p>
                    <a href="#" class="btn btn-outline-primary">Browse Products</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
