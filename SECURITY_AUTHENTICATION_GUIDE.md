# Security & Authentication Implementation Guide

This document describes the complete security and authentication features implemented in Listify.

## 🔐 Features Implemented

### 1. **Email Verification**
- **Status**: ✅ Enabled in Fortify
- **Location**: `config/fortify.php` - `Features::emailVerification()`
- **Implementation**: 
  - User model implements `MustVerifyEmail` interface
  - Routes: `/email/verify` (GET), `/email/verification-notification` (POST)
  - Unverified users redirected to email verification page
  - Resend verification email button available in profile
  - Auto-verified for OAuth (Google) users

**How it works:**
1. User registers → receives verification email
2. Clicks link in email to verify address
3. Only verified users can access protected routes (dashboard, tasks, etc.)
4. Can resend verification email from profile

### 2. **Password Reset & Forgot Password**
- **Status**: ✅ Enabled in Fortify
- **Location**: `config/fortify.php` - `Features::resetPasswords()`
- **Routes**:
  - `/forgot-password` (GET) - Shows form
  - `/forgot-password` (POST) - Sends reset email
  - `/reset-password/{token}` (GET) - Shows password reset form
  - `/reset-password` (POST) - Updates password

**How it works:**
1. User clicks "Forgot Password" on login page
2. Enters email address
3. Receives password reset link via email
4. Clicks link to reset password
5. Sets new password

### 3. **Admin-Only Middleware**
- **Status**: ✅ Implemented & Registered
- **Location**: `app/Http/Middleware/AdminMiddleware.php`
- **Registration**: `bootstrap/app.php` - aliased as `'admin'`
- **Protected Routes**: All `/admin/*` routes require `role === 'admin'`

**How it works:**
```php
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Admin-only routes
});
```

**Features Protected:**
- User management (promote/demote/delete users)
- Task management (view/delete all tasks)
- System reports and analytics
- Activity audit logs
- System settings

### 4. **Security Headers Middleware**
- **Status**: ✅ Implemented & Enabled Globally
- **Location**: `app/Http/Middleware/SecurityHeaders.php`
- **Applied**: All responses via global middleware in `bootstrap/app.php`

**Headers Added:**
- `X-Content-Type-Options: nosniff` - Prevent MIME type sniffing
- `X-XSS-Protection: 1; mode=block` - XSS protection for older browsers
- `X-Frame-Options: SAMEORIGIN` - Prevent clickjacking (allow framing only from same origin)
- `Referrer-Policy: strict-origin-when-cross-origin` - Control referrer information
- `Content-Security-Policy` - Restrict resource loading (scripts, styles, images, etc.)
- `Strict-Transport-Security: max-age=31536000` - Enforce HTTPS for 1 year
- `Permissions-Policy` - Disable dangerous browser APIs (camera, microphone, geolocation, etc.)

### 5. **Rate Limiting**
- **Status**: ✅ Configured in Fortify
- **Location**: `config/fortify.php` - `'limiters'` section
- **Configured Limiters**:
  - `login` - 5 attempts per minute per email/IP
  - `two-factor` - Rate limited for 2FA attempts

**How it works:**
- Login attempts throttled to prevent brute force attacks
- 2FA verification attempts also throttled
- Returns 429 (Too Many Requests) when limit exceeded

### 6. **CORS Configuration (No Wildcard)**
- **Status**: ✅ Configured with specific origins
- **Location**: `config/cors.php`
- **Origin**: Only `APP_URL` environment variable (default: `http://localhost:8000`)
- **No Wildcard**: Explicitly defined allowed origins instead of `['*']`

**Configuration:**
```php
'allowed_origins' => [
    env('APP_URL', 'http://localhost:8000'),
],
```

**API Protection:**
- Paths: `api/*`, `sanctum/csrf-cookie`
- Methods: All HTTP methods (GET, POST, PUT, DELETE, PATCH)
- Credentials: Supported (cookies sent with requests)
- Headers: All standard headers allowed

**To Add More Origins:**
Update `.env`:
```
APP_URL=http://localhost:8000
```

Or add to `allowed_origins_patterns` in config for regex matching.

---

## 🔑 Authentication Features

### Registration
- Email required
- Password validation enforced
- Email verification required before access
- Account creation logs activity

### Login
- Email + Password authentication
- Google OAuth integration
- Rate limiting (5 attempts/min)
- 2FA challenge if enabled
- Automatic redirect to dashboard on success

### Two-Factor Authentication (2FA)
- Available in profile settings
- TOTP-based (Google Authenticator, Authy, etc.)
- Recovery codes provided for emergency access
- Optional - users choose to enable

### OAuth (Google Login)
- Single-click login with Google account
- Auto-creates account if first time
- Auto-verifies email for OAuth users
- Stored as `google_id` in database

---

## 📋 Route Protection

### Public Routes
- `/` - Welcome page
- `/login` - Login form
- `/register` - Registration form
- `/forgot-password` - Password reset form
- `/about`, `/contact`, `/terms` - Static pages
- Google OAuth routes

