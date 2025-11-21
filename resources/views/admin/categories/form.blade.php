<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name ?? '') }}">
</div>
<div class="mb-3">
    <label for="slug" class="form-label">Slug</label>
    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $category->slug ?? '') }}">
</div>
<div class="mb-3">
    <label for="parent_id" class="form-label">Parent Category</label>
    <select class="form-select" id="parent_id" name="parent_id">
        <option value="">Select a parent category</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
</div>
