@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h1>
    <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
        @csrf
        @if (isset($category))
            @method('PUT')
        @endif
        @include('admin.categories.form')
        <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update Category' : 'Add Category' }}</button>
    </form>
</div>
@endsection
