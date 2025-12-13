<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'specifications',
        'price',
        'old_price',
        'stock',
        'is_active',
        'is_featured',
        'is_new',
        'is_flash_deal',
        'views',
        'rating',
        'reviews_count',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_flash_deal' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the primary image for the product.
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Get the primary image path (accessor for convenience).
     * This allows using $product->image in views.
     */
    public function getImageAttribute(): ?string
    {
        $primary = $this->primaryImage;
        if ($primary) {
            return $primary->image_path;
        }
        // Fallback to first image if no primary
        $firstImage = $this->images()->first();
        return $firstImage ? $firstImage->image_path : null;
    }

    /**
     * Get the primary image URL (full URL for use in views).
     * This allows using $product->image_url in views.
     */
    public function getImageUrlAttribute(): ?string
    {
        $imagePath = $this->image;
        if ($imagePath) {
            return asset('storage/' . $imagePath);
        }
        return null;
    }

    /**
     * Get the wishlists for the product.
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get discount percentage.
     */
    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->old_price && $this->old_price > $this->price) {
            return (int) round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return null;
    }

    /**
     * Check if product is in stock.
     */
    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Increment views count.
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
