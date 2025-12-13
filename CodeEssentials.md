# 📚 EEZEPC Code Essentials Guide

This document explains the essential code architecture, logic, and patterns used in the EEZEPC e-commerce platform. Perfect for developers who want to understand how everything works together.

---

## 📋 Table of Contents

1. [MVC Architecture Overview](#mvc-architecture-overview)
2. [Directory Structure Explained](#directory-structure-explained)
3. [Database Architecture](#database-architecture)
4. [Models - The Data Layer](#models---the-data-layer)
5. [Controllers - The Logic Layer](#controllers---the-logic-layer)
6. [Views - The Presentation Layer](#views---the-presentation-layer)
7. [Routes - The Entry Points](#routes---the-entry-points)
8. [Key Features Implementation](#key-features-implementation)
9. [Laravel Concepts Used](#laravel-concepts-used)
10. [Code Patterns & Best Practices](#code-patterns--best-practices)

---

## 🏗️ MVC Architecture Overview

### What is MVC?

**MVC (Model-View-Controller)** is a software design pattern that separates an application into three interconnected components:

```
┌─────────────────────────────────────────────────────────┐
│                     USER'S BROWSER                       │
│              (Sends HTTP Request: GET /)                 │
└────────────────────┬────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────┐
│                    ROUTES (web.php)                      │
│         Maps URL to Controller Method                    │
│    Route::get('/', [HomeController::class, 'index'])    │
└────────────────────┬────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────┐
│                  CONTROLLER (HomeController)             │
│         - Receives the request                           │
│         - Calls Model to get data                        │
│         - Passes data to View                            │
└────────────┬────────────────────┬───────────────────────┘
             │                    │
             ▼                    ▼
┌─────────────────────┐  ┌──────────────────────────────┐
│   MODEL (Product)   │  │    VIEW (home.blade.php)     │
│  - Database queries │  │  - Receives data from        │
│  - Business logic   │  │    Controller                │
│  - Relationships    │  │  - Renders HTML              │
│  - Data validation  │  │  - Displays to user          │
└─────────────────────┘  └──────────┬───────────────────┘
                                    │
                                    ▼
                         ┌──────────────────────┐
                         │   USER'S BROWSER     │
                         │  (Receives HTML)     │
                         └──────────────────────┘
```

### Why MVC?

✅ **Separation of Concerns**: Each component has a specific responsibility  
✅ **Maintainability**: Easy to update one part without affecting others  
✅ **Testability**: Each component can be tested independently  
✅ **Reusability**: Models and Views can be reused across different controllers  

---

## 📁 Directory Structure Explained

### Application Structure

```
ecommerce-bootstrap/
│
├── app/                          # Core application code
│   ├── Http/
│   │   ├── Controllers/          # CONTROLLERS - Handle requests
│   │   │   ├── HomeController.php
│   │   │   ├── ProductController.php
│   │   │   ├── CartController.php
│   │   │   └── Admin/            # Admin panel controllers
│   │   │
│   │   └── Middleware/           # Request filters (auth, CORS, etc.)
│   │
│   └── Models/                   # MODELS - Database & business logic
│       ├── Product.php
│       ├── Category.php
│       ├── Order.php
│       └── User.php
│
├── resources/
│   └── views/                    # VIEWS - Blade templates (HTML)
│       ├── layouts/
│       │   └── app.blade.php     # Master layout
│       ├── partials/             # Reusable components
│       │   ├── navbar.blade.php
│       │   └── footer.blade.php
│       ├── home.blade.php        # Homepage view
│       └── products/             # Product-related views
│
├── routes/
│   └── web.php                   # ROUTES - URL to Controller mapping
│
├── database/
│   ├── migrations/               # Database schema definitions
│   ├── seeders/                  # Sample data generators
│   └── database.sqlite           # SQLite database file
│
├── public/                       # Publicly accessible files
│   ├── css/                      # Stylesheets
│   ├── js/                       # JavaScript files
│   └── storage/                  # Symlink to storage/app/public
│
└── storage/
    └── app/
        └── public/
            └── products/         # Uploaded product images
```

---

## 🗄️ Database Architecture

### Entity Relationship Diagram

```
┌─────────────────┐
│     users       │
│─────────────────│
│ id              │◄────┐
│ name            │     │
│ email           │     │
│ password        │     │
│ is_admin        │     │
└─────────────────┘     │
                        │
                        │ (one user has many orders)
                        │
┌─────────────────┐     │
│    orders       │     │
│─────────────────│     │
│ id              │     │
│ user_id         │─────┘
│ total           │
│ status          │
│ created_at      │
└────────┬────────┘
         │
         │ (one order has many order_items)
         │
         ▼
┌─────────────────┐     ┌─────────────────┐
│  order_items    │     │    products     │
│─────────────────│     │─────────────────│
│ id              │     │ id              │◄────┐
│ order_id        │     │ category_id     │─────┼─┐
│ product_id      │────►│ name            │     │ │
│ quantity        │     │ slug            │     │ │
│ price           │     │ price           │     │ │
└─────────────────┘     │ stock           │     │ │
                        │ is_active       │     │ │
                        └────────┬────────┘     │ │
                                 │              │ │
                                 │              │ │
                    ┌────────────┘              │ │
                    │                           │ │
                    ▼                           │ │
         ┌─────────────────┐                   │ │
         │ product_images  │                   │ │
         │─────────────────│                   │ │
         │ id              │                   │ │
         │ product_id      │───────────────────┘ │
         │ image_path      │                     │
         │ is_primary      │                     │
         └─────────────────┘                     │
                                                 │
                                                 │
                                    ┌────────────┘
                                    │
                                    │ (category belongs to parent category)
                                    │
                         ┌──────────▼────────┐
                         │   categories      │
                         │───────────────────│
                         │ id                │
                         │ parent_id         │──┐
                         │ name              │  │
                         │ slug              │  │
                         │ is_active         │  │
                         └───────────────────┘  │
                                  ▲              │
                                  └──────────────┘
                                  (self-referencing)
```

### Key Relationships

1. **User ↔ Orders**: One-to-Many (One user can have many orders)
2. **Order ↔ OrderItems**: One-to-Many (One order contains many items)
3. **Product ↔ OrderItems**: One-to-Many (One product can be in many orders)
4. **Product ↔ Category**: Many-to-One (Many products belong to one category)
5. **Product ↔ ProductImages**: One-to-Many (One product has many images)
6. **Category ↔ Category**: Self-referencing (Parent-child categories)

---

## 📦 Models - The Data Layer

### What is a Model?

A **Model** represents a database table and contains:
- Database structure definition
- Relationships with other models
- Business logic
- Data accessors and mutators

### Example: Product Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // ===== MASS ASSIGNMENT PROTECTION =====
    // Only these fields can be mass-assigned
    protected $fillable = [
        'name', 'slug', 'price', 'stock', 'category_id'
    ];
    
    // ===== TYPE CASTING =====
    // Automatically convert database values to PHP types
    protected $casts = [
        'price' => 'decimal:2',      // Convert to decimal with 2 places
        'is_active' => 'boolean',    // Convert 0/1 to true/false
    ];
    
    // ===== RELATIONSHIPS =====
    
    /**
     * Product belongs to Category
     * Many-to-One relationship
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Product has many Images
     * One-to-Many relationship
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    
    // ===== ACCESSORS (Virtual Attributes) =====
    
    /**
     * Get the primary image URL
     * Creates a virtual 'image_url' attribute
     */
    public function getImageUrlAttribute()
    {
        $image = $this->images()->where('is_primary', true)->first();
        return $image ? asset('storage/' . $image->path) : null;
    }
    
    /**
     * Calculate discount percentage
     * Creates a virtual 'discount_percentage' attribute
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->old_price && $this->old_price > $this->price) {
            return round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return null;
    }
    
    // ===== BUSINESS LOGIC METHODS =====
    
    /**
     * Increment product view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}
```

### Key Model Concepts

#### 1. **Mass Assignment**
```php
// With $fillable protection
Product::create([
    'name' => 'Laptop',
    'price' => 50000
]); // ✅ Works - both fields are in $fillable

Product::create([
    'id' => 999  // ❌ Fails - 'id' not in $fillable (security)
]);
```

#### 2. **Relationships**
```php
// Get product's category
$product = Product::find(1);
$category = $product->category;  // Returns Category object
echo $category->name;  // "Laptops"

// Get category's products
$category = Category::find(1);
$products = $category->products;  // Returns Collection of Products
foreach ($products as $product) {
    echo $product->name;
}
```

#### 3. **Accessors (Virtual Attributes)**
```php
$product = Product::find(1);

// These don't exist in database, but are computed on-the-fly
echo $product->image_url;           // "http://domain.com/storage/products/laptop.jpg"
echo $product->discount_percentage; // 25
echo $product->in_stock;            // true
```

---

## 🎮 Controllers - The Logic Layer

### What is a Controller?

A **Controller** handles HTTP requests and:
- Receives input from users
- Calls Models to fetch/save data
- Passes data to Views
- Returns responses (HTML, JSON, redirects)

### Example: HomeController

```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Show the homepage
     * 
     * Route: GET /
     * View: resources/views/home.blade.php
     */
    public function index()
    {
        // ===== FETCH DATA FROM MODELS =====
        
        // Get 8 featured products with their categories and images
        $featuredProducts = Product::with(['category', 'primaryImage'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->inRandomOrder()
            ->limit(8)
            ->get();
        
        // Get 8 newest products
        $newProducts = Product::with(['category', 'primaryImage'])
            ->where('is_active', true)
            ->where('is_new', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        
        // Get active categories
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->get();
        
        // ===== PASS DATA TO VIEW =====
        
        // compact() creates: ['featuredProducts' => $featuredProducts, ...]
        return view('home', compact('featuredProducts', 'newProducts', 'categories'));
    }
}
```

### Controller Methods Explained

#### 1. **Query Building**
```php
// Start a query
$query = Product::query();

// Add conditions
$query->where('is_active', true);
$query->where('price', '>', 1000);

// Add relationships (eager loading)
$query->with(['category', 'images']);

// Execute and get results
$products = $query->get();  // Returns Collection
```

#### 2. **Eager Loading (N+1 Problem Solution)**
```php
// ❌ BAD: N+1 Problem (1 query + N queries for categories)
$products = Product::all();  // 1 query
foreach ($products as $product) {
    echo $product->category->name;  // N queries (one per product)
}
// Total: 1 + 100 = 101 queries for 100 products!

// ✅ GOOD: Eager Loading (1 query + 1 query for categories)
$products = Product::with('category')->get();  // 2 queries total
foreach ($products as $product) {
    echo $product->category->name;  // No additional queries
}
// Total: 2 queries for 100 products!
```

#### 3. **Passing Data to Views**
```php
// Method 1: compact()
return view('home', compact('products', 'categories'));

// Method 2: Array
return view('home', [
    'products' => $products,
    'categories' => $categories
]);

// Method 3: with()
return view('home')
    ->with('products', $products)
    ->with('categories', $categories);
```

---

## 🎨 Views - The Presentation Layer

### What is a View?

A **View** is a Blade template that:
- Receives data from Controllers
- Renders HTML
- Uses Blade syntax for logic and loops

### Blade Template Syntax

```blade
{{-- resources/views/home.blade.php --}}

@extends('layouts.app')  {{-- Inherit from master layout --}}

@section('content')      {{-- Define content section --}}

    <h1>Welcome to EEZEPC</h1>
    
    {{-- Display variable (escaped for security) --}}
    <p>{{ $message }}</p>
    
    {{-- Display HTML (unescaped - use carefully!) --}}
    <div>{!! $htmlContent !!}</div>
    
    {{-- Conditional statements --}}
    @if($products->count() > 0)
        <p>We have {{ $products->count() }} products</p>
    @else
        <p>No products available</p>
    @endif
    
    {{-- Loops --}}
    @foreach($products as $product)
        <div class="product-card">
            <h3>{{ $product->name }}</h3>
            <p>Price: Rs. {{ number_format($product->price) }}</p>
            
            {{-- Access relationships --}}
            <span>Category: {{ $product->category->name }}</span>
            
            {{-- Access accessors --}}
            @if($product->discount_percentage)
                <span class="badge">{{ $product->discount_percentage }}% OFF</span>
            @endif
            
            {{-- Display image --}}
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
        </div>
    @endforeach
    
    {{-- Include partial views --}}
    @include('partials.footer')

@endsection
```

### Layout Inheritance

**Master Layout** (`layouts/app.blade.php`):
```blade
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'EEZEPC')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('partials.navbar')
    
    <main>
        @yield('content')  {{-- Child views inject content here --}}
    </main>
    
    @include('partials.footer')
    
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')  {{-- Child views can push scripts here --}}
</body>
</html>
```

**Child View** (`home.blade.php`):
```blade
@extends('layouts.app')

@section('title', 'Home - EEZEPC')

@section('content')
    <h1>Homepage Content</h1>
@endsection

@push('scripts')
    <script>
        console.log('Homepage specific script');
    </script>
@endpush
```

---

## 🛣️ Routes - The Entry Points

### What are Routes?

**Routes** map URLs to Controller methods.

### Route Definition (`routes/web.php`)

```php
<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

// ===== BASIC ROUTES =====

// GET request to homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// GET request to about page
Route::get('/about', function () {
    return view('about');
});

// ===== RESOURCE ROUTES (CRUD) =====

// Automatically creates 7 routes for products:
// GET    /products           -> index()   (list all)
// GET    /products/create    -> create()  (show create form)
// POST   /products           -> store()   (save new)
// GET    /products/{id}      -> show()    (show one)
// GET    /products/{id}/edit -> edit()    (show edit form)
// PUT    /products/{id}      -> update()  (save changes)
// DELETE /products/{id}      -> destroy() (delete)
Route::resource('products', ProductController::class);

// ===== ROUTE PARAMETERS =====

// {slug} is a parameter passed to the controller
Route::get('/products/{slug}', [ProductController::class, 'show'])
    ->name('products.show');

// Multiple parameters
Route::get('/category/{category}/product/{product}', function ($category, $product) {
    return "Category: $category, Product: $product";
});

// ===== ROUTE GROUPS =====

// Group routes with common prefix
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/products', [AdminController::class, 'products']);
    // URLs: /admin/dashboard, /admin/products
});

// Group routes with middleware (authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
});

// ===== NAMED ROUTES =====

// Define a name for the route
Route::get('/contact', [ContactController::class, 'show'])->name('contact');

// Use in views:
// <a href="{{ route('contact') }}">Contact Us</a>

// Use in controllers:
// return redirect()->route('contact');
```

### Route-Controller-View Flow

```
User visits: http://domain.com/products/gaming-laptop

         ↓

Route matches: /products/{slug}
               ↓
         ProductController@show($slug)
               ↓
         $product = Product::where('slug', $slug)->first();
               ↓
         return view('products.show', compact('product'));
               ↓
         resources/views/products/show.blade.php
               ↓
         Rendered HTML sent to browser
```

---

## 🔑 Key Features Implementation

### 1. Product Search (AJAX)

**Route:**
```php
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
```

**Controller:**
```php
public function search(Request $request)
{
    $searchTerm = $request->get('q');
    
    // For AJAX requests, return JSON
    if ($request->ajax()) {
        $products = Product::where('name', 'like', "%{$searchTerm}%")
            ->limit(10)
            ->get();
        
        return response()->json($products);
    }
    
    // For regular requests, redirect to products page
    return redirect()->route('products.index', ['search' => $searchTerm]);
}
```

**JavaScript (public/js/custom.js):**
```javascript
// Listen for input in search box
$('#searchInput').on('keyup', function() {
    let query = $(this).val();
    
    if (query.length < 2) {
        $('#searchResults').hide();
        return;
    }
    
    // Send AJAX request
    $.ajax({
        url: '/search',
        method: 'GET',
        data: { q: query, ajax: true },
        success: function(products) {
            displayResults(products);
        }
    });
});

function displayResults(products) {
    let html = '';
    products.forEach(product => {
        html += `
            <a href="/products/${product.slug}" class="search-result-item">
                <img src="${product.image_url}" alt="${product.name}">
                <div>
                    <div>${product.name}</div>
                    <div>Rs. ${product.price}</div>
                </div>
            </a>
        `;
    });
    $('#searchResults').html(html).show();
}
```

### 2. Shopping Cart (Session-based)

**Controller:**
```php
public function addToCart(Request $request, $id)
{
    $product = Product::findOrFail($id);
    
    // Get cart from session (or create empty array)
    $cart = session()->get('cart', []);
    
    // If product already in cart, increment quantity
    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        // Add new product to cart
        $cart[$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image_url
        ];
    }
    
    // Save cart back to session
    session()->put('cart', $cart);
    
    return response()->json([
        'success' => true,
        'message' => 'Product added to cart',
        'cart_count' => count($cart)
    ]);
}
```

### 3. Image Upload (Admin Panel)

**Controller:**
```php
public function store(Request $request)
{
    // Validate request
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
    ]);
    
    // Create product
    $product = Product::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'price' => $request->price,
        'category_id' => $request->category_id
    ]);
    
    // Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        
        // Store in storage/app/public/products
        $path = $image->store('products', 'public');
        
        // Create product image record
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $path,
            'is_primary' => true
        ]);
    }
    
    return redirect()->route('admin.products.index')
        ->with('success', 'Product created successfully');
}
```

---

## 🧩 Laravel Concepts Used

### 1. **Eloquent ORM**
Object-Relational Mapping for database interactions.

```php
// Instead of raw SQL:
$products = DB::select('SELECT * FROM products WHERE is_active = 1');

