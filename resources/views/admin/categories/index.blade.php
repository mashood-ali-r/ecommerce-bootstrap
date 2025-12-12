@extends('admin.layout')

@section('title', 'Categories')
@section('page-title', 'Categories Management')
@section('breadcrumb', 'Categories')

@section('page-actions')
    <a href="{{ route('admin.categories.create') }}" class="btn-amz-primary">
        <i class="fas fa-plus me-2"></i>Add New Category
    </a>
@endsection

@section('content')
    <div class="admin-card">
        <div class="admin-card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-tags me-2"></i>All Categories</span>
            <span class="badge bg-secondary">{{ $categories->total() }} total</span>
        </div>

        <div class="admin-card-body">
            <!-- Search -->
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="admin-form-control w-100" placeholder="Search categories..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn-amz-secondary w-100">
                            <i class="fas fa-search me-1"></i>Search
                        </button>
                    </div>
                </div>
            </form>

            <!-- Drag & Drop Info -->
            <div class="d-flex align-items-center gap-2 mb-3 p-3"
                style="background: #fff3cd; border-radius: 6px; border: 1px solid #ffc107;">
                <i class="fas fa-grip-vertical" style="color: #856404;"></i>
                <span style="font-size: 13px; color: #856404;">Drag rows using the <strong>grip handle</strong> to reorder
                    categories. Changes save automatically.</span>
            </div>

            <!-- Categories Table -->
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th style="width: 60px;">Icon</th>
                            <th>Category Details</th>
                            <th>Slug</th>
                            <th>Products</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-categories">
                        @forelse($categories as $category)
                            <tr data-id="{{ $category->id }}" class="draggable-row">
                                <td class="drag-handle" style="cursor: grab; color: #999;">
                                    <i class="fas fa-grip-vertical"></i>
                                </td>
                                <td>
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                                    @else
                                        <div
                                            style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-folder text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #007185; margin-bottom: 4px;">
                                        {{ $category->name }}
                                    </div>
                                    @if($category->parent)
                                        <div style="font-size: 12px; color: #666;">
                                            <i class="fas fa-level-up-alt fa-rotate-90" style="font-size: 10px;"></i>
                                            Parent: <span style="color: #1565c0;">{{ $category->parent->name }}</span>
                                        </div>
                                    @endif
                                    @if($category->description)
                                        <div style="font-size: 11px; color: #999; margin-top: 4px;">
                                            {{ Str::limit($category->description, 50) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <code style="background: #f5f5f5; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                                {{ $category->slug }}
                                            </code>
                                </td>
                                <td>
                                    <span
                                        style="background: #e3f2fd; color: #1565c0; padding: 6px 12px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                                        <i class="fas fa-box" style="font-size: 11px;"></i> {{ $category->products_count }}
                                    </span>
                                </td>
                                <td>
                                    <span class="sort-order-display"
                                        style="background: #f5f5f5; color: #666; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                        #{{ $category->sort_order }}
                                    </span>
                                </td>
                                <td>
                                    @if($category->is_active)
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
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm"
                                            style="background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9;"
                                            title="Edit Category">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm"
                                            onclick="confirmDelete('{{ route('admin.categories.destroy', $category) }}')"
                                            style="background: #ffebee; color: #c62828; border: 1px solid #ef9a9a;"
                                            title="Delete Category">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div style="color: #999;">
                                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                                        <p class="mb-3">No categories found.</p>
                                        <a href="{{ route('admin.categories.create') }}" class="btn-amz-primary">
                                            <i class="fas fa-plus me-2"></i>Add Your First Category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <div style="font-size: 13px; color: #666;">
                        Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }}
                        categories
                    </div>
                    <div>
                        {{ $categories->links() }}
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
                    <p>Are you sure you want to delete this category? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Category</button>
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
                const sortableList = document.getElementById('sortable-categories');

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
                                // Update the displayed sort order
                                const sortOrderDisplay = row.querySelector('.sort-order-display');
                                if (sortOrderDisplay) {
                                    sortOrderDisplay.textContent = '#' + index;
                                }
                            });

                            fetch('{{ route("admin.categories.reorder") }}', {
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
                                        // Optional: toast
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