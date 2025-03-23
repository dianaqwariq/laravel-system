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