### Authenticated Routes (require login + email verification)
- `/dashboard` - Task dashboard
- `/tasks/*` - Task management
- `/profile/*` - User profile & settings
- Task history and categories

### Admin Routes (require login + admin role)
- `/admin/dashboard` - Admin overview
- `/admin/users` - User management
- `/admin/tasks` - System task management
- `/admin/reports` - System reports
- `/admin/analytics` - Analytics with live data
- `/admin/activity` - Audit logs
- `/admin/settings` - System settings

---

## 🛡️ Security Best Practices

### Implemented
- ✅ HTTPS enforcement via security headers
- ✅ CSRF protection (via Jetstream/Laravel)
- ✅ SQL injection prevention (via Eloquent ORM)
- ✅ XSS protection (via Blade escaping + CSP header)
- ✅ Clickjacking protection (X-Frame-Options)
- ✅ Rate limiting on auth endpoints
- ✅ Secure password hashing (bcrypt)
- ✅ Email verification requirement
- ✅ 2FA support (TOTP)
- ✅ Role-based access control (admin middleware)
- ✅ API tokens via Sanctum

### Environment Configuration
Required in `.env`:
```
APP_NAME=Listify
APP_ENV=production  # or local/testing
APP_DEBUG=false     # NEVER true in production
APP_URL=https://your-domain.com  # Use HTTPS in production
APP_KEY=base64:...  # Run php artisan key:generate

# Email configuration for password reset & verification
MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS=noreply@listify.com
MAIL_FROM_NAME="Listify"

# Google OAuth (if using)
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
```

---

## 🔄 Password Reset Flow

1. User visits `/forgot-password`
2. Enters email address and submits
3. Laravel sends email with reset token
4. User clicks link in email
5. Redirected to `/reset-password/{token}`
6. User enters new password
7. Password updated, redirected to login
8. Login with new password

---

## ✉️ Email Verification Flow

1. User registers account
2. Laravel sends verification email
3. User clicks verification link in email
4. Email marked as verified
5. User can now access dashboard and tasks

**Resend Verification:**
- Profile page shows "Resend Verification Email" if not verified
- Click button to resend verification email
- Useful if email was not received initially

---

## 🔐 Admin Management

### Promote User to Admin
1. Login as admin
2. Go to `/admin/users`
3. Click "Make Admin" on a user
4. User now has admin privileges

### Demote Admin to User
1. Go to `/admin/users`
2. Click "Remove Admin" on an admin account
3. Admin privileges revoked

### Delete User
1. Go to `/admin/users`
2. Click "Delete" on a user
3. User account removed (admins cannot delete themselves)

---

## 📊 Admin Analytics

Located at `/admin/analytics`:
- Real-time metrics updated every 15 seconds
- Task status distribution (Doughnut chart)
- Priority breakdown (Bar chart)
- Completion rates by priority
- Most active users (last 30 days)
- System insights and workload status

API Endpoint: `/admin/analytics/data` - Returns JSON metrics for live updates

---

## 🧪 Testing Security

### Test Email Verification
1. Register with test email
2. Check verification email (if email configured)
3. Click verification link
4. Verify account is marked as verified

### Test Password Reset
1. Visit `/forgot-password`
2. Enter registered email
3. Check for password reset email
4. Click reset link
5. Set new password
6. Login with new password

### Test Admin Middleware
1. Login as non-admin user
2. Try accessing `/admin/dashboard`
3. Should be forbidden/redirected

### Test Rate Limiting
1. Try to login 6 times with wrong password quickly
2. 6th attempt should be rate limited (429 Too Many Requests)

### Test 2FA
1. Go to profile settings
2. Enable 2FA
3. Scan QR code with authenticator app
4. Enter 6-digit code
5. On next login, will be prompted for 2FA code

---

## 🚀 Deployment Checklist

Before deploying to production:

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Use HTTPS (APP_URL=https://...)
- [ ] Configure email (MAIL_* environment variables)
- [ ] Set strong `APP_KEY` (`php artisan key:generate`)
- [ ] Configure CORS allowed origins (not wildcard)
- [ ] Set up database backups
- [ ] Enable 2FA for admin accounts
- [ ] Review and adjust rate limiting if needed
- [ ] Configure security headers (already done)
- [ ] Test password reset email flow
- [ ] Test email verification flow
- [ ] Monitor admin activity logs

---

## 📞 Support & Troubleshooting

### Email Verification Not Sending
- Check `MAIL_*` environment variables are set correctly
- Check spam/junk folder
- Check Laravel logs: `storage/logs/`

### Password Reset Not Working
- Verify email configuration
- Check token expiration (default: 60 minutes)
- Ensure user email is in database

### Rate Limiting Too Strict
- Adjust limiters in `config/fortify.php`
- Default: 5 attempts/minute for login

### CORS Issues with API
- Check `config/cors.php` - ensure your origin is in `allowed_origins`
- Do NOT use wildcard (`['*']`) in production

### Admin Middleware Not Working
- Verify user has `role = 'admin'` in database
- Check `AdminMiddleware.php` is loaded in `bootstrap/app.php`
