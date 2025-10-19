# Task Manager

Modern task management dashboard powered by Laravel 10. It provides role-based access for administrators and regular team members, intuitive task and category management, and a Tailwind CSS powered interface.

## Features

-   User authentication with dedicated login and registration screens.
-   Role-aware navigation and dashboards (interns vs. administrators).
-   CRUD for tasks with deadlines, categories, statuses, and optional assignees.
-   Task policies ensuring users can only edit/delete their own work while admins retain full control.
-   Category directory with read-only access for interns and full management for admins.
-   Admin control centre showing high-level metrics and recent activity.
-   Flash messaging, validation feedback, and responsive UI built with Tailwind CSS and Vite.

## Tech Stack

-   PHP 8.1+
-   Laravel 10
-   MySQL (or any Laravel-supported database)
-   Blade templates
-   Tailwind CSS + Vite

## Getting Started

### Prerequisites

-   PHP >= 8.1 with required extensions
-   Composer
-   Node.js >= 18 and npm
-   MySQL

### Installation

Clone and bootstrap the project:

```bash
git clone https://github.com/<your-org>/taskmanager.git
cd taskmanager

cp .env.example .env    # or copy manually on Windows
composer install
npm install
php artisan key:generate

# Configure database credentials in .env before migrating
php artisan migrate --seed

# Run the dev services
npm run dev              # builds assets in watch mode
php artisan serve        # http://127.0.0.1:8000
```

> **Tip:** Use `npm run build` for a production-ready asset bundle.

### Seeded Accounts

| Role  | Email               | Password   |
| ----- | ------------------- | ---------- |
| Admin | `admin@example.com` | `password` |
| User  | `user@example.com`  | `password` |

Update or remove these credentials in the database seeder if deploying to production.

## Usage

-   **Dashboard:** Displays task metrics tailored to the logged-in user (admins see global stats).
-   **Tasks:** Users can create, update, and delete their own tasks; admins can assign tasks to any user.
-   **Categories:** All authenticated users can browse categories and view related tasks; only admins can create or modify categories.
-   **Admin Centre:** `/admin` exposes user counts, recent activity, and user management tables.

Authorization rules are enforced via `TaskPolicy`, guaranteeing that non-admins cannot modify tasks they do not own.

## Common Commands

```bash
php artisan test          # run the test suite
php artisan optimize:clear
php artisan migrate:fresh --seed
npm run lint              # if you add lint tooling
```

## Project Structure

-   `app/Http/Controllers` – Task and Category controllers plus admin dashboard logic.
-   `app/Http/Requests` – Form requests handling validation and authorization.
-   `app/Policies` – Task policy enforcing ownership rules.
-   `resources/views` – Blade templates for layouts, tasks, categories, auth, and admin pages.
-   `database/seeders` – Seeds demo users, categories, and tasks.

## Testing

```bash
php artisan test
```

Add feature tests in `tests/Feature` as the app evolves.

## Contributing

1. Fork the repository and create a feature branch.
2. Ensure coding standards and tests pass.
3. Open a pull request detailing your changes.

## License

This project is open-sourced software licensed under the MIT license.
