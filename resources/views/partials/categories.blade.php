<!-- Category Navigation Bar - Direct Links to Filtered Products -->
<div class="category-bar bg-light border-bottom d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav justify-content-center py-2">
                    @isset($navCategories)
                        @foreach($navCategories as $category)
                            <li class="nav-item">
                                <a class="nav-link text-dark category-link px-3"
                                    href="{{ route('products.index', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li class="nav-item">
                            <span class="nav-link text-muted">No categories available</span>
                        </li>
                    @endisset
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .category-bar .category-link {
        font-size: 14px;
        font-weight: 500;
        color: #333 !important;
        transition: color 0.2s ease;
        white-space: nowrap;
    }

    .category-bar .category-link:hover {
        color: #c7511f !important;
        text-decoration: underline;
    }
</style>