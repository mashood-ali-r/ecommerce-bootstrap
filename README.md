# EEZEPC - Premium E-Commerce Platform

Welcome to **EEZEPC**, a modern, full-featured e-commerce application built with Laravel and Bootstrap 5. Designed with a sleek, Amazon-inspired aesthetic, it offers a seamless shopping experience and a powerful admin panel for store management.

---

## 🚀 Key Features

### 🛒 Customer Experience (Frontend)
*   **Modern UI/UX:** A responsive, "Amazon-style" design featuring glassmorphism, soft shadows, and a clean layout.
*   **Dynamic Product Browsing:**
    *   **Categories:** dedicated page with grid view and hover effects.
    *   **Search & Filtering:** Real-time search and sidebar filters (Price, Category) that handle both IDs and Slugs.
    *   **Product Details:** Rich product pages with image galleries, specifications, and related products.
*   **Smart Cart System:**
    *   **AJAX-powered:** Add to cart and update quantities instantly without page reloads.
    *   **Dynamic Totaling:** Prices update automatically as you adjust quantities.
*   **Wishlist:**
    *   Pin products to your wishlist for later.
    *   Move items directly from Wishlist to Cart.
*   **User Accounts:**
    *   Secure Login/Registration.
    *   Order Tracking & History.
    *   Profile Management.

### 🛠️ Admin Panel (Backend)
*   **Dashboard:** Real-time metrics on Sales, Orders, and Customers.
*   **Product Management:** Full CRUD (Create, Read, Update, Delete) for products.
    *   Image uploading & gallery management.
    *   Stock tracking.
    *   Featured/Deal status toggles.
*   **Category Management:** Organize products into hierarchical categories.
*   **Order Management:** View and process customer orders.

---

## 🛠️ Tech Stack

*   **Framework:** [Laravel 10](https://laravel.com)
*   **Frontend:** Blade Templates, Bootstrap 5, Vanilla CSS/JS
*   **Database:** SQLite (Default for portability) / MySQL (Supported)
*   **Scripting:** jQuery (for AJAX operations)

---

## 🔑 Admin Credentials

To access the Admin Panel, use the following pre-seeded credentials:

*   **URL:** `/login`
*   **Email:** `admin@eezepc.com`
*   **Password:** `admin123`

---

## 💿 Installation & Setup

### Option A: Portable Mode (USB / Plug & Play)
**Recommended for Evaluation:** This project is designed to run directly from a USB drive without installing anything on the host computer.

1.  **Read the Guide:** Open `PORTABLE_GUIDE.md` for detailed instructions.
2.  **Quick Start:**
    *   Open the `ecommerce-bootstrap` folder.
    *   Double-click `start_portable.bat`.
    *   The app will launch automatically in your browser.

### Option B: Standard Developer Setup
If you want to install this on your local development machine:

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/mashood-ali-r/ecommerce-bootstrap.git
    cd ecommerce-bootstrap
    ```

2.  **Install Dependencies:**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Environment Setup:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *   *Note:* Ensure `.env` is configured for your database (SQLite is default).

4.  **Database Migration & Seeding:**
    ```bash
    touch database/database.sqlite  # (If using SQLite)
    php artisan migrate --seed
    ```

5.  **Run the Server:**
    ```bash
    php artisan serve
    ```
    Visit `http://127.0.0.1:8000`.

---

## 📂 Project Structure

*   `app/Models`: Eloquent models (Product, Category, Order, User).
*   `app/Http/Controllers`: Business logic (Admin controllers, Shop controllers).
*   `resources/views`: Blade templates.
    *   `layouts`: Main app shell (`app.blade.php`).
    *   `partials`: Reusable components (Header, Footer, Product Cards).
    *   `products`: Storefront views.
    *   `admin`: Backend administration views.

---

## 📜 License
This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
