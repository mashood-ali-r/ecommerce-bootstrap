# EEZEPC - Premium E-Commerce Platform

Welcome to **EEZEPC**, a modern, full-featured e-commerce application built with Laravel and Bootstrap 5. Designed with a sleek, **Amazon-inspired aesthetic**, it offers a seamless shopping experience and a powerful admin panel for store management.

---

## 🚀 Key Features

### 🛒 Customer Experience (Frontend)

#### **Modern Amazon-Style UI/UX**
*   **Premium Navigation Bar:**
    *   Sleek dark header with Amazon-style logo, location selector, and country/language picker
    *   Integrated search bar with category filtering
    *   Quick access to account, orders, and shopping cart
*   **Enhanced Sub-Navigation:**
    *   Premium gradient background with orange accent lines
    *   Icon-enhanced links for Today's Deals, Wishlist, and product categories
    *   Smooth hover effects with glowing animations and gradient underlines
    *   Pulsing "Deals" indicator and dynamic wishlist badge counter
*   **Responsive Design:** Glassmorphism, soft shadows, and clean layouts that adapt to all screen sizes

#### **Dynamic Product Browsing**
*   **Categories:** Dedicated page with grid view and interactive hover effects
*   **Search & Filtering:** 
    *   Real-time search with instant results dropdown
    *   Advanced sidebar filters (Price range, Category)
    *   Handles both category IDs and slugs seamlessly
*   **Product Details:** 
    *   Rich product pages with image galleries
    *   Detailed specifications and descriptions
    *   Related products suggestions
    *   "Add to Cart" and "Add to Wishlist" functionality

#### **Smart Cart System**
*   **AJAX-Powered:** Add to cart and update quantities instantly without page reloads
*   **Dynamic Totaling:** Prices and totals update automatically as you adjust quantities
*   **Persistent Storage:** Cart data saved in session for seamless browsing
*   **Visual Feedback:** Animated cart badge updates

#### **Wishlist Management**
*   Pin favorite products to your wishlist for later
*   Move items directly from Wishlist to Cart with one click
*   Persistent wishlist storage per user account
*   Visual wishlist count badge in navigation

#### **User Accounts**
*   Secure Login/Registration with Laravel authentication
*   Order Tracking & Complete Order History
*   Profile Management and account settings
*   Guest checkout option available

#### **Special Features**
*   **Deal of the Day:** Rotating carousel showcasing featured deals
*   **New Arrivals:** Highlighted section for latest products
*   **Today's Deals Page:** Dedicated page for all active deals
*   **Contact Information:** Easy access to phone and email support

---

### 🛠️ Admin Panel (Backend)

*   **Dashboard:** Real-time metrics on Sales, Orders, and Customers
*   **Product Management:** 
    *   Full CRUD (Create, Read, Update, Delete) for products
    *   Image uploading & gallery management
    *   Stock tracking and inventory management
    *   Featured/Deal status toggles
    *   Bulk operations support
*   **Category Management:** 
    *   Hierarchical category organization
    *   Parent-child category relationships
    *   Category icons and descriptions
*   **Order Management:** 
    *   View and process customer orders
    *   Order status updates
    *   Customer information and order details

---

## 🛠️ Tech Stack

