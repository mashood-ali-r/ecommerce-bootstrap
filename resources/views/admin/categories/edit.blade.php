@extends('admin.layout')

@section('title', 'Edit: ' . $category->name)
@section('page-title', 'Edit Category')

@section('breadcrumb')
    <a href="{{ route('admin.categories.index') }}">Categories</a> / {{ Str::limit($category->name, 25) }}
@endsection

@section('page-actions')
    <a href="{{ route('admin.categories.index') }}" class="btn-amz-secondary">
        <i class="fas fa-arrow-left me-1"></i>Back to Categories
    </a>
@endsection

@section('content')
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" id="categoryForm">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Main Content Column -->
            <div class="col-lg-8">
                <!-- Category Information Card -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div>
                            <h6 class="form-card-title">Category Information</h6>
                            <p class="form-card-subtitle">Name, slug, and description</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    Category Name <span class="required">*</span>
                                </label>
                                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                                    value="{{ old('name', $category->name) }}" placeholder="Enter category name" required>
                                @error('name')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">
                                    URL Slug
                                    <span class="label-hint">(auto-generated)</span>
                                </label>
                                <input type="text" name="slug" class="form-input @error('slug') is-invalid @enderror"
                                    value="{{ old('slug', $category->slug) }}" placeholder="category-url-slug">
                                @error('slug')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label-custom">
                                    Description
                                    <span class="label-hint">(optional)</span>
                                </label>
                                <textarea name="description" rows="3"
                                    class="form-input @error('description') is-invalid @enderror"
                                    placeholder="Brief description of this category...">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organization Card -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon blue">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <div>
                            <h6 class="form-card-title">Organization</h6>
                            <p class="form-card-subtitle">Hierarchy and display order</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Parent Category</label>
                                <div class="select-wrapper">
                                    <select name="parent_id" class="form-input @error('parent_id') is-invalid @enderror">
                                        <option value="">None (Top Level)</option>
                                        @foreach($parentCategories as $parent)
                                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                                @error('parent_id')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Sort Order</label>
                                <input type="number" name="sort_order"
                                    class="form-input @error('sort_order') is-invalid @enderror"
                                    value="{{ old('sort_order', $category->sort_order) }}" placeholder="0">
                                <div class="field-hint">Lower numbers appear first in listings</div>
                                @error('sort_order')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <!-- Category Preview -->
                <div class="form-card stats-card">
                    <div class="stats-header">
                        <i class="fas fa-chart-bar"></i>
                        <span>Category Statistics</span>
                    </div>
                    <div class="stats-body">
                        <div class="stat-row">
                            <span class="stat-label">Products</span>
                            <span class="stat-value highlight">{{ $category->products()->count() }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">Status</span>
                            <span class="stat-badge {{ $category->is_active ? 'active' : 'inactive' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">Created</span>
                            <span class="stat-date">{{ $category->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">Last Updated</span>
                            <span class="stat-date">{{ $category->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon purple">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div>
                            <h6 class="form-card-title">Visibility</h6>
                            <p class="form-card-subtitle">Control category visibility</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="toggle-option main-toggle">
                            <div class="toggle-content">
                                <span class="toggle-label">Category Status</span>
                                <span class="toggle-description">Visible on storefront when active</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-card action-card">
                    <div class="action-buttons">
                        <button type="submit" class="btn-save-primary" id="saveBtn">
                            <i class="fas fa-check"></i>
                            Update Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn-cancel">
                            Cancel
                        </a>
                    </div>
                    <div class="last-updated">
                        <i class="fas fa-clock"></i>
                        Last updated: {{ $category->updated_at->format('M d, Y \a\t h:i A') }}
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

        /* Stats Card */
        .stats-card {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-color: #7dd3fc;
        }

        .stats-header {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(125, 211, 252, 0.5);
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #0369a1;
            font-size: 0.85rem;
        }

        .stats-body {
            padding: 16px 20px;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(125, 211, 252, 0.3);
        }

        .stat-row:last-child {
            border-bottom: none;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #475569;
        }

        .stat-value {
            font-size: 0.9rem;
            font-weight: 700;
            color: #0f172a;
        }

        .stat-value.highlight {
            background: #0284c7;
            color: #fff;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .stat-badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 12px;
        }

        .stat-badge.active {
            background: #dcfce7;
            color: #16a34a;
        }

        .stat-badge.inactive {
            background: #f3f4f6;
            color: #6b7280;
        }

        .stat-date {
            font-size: 0.8rem;
            color: #64748b;
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
            min-height: 80px;
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

        .last-updated {
            padding: 12px 16px;
            text-align: center;
            font-size: 0.7rem;
            color: #6b7280;
            border-top: 1px solid rgba(253, 224, 71, 0.5);
        }

        .last-updated i {
            margin-right: 4px;
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('categoryForm');
                const saveBtn = document.getElementById('saveBtn');

                form.addEventListener('submit', function () {
                    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                    saveBtn.disabled = true;
                });
            });
        </script>
    @endpush
@endsection