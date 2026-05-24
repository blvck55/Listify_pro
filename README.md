# Listify

Listify is a Laravel-based task management application for authenticated users and administrators. The app supports task creation, category organization, task history, notifications, admin analytics, audit logging, and secure authentication flows.

## Project Overview

Listify helps users manage personal and shared tasks while giving administrators a dedicated control panel for monitoring users, tasks, reports, and activity. It includes:

- User task dashboard with create/edit/delete functionality
- Category-based task organization
- Task history and notifications
- Admin panel with user management and analytics
- Secure access using Laravel authentication, email verification, and two-factor auth
- Public landing pages for about, contact, and terms

## Technologies Used

- PHP 8.3
- Laravel 13
- Laravel Jetstream (Livewire stack)
- Laravel Fortify
- Laravel Sanctum
- Blade templates
- Livewire components
- MySQL / Eloquent ORM
- Vite + Tailwind CSS
- Chart.js for analytics
- Google Fonts (DM Sans, Inter)

## Installation Steps

1. Clone the repository:

   ```powershell
   git clone <repository-url> listify
   cd listify
   ```

2. Install PHP dependencies:

   ```powershell
   composer install
   ```

3. Install frontend dependencies:

   ```powershell
   npm install
   ```

4. Copy the environment file and configure it:

   ```powershell
   cp .env.example .env
   ```

   Update `.env` values for database connection, `APP_URL`, and email settings.

5. Generate the application key:

   ```powershell
   php artisan key:generate
   ```

6. Run database migrations:

   ```powershell
   php artisan migrate
   ```

7. Seed the database:

   ```powershell
   php artisan db:seed
   ```

8. Build frontend assets:

   ```powershell
   npm run build
   ```

9. Run the application locally:

   ```powershell
   php artisan serve
   ```

## Database Setup

1. Set database credentials in `.env`:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=listify
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. Create the database if it does not exist.
3. Run migrations and seeders:

   ```powershell
   php artisan migrate --seed
   ```

4. If you need to reset and reseed the database:

   ```powershell
   php artisan migrate:fresh --seed
   ```

## Seeder Credentials

The demo data seeds the following accounts:

- Admin account:
  - Email: `admin@listify.com`
  - Password: `password`

- Test user account:
  - Email: `test@listify.com`
  - Password: `password`

If `CreateAdminSeeder` is used instead, seeded credentials are:

- Admin account:
  - Email: `admin@listify.local`
  - Password: `admin123456`

- Regular user account:
  - Email: `user@listify.local`
  - Password: `user123456`

## Notes

- Email verification is enabled for protected routes.
- Password reset and forgot password flows are available.
- Admin routes are protected with role-based middleware.
- CORS is configured without wildcard origins.
- Security headers are applied globally via middleware.
