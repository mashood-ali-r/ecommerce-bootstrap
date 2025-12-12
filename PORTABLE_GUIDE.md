# USB Portability Guide (SQLite Version)

This guide explains how to package the EEZEPC application on a USB drive using **SQLite** as the database and a **Portable PHP** runtime. This removes the need for XAMPP, MySQL, or any installation on the target computer.

## 1. Minimal Prerequisites
You need two things on your USB drive:
1.  **The Project Folder:** Contains your Laravel code.
2.  **Portable PHP:** A standalone folder containing the PHP executable.

## 2. Directory Structure
Limit your USB root directory to look like this for the `start_portable.bat` script to work optionally:

```text
USB_DRIVE:\
├── php\                  <-- Portable PHP binaries
└── ecommerce-bootstrap\  <-- This project folder
    ├── start_portable.bat
    ├── .env
    └── ...
```

## 3. Step-by-Step Setup

### Step A: Download Portable PHP
1.  Go to [windows.php.net/download](https://windows.php.net/download/).
2.  Download the **VS16 x64 Thread Safe** ZIP file (for PHP 8.2 or 8.3).
3.  Extract the contents into a folder named `php` on your USB drive.
4.  **Important:** Inside the `php` folder, copy `php.ini-development` to `php.ini`.
5.  Open `php.ini` and **uncomment** (remove `;`) these lines to enable required extensions:
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

### Step B: Configure the Project
1.  Copy your `ecommerce-bootstrap` folder to the USB (next to the `php` folder).
2.  Open `.env` in the `ecommerce-bootstrap` folder.
3.  Change the database settings to use SQLite:

    ```ini
    DB_CONNECTION=sqlite
    # DB_HOST=127.0.0.1  <-- Comment or remove
    # DB_PORT=3306       <-- Comment or remove
    # DB_DATABASE=...    <-- Comment or remove
    # DB_USERNAME=...    <-- Comment or remove
    # DB_PASSWORD=...    <-- Comment or remove
    ```
    *(Note: Laravel defaults to searching for `database/database.sqlite` when `DB_CONNECTION=sqlite` is set).*

### Step C: Setup Database
1.  Ensure the file `database/database.sqlite` exists.
    *   If it exists and has data: Great, you're done.
    *   If it doesn't exist: The `start_portable.bat` script will attempt to create and seed it for you.
    *   **Manual Creation:** Create an empty file named `database.sqlite` inside the `database` folder.

## 4. How to Run (Plug & Play)
1.  Plug the USB into any Windows computer.
2.  **Open the `ecommerce-bootstrap` folder** on the USB drive.
3.  **Double-click `start_portable.bat`** located *inside* that folder.
    *   *Do NOT run it from outside the folder or via a shortcut unless the "Start in" directory is set correctly.*

The script will:
1.  Find the `php` folder automatically (it looks in `..\php`).
2.  Check for the database (and create/seed it if missing).
3.  Launch the local server (`http://127.0.0.1:8000`).
4.  Automatically open your web browser.

## 5. Deployment Checklist
Before giving the USB to someone else:
- [ ] Delete `storage/logs/*.log` to clear old error logs.
- [ ] Run `php artisan view:clear` and `php artisan config:clear` to remove hardcoded paths from cache.
- [ ] Ensure `database/database.sqlite` contains the data you specifically want to demo.
