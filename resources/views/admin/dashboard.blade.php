@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Overview')

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-value">{{ $stats['total_products'] }}</div>
                <div class="stat-label">Total Products</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $stats['active_products'] }}</div>
                <div class="stat-label">Active Products</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value">{{ $stats['total_orders'] }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-value">Rs {{ number_format($stats['total_revenue']) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.products.create') }}" class="quick-action d-block">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add New Product</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.categories.create') }}" class="quick-action d-block">
                                <i class="fas fa-folder-plus"></i>
                                <span>Add New Category</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.products.index') }}" class="quick-action d-block">
                                <i class="fas fa-boxes"></i>
                                <span>Manage Products</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.categories.index') }}" class="quick-action d-block">
                                <i class="fas fa-tags"></i>
                                <span>Manage Categories</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Low Stock -->
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <i class="fas fa-clock me-2"></i>Recent Orders
                </div>
                <div class="admin-card-body p-0">
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
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
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block" style="opacity: 0.3;"></i>
                                            No orders yet
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>Low Stock Alert
                </div>
                <div class="admin-card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($low_stock_products as $product)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0" style="font-size: 14px;">{{ Str::limit($product->name, 25) }}</h6>
                                        <small class="text-muted">SKU: {{ $product->sku }}</small>
                                    </div>
                                    <span class="badge bg-danger">{{ $product->stock }} left</span>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center text-muted py-4">
                                <i class="fas fa-check-circle fa-2x mb-2 text-success d-block" style="opacity: 0.5;"></i>
                                All products have sufficient stock
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection