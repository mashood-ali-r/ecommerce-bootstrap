@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Products</h6>
                    <h2 class="mb-0">{{ $stats['total_products'] }}</h2>
                </div>
                <div class="icon text-primary">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Active Products</h6>
                    <h2 class="mb-0">{{ $stats['active_products'] }}</h2>
                </div>
                <div class="icon text-success">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Orders</h6>
                    <h2 class="mb-0">{{ $stats['total_orders'] }}</h2>
                </div>
                <div class="icon text-info">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Revenue</h6>
                    <h2 class="mb-0">Rs {{ number_format($stats['total_revenue']) }}</h2>
                </div>
                <div class="icon text-warning">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Orders</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_orders as $order)
                            <tr>
                                <td><strong>{{ $order->order_number }}</strong></td>
                                <td>{{ $order->customer_name }}</td>
                                <td>Rs {{ number_format($order->total) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_badge }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No orders yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Low Stock Products</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($low_stock_products as $product)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ Str::limit($product->name, 30) }}</h6>
                                <small class="text-muted">{{ $product->sku }}</small>
                            </div>
                            <span class="badge bg-danger">{{ $product->stock }} left</span>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted">
                        All products have sufficient stock
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary me-2">
                    <i class="fas fa-plus me-2"></i>Add New Product
                </a>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-success me-2">
                    <i class="fas fa-plus me-2"></i>Add New Category
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-list me-2"></i>View All Products
                </a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-success">
                    <i class="fas fa-list me-2"></i>View All Categories
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
