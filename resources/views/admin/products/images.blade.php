@extends('admin.layout')

@section('title', 'Product Images')
@section('page-title', 'Manage Product Images')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>
</div>

<div class="row">
    <!-- Product Info -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <h6>{{ $product->name }}</h6>
                <p class="text-muted mb-2">SKU: {{ $product->sku }}</p>
                <p class="text-muted mb-2">Price: Rs {{ number_format($product->price) }}</p>
                <p class="text-muted mb-0">Total Images: {{ $product->images->count() }}</p>
            </div>
        </div>

        <!-- Upload New Image -->
        <div class="card mt-3">
            <div class="card-header bg-white">
                <h5 class="mb-0">Upload New Image</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.images.store', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Select Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Max size: 2MB. Formats: JPG, PNG, WEBP</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_primary" class="form-check-input" id="is_primary" value="1">
                            <label class="form-check-label" for="is_primary">Set as primary image</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-upload me-2"></i>Upload Image
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Product Images -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Product Images ({{ $product->images->count() }})</h5>
            </div>
            <div class="card-body">
                @if($product->images->count() > 0)
                    <div class="row">
                        @foreach($product->images as $image)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="Product Image">
                                        @if($image->is_primary)
                                            <span class="badge bg-success position-absolute top-0 start-0 m-2">Primary</span>
                                        @endif
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="d-grid gap-2">
                                            @if(!$image->is_primary)
                                                <form action="{{ route('admin.products.images.set-primary', [$product, $image]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                                        <i class="fas fa-star me-1"></i>Set as Primary
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.products.images.destroy', [$product, $image]) }}" method="POST" 
                                                  onsubmit="return confirm('Delete this image?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-images fa-4x text-muted mb-3"></i>
                        <h5>No Images Yet</h5>
                        <p class="text-muted">Upload your first product image using the form on the left</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
