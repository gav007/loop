# Loop

Loop is a server-side web development project for buying, selling, swapping, and donating used electronics.

This repository was prepared for **Server-side Web Development COMP3101**  
**Assignment 2**  
**Academic Term:** Jan-May 2025/26  
**CRN:** 26577

## Project Summary

The website includes a landing page, user registration, login, a protected dashboard, logout, and placeholder pages for profile, marketplace, and creating posts.

The aim of the project is to show core PHP lab topics such as:

- server-side form validation
- XSS prevention
- sessions
- cookies
- redirection after login
- logout handling
- PHP filters

## Assignment Criteria and Where It Is Shown

### 1. PHP server-side form checking (Lab 5)

Implemented in:

- `backend/register_handler.php`

Examples:

- checks for empty username, email, password, and confirm password
- checks that password confirmation matches
- checks that password length is at least 8 characters

### 2. XSS prevention functions (Lab 5)

Implemented in:

- `backend/register_handler.php`

Functions used:

- `trim()`
- `stripslashes()`
- `htmlspecialchars()`

These are used inside the `clean_data()` function before user input is processed.

### 3. Sessions (Lab 6)

Implemented in:

- `backend/register_handler.php`
- `backend/login_handler.php`
- `backend/logout.php`
- `templates/dashboard.php`
- `templates/landing_page.php`
- `templates/register.php`

Examples:

- stores registration and login information in `$_SESSION`
- stores success and error messages in the session
- checks `$_SESSION['login']` before showing the dashboard

### 4. Redirection to login page with error message if invalid login (Lab 6)

Implemented in:

- `backend/login_handler.php`
- `templates/landing_page.php`

The login handler redirects the user back to the landing page if login is not valid.

### 5. Redirection to secure page if valid login (Lab 6)

Implemented in:

- `backend/login_handler.php`
- `templates/dashboard.php`

If login is valid, the user is redirected to the dashboard page.

### 6. Logout option that expires cookies/sessions (Lab 6)

Implemented in:

- `backend/logout.php`

Examples:

- `session_unset()`
- `session_destroy()`
- cookie expiry using `setcookie()`

### 7. Cookies (Lab 6)

Implemented in:

- `backend/login_handler.php`
- `backend/logout.php`
- `templates/landing_page.php`

The project stores the user's email in a cookie and uses it to prefill the login form.

### 8. PHP filters (Lab 6)

Implemented in:

- `backend/register_handler.php`

Example:

- `filter_var($email, FILTER_VALIDATE_EMAIL)`

## Extra Features

- dark mode toggle in `scripts/main.js`
- client-side password confirmation check in `scripts/main.js`
- reusable layout and styling across multiple pages
- password hashing during registration with `password_hash()`

## Features Added Since the Previous Assignment

- registration form and handler
- login flow
- protected dashboard page
- logout handler
- session-based success and error messages
- cookie support for remembered email

## Project Structure

- `assets/` images and icons
- `backend/` PHP handlers and database connection
- `scripts/` JavaScript files
- `styles/` CSS files
- `templates/` website pages

## Running the Project

### Requirements

- XAMPP
- Apache
- MySQL / MariaDB
- PHP

### Steps

1. Place the project folder inside `htdocs`.
2. Start Apache and MySQL in XAMPP.
3. Create the database `loop_db`.
4. Create a `users` table for registration/login.
5. Open the project in the browser through localhost.

Example:

`http://localhost/loop/loop/`

## Main Files

- `index.php`
- `backend/register_handler.php`
- `backend/login_handler.php`
- `backend/logout.php`
- `backend/db_connect.php`
- `templates/landing_page.php`
- `templates/register.php`
- `templates/dashboard.php`
- `scripts/main.js`

## Note for Submission

For Brightspace submission, the project should be uploaded as a zipped folder containing all required `.php`, `.html`, `.css`, `.js`, and image files.
