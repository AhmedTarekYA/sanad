# Laravel 11 – Admin Dashboard Starter Guide

Follow this guide precisely when adding any feature.

---

## 1. Folder Structure

```
app/
├── Http/Controllers/Sanad/    ← One controller per resource (grouped by domain)
├── Http/Requests/Sanad/       ← extends MainRequest
├── Models/Sanad/              ← Models + Translation models
├── Services/Sanad/            ← extends MainService
├── Enums/
└── Helpers/
    ├── MainHelper.php         ← jsonSuccess, jsonValid, checkIfHasPermission …
    └── ImageHelper.php        ← uploadFile, showFile, deleteFile …

resources/views/sanad/{resource}/
├── index.blade.php
├── create.blade.php
└── edit.blade.php

routes/dashboard.php  ← all dashboard routes
```

---

## 2. Authentication

| Guard | Driver | Model | Used by |
|---|---|---|---|
| `admin` | session | `Admin` | Dashboard (`auth:admin` middleware) |

- `getAuthUser()` → authenticated admin helper
- `checkIfHasPermission('resource-action')` → permission gate helper
- Admin types: `GlobalManger`, `Developer` — Developer bypasses all permission checks

---

## 3. Admin CRUD

### Routes (`routes/dashboard.php`)
All inside the auth middleware group:
```php
Route::resource('my-things', MyThingController::class)->parameters(['my-things' => 'id']);
```
- Always `->parameters(['resource' => 'id'])` so the param is always `$id`.
- Use kebab-case. Results in `my-things.index`, `.store`, `.edit`, `.update`, `.destroy`.

### Controller (`app/Http/Controllers/Sanad/{Domain}/`)
```php
use App\Services\Sanad\SomethingService as ObjService;
use App\Http\Requests\Sanad\Something\SomethingRequest as ObjRequest;

class SomethingController extends Controller
{
    public string $folderPath = 'sanad.somethings';
    public string $mainRoute  = 'somethings';

    public function index(Request $request, ObjService $service)  // DataTable — ajax check inside
    public function create()                                       // returns full page view
    public function store(ObjRequest $r, ObjService $service)     // AJAX → JSON response
    public function edit(int $id, ObjService $service)            // returns full page view
    public function update(ObjRequest $r, int $id, ObjService $service) // AJAX → JSON response
    public function destroy(int $id, ObjService $service)         // returns jsonSuccess()
}
```
**Rules:**
- Service alias = `ObjService`, Request alias = `ObjRequest`.
- Mutating methods return `response()->json(['code' => 200, 'message' => ..., 'url' => ...])`.
- Destroy returns `jsonSuccess()`.
- `edit()` receives `$id` as a route parameter (not from `$request`).
- DataTables: use `escapeColumns([])` for raw HTML columns.

### Form Request (`app/Http/Requests/Sanad/{Domain}/`)
```php
class SomethingRequest extends MainRequest
{
    public function rules(): array
    {
        return match ($this->method()) {
            'POST'          => $this->store(),
            'PUT', 'PATCH'  => $this->update(),
            default         => [],
        };
    }
    protected function store(): array { ... }
    protected function update(): array { ... }
}
```

### Service (`app/Services/Sanad/`)
```php
class SomethingService extends MainService
{
    public function __construct(Something $model)
    {
        $this->model      = $model;
        $this->fileFolder = 'images/somethings/';
        $this->files      = ['image'];       // fields auto-uploaded by clearRequest()
    }
}
```
- Extend `MainService` — it provides `find`, `store`, `update`, `delete`, `getDataTable`, `deleteWithFile`, etc.
- `clearRequest($data)` auto-trims strings, uploads files in `$this->files`, hashes `password`.
- File uploads are auto-converted to `.webp` at 90% quality.

---

## 4. Response Format

```php
// Store / Update — redirect after success
return response()->json([
    'code'    => 200,
    'message' => __('auth.done successfully'),
    'url'     => route('resource.index'),
]);

// Destroy
return jsonSuccess();

// Validation error (handled automatically by MainRequest::failedValidation)
return jsonValid($validator->errors());
```

---

## 5. File Upload

```php
// In MainService constructor:
$this->fileFolder = 'images/folder/';
$this->files = ['image'];           // clearRequest() handles upload automatically

// Manual upload:
$path = uploadFile($request->file('image'), 'images/folder/');

// Show image with fallback:
showFile($model->image)             // → full URL or /default/no_image.png
showFile($model->image, 'admin')    // → full URL or /default/admin.webp

// Delete file:
deleteFile($model->image);
```

---

## 6. Multilingual Fields (astrotomic/laravel-translatable)

