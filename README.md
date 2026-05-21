# Listify

Listify is a Laravel-based task management application built for authenticated users and administrators.
It provides task creation, editing, completion, deletion, history, and admin management with role-based access control.


FRAMEWORK & ARCHITECTURE
- Migrated from SSP1 plain PHP to Laravel 13 with PHP 8.3
- Implemented MVC architecture with clean separation of concerns
- Configured MySQL database connection via Eloquent ORM
- Set up Vite + Tailwind CSS build pipeline with dark mode support

AUTHENTICATION
- Installed Laravel Jetstream + Fortify (Livewire stack)
- Implemented register, login, logout, email verification
- Added forgot/reset password functionality
- Configured two-factor authentication (2FA) via Fortify
- Integrated Google OAuth via Laravel Socialite
- Custom styled all auth pages (login, register, forgot-password,
  reset-password) to match Listify design system

MODELS & DATABASE (5 Eloquent models)
- User: role (user/admin), google_id, 2FA fields, HasApiTokens
- Task: title, subtitle, description, due_date, priority, status,
  category_id with belongsTo User and Category
- Category: user-owned task categories with colour coding
- TaskHistory: audit trail logging all task state changes
- Notification: in-app alerts stored in listify_notifications table
- Migrations: tasks, categories, task_histories,
  listify_notifications, add_role_to_users, add_category_id_to_tasks

FACTORIES (5 factories)
- UserFactory: realistic users with weighted role distribution
- CategoryFactory: named categories with hex colour codes
- TaskFactory: tasks with pending/completed/highPriority states
- TaskHistoryFactory: history records with created/completed states
- NotificationFactory: typed notifications with read/unread states

LIVEWIRE COMPONENTS (6 components)
- TaskSearch: live search + priority filter (wire:model.live)
- TaskForm: inline reactive add/edit form with live validation
- NotificationBell: real-time bell with unread count and dropdown
- CategoryManager: inline create/delete categories with colour picker
- AdminUserTable: searchable, sortable, paginated user management
- TaskHistoryFeed: filterable activity feed by action type

CONTROLLERS
- TaskController: full CRUD + complete toggle + ownership validation
  (abort 403) + TaskHistory logging on every state change
- AdminController: dashboard, users, tasks, reports with
  status/priority/role distribution analytics
- Api/TaskApiController: 6 REST endpoints with Sanctum protection

SANCTUM API (10 endpoints)
- POST   /api/login        - returns Bearer token
- POST   /api/register     - create account + token
- GET    /api/user         - current authenticated user
- POST   /api/logout       - revoke current token
- GET    /api/tasks        - list all user tasks
- POST   /api/tasks        - create task
- GET    /api/tasks/{id}   - get single task
- PUT    /api/tasks/{id}   - update task
- DELETE /api/tasks/{id}   - delete task
- PATCH  /api/tasks/{id}/complete - toggle status

SECURITY
- bcrypt password hashing via Jetstream
- CSRF protection on all forms (@csrf)
- Ownership validation on all task mutations (abort 403)
- AdminMiddleware role-based access control for /admin/* routes
- Input validation on all controller methods
- Eloquent prepared statements preventing SQL injection
- $fillable mass assignment protection on all models
- Sanctum Bearer token authentication for API routes
- APP_DEBUG=false enforced in production config

ADMIN PANEL
- Dashboard with total users/tasks stat tiles + recent activity
- User management: search, role toggle, delete with self-guard
- All tasks system-wide view with delete
- Reports: task status distribution, priority distribution,
  user roles breakdown with progress bar charts

UI & DESIGN SYSTEM
- Professional CSS design system (700+ lines) using CSS variables
- Dark mode via html.dark class, persisted in localStorage,
  no flash on load
- DM Sans (headings) + Inter (body) from Google Fonts
- Component classes: lf-card, lf-stat, lf-task-tile, lf-btn,
  lf-badge, lf-pill, lf-table, lf-modal, lf-alert, lf-empty
- Sticky navbar with centred tabs, theme toggle, notification
  bell, profile dropdown
- Responsive design tested on desktop, tablet, mobile
- Delete confirmation modal on all destructive actions

PAGES (9 total)
- Landing page (public)
- Login, Register, Forgot password, Reset password (styled)
- User dashboard with live search and task tiles
- Add task / Edit task forms
- Task history feed
- Admin dashboard, User management, All tasks, System reports

SEEDER & DEMO DATA
- DemoSeeder using all 5 factories
- Admin account: admin@listify.com / password
- Test account:  test@listify.com  / password
- 3 categories, 5 seeded tasks, task history records,
  notifications, 8 random users with random tasks

DEPLOYMENT PREPARATION
- deployment/server-setup.sh for fresh Ubuntu 22.04 EC2 instance
- deployment/nginx.conf for Nginx web server configuration
- deployment/deploy.sh for zero-downtime update workflow
- .github/workflows/deploy.yml for GitHub Actions CI/CD
- .env.production template for production environment
- deployment/SUBMISSION_CHECKLIST.md for final submission steps
