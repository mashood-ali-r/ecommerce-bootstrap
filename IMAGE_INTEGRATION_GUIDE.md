# Image Integration Guide

This guide provides detailed instructions on how to integrate and manage product images in the eCommerce application.

## 1. Folder Structure for Storage

Product images are stored in the `storage/app/public/products` directory. To make these images accessible from the web, you need to create a symbolic link from `public/storage` to `storage/app/public`.

## 2. How to run `php artisan storage:link`

To create the symbolic link, run the following command in your terminal:

```bash
php artisan storage:link
```

This command will create a `storage` directory in your `public` folder that links to the `storage/app/public` directory.

## 3. How to place images locally for upload

When creating or editing a product in the admin panel, you can upload images directly from your local machine using the file input field in the product form.

## 4. Migrations for `product_images` table

The migration for the `product_images` table has already been created. It includes the following columns:

- `id`: Primary key
- `product_id`: Foreign key to the `products` table
- `path`: The path to the image file in the `storage` directory
- `is_primary`: A boolean to indicate if the image is the primary image for the product
- `timestamps`: `created_at` and `updated_at` timestamps

## 5. Controller methods for upload

The `store` and `update` methods in the `App\Http\Controllers\Admin\ProductController` handle image uploads. When a product is created or updated, the controller checks for any uploaded images, stores them in the `storage/app/public/products` directory, and creates a new `ProductImage` record in the database.

## 6. Blade for multi-image upload

The `resources/views/admin/products/form.blade.php` file includes a file input that allows for multiple image uploads.

## 7. How to seed demo images

To seed demo images, you can create a new seeder that creates `ProductImage` records and associates them with existing products. You can use the `faker` library to generate random images.

## 8. How to manually test uploads

To manually test uploads, you can:

1.  Run the application: `php artisan serve`
2.  Navigate to the admin panel: `http://localhost:8000/admin/products`
3.  Click on "Add Product"
4.  Fill out the form and select one or more images to upload
5.  Click on "Add Product" to submit the form
6.  Check the `storage/app/public/products` directory to see if the images were uploaded
7.  Check the `product_images` table in the database to see if the image records were created
