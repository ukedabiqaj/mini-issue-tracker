# Mini Issue Tracker

A Laravel 13 issue tracker for small teams to manage **projects**, **issues**, **tags**, and **comments**. Built for the PRITECH technical assessment.

## Features

- **Projects** — list, create, edit, delete, and view issues per project
- **Issues** — full CRUD with filters by status, priority, and tag
- **Tags** — create (unique name) and list; attach/detach on issues via AJAX modal
- **Comments** — paginated AJAX load and create on issue detail pages
- **Search** — debounced text search on issue title/description (bonus)
- **Members** — assign/unassign users to issues via AJAX (bonus)
- **Authorization** — project owners can edit/delete their own projects (bonus)

## Tech Stack

- Laravel 13
- MySQL
- Blade + Tailwind CSS v4 (Vite)
- Vanilla JavaScript (fetch + CSRF)

## Requirements

- PHP 8.3+
- Composer
- Node.js 18+
- MySQL 8+

## Installation

```bash
# Clone the repository
git clone <your-repo-url>
cd mini-issue-tracker

# Install dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate
```

Update `.env` for MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_issue_tracker
DB_USERNAME=root
DB_PASSWORD=

APP_URL=http://mini-issue-tracker.test
```

```bash
# Create database (MySQL)
mysql -u root -e "CREATE DATABASE IF NOT EXISTS mini_issue_tracker;"

# Migrate and seed demo data
php artisan migrate:fresh --seed

# Build frontend assets
npm run build
```

## Running the App

**Laragon:** open `http://mini-issue-tracker.test/projects`

**Artisan serve:**

```bash
php artisan serve
npm run dev   # optional, for live CSS/JS reload
```

## Demo Accounts

| Email | Password | Role |
|-------|----------|------|
| alice@example.com | password | Project owner |
| bob@example.com | password | Project owner |
| test@example.com | password | Project owner |

Log in to edit or delete projects you own.

## Running Tests

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS mini_issue_tracker_test;"
php artisan test
```

## Project Structure

```
app/
├── Http/Controllers/     # Resource + AJAX controllers
├── Http/Requests/        # Form validation
├── Models/               # Eloquent models
└── Policies/             # Project authorization

database/
├── migrations/           # Schema (incl. separate start_date/deadline migration)
├── factories/
└── seeders/

resources/
├── views/                # Blade templates
└── js/modules/           # AJAX: tags, comments, search
```

## API Routes (AJAX)

| Method | URI | Purpose |
|--------|-----|---------|
| GET | `/issues/{issue}/comments` | Paginated comments |
| POST | `/issues/{issue}/comments` | Create comment |
| POST | `/issues/{issue}/tags/{tag}` | Attach tag |
| DELETE | `/issues/{issue}/tags/{tag}` | Detach tag |
| POST | `/issues/{issue}/users/{user}` | Assign member |
| DELETE | `/issues/{issue}/users/{user}` | Unassign member |
| GET | `/issues-search?q=` | Search issues |

## License

MIT
