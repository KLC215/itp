# Information Technology Project

## Installation

1. Copy `.env.example` to `.env` and update the configs

2. Install dependencies
```bash
composer install

# Choose one, prefer yarn
yarn
npm install
```
3. Update `config/admin.php`
4. Install Laravel Admin package, it will migrate admin' tables
```bash
php artisan admin:install
```
5. Migrate application' tables
```bash
php artisan migrate
```
6. Create dummy data
```bash
php artisan db:seed
```
7. Good to go! :)
