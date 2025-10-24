@extends('layouts.app')

@section('title', 'All Products - Shop Now')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="filter-sidebar">
                <h6>Categories</h6>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="cat1">
                        <label class="form-check-label" for="cat1">
                            Laptops <span class="text-muted">(45)</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="cat2">
                        <label class="form-check-label" for="cat2">
                            Desktops <span class="text-muted">(32)</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="cat3">
                        <label class="form-check-label" for="cat3">
                            Components <span class="text-muted">(78)</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="cat4">
                        <label class="form-check-label" for="cat4">
                            Accessories <span class="text-muted">(120)</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="cat5">
                        <label class="form-check-label" for="cat5">
                            Gaming <span class="text-muted">(56)</span>
                        </label>
                    </div>
                </div>

                <h6>Price Range</h6>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="price1">
                        <label class="form-check-label" for="price1">
                            Under Rs 10,000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="price2">
                        <label class="form-check-label" for="price2">
                            Rs 10,000 - Rs 50,000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="price3">
                        <label class="form-check-label" for="price3">
                            Rs 50,000 - Rs 100,000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="price4">
                        <label class="form-check-label" for="price4">
                            Rs 100,000 - Rs 200,000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="price5">
                        <label class="form-check-label" for="price5">
                            Above Rs 200,000
                        </label>
                    </div>
                </div>

                <h6>Brands</h6>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="brand1">
                        <label class="form-check-label" for="brand1">
                            Dell
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="brand2">
                        <label class="form-check-label" for="brand2">
                            HP
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="brand3">
                        <label class="form-check-label" for="brand3">
                            Lenovo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="brand4">
                        <label class="form-check-label" for="brand4">
                            Apple
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="brand5">
                        <label class="form-check-label" for="brand5">
                            ASUS
                        </label>
                    </div>
                </div>

                <h6>Rating</h6>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rating5">
                        <label class="form-check-label" for="rating5">
                            <span class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rating4">
                        <label class="form-check-label" for="rating4">
                            <span class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </span>
                            & Up
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rating3">
                        <label class="form-check-label" for="rating3">
                            <span class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </span>
                            & Up
                        </label>
                    </div>
                </div>

                <button class="btn btn-outline-primary w-100 mb-2">Apply Filters</button>
                <button class="btn btn-outline-secondary w-100">Clear All</button>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Sorting and View Options -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="mb-0 text-muted">Showing {{ $products->count() ?? 12 }} of {{ $products->total() ?? 150 }} products</p>
                </div>
                <div class="d-flex align-items-center">
                    <label class="me-2 text-muted small">Sort by:</label>
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option>Featured</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest</option>
                        <option>Best Selling</option>
                        <option>Top Rated</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row g-4">
                @forelse($products ?? [] as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="product-card position-relative">
                        @if($product->discount > 0)
                        <span class="discount-badge">-{{ $product->discount }}%</span>
                        @endif
                        
                        <div class="wishlist-icon">
                            <i class="far fa-heart"></i>
                        </div>
                        
                        <a href="{{ route('products.show', $product->id) }}">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="card-img-top">
                        </a>
                        
                        <div class="card-body">
                            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
                                <h6 class="product-title">{{ $product->name }}</h6>
                            </a>
                            
                            <div class="rating mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $product->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span class="text-muted">({{ $product->reviews_count }})</span>
                            </div>
                            
                            <div class="d-flex align-items-center mb-3">
                                <span class="product-price">Rs {{ number_format($product->price) }}</span>
                                @if($product->original_price)
                                <span class="original-price">Rs {{ number_format($product->original_price) }}</span>
                                @endif
                            </div>
                            
                            <button class="btn btn-primary btn-add-cart" onclick="addToCart({{ $product->id }})">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Sample Products if database is empty -->
                @for($i = 1; $i <= 12; $i++)
                <div class="col-lg-4 col-md-6">
                    <div class="product-card position-relative">
                        @if($i % 3 == 0)
                        <span class="discount-badge">-{{ rand(10, 30) }}%</span>
                        @endif
                        
                        <div class="wishlist-icon">
                            <i class="far fa-heart"></i>
                        </div>
                        
                        <img src="https://via.placeholder.com/250" alt="Product" class="card-img-top">
                        
                        <div class="card-body">
                            <h6 class="product-title">Sample Product {{ $i }} - High Quality Tech Device</h6>
                            
                            <div class="rating mb-2">
                                @for($j = 1; $j <= 5; $j++)
                                    @if($j <= 4)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span class="text-muted">({{ rand(20, 200) }})</span>
                            </div>
                            
                            <div class="d-flex align-items-center mb-3">
                                <span class="product-price">Rs {{ number_format(rand(10, 300) * 1000) }}</span>
                                @if($i % 3 == 0)
                                <span class="original-price">Rs {{ number_format(rand(350, 400) * 1000) }}</span>
                                @endif
                            </div>
                            
                            <button class="btn btn-primary btn-add-cart">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                @endfor
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                @if(isset($products) && method_exists($products, 'links'))
                    {{ $products->links() }}
                @else
                <nav>
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addToCart(productId) {
    // AJAX call to add product to cart
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Product added to cart!');
            // Update cart count
            document.querySelector('.fa-shopping-cart + .badge').textContent = data.cart_count;
        }
    })
    .catch(error => console.error('Error:', error));
}

// Wishlist functionality
document.querySelectorAll('.wishlist-icon').forEach(icon => {
    icon.addEventListener('click', function(e) {
        e.preventDefault();
        this.classList.toggle('active');
        const heartIcon = this.querySelector('i');
        if (this.classList.contains('active')) {
            heartIcon.classList.remove('far');
            heartIcon.classList.add('fas');
        } else {
            heartIcon.classList.remove('fas');
            heartIcon.classList.add('far');
        }
    });
});
</script>
@endpush