*   **Framework:** [Laravel 10](https://laravel.com)
*   **Frontend:** Blade Templates, Bootstrap 5, Vanilla CSS/JS
*   **Database:** SQLite (Default for portability) / MySQL (Supported)
*   **Icons:** Font Awesome 6
*   **Scripting:** jQuery (for AJAX operations)
*   **Styling:** Custom CSS with Amazon-inspired design patterns

---

## 🔑 Admin Credentials

To access the Admin Panel, use the following pre-seeded credentials:

*   **Login URL:** `http://127.0.0.1:8000/login`
*   **Email:** `admin@eezepc.com`
*   **Password:** `admin123`

---

## 📞 Contact Information

The application displays the following contact details:

*   **Phone:** (0302) 0274115
*   **Help Email:** help@eezepc.com
*   **Sales Email:** sales@eezepc.com
*   **Business Hours:** Monday – Saturday: 11:00 A.M – 6:00 P.M

---

## 💿 Installation & Setup

### Option A: Portable Mode (USB / Plug & Play) ⭐ RECOMMENDED

**Perfect for Evaluation & Demos:** This project is designed to run directly from a USB drive without installing anything on the host computer.

1.  **Read the Comprehensive Guide:** Open `PORTABLE_GUIDE.md` for detailed step-by-step instructions
2.  **Quick Start:**
    *   Plug in your USB drive
    *   Open the `ecommerce-bootstrap` folder
    *   Double-click `start_portable.bat`
    *   The app will launch automatically in your browser at `http://127.0.0.1:8000`

**What You Need on Your USB:**
*   Portable PHP folder (see PORTABLE_GUIDE.md for download instructions)
*   This project folder (`ecommerce-bootstrap`)
*   SQLite database (included in `database/database.sqlite`)

---

### Option B: Standard Developer Setup

If you want to install this on your local development machine with full development tools:

#### **Prerequisites**
*   PHP 8.1 or higher
*   Composer
*   Node.js & NPM
*   SQLite or MySQL

#### **Installation Steps**

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/mashood-ali-r/ecommerce-bootstrap.git
    cd ecommerce-bootstrap
    ```

2.  **Install PHP Dependencies:**
    ```bash
    composer install
    ```

3.  **Install Frontend Dependencies:**
    ```bash
    npm install
    npm run build
    ```

4.  **Environment Setup:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    
    **For SQLite (Recommended for portability):**
    ```bash
    # Ensure DB_CONNECTION is set to sqlite in .env
    # Comment out or remove MySQL-specific settings
    ```
    
    **For MySQL:**
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=eezepc
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Database Setup:**
    
    **For SQLite:**
    ```bash
    # Create the database file
    touch database/database.sqlite
    
    # Run migrations and seed data
    php artisan migrate --seed
    ```
    
    **For MySQL:**
    ```bash
    # Create the database first in MySQL
    # Then run migrations
    php artisan migrate --seed
    ```

6.  **Create Storage Link:**
    ```bash
    php artisan storage:link
    ```
    This creates a symbolic link from `public/storage` to `storage/app/public` for product images.

7.  **Run the Development Server:**
    ```bash
    php artisan serve
    ```
    Visit `http://127.0.0.1:8000` in your browser.

8.  **Optional - Run with Custom Port:**
    ```bash
    php artisan serve --port=8080
    ```

---

## 📂 Project Structure

```
ecommerce-bootstrap/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin panel controllers
│   │   │   ├── CartController.php
│   │   │   ├── ProductController.php
│   │   │   ├── WishlistController.php
│   │   │   └── ...
│   │   └── Middleware/
│   └── Models/
│       ├── Product.php
│       ├── Category.php
│       ├── Order.php
│       ├── User.php
│       └── ...
├── database/
│   ├── migrations/             # Database schema
│   ├── seeders/                # Sample data seeders
│   └── database.sqlite         # SQLite database file
├── public/
│   ├── css/                    # Custom stylesheets
│   ├── js/                     # Custom JavaScript
│   └── storage/                # Symlink to storage/app/public
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php   # Main layout template
│       ├── partials/
│       │   ├── navbar.blade.php    # Navigation bar
│       │   ├── footer.blade.php    # Footer
│       │   ├── topbar.blade.php    # Top bar
│       │   └── ...
│       ├── products/           # Product pages
│       ├── admin/              # Admin panel views
│       ├── cart/               # Shopping cart
│       ├── wishlist/           # Wishlist pages
│       └── home.blade.php      # Homepage
├── routes/
│   └── web.php                 # Application routes
├── storage/
│   └── app/
│       └── public/
│           └── products/       # Product images stored here
├── .env                        # Environment configuration
├── start_portable.bat          # Portable launcher script
├── README.md                   # This file
└── PORTABLE_GUIDE.md           # Portable setup guide
```

---

## 🎨 Design Features

### Amazon-Inspired Aesthetics
*   **Color Scheme:** Dark navy header (#131921), Amazon orange (#FF9900, #FEBD69)
*   **Typography:** Clean, readable fonts with proper hierarchy
*   **Hover Effects:** Smooth transitions, glowing effects, and gradient animations
*   **Icons:** Font Awesome icons with dynamic category mapping
*   **Responsive:** Mobile-first design that works on all devices

### Premium Navigation Features
*   Gradient backgrounds with subtle animations
*   Icon-enhanced category links with smart icon mapping
*   Pulsing glow effect on "Today's Deals"
*   Animated wishlist badge counter
*   Smooth hover states with lift effects
*   Orange gradient underlines on active links

---

## 🗄️ Database Information

### SQLite (Default)
*   **Location:** `database/database.sqlite`
*   **Advantages:** 
    *   No server setup required
    *   Perfect for portable/USB deployment
    *   Single file database - easy to backup
    *   Included in the project

### MySQL (Alternative)
*   Configure in `.env` file
*   Requires MySQL server installation
*   Better for production deployments

### Seeded Data
The database comes pre-populated with:
*   Admin user account
*   Sample product categories
*   Demo products with images
*   Sample orders

---

## 🖼️ Image Management

### Product Images
*   **Storage Location:** `storage/app/public/products/`
*   **Public Access:** Via symlink at `public/storage/products/`
*   **Upload Method:** Admin panel product management
*   **Supported Formats:** JPG, PNG, WebP
*   **Automatic Optimization:** Images are processed on upload

### Image Portability
When moving the application to another computer:
*   All product images are stored in `storage/app/public/products/`
*   The storage link must be recreated: `php artisan storage:link`
*   For portable USB deployment, images travel with the database
*   See `PORTABLE_GUIDE.md` for detailed image handling instructions

---

## 🚀 Deployment Checklist

Before deploying or sharing the application:

- [ ] Clear application cache: `php artisan cache:clear`
- [ ] Clear configuration cache: `php artisan config:clear`
- [ ] Clear view cache: `php artisan view:clear`
- [ ] Clear route cache: `php artisan route:clear`
- [ ] Delete old logs: Remove files from `storage/logs/`
- [ ] Verify `.env` settings are correct
- [ ] Ensure `database/database.sqlite` exists and has data
- [ ] Verify storage link exists: `php artisan storage:link`
- [ ] Test admin login credentials
- [ ] Check that product images display correctly

---

## 🔧 Troubleshooting

### Common Issues

**Issue:** Product images not displaying
*   **Solution:** Run `php artisan storage:link` to create the storage symlink

**Issue:** Database errors on startup
*   **Solution:** Ensure `database/database.sqlite` exists and run `php artisan migrate --seed`

**Issue:** Permission errors
*   **Solution:** Ensure `storage/` and `bootstrap/cache/` directories are writable

**Issue:** Portable mode not starting
*   **Solution:** Check that `php` folder exists at `../php` relative to project folder

**Issue:** Search not working
*   **Solution:** Clear cache with `php artisan cache:clear` and `php artisan config:clear`

---

## 📝 Recent Updates

### Latest Changes (December 2025)
*   ✅ Enhanced sub-navigation with premium Amazon-style design
*   ✅ Added gradient backgrounds and glow effects
*   ✅ Implemented icon-enhanced category links with dynamic mapping
*   ✅ Added pulsing animation to "Today's Deals"
*   ✅ Integrated animated wishlist badge counter
*   ✅ Improved hover effects with smooth transitions
*   ✅ Updated contact phone number to (0302) 0274115
*   ✅ Optimized responsive design for mobile devices
*   ✅ Enhanced search functionality with better UX
*   ✅ Improved product image handling and storage

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1.  Fork the repository
2.  Create your feature branch (`git checkout -b feature/AmazingFeature`)
3.  Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4.  Push to the branch (`git push origin feature/AmazingFeature`)
5.  Open a Pull Request

---

## 📜 License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👨‍💻 Author

**Mashood Ali**
*   GitHub: [@mashood-ali-r](https://github.com/mashood-ali-r)

---

## 🙏 Acknowledgments

*   Laravel Framework
*   Bootstrap 5
*   Font Awesome
*   Amazon.com for design inspiration

---

**Need Help?** Check out `PORTABLE_GUIDE.md` for portable deployment instructions or open an issue on GitHub.
