<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductImageController extends Controller
{
    /**
     * Display images for a product
     */
    public function index(Product $product)
    {
        $product->load('images');
        return view('admin.products.images', compact('product'));
    }

    /**
     * Upload new product image
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_primary' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Store original image
            $path = $image->storeAs('products', $filename, 'public');

            // Create thumbnail (optional - requires intervention/image package)
            // $thumbnailPath = 'products/thumbnails/' . $filename;
            // Image::make($image)->fit(300, 300)->save(storage_path('app/public/' . $thumbnailPath));

            // If this is set as primary, unset other primary images
            if ($request->is_primary) {
                ProductImage::where('product_id', $product->id)
                    ->update(['is_primary' => false]);
            }

            // Create product image record
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'thumbnail_path' => null, // or $thumbnailPath if using thumbnails
                'is_primary' => $request->is_primary ?? false,
                'sort_order' => ProductImage::where('product_id', $product->id)->count() + 1
            ]);

            return redirect()->route('admin.products.images', $product)
                ->with('success', 'Image uploaded successfully!');
        }

        return back()->with('error', 'No image file provided');
    }

    /**
     * Upload multiple secondary images
     */
    public function storeBulk(Request $request, Product $product)
    {
        $request->validate([
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $uploadedCount = 0;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Store image
                $path = $image->storeAs('products', $filename, 'public');

                // Create product image record
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'thumbnail_path' => null,
                    'is_primary' => false,
                    'sort_order' => ProductImage::where('product_id', $product->id)->count() + 1
                ]);

                $uploadedCount++;
            }

            return redirect()->route('admin.products.images', $product)
                ->with('success', "{$uploadedCount} images uploaded successfully!");
        }

        return back()->with('error', 'No image files provided');
    }

    /**
     * Set image as primary
     */
    public function setPrimary(Product $product, ProductImage $productImage)
    {
        // Unset all primary images for this product
        ProductImage::where('product_id', $product->id)
            ->update(['is_primary' => false]);

        // Set this image as primary
        $productImage->update(['is_primary' => true]);

        return back()->with('success', 'Primary image updated!');
    }

    /**
     * Delete product image
     */
    public function destroy(Product $product, ProductImage $productImage)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($productImage->image_path)) {
            Storage::disk('public')->delete($productImage->image_path);
        }

        if ($productImage->thumbnail_path && Storage::disk('public')->exists($productImage->thumbnail_path)) {
            Storage::disk('public')->delete($productImage->thumbnail_path);
        }

        // Delete database record
        $productImage->delete();

        return back()->with('success', 'Image deleted successfully!');
    }
}
