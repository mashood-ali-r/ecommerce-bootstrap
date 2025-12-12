@echo off
setlocal
title EEZEPC Portable Launcher

echo ==========================================
echo      EEZEPC Portable Loader (SQLite)
echo ==========================================
echo.

:: 1. Look for portable PHP in sibling directory (..\php)
if exist "..\php\php.exe" (
    set PHP_BIN=..\php\php.exe
    echo [INFO] Found Portable PHP at ..\php\php.exe
) else (
    :: 2. Look for portable PHP in current directory (.\php)
    if exist "php\php.exe" (
        set PHP_BIN=php\php.exe
        echo [INFO] Found Portable PHP at .\php\php.exe
    ) else (
        :: 3. Fallback to system PHP
        set PHP_BIN=php
        echo [INFO] Using System PHP (Ensure it is in PATH)
    )
)

:: Check if database exists
if not exist "database\database.sqlite" (
    echo [WARNING] Database file not found!
    echo [INFO] Creating empty database...
    type nul > "database\database.sqlite"
    echo [INFO] Running Migrations...
    "%PHP_BIN%" artisan migrate --force
    echo [INFO] Seeding Database...
    "%PHP_BIN%" artisan db:seed --force
)

echo.
echo [INFO] Starting Server at http://127.0.0.1:8000
echo [INFO] Press Ctrl+C to stop.
echo.

:: Open Browser (wait 2 seconds for server to start)
start /min timeout /t 3 /nobreak >nul & start http://127.0.0.1:8000

:: Start Server
"%PHP_BIN%" artisan serve

pause
