@extends('admin.layout')

@section('title', 'Create Product')
@section('page-title', 'Create New Product')

@section('breadcrumb')
    <a href="{{ route('admin.products.index') }}">Products</a> / New Product
@endsection

@section('page-actions')
    <a href="{{ route('admin.products.index') }}" class="btn-amz-secondary">
        <i class="fas fa-arrow-left me-1"></i>Back to Products
    </a>
@endsection

@section('content')
    <form action="{{ route('admin.products.store') }}" method="POST" id="productForm">
        @csrf

        <div class="row g-4">
            <!-- Main Content Column -->
            <div class="col-xl-8 col-lg-7">
                <!-- Basic Information Card -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div>
                            <h6 class="form-card-title">Basic Information</h6>
                            <p class="form-card-subtitle">Product name, category, and identifiers</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label-custom">
                                    Product Name <span class="required">*</span>
                                </label>
                                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Enter product name" required>
                                @error('name')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label-custom">
                                    SKU <span class="required">*</span>
                                </label>
                                <input type="text" name="sku" class="form-input @error('sku') is-invalid @enderror"
                                    value="{{ old('sku') }}" placeholder="e.g., PROD-001" required>
                                @error('sku')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    Category <span class="required">*</span>
                                </label>
                                <div class="select-wrapper">
                                    <select name="category_id" class="form-input @error('category_id') is-invalid @enderror"
                                        required>
                                        <option value="">Select a category...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                                @error('category_id')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    URL Slug
                                    <span class="label-hint">(auto-generated if empty)</span>
                                </label>
                                <input type="text" name="slug" class="form-input @error('slug') is-invalid @enderror"
                                    value="{{ old('slug') }}" placeholder="product-url-slug">
                                @error('slug')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon blue">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div>
                            <h6 class="form-card-title">Product Description</h6>
                            <p class="form-card-subtitle">Detailed information shown on product page</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="mb-4">
                            <label class="form-label-custom">
                                Description <span class="required">*</span>
                            </label>
                            <textarea name="description" rows="5"
                                class="form-input @error('description') is-invalid @enderror"
                                placeholder="Write a detailed product description that helps customers understand what they're buying..."
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                            <div class="char-count">
                                <span id="descCount">0</span> characters
                            </div>
                        </div>

                        <div>
                            <label class="form-label-custom">
                                Technical Specifications
                                <span class="label-hint">(optional)</span>
                            </label>
                            <textarea name="specifications" rows="4"
                                class="form-input @error('specifications') is-invalid @enderror"
                                placeholder="• Screen: 15.6 inch FHD&#10;• Processor: Intel Core i7&#10;• RAM: 16GB DDR4&#10;• Storage: 512GB SSD">{{ old('specifications') }}</textarea>
                            @error('specifications')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="col-xl-4 col-lg-5">
                <!-- Quick Tips -->
                <div class="form-card tips-card">
                    <div class="tips-header">
                        <i class="fas fa-lightbulb"></i>
                        <span>Quick Tips</span>
                    </div>
                    <div class="tips-body">
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Use descriptive product names for better SEO</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Add high-quality images after creating the product</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Include detailed specifications for tech products</span>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon green">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div>
                            <h6 class="form-card-title">Pricing & Inventory</h6>
                            <p class="form-card-subtitle">Set pricing and stock levels</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="mb-3">
                            <label class="form-label-custom">
                                Selling Price <span class="required">*</span>
                            </label>
                            <div class="input-with-prefix">
                                <span class="input-prefix">Rs</span>
                                <input type="number" name="price" step="0.01"
                                    class="form-input with-prefix @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}" placeholder="0.00" required>
                            </div>
                            @error('price')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">
                                Compare at Price
                                <span class="label-hint">(original price)</span>
                            </label>
                            <div class="input-with-prefix">
                                <span class="input-prefix">Rs</span>
                                <input type="number" name="old_price" step="0.01"
                                    class="form-input with-prefix @error('old_price') is-invalid @enderror"
                                    value="{{ old('old_price') }}" placeholder="0.00">
                            </div>
                            <div class="field-hint">Shows strikethrough price to highlight discount</div>
                            @error('old_price')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label-custom">
                                Stock Quantity <span class="required">*</span>
                            </label>
                            <div class="input-with-suffix">
                                <input type="number" name="stock"
                                    class="form-input with-suffix @error('stock') is-invalid @enderror"
                                    value="{{ old('stock', 0) }}" placeholder="0" required>
                                <span class="input-suffix">units</span>
                            </div>
                            @error('stock')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status & Visibility -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon purple">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div>
                            <h6 class="form-card-title">Status & Visibility</h6>
                            <p class="form-card-subtitle">Control product visibility</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <!-- Active Toggle -->
                        <div class="toggle-option main-toggle">
                            <div class="toggle-content">
                                <span class="toggle-label">Product Status</span>
                                <span class="toggle-description">Visible on storefront when active</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <div class="divider"></div>

                        <!-- Product Labels -->
                        <div class="labels-section">
                            <span class="section-label">Product Labels</span>

                            <label class="checkbox-option">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-content">
                                    <i class="fas fa-star label-icon featured"></i>
                                    <span class="checkbox-label">Featured Product</span>
                                </span>
                            </label>

                            <label class="checkbox-option">
                                <input type="checkbox" name="is_new" value="1" {{ old('is_new') ? 'checked' : '' }}>
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-content">
                                    <i class="fas fa-certificate label-icon new"></i>
                                    <span class="checkbox-label">New Arrival</span>
                                </span>
                            </label>

                            <label class="checkbox-option">
                                <input type="checkbox" name="is_flash_deal" value="1" {{ old('is_flash_deal') ? 'checked' : '' }}>
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-content">
                                    <i class="fas fa-bolt label-icon flash"></i>
                                    <span class="checkbox-label">Flash Deal</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-card action-card">
                    <div class="action-buttons">
                        <button type="submit" class="btn-save-primary" id="saveBtn">
                            <i class="fas fa-plus"></i>
                            Create Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn-cancel">
                            Cancel
                        </a>
                    </div>
                    <div class="action-hint">
                        <i class="fas fa-info-circle"></i>
                        After creating, you can add product images
                    </div>
                </div>
            </div>
        </div>
    </form>

    <style>
        /* Form Cards */
        .form-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .form-card-header {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-bottom: 1px solid #e5e7eb;
            gap: 14px;
        }

        .form-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fff4e5 0%, #ffe4c4 100%);
            color: #f59e0b;
            font-size: 1rem;
        }

        .form-card-icon.blue {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            color: #0284c7;
        }

        .form-card-icon.green {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #16a34a;
        }

        .form-card-icon.purple {
            background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
            color: #9333ea;
        }

        .form-card-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #0f172a;
            margin: 0;
        }

        .form-card-subtitle {
            font-size: 0.75rem;
            color: #64748b;
            margin: 2px 0 0 0;
        }

        .form-card-body {
            padding: 20px;
        }

        /* Tips Card */
        .tips-card {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-color: #6ee7b7;
        }

        .tips-header {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(110, 231, 183, 0.5);
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #059669;
            font-size: 0.85rem;
        }

        .tips-body {
            padding: 16px 20px;
        }

        .tip-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 0.8rem;
            color: #065f46;
        }

        .tip-item:last-child {
            margin-bottom: 0;
        }

        .tip-item i {
            color: #10b981;
            margin-top: 2px;
        }

        /* Form Labels */
        .form-label-custom {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .required {
            color: #dc2626;
        }

        .label-hint {
            font-weight: 400;
            color: #9ca3af;
            font-size: 0.75rem;
        }

        /* Form Inputs */
        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.875rem;
            color: #0f172a;
            background: #fff;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #ff9900;
            box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .form-input.is-invalid {
            border-color: #dc2626;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 100px;
        }

        /* Select Wrapper */
        .select-wrapper {
            position: relative;
        }

        .select-wrapper select {
            appearance: none;
            padding-right: 40px;
        }

        .select-arrow {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
            font-size: 0.75rem;
        }

        /* Input with Prefix/Suffix */
        .input-with-prefix,
        .input-with-suffix {
            position: relative;
            display: flex;
            align-items: stretch;
        }

        .input-prefix,
        .input-suffix {
            display: flex;
            align-items: center;
            padding: 0 12px;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            color: #6b7280;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .input-prefix {
            border-right: none;
            border-radius: 8px 0 0 8px;
        }

        .input-suffix {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }

        .form-input.with-prefix {
            border-radius: 0 8px 8px 0;
        }

        .form-input.with-suffix {
            border-radius: 8px 0 0 8px;
        }

        /* Field Hints and Errors */
        .field-hint {
            font-size: 0.7rem;
            color: #9ca3af;
            margin-top: 4px;
        }

        .field-error {
            font-size: 0.75rem;
            color: #dc2626;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .field-error::before {
            content: '⚠';
        }

        .char-count {
            font-size: 0.7rem;
            color: #9ca3af;
            text-align: right;
            margin-top: 4px;
        }

        /* Toggle Switch */
        .toggle-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .toggle-option.main-toggle {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1px solid #86efac;
        }

        .toggle-content {
            flex: 1;
        }

        .toggle-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #0f172a;
        }

        .toggle-description {
            font-size: 0.7rem;
            color: #6b7280;
        }

        .toggle-switch {
            position: relative;
            width: 48px;
            height: 26px;
            cursor: pointer;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #d1d5db;
            border-radius: 26px;
            transition: all 0.3s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            left: 3px;
            bottom: 3px;
            background: #fff;
            border-radius: 50%;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .toggle-switch input:checked+.toggle-slider {
            background: #22c55e;
        }

        .toggle-switch input:checked+.toggle-slider::before {
            transform: translateX(22px);
        }

        /* Divider */
        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 16px 0;
        }

        /* Labels Section */
        .labels-section {
            margin-top: 4px;
        }

        .section-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .checkbox-option {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            margin-bottom: 8px;
            background: #f8f9fa;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .checkbox-option:hover {
            background: #f1f5f9;
        }

        .checkbox-option:last-child {
            margin-bottom: 0;
        }

        .checkbox-option input {
            display: none;
        }

        .checkbox-custom {
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            margin-right: 12px;
            position: relative;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .checkbox-option input:checked+.checkbox-custom {
            background: #ff9900;
            border-color: #ff9900;
        }

        .checkbox-option input:checked+.checkbox-custom::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 2px;
            width: 5px;
            height: 9px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .checkbox-content {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .label-icon {
            font-size: 0.9rem;
        }

        .label-icon.featured {
            color: #f59e0b;
        }

        .label-icon.new {
            color: #22c55e;
        }

        .label-icon.flash {
            color: #ef4444;
        }

        .checkbox-label {
            font-size: 0.85rem;
            color: #374151;
        }

        /* Action Card */
        .action-card {
            background: linear-gradient(135deg, #fefce8 0%, #fef9c3 100%);
            border-color: #fde047;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 16px;
        }

        .btn-save-primary {
            width: 100%;
            padding: 14px 20px;
            background: linear-gradient(to bottom, #f7ca00 0%, #f0a800 100%);
            color: #111;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(240, 168, 0, 0.3);
        }

        .btn-save-primary:hover {
            background: linear-gradient(to bottom, #f0a800 0%, #e09800 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(240, 168, 0, 0.4);
        }

        .btn-cancel {
            width: 100%;
            padding: 12px 20px;
            background: #fff;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #f8f9fa;
            border-color: #9ca3af;
            color: #374151;
        }

        .action-hint {
            padding: 12px 16px;
            text-align: center;
            font-size: 0.7rem;
            color: #6b7280;
            border-top: 1px solid rgba(253, 224, 71, 0.5);
        }

        .action-hint i {
            margin-right: 4px;
            color: #ca8a04;
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Character count for description
                const descTextarea = document.querySelector('textarea[name="description"]');
                const descCount = document.getElementById('descCount');

                if (descTextarea && descCount) {
                    // Initial count
                    descCount.textContent = descTextarea.value.length;

                    descTextarea.addEventListener('input', function () {
                        descCount.textContent = this.value.length;
                    });
                }

                // Form submission feedback
                const form = document.getElementById('productForm');
                const saveBtn = document.getElementById('saveBtn');

                form.addEventListener('submit', function () {
                    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
                    saveBtn.disabled = true;
                });
            });
        </script>
    @endpush
@endsection