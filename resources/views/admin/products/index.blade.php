@extends('admin.layout')

@section('title', 'Products')
@section('page-title', 'Products Management')
@section('breadcrumb', 'Products')

@section('page-actions')
    <a href="{{ route('admin.products.create') }}" class="btn-amz-primary">
        <i class="fas fa-plus me-2"></i>Add New Product
    </a>
@endsection

@section('content')
    <div class="admin-card">
        <div class="admin-card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-box me-2"></i>All Products</span>
            <span class="badge bg-secondary">{{ $products->total() }} total</span>
        </div>

        <div class="admin-card-body">
            <!-- Filters -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="admin-form-control w-100" placeholder="Search products..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="admin-form-control w-100">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="admin-form-control w-100">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn-amz-secondary w-100">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                </div>
            </form>

            <!-- Drag & Drop Info -->
            <div class="d-flex align-items-center gap-2 mb-3 p-3"
                style="background: #fff3cd; border-radius: 6px; border: 1px solid #ffc107;">
                <i class="fas fa-grip-vertical" style="color: #856404;"></i>
                <span style="font-size: 13px; color: #856404;">Drag rows using the <strong>grip handle</strong> to reorder
                    products. Changes save automatically.</span>
            </div>

            <!-- Products Table -->
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th style="width: 60px;">Image</th>
                            <th>Product Details</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th style="width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-products">
                        @forelse($products as $product)
                            <tr data-id="{{ $product->id }}" class="draggable-row">
                                <td class="drag-handle" style="cursor: grab; color: #999;">
                                    <i class="fas fa-grip-vertical"></i>
                                </td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                                    @else
                                        <div
                                            style="width: 50px; height: 50px; background: #f5f5f5; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #007185; margin-bottom: 4px;">
                                        {{ Str::limit($product->name, 45) }}
                                    </div>
                                    <div style="font-size: 12px; color: #666;">
                                        SKU: <code
                                            style="background: #f5f5f5; padding: 2px 6px; border-radius: 3px;">{{ $product->sku }}</code>
                                    </div>
                                    <div style="margin-top: 4px;">
                                        @if($product->is_featured)
                                            <span
                                                style="background: linear-gradient(135deg, #ffd700, #ffb700); color: #000; font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 3px; margin-right: 4px;">
                                                <i class="fas fa-star" style="font-size: 8px;"></i> FEATURED
                                            </span>
                                        @endif
                                        @if($product->is_new)
                                            <span
                                                style="background: #28a745; color: #fff; font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 3px; margin-right: 4px;">NEW</span>
                                        @endif
                                        @if($product->is_flash_deal)
                                            <span
                                                style="background: #dc3545; color: #fff; font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 3px;">
                                                <i class="fas fa-bolt" style="font-size: 8px;"></i> DEAL
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span
                                        style="background: #e3f2fd; color: #1565c0; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #0F1111; font-size: 15px;">
                                        Rs {{ number_format($product->price) }}
                                    </div>
                                    @if($product->old_price)
                                        <div style="font-size: 12px; color: #999; text-decoration: line-through;">
                                            Rs {{ number_format($product->old_price) }}
                                        </div>
                                        <div style="font-size: 11px; color: #cc0c39; font-weight: 600;">
                                            -{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($product->stock > 10)
                                        <span
                                            style="background: #d4edda; color: #155724; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                            {{ $product->stock }} in stock
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span
                                            style="background: #fff3cd; color: #856404; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                            {{ $product->stock }} left
                                        </span>
                                    @else
                                        <span
                                            style="background: #f8d7da; color: #721c24; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                            Out of Stock
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span
                                            style="background: #28a745; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                            <i class="fas fa-check-circle" style="font-size: 10px;"></i> Active
                                        </span>
                                    @else
                                        <span
                                            style="background: #6c757d; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                            <i class="fas fa-pause-circle" style="font-size: 10px;"></i> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm"
                                            style="background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9;"
                                            title="Edit Product">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.products.images', $product) }}" class="btn btn-sm"
                                            style="background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7;"
                                            title="Manage Images">
                                            <i class="fas fa-images"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm"
                                            onclick="confirmDelete('{{ route('admin.products.destroy', $product) }}')"
                                            style="background: #ffebee; color: #c62828; border: 1px solid #ef9a9a;"
                                            title="Delete Product">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div style="color: #999;">
                                        <i class="fas fa-box-open fa-3x mb-3"></i>
                                        <p class="mb-3">No products found.</p>
                                        <a href="{{ route('admin.products.create') }}" class="btn-amz-primary">
                                            <i class="fas fa-plus me-2"></i>Add Your First Product
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <div style="font-size: 13px; color: #666;">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this product? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .draggable-row {
                transition: background-color 0.2s;
            }

            .draggable-row:hover {
                background-color: #f5f9ff;
            }

            .sortable-ghost {
                background-color: #fff3cd !important;
                opacity: 0.9;
            }

            .drag-handle:hover {
                color: var(--amz-orange) !important;
            }
        </style>
    @endpush

    @push('scripts')
        <!-- SortableJS CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script>
            function confirmDelete(url) {
                const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                document.getElementById('deleteForm').action = url;
                modal.show();
            }

            document.addEventListener('DOMContentLoaded', function () {
                const sortableList = document.getElementById('sortable-products');

                if (sortableList && sortableList.querySelectorAll('tr[data-id]').length > 0) {
                    new Sortable(sortableList, {
                        animation: 150,
                        handle: '.drag-handle',
                        ghostClass: 'sortable-ghost',
                        onEnd: function (evt) {
                            const rows = sortableList.querySelectorAll('tr[data-id]');
                            const items = [];

                            rows.forEach((row, index) => {
                                items.push({
                                    id: parseInt(row.dataset.id),
                                    sort_order: index
                                });
                            });

                            fetch('{{ route("admin.products.reorder") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ items: items })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Optional: show toast
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection