@extends('admin.layout')

@section('title', 'Images: ' . $product->name)
@section('page-title', 'Manage Product Images')

@section('breadcrumb')
    <a href="{{ route('admin.products.index') }}">Products</a> / <a
        href="{{ route('admin.products.edit', $product) }}">{{ Str::limit($product->name, 25) }}</a> / Images
@endsection

@section('page-actions')
    <a href="{{ route('admin.products.edit', $product) }}" class="btn-amz-secondary me-2">
        <i class="fas fa-edit me-1"></i>Edit Product
    </a>
    <a href="{{ route('admin.products.index') }}" class="btn-amz-secondary">
        <i class="fas fa-arrow-left me-1"></i>Back to Products
    </a>
@endsection

@section('content')
    <div class="row g-4">
        <!-- Left Column: Upload Hub -->
        <div class="col-xl-4 col-lg-5">
            <!-- Product Summary Card -->
            <div class="image-upload-card mb-4">
                <div class="product-summary-header">
                    <div class="d-flex align-items-center">
                        @if($product->images->where('is_primary', true)->first())
                            <img src="{{ asset('storage/' . $product->images->where('is_primary', true)->first()->image_path) }}"
                                alt="{{ $product->name }}" class="product-summary-thumb">
                        @else
                            <div class="product-summary-thumb-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        <div class="product-summary-info">
                            <h6 class="product-summary-title">{{ Str::limit($product->name, 35) }}</h6>
                            <span class="product-summary-sku">SKU: {{ $product->sku }}</span>
                            <div class="product-summary-badges">
                                <span class="status-badge {{ $product->is_active ? 'status-active' : 'status-inactive' }}">
                                    <i class="fas fa-circle"></i>
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-summary-stats">
                    <div class="stat-item">
                        <span class="stat-label">Price</span>
                        <span class="stat-value">Rs {{ number_format((float) $product->price) }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Stock</span>
                        <span class="stat-value">{{ $product->stock }} units</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Images</span>
                        <span class="stat-value highlight">{{ $product->images->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Primary Upload Zone -->
            <div class="image-upload-card mb-4">
                <div class="upload-card-header">
                    <div class="upload-card-icon primary">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h6 class="upload-card-title">Upload Primary Image</h6>
                        <p class="upload-card-subtitle">Main product image for listings</p>
                    </div>
                </div>

                <form action="{{ route('admin.products.images.store', $product) }}" method="POST"
                    enctype="multipart/form-data" id="primaryUploadForm">
                    @csrf

                    <div class="upload-dropzone" id="primaryDropzone">
                        <input type="file" name="image" class="upload-input" id="primaryImageInput" accept="image/*"
                            required>
                        <div class="dropzone-content" id="primaryDropzoneContent">
                            <div class="dropzone-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h6 class="dropzone-title">Drag & drop your image here</h6>
                            <p class="dropzone-text">or click to browse from your device</p>
                            <span class="dropzone-formats">JPG, PNG, WEBP • Max 2MB</span>
                        </div>
                        <div class="dropzone-preview d-none" id="primaryPreview">
                            <img src="" alt="Preview" id="primaryPreviewImg">
                            <div class="preview-overlay">
                                <button type="button" class="btn-preview-remove" id="primaryRemoveBtn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <span class="preview-filename" id="primaryFilename"></span>
                        </div>
                    </div>

                    @error('image')
                        <div class="upload-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="upload-option">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="is_primary" value="1" checked>
                            <span class="checkmark"></span>
                            <span class="checkbox-label">
                                <i class="fas fa-star text-warning"></i>
                                Set as primary image
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="btn-upload-primary" id="primaryUploadBtn" disabled>
                        <i class="fas fa-upload"></i>
                        Upload Image
                    </button>
                </form>
            </div>

            <!-- Bulk Upload Zone -->
            <div class="image-upload-card">
                <div class="upload-card-header">
                    <div class="upload-card-icon secondary">
                        <i class="fas fa-images"></i>
                    </div>
                    <div>
                        <h6 class="upload-card-title">Add Gallery Images</h6>
                        <p class="upload-card-subtitle">Additional product views & angles</p>
                    </div>
                </div>

                <form action="{{ route('admin.products.images.store-bulk', $product) }}" method="POST"
                    enctype="multipart/form-data" id="bulkUploadForm">
                    @csrf

                    <div class="bulk-upload-zone" id="bulkDropzone">
                        <input type="file" name="images[]" class="upload-input" id="bulkImageInput" accept="image/*"
                            multiple required>
                        <div class="bulk-zone-content" id="bulkDropzoneContent">
                            <div class="bulk-icon">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <span class="bulk-text">Select multiple images</span>
                            <span class="bulk-hint">Ctrl/Cmd + Click to select multiple</span>
                        </div>
                    </div>

                    <div class="bulk-preview-grid d-none" id="bulkPreviewGrid">
                        <div class="bulk-preview-header">
                            <span class="bulk-count"><span id="bulkCount">0</span> images selected</span>
                            <button type="button" class="btn-clear-bulk" id="clearBulkBtn">
                                <i class="fas fa-times"></i> Clear all
                            </button>
                        </div>
                        <div class="bulk-thumbnails" id="bulkThumbnails"></div>
                    </div>

                    @error('images')
                        <div class="upload-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    @error('images.*')
                        <div class="upload-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <button type="submit" class="btn-upload-secondary" id="bulkUploadBtn" disabled>
                        <i class="fas fa-images"></i>
                        Upload All Images
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Gallery -->
        <div class="col-xl-8 col-lg-7">
            <div class="gallery-container">
                <div class="gallery-header">
                    <div class="gallery-title-section">
                        <h5 class="gallery-title">
                            <i class="fas fa-th-large"></i>
                            Product Gallery
                        </h5>
                        <span class="gallery-count">{{ $product->images->count() }}
                            {{ Str::plural('image', $product->images->count()) }}</span>
                    </div>
                    @if($product->images->count() > 0)
                        <div class="gallery-status">
                            <span class="status-indicator success"></span>
                            Images ready for display
                        </div>
                    @endif
                </div>

                <div class="gallery-body">
                    @if($product->images->count() > 0)
                        <div class="image-gallery-grid">
                            @foreach($product->images->sortByDesc('is_primary') as $image)
                                <div class="gallery-item {{ $image->is_primary ? 'is-primary' : '' }}">
                                    <div class="gallery-image-wrapper">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image" loading="lazy">

                                        @if($image->is_primary)
                                            <div class="primary-badge">
                                                <i class="fas fa-star"></i>
                                                Primary
                                            </div>
                                        @endif

                                        <div class="gallery-overlay">
                                            <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank"
                                                class="overlay-btn view-btn" title="View full size">
                                                <i class="fas fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="gallery-item-actions">
                                        @if(!$image->is_primary)
                                            <form action="{{ route('admin.products.images.set-primary', [$product, $image]) }}"
                                                method="POST" class="action-form">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="action-btn set-primary-btn" title="Set as primary">
                                                    <i class="fas fa-star"></i>
                                                    <span>Make Primary</span>
                                                </button>
                                            </form>
                                        @else
                                            <div class="action-btn primary-indicator">
                                                <i class="fas fa-check-circle"></i>
                                                <span>Primary Image</span>
                                            </div>
                                        @endif

                                        <button type="button" class="action-btn delete-btn" title="Delete image"
                                            onclick="confirmDeleteImage('{{ route('admin.products.images.destroy', [$product, $image]) }}')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="gallery-empty">
                            <div class="empty-illustration">
                                <div class="empty-icon">
                                    <i class="fas fa-images"></i>
                                </div>
                                <div class="empty-circles">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                            <h5 class="empty-title">No images uploaded yet</h5>
                            <p class="empty-text">Upload your first product image to showcase this product in your store</p>
                            <button type="button" class="btn-empty-upload"
                                onclick="document.getElementById('primaryImageInput').click()">
                                <i class="fas fa-plus"></i>
                                Add First Image
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Image Guidelines -->
                <div class="gallery-guidelines">
                    <div class="guidelines-header">
                        <i class="fas fa-lightbulb"></i>
                        <span>Image Best Practices</span>
                    </div>
                    <div class="guidelines-grid">
                        <div class="guideline-item">
                            <div class="guideline-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <div class="guideline-content">
                                <strong>High Quality</strong>
                                <span>Use clear, sharp images with good lighting</span>
                            </div>
                        </div>
                        <div class="guideline-item">
                            <div class="guideline-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div class="guideline-content">
                                <strong>Multiple Angles</strong>
                                <span>Show front, back, sides & details</span>
                            </div>
                        </div>
                        <div class="guideline-item">
                            <div class="guideline-icon">
                                <i class="fas fa-square"></i>
                            </div>
                            <div class="guideline-content">
                                <strong>White Background</strong>
                                <span>Clean background focuses attention</span>
                            </div>
                        </div>
                        <div class="guideline-item">
                            <div class="guideline-icon">
                                <i class="fas fa-expand-arrows-alt"></i>
                            </div>
                            <div class="guideline-content">
                                <strong>1000px Minimum</strong>
                                <span>For zoom & high-res displays</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Upload Cards */
        .image-upload-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        /* Product Summary */
        .product-summary-header {
            padding: 16px;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-bottom: 1px solid #e5e7eb;
        }

        .product-summary-thumb {
            width: 64px;
            height: 64px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .product-summary-thumb-placeholder {
            width: 64px;
            height: 64px;
            border-radius: 8px;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 1.5rem;
        }

        .product-summary-info {
            margin-left: 14px;
            flex: 1;
            min-width: 0;
        }

        .product-summary-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #0f172a;
            margin: 0 0 4px 0;
            line-height: 1.3;
        }

        .product-summary-sku {
            font-size: 0.75rem;
            color: #64748b;
            display: block;
            margin-bottom: 6px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .status-badge i {
            font-size: 6px;
        }

        .status-active {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-inactive {
            background: #f3f4f6;
            color: #6b7280;
        }

        .product-summary-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border-top: 1px solid #f1f5f9;
        }

        .stat-item {
            padding: 12px;
            text-align: center;
            border-right: 1px solid #f1f5f9;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-label {
            display: block;
            font-size: 0.7rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
        }

        .stat-value.highlight {
            color: #ff9900;
        }

        /* Upload Card Header */
        .upload-card-header {
            display: flex;
            align-items: center;
            padding: 16px;
            gap: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .upload-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .upload-card-icon.primary {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #d97706;
        }

        .upload-card-icon.secondary {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #2563eb;
        }

        .upload-card-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #0f172a;
            margin: 0;
        }

        .upload-card-subtitle {
            font-size: 0.75rem;
            color: #64748b;
            margin: 2px 0 0 0;
        }

        /* Upload Dropzone */
        .upload-dropzone {
            margin: 16px;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            position: relative;
            transition: all 0.3s ease;
            overflow: hidden;
            background: #fafafa;
        }

        .upload-dropzone:hover,
        .upload-dropzone.dragover {
            border-color: #ff9900;
            background: #fffbf0;
        }

        .upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }

        .dropzone-content {
            padding: 32px 20px;
            text-align: center;
        }

        .dropzone-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 12px;
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .dropzone-icon i {
            font-size: 1.5rem;
            color: #ff9900;
        }

        .dropzone-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #0f172a;
            margin: 0 0 4px 0;
        }

        .dropzone-text {
            font-size: 0.8rem;
            color: #64748b;
            margin: 0 0 8px 0;
        }

        .dropzone-formats {
            font-size: 0.7rem;
            color: #9ca3af;
            background: #fff;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        /* Preview State */
        .dropzone-preview {
            padding: 16px;
            text-align: center;
        }

        .dropzone-preview img {
            max-width: 100%;
            max-height: 180px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .preview-overlay {
            margin-top: 10px;
        }

        .btn-preview-remove {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 50%;
            background: #fee2e2;
            color: #dc2626;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-preview-remove:hover {
            background: #fecaca;
            transform: scale(1.1);
        }

        .preview-filename {
            display: block;
            margin-top: 8px;
            font-size: 0.75rem;
            color: #64748b;
        }

        /* Upload Option */
        .upload-option {
            padding: 0 16px;
            margin-bottom: 16px;
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 10px 12px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .custom-checkbox:hover {
            background: #f1f5f9;
        }

        .custom-checkbox input {
            display: none;
        }

        .checkmark {
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            margin-right: 10px;
            position: relative;
            transition: all 0.2s;
        }

        .custom-checkbox input:checked+.checkmark {
            background: #ff9900;
            border-color: #ff9900;
        }

        .custom-checkbox input:checked+.checkmark::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 2px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .checkbox-label {
            font-size: 0.8rem;
            color: #374151;
        }

        .checkbox-label i {
            margin-right: 6px;
        }

        /* Upload Buttons */
        .btn-upload-primary,
        .btn-upload-secondary {
            width: calc(100% - 32px);
            margin: 0 16px 16px;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-upload-primary {
            background: linear-gradient(to bottom, #f7ca00 0%, #f0a800 100%);
            color: #111;
        }

        .btn-upload-primary:hover:not(:disabled) {
            background: linear-gradient(to bottom, #f0a800 0%, #e09800 100%);
        }

        .btn-upload-secondary {
            background: #fff;
            color: #0f172a;
            border: 1px solid #d1d5db;
        }

        .btn-upload-secondary:hover:not(:disabled) {
            background: #f8f9fa;
            border-color: #9ca3af;
        }

        .btn-upload-primary:disabled,
        .btn-upload-secondary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Upload Error */
        .upload-error {
            margin: 0 16px 12px;
            padding: 10px 12px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #dc2626;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Bulk Upload */
        .bulk-upload-zone {
            margin: 16px;
            padding: 20px;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            text-align: center;
            position: relative;
            background: #fafafa;
            transition: all 0.3s;
            cursor: pointer;
        }

        .bulk-upload-zone:hover {
            border-color: #3b82f6;
            background: #f0f7ff;
        }

        .bulk-icon {
            font-size: 1.5rem;
            color: #3b82f6;
            margin-bottom: 8px;
        }

        .bulk-text {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .bulk-hint {
            font-size: 0.7rem;
            color: #9ca3af;
        }

        /* Bulk Preview Grid */
        .bulk-preview-grid {
            margin: 16px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .bulk-preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .bulk-count {
            font-size: 0.8rem;
            font-weight: 600;
            color: #3b82f6;
        }

        .btn-clear-bulk {
            font-size: 0.7rem;
            color: #dc2626;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .btn-clear-bulk:hover {
            background: #fef2f2;
        }

        .bulk-thumbnails {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .bulk-thumbnails img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Gallery Container */
        .gallery-container {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .gallery-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-bottom: 1px solid #e5e7eb;
        }

        .gallery-title-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .gallery-title {
            font-size: 1rem;
            font-weight: 600;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .gallery-title i {
            color: #ff9900;
        }

        .gallery-count {
            font-size: 0.75rem;
            padding: 4px 10px;
            background: #f1f5f9;
            border-radius: 20px;
            color: #64748b;
        }

        .gallery-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            color: #16a34a;
        }

        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .status-indicator.success {
            background: #22c55e;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .gallery-body {
            padding: 20px;
            min-height: 300px;
        }

        /* Image Gallery Grid */
        .image-gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }

        .gallery-item {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            border-color: #ff9900;
            box-shadow: 0 8px 24px rgba(255, 153, 0, 0.15);
            transform: translateY(-2px);
        }

        .gallery-item.is-primary {
            border: 2px solid #f59e0b;
        }

        .gallery-image-wrapper {
            position: relative;
            aspect-ratio: 4/3;
            overflow: hidden;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
        }

        .gallery-image-wrapper img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-image-wrapper img {
            transform: scale(1.05);
        }

        .primary-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.4);
        }

        .primary-badge i {
            font-size: 0.6rem;
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .overlay-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s;
        }

        .overlay-btn:hover {
            transform: scale(1.1);
            color: #0f172a;
        }

        /* Gallery Item Actions */
        .gallery-item-actions {
            display: flex;
            align-items: center;
            padding: 8px;
            gap: 6px;
            background: #f8f9fa;
            border-top: 1px solid #e5e7eb;
        }

        .action-form {
            flex: 1;
        }

        .action-btn {
            width: 100%;
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: all 0.2s;
            background: #fff;
            border: 1px solid #e5e7eb;
            color: #374151;
        }

        .set-primary-btn:hover {
            background: #fef3c7;
            border-color: #f59e0b;
            color: #d97706;
        }

        .primary-indicator {
            background: #dcfce7;
            border-color: #86efac;
            color: #16a34a;
            cursor: default;
        }

        .delete-btn {
            flex: 0 0 36px;
            width: 36px;
            padding: 6px;
        }

        .delete-btn span {
            display: none;
        }

        .delete-btn:hover {
            background: #fef2f2;
            border-color: #fecaca;
            color: #dc2626;
        }

        /* Gallery Empty State */
        .gallery-empty {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-illustration {
            margin-bottom: 24px;
            position: relative;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #94a3b8;
        }

        .empty-circles {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 120px;
        }

        .empty-circles span {
            position: absolute;
            border: 2px dashed #e2e8f0;
            border-radius: 50%;
            animation: ripple 3s infinite;
        }

        .empty-circles span:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 10px;
            left: 10px;
            animation-delay: 0s;
        }

        .empty-circles span:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 0;
            left: 0;
            animation-delay: 0.5s;
        }

        .empty-circles span:nth-child(3) {
            width: 140px;
            height: 140px;
            top: -10px;
            left: -10px;
            animation-delay: 1s;
        }

        @keyframes ripple {
            0% {
                transform: scale(0.9);
                opacity: 1;
            }

            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        .empty-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #0f172a;
            margin: 0 0 8px 0;
        }

        .empty-text {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0 0 20px 0;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-empty-upload {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            background: linear-gradient(to bottom, #f7ca00 0%, #f0a800 100%);
            color: #111;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-empty-upload:hover {
            background: linear-gradient(to bottom, #f0a800 0%, #e09800 100%);
            transform: translateY(-1px);
        }

        /* Guidelines */
        .gallery-guidelines {
            padding: 16px 20px;
            background: #fffbeb;
            border-top: 1px solid #fde68a;
        }

        .guidelines-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #d97706;
            margin-bottom: 12px;
        }

        .guidelines-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        @media (max-width: 768px) {
            .guidelines-grid {
                grid-template-columns: 1fr;
            }
        }

        .guideline-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .guideline-icon {
            width: 28px;
            height: 28px;
            background: #fff;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f59e0b;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .guideline-content strong {
            display: block;
            font-size: 0.75rem;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .guideline-content span {
            font-size: 0.7rem;
            color: #64748b;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .image-gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }
    </style>


    <!-- Delete Image Modal -->
    <div class="modal fade" id="deleteImageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Delete Image</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this image? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteImageForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Image</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Primary Upload
                const primaryDropzone = document.getElementById('primaryDropzone');
                const primaryInput = document.getElementById('primaryImageInput');
                const primaryContent = document.getElementById('primaryDropzoneContent');
                const primaryPreview = document.getElementById('primaryPreview');
                const primaryPreviewImg = document.getElementById('primaryPreviewImg');
                const primaryFilename = document.getElementById('primaryFilename');
                const primaryRemoveBtn = document.getElementById('primaryRemoveBtn');
                const primaryUploadBtn = document.getElementById('primaryUploadBtn');

                // Drag and drop
                ['dragenter', 'dragover'].forEach(event => {
                    primaryDropzone.addEventListener(event, (e) => {
                        e.preventDefault();
                        primaryDropzone.classList.add('dragover');
                    });
                });

                ['dragleave', 'drop'].forEach(event => {
                    primaryDropzone.addEventListener(event, (e) => {
                        e.preventDefault();
                        primaryDropzone.classList.remove('dragover');
                    });
                });

                primaryDropzone.addEventListener('drop', (e) => {
                    const files = e.dataTransfer.files;
                    if (files.length && files[0].type.startsWith('image/')) {
                        primaryInput.files = files;
                        showPrimaryPreview(files[0]);
                    }
                });

                primaryInput.addEventListener('change', function () {
                    if (this.files.length) {
                        showPrimaryPreview(this.files[0]);
                    }
                });

                function showPrimaryPreview(file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        primaryPreviewImg.src = e.target.result;
                        primaryFilename.textContent = file.name + ' (' + formatSize(file.size) + ')';
                        primaryContent.classList.add('d-none');
                        primaryPreview.classList.remove('d-none');
                        primaryUploadBtn.disabled = false;
                    };
                    reader.readAsDataURL(file);
                }

                primaryRemoveBtn.addEventListener('click', () => {
                    primaryInput.value = '';
                    primaryContent.classList.remove('d-none');
                    primaryPreview.classList.add('d-none');
                    primaryUploadBtn.disabled = true;
                });

                // Bulk Upload
                const bulkDropzone = document.getElementById('bulkDropzone');
                const bulkInput = document.getElementById('bulkImageInput');
                const bulkContent = document.getElementById('bulkDropzoneContent');
                const bulkPreviewGrid = document.getElementById('bulkPreviewGrid');
                const bulkThumbnails = document.getElementById('bulkThumbnails');
                const bulkCount = document.getElementById('bulkCount');
                const clearBulkBtn = document.getElementById('clearBulkBtn');
                const bulkUploadBtn = document.getElementById('bulkUploadBtn');

                bulkDropzone.addEventListener('click', () => bulkInput.click());

                bulkInput.addEventListener('change', function () {
                    bulkThumbnails.innerHTML = '';

                    if (this.files.length) {
                        bulkCount.textContent = this.files.length;
                        bulkContent.classList.add('d-none');
                        bulkPreviewGrid.classList.remove('d-none');
                        bulkUploadBtn.disabled = false;

                        Array.from(this.files).slice(0, 10).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.title = file.name;
                                bulkThumbnails.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        });
                    }
                });

                clearBulkBtn.addEventListener('click', () => {
                    bulkInput.value = '';
                    bulkThumbnails.innerHTML = '';
                    bulkContent.classList.remove('d-none');
                    bulkPreviewGrid.classList.add('d-none');
                    bulkUploadBtn.disabled = true;
                });

                function formatSize(bytes) {
                    if (bytes < 1024) return bytes + ' B';
                    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                    return (bytes / 1048576).toFixed(1) + ' MB';
                }
            });

            function confirmDeleteImage(url) {
                const modal = new bootstrap.Modal(document.getElementById('deleteImageModal'));
                document.getElementById('deleteImageForm').action = url;
                modal.show();
            }
        </script>
    @endpush
@endsection