// Use Eloquent:
$products = Product::where('is_active', true)->get();
```

### 2. **Query Builder**
Fluent interface for building database queries.

```php
$products = Product::query()
    ->where('is_active', true)
    ->where('price', '>', 1000)
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();
```

### 3. **Collections**
Powerful array manipulation.

```php
$products = Product::all();  // Returns Collection

// Filter
$featured = $products->where('is_featured', true);

// Map (transform)
$names = $products->pluck('name');  // ['Laptop', 'Mouse', ...]

// Count
$count = $products->count();

// Sum
$total = $products->sum('price');

// Group by
$grouped = $products->groupBy('category_id');
```

### 4. **Middleware**
Request filtering.

```php
// In routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// Request flow:
// User Request → Middleware (check if logged in) → Controller
//                      ↓ (if not logged in)
//                Redirect to login
```

### 5. **Validation**
Input validation.

```php
$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'price' => 'required|numeric|min:0',
    'image' => 'image|mimes:jpeg,png|max:2048'
]);
```

### 6. **Blade Templating**
Template engine for views.

```blade
{{-- Variables --}}
{{ $product->name }}

{{-- Conditionals --}}
@if($product->in_stock)
    <button>Add to Cart</button>
@endif

{{-- Loops --}}
@foreach($products as $product)
    <div>{{ $product->name }}</div>