```php
// Migration — two tables: {model} + {model}_translations
Schema::create('blog_translations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('blog_id')->constrained()->cascadeOnDelete();
    $table->string('locale', 10);
    $table->string('title');
    $table->text('description')->nullable();
    $table->unique(['blog_id', 'locale']);
});

// Model
class Blog extends Model
{
    use Translatable;
    public $translatedAttributes  = ['title', 'description'];
    protected $translationForeignKey = 'blog_id';
    public $translationModel       = BlogTranslation::class;
}

// Store — pass locale arrays; Astrotomic handles translation records
Blog::create([
    'slug' => 'my-slug',
    'ar'   => ['title' => 'عنوان', 'description' => 'وصف'],
    'en'   => ['title' => 'Title', 'description' => 'Description'],
]);

// Request validation
'ar.title' => ['required', 'string', 'max:255'],
'en.title' => ['nullable', 'string', 'max:255'],

// Blade form inputs
<input name="ar[title]" value="{{ $obj->translate('ar')?->title }}">
<input name="en[title]" value="{{ $obj->translate('en')?->title }}">

// Read in blade
{{ $obj->title }}                       // uses current locale
{{ $obj->translate('ar')?->title }}     // explicit locale
{{ $obj->translateOrDefault('ar')?->title }} // with fallback
```

---

## 7. Naming Conventions

| Thing | Convention | Example |
|---|---|---|
| Controller | PascalCase, grouped in domain folder | `Sanad/Blog/BlogController` |
| Service | `app/Services/Sanad/XyzService.php` | `BlogService` |
| Route name | `{kebab}.{action}` | `blogs.index`, `blogs.store` |
| Route param | always `id` via `->parameters(...)` | `->parameters(['blogs' => 'id'])` |
| View path | `sanad.{snake_case}` | `sanad.blog` |
| Upload folder | `images/{plural}/` | `images/blogs/` |
| Translation model | `{Model}Translation` | `BlogTranslation` |

---

## 8. Seeders — Always Idempotent

```php
Model::updateOrCreate(['name' => $data['name']], $data);
```
- Use `updateOrCreate`, never `firstOrCreate`.
- Plain-text passwords in seeders — `clearRequest()` hashes via bcrypt automatically.
- Register every seeder in `DatabaseSeeder::run()`.
- **عند تعديل أي migration (إضافة/حذف/تغيير عمود) — ابحث عن الـ Seeder المرتبط وعدّله فورًا ليعكس التغيير.**

---

## 9. Permissions

Permissions follow the pattern `{resource}-{action}` e.g. `blogs-create`, `blogs-read`.

Add to `config/laratrust_seeder.php` under `roles_structure.system_manager`:
```php
'blogs' => 'c,r,u,d',
```

Use in controllers and views:
```php
checkIfHasPermission('blogs-read')   // returns bool; Developer always returns true
```

---

## 10. Localization

- Lang files: `lang/ar.json` and `lang/en.json` — flat JSON key/value.
- Use `__('auth.key')` in controllers and Blade views.
- Add keys to **both** files whenever adding new UI strings.

---

## 11. Checklist — New Admin Resource

1. Route in `routes/dashboard.php` with `->parameters(['x' => 'id'])`
2. Controller in `app/Http/Controllers/Sanad/{Domain}/`
3. Service in `app/Services/Sanad/` extending `MainService`
4. FormRequest in `app/Http/Requests/Sanad/{Domain}/` extending `MainRequest`
5. Model with `$fillable` + Translation model if multilingual
6. Migrations (main table + `_translations` table if multilingual)
7. Views: `index.blade.php`, `create.blade.php`, `edit.blade.php`
8. Sidebar link in `resources/views/sanad/layout/inc/sidebar.blade.php`
9. Permission entry in `config/laratrust_seeder.php`
10. Lang keys in `lang/ar.json` + `lang/en.json`

---

## 12. Views — Rules

- Extend `sanad.layout.indexs.index`.
- DataTables index: load `dataTables.min.css` + `dataTables.bundle.js`, call `showDataTable(url, columns)`.
- Forms: use `enctype="multipart/form-data"` when uploading files. Submit via AJAX with `FormData`.
- File inputs: use class `dropify`. Load `dropify.min.css` + `dropify.min.js`.
- Validation: use `$.validate({ modules: 'date, security' })` from jquery-form-validator.
- Success handler: `successToster(...)` then `window.location.href = response.url`.
- Error handler: `handleErrorResponce(response)`.
- Delete button: `deleteButton(route('resource.destroy', id))`.

---

## 13. ⚠️ Dashboard View Text — NEVER Hardcode Arabic Strings

The dashboard is **bilingual (Arabic + English)**. Every user-visible string in any Blade view must come from a translation key.

**Wrong ❌**
```blade
<th>العنوان</th>
```
**Correct ✅**
```blade
<th>{{ __('auth.title') }}</th>
```

---

## 14. Emoji Picker — Notification Pages (Title & Body Fields)

Any page that has a notification **title** or **body** field must include an emoji picker button next to each label, using `emoji-picker-element@1.18.0`.

```blade
<div class="emoji-label">
    <label class="form-label mb-0">عنوان الإشعار</label>
    <button type="button" class="btn btn-sm emoji-btn" data-target="notif-title-ar">😊</button>
</div>
<input type="text" id="notif-title-ar" name="title" class="form-control">
```

One singleton picker per page — see full JS implementation in the old starter for details.
