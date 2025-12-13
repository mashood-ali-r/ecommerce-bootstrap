<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Product Model
 * 
 * This is the MODEL in the MVC (Model-View-Controller) architecture.
 * The Model represents the data structure and business logic for products.
 * 
 * Key Responsibilities:
 * - Define the database table structure (via migrations)
 * - Define relationships with other models (Category, ProductImage, etc.)
 * - Provide accessors/mutators for data transformation
 * - Contain business logic related to products
 * 
 * Laravel Features Used:
 * - Eloquent ORM: Object-Relational Mapping for database interactions
 * - SoftDeletes: Allows "soft deletion" (marking as deleted without removing from DB)
 * - HasFactory: Enables model factories for testing and seeding
 */
class Product extends Model
{
    // Traits provide additional functionality to the model
    use HasFactory;    // Enables factory pattern for creating test data
    use SoftDeletes;   // Enables soft deletion (deleted_at timestamp instead of actual deletion)

    /**
     * Mass Assignment Protection
     * 
     * The $fillable array defines which attributes can be mass-assigned.
     * This protects against mass-assignment vulnerabilities.
     * 
     * Example: Product::create(['name' => 'Laptop', 'price' => 50000])
     * Only attributes listed here can be set this way.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',      // Foreign key to categories table
        'name',             // Product name
        'slug',             // URL-friendly version of name (e.g., "gaming-laptop")
        'sku',              // Stock Keeping Unit - unique product identifier
        'description',      // Full product description (HTML allowed)
        'specifications',   // Technical specifications (JSON or text)
        'price',            // Current selling price
        'old_price',        // Original price (for showing discounts)
        'stock',            // Available quantity in inventory
        'is_active',        // Whether product is visible on site (boolean)
        'is_featured',      // Featured on homepage (boolean)
        'is_new',           // Mark as "New Arrival" (boolean)
        'is_flash_deal',    // Part of flash/limited-time deals (boolean)
        'views',            // Number of times product page was viewed
        'rating',           // Average customer rating (1-5)
        'reviews_count',    // Total number of reviews
        'sort_order',       // Manual sorting order (lower = appears first)
    ];

    /**
     * Attribute Casting
     * 
     * Laravel automatically converts these attributes to the specified types
     * when retrieving from or saving to the database.
     * 
     * Example: 'price' is stored as DECIMAL in DB but accessed as float in PHP
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',        // Cast to decimal with 2 decimal places
        'old_price' => 'decimal:2',    // Cast to decimal with 2 decimal places
        'rating' => 'decimal:2',       // Cast to decimal with 2 decimal places
        'is_active' => 'boolean',      // Cast to true/false (stored as 0/1 in DB)
        'is_featured' => 'boolean',    // Cast to true/false
        'is_new' => 'boolean',         // Cast to true/false
        'is_flash_deal' => 'boolean',  // Cast to true/false
    ];

    /**
     * RELATIONSHIP: Product belongs to Category
     * 
     * This defines a "Many-to-One" relationship.
     * Many products can belong to one category.
     * 
     * Database: Uses 'category_id' foreign key in products table
     * 
     * Usage in Controller:
     *   $product->category          // Get the category object
     *   $product->category->name    // Get category name
     * 
     * Eager Loading (prevents N+1 queries):
     *   Product::with('category')->get()
     * 
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * RELATIONSHIP: Product has many Images
     * 
     * This defines a "One-to-Many" relationship.
     * One product can have multiple images.
     * 
     * Database: ProductImage table has 'product_id' foreign key
     * 
     * Usage:
     *   $product->images           // Collection of all images
     *   $product->images->count()  // Number of images
     *   foreach($product->images as $image) { ... }
     * 
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * RELATIONSHIP: Get Primary Image
     * 
     * Returns the single image marked as primary (is_primary = true).
     * Used for product thumbnails and listings.
     * 
     * Usage:
     *   $product->primaryImage        // Single ProductImage object or null
     *   $product->primaryImage->image_path
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * ACCESSOR: Get Image Path
     * 
     * Accessors allow you to transform attribute values when accessing them.
     * This creates a virtual "image" attribute that doesn't exist in the database.
     * 
     * Logic:
     * 1. Try to get the primary image
     * 2. If no primary, get the first available image
     * 3. If no images at all, return null
     * 
     * Usage in Views:
     *   $product->image  // Returns: "products/laptop.jpg"
     * 
     * Note: Accessor methods follow naming convention: get{AttributeName}Attribute
     * 
     * @return string|null
     */
    public function getImageAttribute(): ?string
    {
        // First, try to get the primary image
        $primary = $this->primaryImage;
        if ($primary) {
            return $primary->image_path;
        }

        // Fallback: Get the first image if no primary is set
        $firstImage = $this->images()->first();
        return $firstImage ? $firstImage->image_path : null;
    }

    /**
     * ACCESSOR: Get Full Image URL
     * 
     * Converts the relative image path to a full URL for use in HTML.
     * 
     * Process:
     * 1. Get image path using the image accessor above
     * 2. Prepend 'storage/' and convert to full URL using asset() helper
     * 
     * Usage in Blade Views:
     *   <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
     * 
     * Output Example:
     *   http://127.0.0.1:8000/storage/products/laptop.jpg
     * 
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        $imagePath = $this->image;  // Uses the accessor above
        if ($imagePath) {
            // asset() helper creates full URL: http://domain.com/storage/products/image.jpg
            return asset('storage/' . $imagePath);
        }
        return null;
    }

    /**
     * RELATIONSHIP: Product in Wishlists
     * 
     * One product can be in many users' wishlists.
     * 
     * Usage:
     *   $product->wishlists           // All wishlist entries for this product
     *   $product->wishlists->count()  // How many users wishlisted this
     * 
     * @return HasMany
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * RELATIONSHIP: Product in Order Items
     * 
     * Tracks all orders that include this product.
     * 
     * Usage:
     *   $product->orderItems           // All order items containing this product
     *   $product->orderItems->sum('quantity')  // Total units sold
     * 
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * ACCESSOR: Calculate Discount Percentage
     * 
     * Business Logic: Calculate discount percentage from old_price to current price.
     * 
     * Formula: ((old_price - price) / old_price) * 100
     * 
     * Usage in Views:
     *   @if($product->discount_percentage)
     *       <span class="badge">{{ $product->discount_percentage }}% OFF</span>
     *   @endif
     * 
     * Returns null if no old_price or if old_price <= current price
     * 
     * @return int|null
     */
    public function getDiscountPercentageAttribute(): ?int
    {
        // Only calculate if old_price exists and is greater than current price
        if ($this->old_price && $this->old_price > $this->price) {
            // Calculate percentage and round to nearest integer
            return (int) round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return null;
    }

    /**
     * ACCESSOR: Check Stock Availability
     * 
     * Simple boolean check for inventory availability.
     * 
     * Usage in Views:
     *   @if($product->in_stock)
     *       <button>Add to Cart</button>
     *   @else
     *       <span>Out of Stock</span>
     *   @endif
     * 
     * @return bool
     */
    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    /**
     * BUSINESS LOGIC: Increment View Counter
     * 
     * Called when someone views the product detail page.
     * Tracks product popularity for analytics and sorting.
     * 
     * Usage in Controller:
     *   $product->incrementViews();
     * 
     * Database: Increments the 'views' column by 1
     * 
     * @return void
     */
    public function incrementViews(): void
    {
        // increment() is an Eloquent method that performs: UPDATE products SET views = views + 1
        $this->increment('views');
    }
}