@endforeach

{{-- Components --}}
@include('partials.navbar')
```

---

## 💡 Code Patterns & Best Practices

### 1. **Repository Pattern** (Simplified)

Instead of querying directly in controllers:

```php
// ❌ Not ideal: Controller has database logic
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('products.index', compact('products'));
    }
}

// ✅ Better: Extract to repository
class ProductRepository
{
    public function getActiveProducts($perPage = 12)
    {
        return Product::where('is_active', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}

class ProductController extends Controller
{
    protected $productRepo;
    
    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }
    
    public function index()
    {
        $products = $this->productRepo->getActiveProducts();
        return view('products.index', compact('products'));
    }
}
```

### 2. **Service Layer** (For Complex Business Logic)

```php
// app/Services/OrderService.php
class OrderService
{
    public function createOrder($userId, $cartItems)
    {
        // Start database transaction
        DB::beginTransaction();
        
        try {
            // Create order
            $order = Order::create([
                'user_id' => $userId,
                'total' => $this->calculateTotal($cartItems),
                'status' => 'pending'
            ]);
            
            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
                
                // Reduce stock
                Product::find($item['product_id'])->decrement('stock', $item['quantity']);
            }
            
            // Commit transaction
            DB::commit();
            
            return $order;
        } catch (\Exception $e) {
            // Rollback on error
            DB::rollback();
            throw $e;
        }
    }
}
```

### 3. **Resource Controllers** (RESTful)

```php
// Automatically handles CRUD operations
Route::resource('products', ProductController::class);

