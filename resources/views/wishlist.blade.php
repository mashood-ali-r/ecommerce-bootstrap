@extends('layouts.app')

@section('title', 'Wishlist - EEZEPC.com')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">My Wishlist</h1>
    
    @if(count(session('wishlist', [])) > 0)
        <div class="row">
            @foreach(session('wishlist', []) as $item)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="{{ $item['name'] }}">
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="removeFromWishlist('{{ $item['id'] }}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $item['name'] }}</h6>
                        <p class="card-text price-current mb-3">Rs {{ number_format($item['price']) }}</p>
                        <div class="d-grid gap-2 mt-auto">
                            <a href="{{ route('products.show', $item['id']) }}" class="btn btn-outline-primary btn-sm">View Product</a>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item['id'] }}">
                                <input type="hidden" name="name" value="{{ $item['name'] }}">
                                <input type="hidden" name="price" value="{{ $item['price'] }}">
                                <button type="submit" class="btn btn-primary w-100 btn-ripple">Add to Basket</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
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
    @endif
</div>

@push('scripts')
<script>
function removeFromWishlist(productId) {
    if (confirm('Are you sure you want to remove this item from your wishlist?')) {
        // Make AJAX request to remove from wishlist
        fetch('/wishlist/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to update the wishlist
                location.reload();
            } else {
                alert('Error removing item from wishlist');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing item from wishlist');
        });
    }
}
</script>
@endpush
@endsection
