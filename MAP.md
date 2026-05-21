# Listify Application Map

## Purpose

Listify is a Laravel-based task management app that lets authenticated users create, edit, complete, and delete tasks.
It also includes an admin area for managing users, tasks, roles, and reporting.

## High-level Architecture

- **Frontend**: Blade templates + Jetstream + Livewire + Tailwind CSS + Vite
- **Backend**: Laravel 13, Eloquent ORM, controllers, middleware
- **Auth**: Jetstream/Fortify provides authentication, email verification, and 2FA
- **OAuth**: Laravel Socialite handles Google sign-in
- **Database**: MySQL/SQLite via Laravel migrations

## Main Components

### Models
- `app/Models/User.php`
  - Manages users, profile photos, 2FA, roles, and relationships
  - `hasMany(Task::class)` relationship
  - `isAdmin()` helper
- `app/Models/Task.php`
  - Represents tasks
  - `belongsTo(User::class)` relationship
  - Mass-assignable fields: `user_id`, `title`, `subtitle`, `description`, `due_date`, `priority`, `status`
  - Casts `due_date` as a date object

### Controllers
- `app/Http/Controllers/AuthController.php`
  - Redirects to Google OAuth and processes callback
  - Links Google accounts to existing users or creates new users
- `app/Http/Controllers/TaskController.php`
  - Shows the dashboard and task history
  - Handles task creation, editing, deletion, and completion toggles
  - Enforces ownership checks before modifying tasks
- `app/Http/Controllers/AdminController.php`
  - Renders admin dashboard, user list, task list, and reports
  - Toggles user roles
  - Deletes users and tasks
- `app/Http/Middleware/AdminMiddleware.php`
  - Guards `/admin/*` routes and ensures only admin users can access them

### Routes
- Public routes
  - `/` → welcome page
  - `/auth/google` → start Google OAuth
  - `/auth/google/callback` → Google OAuth callback
- Protected user routes (`auth`, `verified`)
  - `/dashboard`
  - `/tasks/create`
  - `/tasks`
  - `/tasks/{task}/edit`
  - `/tasks/{task}`
  - `/tasks/{task}/complete`
  - `/task-history`
- Admin routes (`auth`, `admin`, prefix `admin.`)
  - `/admin/dashboard`
  - `/admin/users`
  - `/admin/users/{user}/role`
  - `/admin/users/{user}`
  - `/admin/tasks`
  - `/admin/tasks/{task}`
  - `/admin/reports`

