# SECURITY.md

# Security Policy

## Supported Versions

The Listify application is actively maintained and secured using the latest stable Laravel framework updates and security patches.

| Version        | Supported |
| -------------- | --------- |
| Laravel 13.x   | Yes       |
| Older Versions | No        |

---

# Reporting a Vulnerability

If a security vulnerability is discovered within the Listify application, please report it responsibly through the project administrator or development team.

When reporting a vulnerability, include:

* vulnerability description
* affected functionality
* reproduction steps
* possible impact
* screenshots or logs if available

All reported vulnerabilities will be reviewed and resolved as quickly as possible.

---

# Security Features Implemented

The Listify system includes multiple security mechanisms to protect user accounts, APIs, and cloud-hosted resources.

## Authentication Security

* Laravel Fortify authentication
* Secure login and registration
* Email verification
* Password reset functionality
* Session authentication
* Google OAuth authentication

---

## Two-Factor Authentication (2FA)

* TOTP-based authentication
* Google Authenticator support
* Recovery code support
* Additional account verification layer

---

## API Security

* Laravel Sanctum bearer token authentication
* Protected API routes using auth:sanctum
* Token validation
* Secure JSON API communication
* API rate limiting

---

## Middleware Protection

* Route protection using auth middleware
* Admin route authorization
* Role-based access control
* Request filtering and authorization

---

## Input Validation

* Laravel validation rules
* Prevention of invalid input
* Request sanitization
* API validation responses

---

## Password Security

* Bcrypt password hashing
* Secure password storage
* Protection against plain text passwords

---

## Session Security

* Secure session management
* CSRF protection
* Secure authentication sessions

---

## Cloud Security

* AWS Elastic Beanstalk hosting
* AWS Security Groups configuration
* Restricted inbound traffic
* Secure production environment variables

---

# Security Headers

The application includes security middleware and browser protection mechanisms to improve overall web security.

Implemented protections include:

* CSRF protection
* Secure session handling
* Middleware authorization
* Request validation

---

# Rate Limiting

Rate limiting was implemented to protect APIs and authentication routes from abuse and brute-force attacks.

Implemented protections:

* Login throttling
* API request limiting
* Protected authentication endpoints

---

# Environment Security

Sensitive production configuration values are stored securely using environment variables and are not exposed publicly.

Protected configurations include:

* database credentials
* API keys
* Google OAuth secrets
* AWS configuration values

---

# Deployment Security

The production environment includes:

* optimized Laravel configuration
* protected storage permissions
* secure cloud deployment
* production caching and optimization

---

# Future Security Improvements

Planned future security enhancements include:

* advanced activity monitoring
* real-time security alerts
* enhanced audit logging
* HTTPS enforcement improvements
* additional API security layers
