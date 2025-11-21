<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name ?? '') }}">
</div>
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $product->price ?? '') }}">
</div>
<div class="mb-3">
    <label for="stock" class="form-label">Stock</label>
    <input type="text" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock ?? '') }}">
</div>
<div class="mb-3">
    <label for="sku" class="form-label">SKU</label>
    <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku', $product->sku ?? '') }}">
</div>
<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" value="1" {{ old('is_visible', $product->is_visible ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_visible">Visible</label>
</div>
<div class="mb-3">
    <label for="category_id" class="form-label">Category</label>
    <select class="form-select" id="category_id" name="category_id">
        <option value="">Select a category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="images" class="form-label">Images</label>
    <input type="file" class="form-control" id="images" name="images[]" multiple>
</div>

@if (isset($product) && $product->images)
    <div class="row">
        @foreach ($product->images as $image)
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <form action="{{ route('admin.products.images.destroy', $image) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
