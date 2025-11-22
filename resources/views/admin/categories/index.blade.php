@extends('admin.layout')

@section('title', 'Categories')
@section('page-title', 'Categories Management')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Categories</h5>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add New Category
        </a>
    </div>
    
    <div class="card-body">
        <!-- Search -->
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search categories..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Search</button>
                </div>
            </div>
        </form>

        <!-- Categories Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Products</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            <strong>{{ $category->name }}</strong>
                            @if($category->parent)
                                <div class="small text-muted">Parent: {{ $category->parent->name }}</div>
                            @endif
                        </td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td><span class="badge bg-info">{{ $category->products_count }}</span></td>
                        <td>{{ $category->sort_order }}</td>
                        <td>
                            <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure? This will fail if category has products.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No categories found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
