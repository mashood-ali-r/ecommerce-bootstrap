@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h1>
    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($product))
            @method('PUT')
        @endif
        @include('admin.products.form')
        <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update Product' : 'Add Product' }}</button>
    </form>
</div>
@endsection
