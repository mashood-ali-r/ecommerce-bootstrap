# Installation Instructions

This guide provides instructions on how to set up and run the eCommerce application.

## 1. Requirements

- PHP 8.3+
- Composer
- Node.js
- NPM
- MySQL

## 2. Installation

1.  Clone the repository:

    ```bash
    git clone https://github.com/your-username/your-repository.git
    ```

2.  Navigate to the project directory:

    ```bash
    cd your-repository
    ```

3.  Install PHP dependencies:

    ```bash
    composer install
    ```

4.  Install Node.js dependencies:

    ```bash
    npm install
    ```

5.  Create a copy of the `.env.example` file and name it `.env`:

    ```bash
    cp .env.example .env
    ```

6.  Generate an application key:

    ```bash
    php artisan key:generate
    ```

7.  Configure your database in the `.env` file:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

8.  Run the database migrations:

    ```bash
    php artisan migrate
    ```

9.  Seed the database with sample data:

    ```bash
    php artisan db:seed
    ```

10. Create the storage link:

    ```bash
    php artisan storage:link
    ```

11. Compile the assets:

    ```bash
    npm run dev
    ```

12. Run the application:

    ```bash
    php artisan serve
    ```

    The application will be available at `http://localhost:8000`.
