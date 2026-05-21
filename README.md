# Listify

Listify is a Laravel-based task management application built for authenticated users and administrators.
It provides task creation, editing, completion, deletion, history, and admin management with role-based access control.

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database](#database)
- [Authentication](#authentication)
- [Running the App](#running-the-app)
- [Testing](#testing)
- [Application Structure](#application-structure)
- [Routes](#routes)
- [Admin Area](#admin-area)
- [Map File](#map-file)
- [License](#license)

## Features

- User registration, login, and email verification
- Google OAuth sign-in
- Two-factor authentication (2FA)
- Personal task management
- Task creation, edit, delete, complete/pending toggle
- Task history view
- Admin dashboard, users page, tasks page, and reports
- Role-based authorization for admin-only sections
- Responsive UI with Jetstream/Livewire and Tailwind CSS

## Tech Stack

- Backend: Laravel 13, PHP 8.3+
- Frontend: Blade + Livewire + Tailwind CSS + Vite
- Authentication: Laravel Jetstream / Fortify
- OAuth: Laravel Socialite
- Database: Eloquent ORM with MySQL or SQLite
- Build tooling: Vite, PostCSS, Tailwind

## Installation

1. Clone the repo
   ```bash
   git clone <repository-url>
   cd listify
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install Node dependencies
   ```bash
   npm install
   ```

4. Copy and configure environment variables
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure database settings in `.env`

6. Run migrations
   ```bash
   php artisan migrate
   ```

7. Seed the database (optional)
   ```bash
   php artisan db:seed
   ```

## Configuration

Update `.env` with your database credentials and application settings.

### Google OAuth

To enable Google login, set:

```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Common `.env` values

- `APP_NAME=Listify`
- `APP_URL=http://localhost:8000`
- `DB_CONNECTION=mysql` or `sqlite`
- `DB_DATABASE=database/database.sqlite` for SQLite

## Database

### Users

The `users` table stores:
- `name`
- `email`
- `password`
- `email_verified_at`
- `role` (`user` or `admin`)
- `google_id`
- profile photo and 2FA fields

### Tasks

The `tasks` table stores:
- `user_id`
- `title`
- `subtitle`
- `description`
- `due_date`
- `priority` (`low`, `medium`, `high`)
- `status` (`pending`, `completed`)

## Authentication

Authentication is handled by Jetstream and Fortify.

- Email/password registration and login
- Email verification required for protected routes
- Google OAuth login via `AuthController`
- 2FA support via Jetstream
- Admin-only middleware protects `/admin/*` routes

## Running the App

### Local development

```bash
npm run dev
```

### Start Laravel server

```bash
php artisan serve
```

### Start both frontend and backend

```bash
npm run serve
```

### Full development environment

```bash
composer run dev
```

### Windows scripts

- `start.bat`
- `start.ps1`

## Testing

```bash
php artisan test
```

## Application Structure

### Key directories

- `app/Http/Controllers`
- `app/Http/Middleware`
- `app/Models`
- `resources/views`
- `database/migrations`
- `database/seeders`

### Core controllers

- `TaskController` — user task CRUD and history
- `AdminController` — admin dashboard, user/task management, reports
- `AuthController` — Google OAuth

### Middleware

- `AdminMiddleware` — restricts admin-only access

## Routes

### Public

- `/` — welcome page
- `/auth/google` — Google OAuth redirect
- `/auth/google/callback` — OAuth callback

### Authenticated user routes

- `/dashboard`
- `/tasks/create`
- `/tasks`
- `/tasks/{task}/edit`
- `/tasks/{task}`
- `/tasks/{task}/complete`
- `/task-history`

### Admin routes

- `/admin/dashboard`
- `/admin/users`
- `/admin/users/{user}/role`
- `/admin/users/{user}`
- `/admin/tasks`
- `/admin/tasks/{task}`
- `/admin/reports`

## Admin Area

Administrators can:

- View application metrics on the admin dashboard
- View and manage users
- Toggle user/admin role
- Delete users (with self-deletion prevented)
- View and delete tasks
- Access reporting by task status and priority

## Map File

See `MAP.md` for an architecture map, route-to-controller mapping, and key file references.

## License

This project is licensed under the MIT License.
