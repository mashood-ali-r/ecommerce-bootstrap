# USB Portability Guide for EEZEPC

This guide outlines how to make the EEZEPC E-Commerce application fully portable on a USB drive, allowing you to run it on any Windows computer without installation.

## Prerequisites
1.  **USB Drive:** Ensure you have a USB drive with at least 2GB of free space.
2.  **XAMPP Portable:** Download "XAMPP Portable for Windows" (specifically the PHP 8.2+ version) from [Apache Friends](https://www.apachefriends.org/top/download.html).

## Step-by-Step Setup

### 1. Prepare the USB Drive
1.  **Install XAMPP Portable:**
    *   Run the XAMPP Portable installer.
    *   Select your USB drive letter (e.g., `E:\`) as the installation destination.
    *   This will create a `xampp` folder on your USB drive (e.g., `E:\xampp`).

### 2. Copy the Project Files
1.  Navigate to your local project folder: `C:\xampp\htdocs\ecommerce-bootstrap`.
2.  **Copy the entire folder** (including `vendor`, `node_modules`, `.env`, etc.).
3.  Paste this folder into the `htdocs` directory on your USB drive:
    *   Destination: `E:\xampp\htdocs\ecommerce-bootstrap`

### 3. Migrate the Database
1.  **Export Local Database:**
    *   Open XAMPP Control Panel on your computer and start MySQL.
    *   Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
    *   Select the `ecommerce_db` (or your project's database).
    *   Click **Export** tab -> Click **Export**.
    *   Save the `.sql` file (e.g., `ecommerce_backup.sql`).

2.  **Import to USB database:**
    *   Start **XAMPP Control Panel** from the USB drive (`E:\xampp\xampp-control.exe`).
    *   Start **Apache** and **MySQL**.
    *   Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin) (this is now running from the USB).
    *   Click **New** in the sidebar -> Create a database named `ecommerce_db` (or whatever matches your `.env`).
    *   Select the new database -> Click **Import** tab.
    *   Choose the file `ecommerce_backup.sql` you saved earlier.
    *   Click **Import**.

### 4. Configure Application on USB
1.  Open the `.env` file on your USB drive (`E:\xampp\htdocs\ecommerce-bootstrap\.env`).
2.  Ensure the database credentials match the XAMPP Portable defaults (usually root with no password):
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ecommerce_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

### 5. Running the Application (Portable)
1.  Plug the USB into any Windows computer.
2.  Run `xampp-control.exe` from the `xampp` folder on the USB.
3.  Click **Start** next to Apache and MySQL.
4.  **Option A (Easiest - URL Access):**
    *   Open a browser and go to: `http://localhost/ecommerce-bootstrap/public`
    *   *Note: This works but may show "public" in the URL.*

5.  **Option B (Cleaner - Artisan Serve):**
    *   In the XAMPP Control Panel, click the **Shell** button (right side).
    *   Navigate to the project folder:
        ```cmd
        cd htdocs\ecommerce-bootstrap
        ```
    *   Run the server:
        ```cmd
        php artisan serve
        ```
    *   Open browser to: `http://127.0.0.1:8000`

## Troubleshooting
*   **Port Conflicts:** If port 80 or 3306 are taken on the host machine, change ports in XAMPP Config and update `.env` (DB_PORT) and browser URL (localhost:8080) accordingly.
*   **Missing Dependencies:** Since you copied the entire folder including `vendor`, no `composer install` is needed. This is crucial as the host machine might not have Composer installed.

## Quick Start (For Evaluation)
1.  Plug in USB.
2.  Start XAMPP.
3.  Click "Shell" -> `cd htdocs\ecommerce-bootstrap` -> `php artisan serve`.
4.  Open `http://localhost:8000`.
