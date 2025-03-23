# Laravel Login System with JWT Authentication

This project implements a secure login system in Laravel with the following features:

-   JWT token generation and authentication.
-   Track failed login attempts and lock accounts after 5 failed attempts.
-   Admin functionality to unlock locked accounts.
-   Role-based access control (admin and user roles).

## Features

-   **JWT Token Generation**: Tokens are generated on successful login and expire after 1 hour.
-   **Failed Login Attempts**: Accounts are locked after 5 failed login attempts.
-   **Admin Unlock**: Admins can unlock locked accounts.
-   **Role-Based Access**: Users have either `admin` or `user` roles.

## Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/dianaqwariq/laravel-system.git
cd laravel-system
```

2. Install Dependencies
   Install PHP dependencies using Composer and JavaScript dependencies using npm:

composer install
npm install

3. Configure Environment
   Copy the .env.example file to .env and update the database credentials:
   APP_NAME=Laravel
   APP_ENV=local
   APP_KEY=base64:DRds9FTqLlTafO9xMJXVBRl9i5O9jAkC1/Ro5AdFfnc=
   APP_DEBUG=true
   APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myphp_db
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

API_KEY=very-secret

JWT_SECRET=aofEBTtB2UBK7zaJCCnurj6f4qc6HIZiDYDEc7yleuTIrE4kNmiSrt3CLqBEdqfI

4. Generate Application Key
   Generate a unique application key:

php artisan key:generate 5. Run Migrations and Seeders
Run migrations to create the database tables and seed the database with test data:

php artisan migrate --seed 6. Install JWT Auth
Install and configure the tymon/jwt-auth package:

composer require tymon/jwt-auth
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret 7. Start the Development Server
Start the Laravel development server:

php artisan serve
Visit http://localhost:8000 in your browser to access the application.

8. Test the API
   Use Postman to test the following endpoints:

Login: POST http://localhost/my_laravel_project/public/api/login

Get Users: GET http://localhost/my_laravel_project/public/api/users

Unlock Account: POST http://localhost/my_laravel_project/public/api/unlock-account (Admin only)

API Endpoints
Login
URL: POST http://localhost/my_laravel_project/public/api/login

Body:

{
"email": "admin@example.com",
"password": "password"
}
Unlock Account (Admin Only)
URL: POST http://localhost/my_laravel_project/public/api/unlock-account

Headers:

Authorization: Bearer <admin-jwt-token>

Body:

json

{
"email": "locked-user@example.com"
}
License
This project is open-source and available under the MIT License.

---

### **Why These Instructions Are Important**

1. **Cloning the Repository**: Explains how to get the code onto a local machine.
2. **Installing Dependencies**: Ensures all required PHP and JavaScript packages are installed.
3. **Configuring Environment**: Guides users to set up the `.env` file with their database credentials.
4. **Generating Application Key**: Ensures the application has a secure encryption key.
5. **Running Migrations and Seeders**: Sets up the database and populates it with test data.
6. **Installing JWT Auth**: Configures JWT authentication for the project.
7. **Starting the Development Server**: Explains how to run the application locally.
8. **Testing the API**: Provides examples of how to test the API endpoints.

---
