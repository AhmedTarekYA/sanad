<p align="center">
  <img src="public/admin/login/imgs/Frame_36125.svg" width="260" alt="Nami Dashboard">
</p>

<h1 align="center">Nami Dashboard</h1>

<p align="center">
  A clean Laravel admin dashboard starter for building structured, scalable projects faster.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel 13">
  <img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP 8.3 or higher">
  <img src="https://img.shields.io/badge/License-MIT-111827?style=flat-square" alt="MIT License">
</p>

## Overview

Nami Dashboard is a Laravel-based admin starter designed around a consistent application structure:

`Model → Request → Service → Controller → Resource / Blade`

It includes a responsive admin interface, Arabic and English localization, authentication, permissions, DataTables, theme customization, and project file generators.

## Requirements

- PHP 8.3 or higher
- Composer
- Node.js and npm
- MySQL or another Laravel-supported database

## Installation

```bash
git clone <repository-url>
cd nami-v13
composer install
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`, then run:

```bash
php artisan migrate
npm install
npm run build
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`.

## Project Generator

Generate project files from your migrations with:

```bash
php artisan app:set-project-files YourProjectName --resources --blades
```

| Option | Description |
| --- | --- |
| `--resources` | Generate API resources. |
| `--blades` | Generate CRUD Blade templates. |

> The generator may ask to install `krlove/eloquent-model-generator` for relationship-aware models. Review your migration workflow before running it on a shared or production database.

## Architecture

| Layer | Location | Responsibility |
| --- | --- | --- |
| Models | `app/Models` | Eloquent models and relationships. |
| Requests | `app/Http/Requests` | Validation and input rules. |
| Services | `app/Services` | Application and business logic. |
| Controllers | `app/Http/Controllers` | HTTP orchestration and responses. |
| Repositories | `app/Repositories` | Reusable data-access abstractions when needed. |
| Views | `resources/views` | Blade pages and dashboard UI. |
| Utilities | `app/Utils` | Generator templates and shared helpers. |

Keep controllers focused on the request flow. Put reusable business logic in services and keep validation inside Form Requests.

## Included Features

- Responsive Laravel admin dashboard
- Arabic RTL and English LTR support
- Light, dark, and automatic color modes
- Custom primary color and appearance settings
- Authentication and admin profile management
- Roles and permissions with Laratrust
- Reusable CRUD generators
- Yajra DataTables integration
- File uploads and image processing
- API support with Sanctum and JWT
- Log viewer and developer utilities

## Useful Commands

```bash
php artisan route:list
php artisan optimize:clear
php artisan test
vendor/bin/pint
```

For local development:

```bash
npm run dev
```

## Localization

The dashboard supports:

- Arabic: `/ar/...`
- English: `/en/...`

Translations live in `lang/ar` and `lang/en`. Add new labels to both language files to keep the interface consistent.

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
