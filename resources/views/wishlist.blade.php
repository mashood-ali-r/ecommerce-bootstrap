@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 fw-bold">Your Wishlist</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Your wishlist is empty!</h4>
                <p class="text-muted">Save items you love for later by clicking the heart icon.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Start Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
