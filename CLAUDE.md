# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application running on PHP 8.4. You are an expert with the Laravel ecosystem. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and sanadng.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists (settled decisions, non-obvious traps, standing constraints). Framework and package guidelines that only apply to specific paths (testing, frontend, components) also live there, under `.ai/rules/boost` — this is not just recorded decisions, it is load-bearing guidance you have not seen inline. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.
- Record durable rules with `record-rule` so the next agent or teammate inherits them instead of working them out again. Pass a `glob` (e.g. `app/Http/Controllers/**`), a short `title`, and a few-line `note`. Always use `record-rule`, never your native memory or notes tool — native memory is personal and session-scoped; only `.ai/rules` is shared with the team and persists in the repo.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.
- Activate the `deploying-to-cloud` skill whenever deploying to Laravel Cloud, configuring Cloud environments or resources, using the Cloud CLI, or troubleshooting Cloud deployments.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== phpunit/core rules ===

# PHPUnit

- This project uses PHPUnit. Create tests with `php artisan make:test --phpunit {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, sanadng, structure, dependency isolation, and review.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/phpunit` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.

</laravel-boost-guidelines>

---

## About This Application

**Sanad** is a bilingual (Arabic RTL / English LTR) Laravel admin dashboard. It manages blog content, consultation requests, admins, roles/permissions, site settings, and provides developer tools (terminal, DB backups, system update). The full architecture guide is in `starter.md` — read it before adding any feature.

## Common Commands

```bash
# Run all tests
php artisan test --compact

# Run a single test
php artisan test --filter=BlogTest --compact

# Format PHP after edits
vendor/bin/pint --dirty --format agent

# Seed roles & permissions
php artisan db:seed --class=LaratrustSeeder

# Generate a full CRUD scaffold
php artisan app:set-project-files YourResourceName --resources --blades

# Build frontend assets
npm run build
```

## Architecture

The application follows a strict layered pattern: **Route → Controller → Service → Model**.

- **Routes**: `routes/dashboard.php` (authenticated admin), `routes/web.php` (public), `routes/api.php`
- **Controllers**: `app/Http/Controllers/Sanad/{Domain}/` — thin, delegate all business logic to services
- **Services**: `app/Services/Sanad/` — extend `MainService`, which provides `find`, `store`, `update`, `delete`, `getDataTable`, `clearRequest` (auto-uploads files, hashes passwords)
- **Requests**: `app/Http/Requests/Sanad/{Domain}/` — extend `MainRequest`, split rules into `store()` / `update()` matched by HTTP method
- **Models**: `app/Models/Sanad/` — translatable models come in pairs (e.g. `Blog` + `BlogTranslation`)

### Authentication & Guards

| Guard | Model | Used by |
|---|---|---|
| `admin` | `Admin` | Dashboard — all routes protected by `auth:admin` |
| `web` | `User` | Public website |
| `api` | `User` | API (Sanctum + JWT) |

- `getAuthUser()` — returns the authenticated admin
- `checkIfHasPermission('resource-action')` — permission gate; `Developer` type bypasses all checks

### Route Convention

```php
// Always use ->parameters(['resource' => 'id']) so the param is always $id
Route::resource('my-things', MyThingController::class)->parameters(['my-things' => 'id']);
```

### Response Convention

```php
// Mutating actions (store / update)
return response()->json(['code' => 200, 'message' => __('auth.done successfully'), 'url' => route('resource.index')]);

// Destroy
return jsonSuccess();

// Validation errors are handled automatically by MainRequest::failedValidation → jsonValid()
```

### File Uploads

- Declare `$this->fileFolder = 'images/folder/';` and `$this->files = ['image'];` in the service constructor — `clearRequest()` handles upload automatically, converting to `.webp` at 90% quality.
- Manual helpers: `uploadFile()`, `showFile()`, `deleteFile()` (from `app/Helpers/ImageHelper.php`)

### Multilingual Models (astrotomic/laravel-translatable)

Translatable resources require two tables (`blogs` + `blog_translations`) and two models (`Blog` + `BlogTranslation`). Store with locale-keyed arrays: `['ar' => ['title' => '...'], 'en' => ['title' => '...']]`. Read with `$obj->title` (current locale) or `$obj->translate('ar')?->title`.

### Permissions

Pattern: `{resource}-{action}` (e.g. `blogs-create`).

1. Add to `config/laratrust_seeder.php` under `roles_structure.system_manager`
2. Add Arabic display names to `$permissionDisplayNames` in `database/seeders/LaratrustSeeder.php`
3. Re-run `php artisan db:seed --class=LaratrustSeeder`

### Localization

- Use `__('auth.key')` everywhere — never hardcode Arabic strings in Blade views.
- Keys go in `lang/ar/auth.php` and `lang/en/auth.php` (PHP arrays). Add to **both** files simultaneously.
- `lang/ar.json` / `lang/en.json` are for flat `__('key')` lookups only.

### DataTable Filters

Every index page must include a filter bar above the table. Use `showDataTableWithFilters(url, columns, filterFn)` in JS and apply `where` clauses server-side in the controller's `if ($request->ajax())` block. See `starter.md` §9 for the full template.

### Views

- Extend `sanad.layout.indexs.index`.
- Submit forms via AJAX with `FormData`; success handler calls `successToster(...)` then redirects to `response.url`.
- Error handler: `handleErrorResponce(response)`.
- Delete: `deleteButton(route('resource.destroy', id))`.
- File inputs: class `dropify` + load `dropify.min.css` / `dropify.min.js`.

### Checklist — New Admin Resource

1. Route in `routes/dashboard.php` with `->parameters(['x' => 'id'])`
2. Controller in `app/Http/Controllers/Sanad/{Domain}/`
3. Service in `app/Services/Sanad/` extending `MainService`
4. FormRequest in `app/Http/Requests/Sanad/{Domain}/` extending `MainRequest`
5. Model + Translation model (if multilingual) with migrations
6. Views: `index.blade.php`, `create.blade.php`, `edit.blade.php`
7. Sidebar link in `resources/views/sanad/layout/inc/sidebar.blade.php`
8. Permission entry + Arabic display names → re-run LaratrustSeeder
9. Lang keys in both `lang/ar/auth.php` and `lang/en/auth.php`
10. Filter bar in index using `showDataTableWithFilters`
