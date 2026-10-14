# CARECRADLE – LARAVEL REVIEWER

## I. BASIC LARAVEL COMMANDS

### Start the Laravel Server

```bash
php artisan serve
```

**Purpose:** Runs the Laravel application locally.

**Default URL:**

```
http://127.0.0.1:8000
```

---

### Run Database Migrations

```bash
php artisan migrate
```

**Purpose:** Creates database tables based on migration files.

---

### Fresh Migration

```bash
php artisan migrate:fresh
```

**Purpose:** Deletes all existing tables and recreates them.

**Note:** All existing data will be deleted.

---

### Fresh Migration with Seeders

```bash
php artisan migrate:fresh --seed
```

**Purpose:** Recreates tables and inserts default/sample data.

---

### Generate Application Key

```bash
php artisan key:generate
```

**Purpose:** Generates Laravel's encryption key.

Used when:

```
No application encryption key has been specified.
```

---

## II. CACHE COMMANDS

### Clear All Cached Files

```bash
php artisan optimize:clear
```

**Purpose:** Clears all Laravel caches.

---

### Clear Application Cache

```bash
php artisan cache:clear
```

---

### Clear Configuration Cache

```bash
php artisan config:clear
```

---

### Clear Route Cache

```bash
php artisan route:clear
```

---

### Clear View Cache

```bash
php artisan view:clear
```

---

## III. COMPOSER & NPM COMMANDS

### Install PHP Dependencies

```bash
composer install
```

**Purpose:** Recreates the `vendor` folder.

Used when:

* Transferring the project to another computer
* `vendor` folder is missing

---

### Regenerate Autoload Files

```bash
composer dump-autoload
```

**Purpose:** Fixes class loading issues.

---

### Install Node.js Dependencies

```bash
npm install
```

**Purpose:** Recreates the `node_modules` folder.

---

## IV. CREATE LARAVEL COMPONENTS

### Create a Controller

```bash
php artisan make:controller AppointmentController
```

---

### Create a Model

```bash
php artisan make:model Appointment
```

---

### Create a Model with Migration

```bash
php artisan make:model Appointment -m
```

---

## V. DATABASE CONFIGURATION

### Example `.env` Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=carecradle
DB_USERNAME=root
DB_PASSWORD=
```

### If Database Connection Fails:

1. Check if MySQL is running.
2. Verify database name.
3. Verify username and password.
4. Verify port number.
5. Check Laravel logs.

---

## VI. LARAVEL LOGS

### Log File Location

```
storage/logs/laravel.log
```

### Why Check Logs?

Logs help identify:

* Database errors
* Login errors
* SMS errors
* Validation errors
* System exceptions

---

## VII. COMMON TROUBLESHOOTING SCENARIOS

### 1. SMS Not Sending

**Possible Causes:**

* No internet connection
* Invalid API key
* No SMS credits
* Incorrect phone number
* SMS service unavailable

**Steps:**

1. Check internet connection.
2. Verify SMS API configuration.
3. Verify SMS credits.
4. Verify phone number.
5. Check Laravel logs.

---

### 2. User Cannot Login

**Steps:**

1. Verify username.
2. Verify password.
3. Check if account exists.
4. Reset password if necessary.
5. Check authentication logs.

---

### 3. Data Not Saving

**Steps:**

1. Check required fields.
2. Check validation rules.
3. Verify database connection.
4. Check Laravel logs.

---

### 4. Website Not Loading

**Steps:**

1. Check internet connection.
2. Verify Laravel server is running.
3. Check application logs.
4. Verify system configuration.

---

### 5. Database Connection Error

**Steps:**

1. Check MySQL service.
2. Verify `.env` settings.
3. Verify database exists.
4. Check username and password.
5. Check Laravel logs.

---

## VIII. CARECRADLE SYSTEM FLOW

### Appointment with SMS Notification

```
Health Worker Creates Appointment
            ↓
 Appointment Saved in Database
            ↓
    SMS API is Triggered
            ↓
 SMS Sent to Mother's Phone
```

---

## IX. FREQUENT PANEL QUESTIONS

### What is Migration?

Migration is Laravel's way of creating and modifying database tables using code.

---

### Why Use Laravel?

* Organized code structure
* Built-in security features
* Faster development
* Easy maintenance

---

### Why Use MySQL?

* Reliable database system
* Widely used
* Easy integration with Laravel

---

### Why Exclude `vendor` and `node_modules` When Sending the Project?

Because these folders contain dependencies that can be regenerated using Composer and NPM. Excluding them significantly reduces the project size.

---

### How Do You Troubleshoot Laravel?

1. Identify the problem.
2. Check Laravel logs.
3. Verify database connection.
4. Check configuration files.
5. Apply the fix.
6. Test the system.

---

## X. TOP 5 COMMANDS TO MEMORIZE

```bash
php artisan serve
php artisan migrate
php artisan migrate:fresh
php artisan optimize:clear
php artisan key:generate
```

### General Troubleshooting Flow

```
Identify Problem
       ↓
Check Logs
       ↓
Check Database
       ↓
Check Configuration
       ↓
Apply Fix
       ↓
Test Again
```



2. Create the migration

If you want to create a migration for a mothers table:


php artisan make:migration create_mothers_table
f you're creating a new feature, you'll often use:

php artisan make:model Mother -m
The -m means create a migration too.

It creates:

app/Models/Mother.php

and:

database/migrations/xxxx_xx_xx_xxxxxx_create_mothers_table.p


Create model + migration: php artisan make:model Mother -m



Username: admin
Password: Admin@12345