// Generates these routes:
// GET    /products           -> index()
// GET    /products/create    -> create()
// POST   /products           -> store()
// GET    /products/{id}      -> show()
// GET    /products/{id}/edit -> edit()
// PUT    /products/{id}      -> update()
// DELETE /products/{id}      -> destroy()
```

### 4. **Form Requests** (Validation)

```php
// app/Http/Requests/StoreProductRequest.php
class StoreProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ];
    }
}

// In controller
public function store(StoreProductRequest $request)
{
    // Request is already validated
    $product = Product::create($request->validated());
    return redirect()->route('products.index');
}
```

---

## 🎓 Learning Path

### For Beginners:

1. **Start with Routes** → Understand URL mapping
2. **Learn Controllers** → Handle requests and responses
3. **Study Models** → Database interactions
4. **Master Views** → Blade templating
5. **Practice CRUD** → Create, Read, Update, Delete

### Key Files to Study:

1. `routes/web.php` - See all available URLs
2. `app/Models/Product.php` - Understand model structure
3. `app/Http/Controllers/HomeController.php` - Simple controller example
4. `resources/views/home.blade.php` - View rendering
5. `database/migrations/` - Database structure

---

## 📚 Additional Resources

### Laravel Documentation
- [Laravel Official Docs](https://laravel.com/docs)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Blade Templates](https://laravel.com/docs/blade)

### Video Tutorials
- [Laracasts](https://laracasts.com) - Premium Laravel screencasts
- [Laravel Daily](https://www.youtube.com/c/LaravelDaily) - Free YouTube tutorials

---

## 🎯 Summary

### MVC in EEZEPC:

**Model (Product.php)**
- Defines database structure
- Contains relationships
- Provides accessors for computed attributes

**Controller (ProductController.php)**
- Receives HTTP requests
- Queries models for data
- Passes data to views
- Returns responses

**View (products/index.blade.php)**
- Receives data from controller
- Renders HTML using Blade syntax
- Displays data to user

### Data Flow:
```
User Request → Route → Controller → Model → Database
                                      ↓
User Browser ← View ← Controller ← Model
```

---

**Happy Coding!** 🚀

For questions or clarifications, refer to the inline comments in the actual code files or consult the Laravel documentation.