### Views
- `resources/views/welcome.blade.php`
- `resources/views/dashboard.blade.php`
- `resources/views/tasks/create.blade.php`
- `resources/views/tasks/edit.blade.php`
- `resources/views/tasks/history.blade.php`
- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/users.blade.php`
- `resources/views/admin/tasks.blade.php`
- `resources/views/admin/reports.blade.php`
- Layout and shared partials under `resources/views/layouts/`, `resources/views/components/`, and `resources/views/navigation-menu.blade.php`

## Database Schema

### `users`
- `id`
- `name`
- `email`
- `email_verified_at`
- `password`
- `remember_token`
- Jetstream team/profile fields
- `role` (`user` or `admin`)
- `google_id`
- `profile_photo_path`
- timestamps

### `tasks`
- `id`
- `user_id` (foreign key to `users.id`)
- `title`
- `subtitle`
- `description`
- `due_date`
- `priority` (`low`, `medium`, `high`)
- `status` (`pending`, `completed`)
- timestamps

## Important Files
- `routes/web.php` — application route definitions
- `app/Http/Controllers/TaskController.php`
- `app/Http/Controllers/AdminController.php`
- `app/Http/Controllers/AuthController.php`
- `app/Http/Middleware/AdminMiddleware.php`
- `app/Models/User.php`
- `app/Models/Task.php`
- `database/migrations/0001_01_01_000000_create_users_table.php`
- `database/migrations/2024_01_01_000001_create_tasks_table.php`
- `database/migrations/2024_01_01_000002_add_role_to_users_table.php`
- `database/migrations/2026_05_13_135043_add_google_id_to_users_table.php`
- `resources/views/*`

## Application Flow

1. A visitor lands on `/`.
2. They can register/login or sign in with Google.
3. Authenticated users see `/dashboard` and can manage their tasks.
4. Task changes are handled through `TaskController` and saved to the database.
5. Admin users access `/admin/*` routes via `AdminMiddleware`.
6. Admin reports aggregate task and user data for operational oversight.

## Environment and Runtime

- `composer.json` defines PHP and Laravel dependencies
- `package.json` defines frontend build tooling: Vite, Tailwind, PostCSS
- `start.bat`, `start.ps1`, and `composer run dev` are convenience start scripts
- `.env` controls app settings, DB credentials, and Google OAuth keys

## API Routes

The app includes a JSON REST API under `routes/api.php` with Sanctum token authentication.

### Public Endpoints

#### POST `/api/login`
Login and get a Sanctum token.

**Request:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response (200):**
```json
{
  "token": "1|abcdef...",
  "user": "John Doe",
  "message": "Login successful. Use the token in your Authorization header."
}
```

#### POST `/api/register`
Register and get a Sanctum token.

**Request:**
```json
{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "password": "password123"
}
```

**Response (201):**
```json
{
  "token": "1|abcdef...",
  "user": "Jane Doe",
  "message": "Account created."
}
```

### Protected Endpoints (Bearer Token Required)

All endpoints below require the header: `Authorization: Bearer YOUR_TOKEN_HERE`

#### GET `/api/user`
Get the authenticated user's profile.

**Response (200):**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "role": "user",
  ...
}
```

#### POST `/api/logout`
Revoke the current access token.

**Response (200):**
```json
{
  "message": "Logged out"
}
```

#### GET `/api/tasks`
Get all tasks for the authenticated user.

**Response (200):**
```json
{
  "success": true,
  "count": 5,
  "tasks": [
    {
      "id": 1,
      "user_id": 1,
      "title": "Buy groceries",
      "subtitle": "Weekly shopping",
      "description": "Milk, eggs, bread",
      "due_date": "2026-05-20",
      "priority": "high",
      "status": "pending",
      "created_at": "2026-05-14T10:00:00Z",
      "updated_at": "2026-05-14T10:00:00Z"
    },
    ...
  ]
}
```

#### POST `/api/tasks`
Create a new task.

**Request:**
```json
{
  "title": "Buy groceries",
  "subtitle": "Weekly shopping",
  "description": "Milk, eggs, bread",
  "due_date": "2026-05-20",
  "priority": "high"
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "Task created.",
  "task": {
    "id": 1,
    "user_id": 1,
    "title": "Buy groceries",
    "subtitle": "Weekly shopping",
    "description": "Milk, eggs, bread",
    "due_date": "2026-05-20",
    "priority": "high",
    "status": "pending",
    "created_at": "2026-05-14T10:00:00Z",
    "updated_at": "2026-05-14T10:00:00Z"
  }
}
```

#### GET `/api/tasks/{task}`
Get a specific task (owned by the authenticated user).

**Response (200):**
```json
{
  "success": true,
  "task": {
    "id": 1,
    "user_id": 1,
    "title": "Buy groceries",
    ...
  }
}
```

**Response (403) if task is not owned by user:**
```json
{
  "success": false,
  "message": "Forbidden."
}
```

#### PUT `/api/tasks/{task}`
Update a task (owned by the authenticated user).

**Request:**
```json
{
  "title": "Buy groceries",
  "priority": "medium",
  "due_date": "2026-05-21"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Task updated.",
  "task": {
    "id": 1,
    "user_id": 1,
    "title": "Buy groceries",
    "priority": "medium",
    "due_date": "2026-05-21",
    ...
  }
}
```

#### DELETE `/api/tasks/{task}`
Delete a task (owned by the authenticated user).

**Response (200):**
```json
{
  "success": true,
  "message": "Task deleted."
}
```

#### PATCH `/api/tasks/{task}/complete`
Toggle task status between `pending` and `completed`.

**Response (200):**
```json
{
  "success": true,
  "message": "Status updated.",
  "task": {
    "id": 1,
    "user_id": 1,
    "title": "Buy groceries",
    "status": "completed",
    ...
  }
}
```

### Controller
- `app/Http/Controllers/Api/TaskApiController.php`
  - Implements all task API operations
  - Returns JSON with `success` flag and optional `task` or `tasks` data
  - Enforces ownership checks (403 Forbidden if task belongs to another user)

## Livewire Components

### TaskSearch Component

**Location:** `app/Livewire/TaskSearch.php`

**View:** `resources/views/livewire/task-search.blade.php`

**Purpose:** Provides real-time task search and priority filtering with live updates.

**Public Properties:**
- `string $search` — search query for title/subtitle (default: `''`)
- `string $filter` — priority filter: `'all'`, `'low'`, `'medium'`, `'high'` (default: `'all'`)

**Functionality:**
- Filters authenticated user's pending tasks by search query and priority
- Uses `wire:model.live` for real-time updates
- Filters on `title` and `subtitle` fields
- Returns tasks ordered by `latest()` (newest first)

**Usage in Blade:**
```blade
<livewire:task-search />
```

**Example Rendered Variables:**
- `$tasks` — array of filtered Task models

## Jetstream / Fortify Actions

Located in `app/Actions/Fortify/` and `app/Actions/Jetstream/`:

- `CreateNewUser.php` — handles registration flow
- `PasswordValidationRules.php` — defines password validation rules
- `ResetUserPassword.php` — password reset logic
- `UpdateUserPassword.php` — password update for authenticated users
- `UpdateUserProfileInformation.php` — profile updates

These actions are called by Fortify's built-in registration, password reset, and profile update forms.

## Notes

- Google OAuth uses `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, and `GOOGLE_REDIRECT_URI`
- Tasks are user-scoped; only the owning user can modify their own tasks
- Admin role management is enforced to prevent self-demotion or self-deletion
- API uses manual `response()->json()` instead of Laravel `Resource` classes
- All API responses include a `success` boolean flag for client-side handling
- Sanctum tokens are personal access tokens; no scope-based permissions
