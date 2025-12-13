# 🚀 EEZEPC Portable USB Deployment Guide

This comprehensive guide explains how to run the **EEZEPC E-Commerce Platform** directly from a USB drive on any Windows computer **without installing anything**. Perfect for demos, presentations, or portable development.

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [What You Need](#what-you-need)
3. [Directory Structure](#directory-structure)
4. [Step-by-Step Setup](#step-by-step-setup)
5. [How Product Images Work](#how-product-images-work)
6. [Running on Another Computer](#running-on-another-computer)
7. [Troubleshooting](#troubleshooting)
8. [Pre-Deployment Checklist](#pre-deployment-checklist)
9. [Technical Details](#technical-details)

---

## 🎯 Overview

### What is Portable Mode?

Portable mode allows you to run the entire EEZEPC application from a USB drive without:
*   Installing XAMPP, WAMP, or any web server
*   Installing MySQL or any database server
*   Installing PHP on the host computer
*   Requiring administrator privileges
*   Making any changes to the host computer

### How It Works

The application uses:
*   **Portable PHP:** A standalone PHP runtime that runs directly from the USB
*   **SQLite Database:** A single-file database (`database.sqlite`) that travels with your USB
*   **Built-in Server:** Laravel's built-in development server (no Apache/Nginx needed)
*   **Batch Script:** Automated launcher (`start_portable.bat`) that handles everything

---

## 📦 What You Need

### Required Components

1.  **USB Drive**
    *   Minimum 2GB free space
    *   USB 3.0 recommended for better performance
    *   Formatted as NTFS or FAT32

2.  **Portable PHP**
    *   PHP 8.1, 8.2, or 8.3 (Thread Safe version)
    *   Downloaded as a ZIP file (no installation required)
    *   Size: ~30-40MB

3.  **EEZEPC Project Folder**
    *   The complete `ecommerce-bootstrap` directory
    *   Includes all code, database, and images
    *   Size: ~50-100MB (depending on product images)

### Host Computer Requirements

The computer where you'll run the USB drive needs:
*   Windows 7 or later (Windows 10/11 recommended)
*   No special software installed
*   USB port
*   Web browser (Chrome, Firefox, Edge, etc.)

---

## 📁 Directory Structure

Your USB drive should be organized like this:

```
USB_DRIVE:\
├── php\                          ← Portable PHP binaries
│   ├── php.exe                   ← PHP executable
│   ├── php.ini                   ← PHP configuration
│   ├── ext\                      ← PHP extensions
│   └── ...
│
└── ecommerce-bootstrap\          ← Your project folder
    ├── app\                      ← Application code
    ├── database\
    │   └── database.sqlite       ← SQLite database (contains all data)
    ├── public\
    │   └── storage\              ← Symlink to storage/app/public
    ├── storage\
    │   └── app\
    │       └── public\
    │           └── products\     ← Product images stored here
    ├── .env                      ← Environment configuration
    ├── start_portable.bat        ← Launcher script
    └── ...
```

### Important Notes:
*   The `php` folder must be at the **same level** as `ecommerce-bootstrap`
*   The `start_portable.bat` script must be **inside** the `ecommerce-bootstrap` folder
*   Product images are in `storage/app/public/products/`

---

## 🛠️ Step-by-Step Setup

### Step 1: Download Portable PHP

1.  **Visit the PHP Download Page:**
    *   Go to: [windows.php.net/download](https://windows.php.net/download/)

2.  **Choose the Correct Version:**
    *   Select **PHP 8.2** or **PHP 8.3**
    *   Download the **VS16 x64 Thread Safe** ZIP file
    *   Example: `php-8.2.x-Win32-vs16-x64.zip`

3.  **Extract PHP to USB:**
    *   Extract the ZIP file
    *   Create a folder named `php` at the root of your USB drive
    *   Copy all extracted files into the `php` folder
    *   Verify that `php.exe` is at `USB_DRIVE:\php\php.exe`

### Step 2: Configure PHP

1.  **Create php.ini:**
    *   Navigate to `USB_DRIVE:\php\`
    *   Find the file `php.ini-development`
    *   Copy it and rename the copy to `php.ini`

2.  **Enable Required Extensions:**
    *   Open `php.ini` in a text editor (Notepad++ recommended)
    *   Find and **uncomment** (remove the `;` at the start) these lines:

    ```ini
    extension_dir = "ext"
    extension=curl
    extension=fileinfo
    extension=mbstring
    extension=openssl
    extension=pdo_sqlite
    extension=sqlite3
    extension=zip
    ```

3.  **Save and Close** the `php.ini` file

### Step 3: Prepare the Project

1.  **Copy Project to USB:**
    *   Copy the entire `ecommerce-bootstrap` folder to your USB drive
    *   Place it at the root level (same level as the `php` folder)

2.  **Configure Environment:**
    *   Open `ecommerce-bootstrap\.env` in a text editor
    *   Ensure these settings are configured:

    ```ini
    APP_NAME="EEZEPC"
    APP_ENV=local
    APP_DEBUG=true
    APP_URL=http://127.0.0.1:8000

    # Database Configuration for SQLite
    DB_CONNECTION=sqlite
    # DB_HOST=127.0.0.1        ← Comment out or remove
    # DB_PORT=3306             ← Comment out or remove
    # DB_DATABASE=laravel      ← Comment out or remove
    # DB_USERNAME=root         ← Comment out or remove
    # DB_PASSWORD=             ← Comment out or remove
    ```

3.  **Verify Database File:**
    *   Check that `ecommerce-bootstrap\database\database.sqlite` exists
    *   This file contains all your products, categories, orders, and users
    *   Size should be several MB if it contains data

### Step 4: Verify Storage Link

The storage link connects `public/storage` to `storage/app/public` for image access.

**On Windows (if not already created):**
```bash
# Navigate to project folder
cd ecommerce-bootstrap

# Create the symbolic link
php artisan storage:link
```

**Note:** The `start_portable.bat` script will attempt to create this link automatically if it doesn't exist.

---

## 🖼️ How Product Images Work

### Image Storage Architecture

```
ecommerce-bootstrap\
├── public\
│   └── storage\                  ← Symbolic link (shortcut)
│       └── products\             ← Points to storage/app/public/products
│
└── storage\
    └── app\
        └── public\
            └── products\         ← ACTUAL image files stored here
                ├── product1.jpg
                ├── product2.png
                └── ...
```

### How Images Are Accessed

1.  **Admin uploads image** via the admin panel
2.  **Laravel saves image** to `storage/app/public/products/`
3.  **Symbolic link** makes it accessible at `public/storage/products/`
4.  **Web pages reference** images as `/storage/products/image.jpg`
5.  **Browser displays** the image

### Image Portability on USB

✅ **Good News:** All images travel with your USB drive!

*   Images are stored in `storage/app/public/products/`
*   This folder is part of your project directory
*   When you copy the project to USB, images come with it
*   The database (`database.sqlite`) contains image paths
*   Everything is self-contained

### When Moving to Another Computer

**What Happens:**
1.  You plug USB into a new computer
2.  Run `start_portable.bat`
3.  The script checks for the storage link
4.  If missing, it creates the link automatically
5.  All images display correctly

**Manual Link Creation (if needed):**
```bash
# From the ecommerce-bootstrap folder
..\php\php.exe artisan storage:link
```

### Image Path Examples

**Database stores:**
```
products/lenovo-laptop.jpg
products/gaming-mouse.png
```

**Web pages use:**
```html
<img src="/storage/products/lenovo-laptop.jpg">
```

**Actual file location:**
```
storage/app/public/products/lenovo-laptop.jpg
```

**Accessed via symlink:**
```
public/storage/products/lenovo-laptop.jpg
```

---

## 💻 Running on Another Computer

### Quick Start (Plug & Play)

1.  **Plug in USB Drive**
    *   Insert your USB drive into any Windows computer
    *   Wait for Windows to recognize it (usually drive letter E:, F:, etc.)

2.  **Navigate to Project Folder**
    *   Open File Explorer
    *   Go to your USB drive
    *   Open the `ecommerce-bootstrap` folder

3.  **Launch the Application**
    *   Find `start_portable.bat` inside the folder
    *   **Double-click** `start_portable.bat`
    *   A command prompt window will open

4.  **Wait for Automatic Launch**
    *   The script will:
        *   Detect the PHP installation
        *   Check the database
        *   Create storage link if needed
        *   Start the Laravel server
        *   Open your default web browser
    *   Your browser will open to `http://127.0.0.1:8000`

5.  **Start Using the Application**
    *   The homepage will load
    *   You can browse products, add to cart, etc.
    *   Login as admin: `admin@eezepc.com` / `admin123`

### What the Script Does

The `start_portable.bat` script automatically:

```batch
1. Checks if PHP exists at ..\php\php.exe
2. Verifies database.sqlite exists
3. Creates database if missing (runs migrations & seeders)
4. Creates storage link if missing
5. Clears Laravel caches
6. Starts the development server on port 8000
7. Opens http://127.0.0.1:8000 in your browser
```

### Stopping the Application

**To stop the server:**
1.  Go to the command prompt window
2.  Press `Ctrl + C`
3.  Type `Y` and press Enter
4.  The server will stop

**Or simply:**
*   Close the command prompt window
*   The server stops automatically

---

## 🔧 Troubleshooting

### Issue: "PHP not found" Error

**Symptoms:**
```
Error: PHP executable not found at ..\php\php.exe
```

**Solutions:**
1.  Verify the `php` folder exists at the USB root
2.  Check that `php.exe` is inside the `php` folder
3.  Ensure you're running `start_portable.bat` from **inside** the `ecommerce-bootstrap` folder

**Directory Check:**
```
USB_DRIVE:\
├── php\
│   └── php.exe  ← Must exist here
└── ecommerce-bootstrap\
    └── start_portable.bat  ← Run from here
```

---

### Issue: Product Images Not Displaying

**Symptoms:**
*   Products show but images are broken
*   404 errors for `/storage/products/...`

**Solutions:**

1.  **Recreate Storage Link:**
    ```bash
    # From ecommerce-bootstrap folder
    ..\php\php.exe artisan storage:link
    ```

2.  **Verify Image Files Exist:**
    *   Check `storage\app\public\products\`
    *   Ensure image files are present

3.  **Check Symlink:**
    *   Look for `public\storage` folder
    *   It should be a shortcut/link (not a regular folder)
    *   On Windows, it appears with a shortcut arrow

4.  **Permissions (Advanced):**
    *   Ensure USB drive is not write-protected
    *   Try running as administrator (right-click `start_portable.bat` → Run as administrator)

---

### Issue: Database Errors

**Symptoms:**
```
SQLSTATE[HY000]: General error: 1 no such table: products
```

**Solutions:**

1.  **Database Missing:**
    *   Check if `database\database.sqlite` exists
    *   If missing, the script should create it automatically

2.  **Recreate Database:**
    ```bash
    # Delete old database
    del database\database.sqlite

    # Run migrations and seeders
    ..\php\php.exe artisan migrate --seed
    ```

3.  **Database Corrupted:**
    *   Restore from backup if available
    *   Or recreate using migrations

---

### Issue: Port 8000 Already in Use

**Symptoms:**
```
Address already in use
```

**Solutions:**

1.  **Close Other Instances:**
    *   Check if another `start_portable.bat` is running
    *   Close all command prompt windows
    *   Try again

2.  **Use Different Port:**
    *   Edit `start_portable.bat`
    *   Change `8000` to `8080` or another port:
    ```batch
    "%PHP_PATH%" artisan serve --port=8080
    ```

3.  **Kill Process:**
    ```bash
    # Find process using port 8000
    netstat -ano | findstr :8000

    # Kill the process (replace PID with actual number)
    taskkill /PID <PID> /F
    ```

---

### Issue: Permission Denied Errors

**Symptoms:**
```
Permission denied: storage/logs/laravel.log
```

**Solutions:**

1.  **Run as Administrator:**
    *   Right-click `start_portable.bat`
    *   Select "Run as administrator"

2.  **Check USB Write Protection:**
    *   Ensure USB drive is not write-protected
    *   Check drive properties

3.  **Clear Logs:**
    ```bash
    # Delete old log files
    del storage\logs\*.log
    ```

---

### Issue: Slow Performance

**Symptoms:**
*   Pages load slowly
*   Images take long to display

**Solutions:**

1.  **Use USB 3.0:**
    *   USB 3.0 ports are much faster than USB 2.0
    *   Look for blue USB ports on the computer

2.  **Use Faster USB Drive:**
    *   USB 3.0/3.1 flash drives are faster
    *   Consider an external SSD for best performance

3.  **Clear Caches:**
    ```bash
    ..\php\php.exe artisan cache:clear
    ..\php\php.exe artisan view:clear
    ```

---

## ✅ Pre-Deployment Checklist

Before giving your USB drive to someone else or using it for a demo:

### Database & Content
- [ ] Database file exists: `database\database.sqlite`
- [ ] Database contains the products you want to show
- [ ] Admin account works: `admin@eezepc.com` / `admin123`
- [ ] Test products display correctly
- [ ] Product images are present in `storage\app\public\products\`

### PHP Configuration
- [ ] `php` folder exists at USB root
- [ ] `php.ini` file exists and is configured
- [ ] Required extensions are enabled in `php.ini`

### Laravel Configuration
- [ ] `.env` file is configured for SQLite
- [ ] `APP_KEY` is set in `.env`
- [ ] Storage link exists or will be created automatically
- [ ] Contact information is updated (phone, email)

### Cleanup
- [ ] Clear old logs: `del storage\logs\*.log`
- [ ] Clear caches:
    ```bash
    ..\php\php.exe artisan cache:clear
    ..\php\php.exe artisan config:clear
    ..\php\php.exe artisan view:clear
    ..\php\php.exe artisan route:clear
    ```
- [ ] Remove any test/development data

### Testing
- [ ] Test `start_portable.bat` on your computer
- [ ] Verify all pages load correctly
- [ ] Test product browsing and search
- [ ] Test cart functionality
- [ ] Test admin panel access
- [ ] Verify images display correctly
- [ ] Test on a different computer if possible

---

## 🔬 Technical Details

### How the Batch Script Works

The `start_portable.bat` script performs these operations:

```batch
@echo off
REM 1. Set up paths
set PHP_PATH=..\php\php.exe
set PROJECT_PATH=%~dp0

REM 2. Verify PHP exists
if not exist "%PHP_PATH%" (
    echo Error: PHP not found
    exit /b 1
)

REM 3. Check database
if not exist "database\database.sqlite" (
    echo Creating database...
    "%PHP_PATH%" artisan migrate --seed
)

REM 4. Create storage link
if not exist "public\storage" (
    "%PHP_PATH%" artisan storage:link
)

REM 5. Clear caches
"%PHP_PATH%" artisan config:clear
"%PHP_PATH%" artisan cache:clear

REM 6. Start server
echo Starting EEZEPC...
start http://127.0.0.1:8000
"%PHP_PATH%" artisan serve
```

### Database Schema

The SQLite database contains these main tables:

*   **users** - User accounts (customers and admin)
*   **products** - Product catalog
*   **categories** - Product categories (hierarchical)
*   **orders** - Customer orders
*   **order_items** - Individual items in orders
*   **wishlists** - User wishlist items
*   **migrations** - Laravel migration tracking

### File Sizes (Approximate)

*   Portable PHP: ~35 MB
*   Project Code: ~20 MB
*   SQLite Database: ~5-50 MB (depends on data)
*   Product Images: ~10-100 MB (depends on number of products)
*   **Total USB Space Needed: ~100-250 MB**

### Performance Considerations

**Factors Affecting Speed:**
*   USB drive speed (USB 3.0 vs 2.0)
*   Computer RAM and CPU
*   Number of products in database
*   Size and number of product images
*   Browser cache

**Optimization Tips:**
*   Use USB 3.0 drive and port
*   Keep database size reasonable
*   Optimize product images (compress before upload)
*   Clear browser cache if pages load slowly

---

## 🎓 Advanced Topics

### Customizing the Port

Edit `start_portable.bat` and change the port:

```batch
"%PHP_PATH%" artisan serve --port=8080
```

Then access at: `http://127.0.0.1:8080`

### Adding More Products

1.  Run the application
2.  Login as admin
3.  Go to Admin Panel → Products
4.  Click "Add New Product"
5.  Upload images and fill in details
6.  Images are automatically saved to `storage/app/public/products/`

### Backing Up Your Data

**Backup the Database:**
```bash
# Copy the database file
copy database\database.sqlite database\database.backup.sqlite
```

**Backup Product Images:**
```bash
# Copy the entire products folder
xcopy storage\app\public\products storage\app\public\products.backup\ /E /I
```

### Restoring from Backup

**Restore Database:**
```bash
copy database\database.backup.sqlite database\database.sqlite
```

**Restore Images:**
```bash
xcopy storage\app\public\products.backup\* storage\app\public\products\ /E /Y
```

---

## 📞 Support & Help

### Getting Help

1.  **Check this guide** - Most issues are covered in Troubleshooting
2.  **Check README.md** - General application documentation
3.  **Check Laravel Logs** - `storage/logs/laravel.log`
4.  **GitHub Issues** - Report bugs or ask questions

### Useful Commands

```bash
# Clear all caches
..\php\php.exe artisan cache:clear
..\php\php.exe artisan config:clear
..\php\php.exe artisan view:clear
..\php\php.exe artisan route:clear

# Recreate storage link
..\php\php.exe artisan storage:link

# Reset database (WARNING: Deletes all data!)
..\php\php.exe artisan migrate:fresh --seed

# Check Laravel version
..\php\php.exe artisan --version

# List all routes
..\php\php.exe artisan route:list
```

---

## 🎉 Success!

If you've followed this guide, you should now have a fully portable EEZEPC installation that:

✅ Runs from any Windows computer  
✅ Requires no installation  
✅ Includes all product images  
✅ Contains all your data  
✅ Launches with one click  

**Enjoy your portable e-commerce platform!** 🚀

---

**Last Updated:** December 2025  
**Version:** 1.0  
**Author:** Mashood Ali
