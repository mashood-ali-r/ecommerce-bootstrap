@extends('layouts.app')

@section('title', 'Shop by Category - EEZEPC.com')

@section('content')
    <div class="bg-light min-vh-100 pb-5">
        <div class="container py-4">
            <h1 class="fw-bold mb-4" style="color: #0f1111; font-size: 28px;">Shop by Category</h1>

            <div class="row g-4">
                @isset($navCategories)
                    @foreach($navCategories as $category)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="bg-white h-100 d-flex flex-column"
                                style="border: 1px solid #d5d9d9; border-radius: 8px; overflow: hidden; transition: box-shadow 0.2s;">

                                <div class="p-3 pb-0 flex-grow-1">
                                    <h3 class="fw-bold mb-3" style="font-size: 21px; color: #0f1111;">{{ $category->name }}</h3>

                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                        class="d-block text-decoration-none">
                                        <div
                                            style="background: #f7f7f7; height: 260px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 4px;">
                                            <!-- Placeholder or Category Image if exists -->
                                            <img src="https://source.unsplash.com/random/400x400/?{{ $category->slug }}"
                                                alt="{{ $category->name }}" class="img-fluid"
                                                style="max-height: 100%; object-fit: cover;">
                                        </div>
                                    </a>
                                </div>

                                <div class="p-3 pt-2">
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                        class="text-decoration-none hover-link"
                                        style="color: #007185; font-size: 14px; font-weight: 500;">
                                        Shop now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-5">
                        <h3>No categories found.</h3>
                    </div>
                @endisset
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .hover-link:hover {
                color: #c7511f !important;
                text-decoration: underline !important;
            }
        </style>
    @endpush
@endsection