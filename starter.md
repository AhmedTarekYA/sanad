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

## 9. DataTable Filters

Every CRUD index **must** have a filter bar above the table. Add whichever filters make sense for the resource (featured flag, status, date range, category, etc.).

### Pattern

**View** — filter bar + `showDataTableWithFilters` instead of `showDataTable`:

```blade
{{-- Filter Bar --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-3">
                <label class="form-label mb-1 small fw-semibold">{{ __('auth.status') }}</label>
                <select id="filter-status" class="form-select form-select-sm">
                    <option value="">{{ __('auth.all') }}</option>
                    <option value="1">{{ __('auth.active') }}</option>
                    <option value="0">{{ __('auth.inactive') }}</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label mb-1 small fw-semibold">{{ __('auth.date_from') }}</label>
                <input type="date" id="filter-date-from" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label mb-1 small fw-semibold">{{ __('auth.date_to') }}</label>
                <input type="date" id="filter-date-to" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button id="btn-filter" class="btn btn-primary btn-sm flex-grow-1">
                    <i class="ti ti-filter me-1"></i>{{ __('auth.filter') }}
                </button>
                <button id="btn-reset-filter" class="btn btn-outline-secondary btn-sm">
                    <i class="ti ti-refresh"></i>
                </button>
            </div>
        </div>
    </div>
</div>
```

```js
// Use showDataTableWithFilters instead of showDataTable
showDataTableWithFilters("{{ $dataTableRoute }}", columns, function () {
    return {
        status:    $('#filter-status').val(),
        date_from: $('#filter-date-from').val(),
        date_to:   $('#filter-date-to').val(),
    };
});

$('#btn-filter').on('click', function () { window.reloadDataTable(); });
$('#btn-reset-filter').on('click', function () {
    $('#filter-status, #filter-date-from, #filter-date-to').val('');
    window.reloadDataTable();
});
```

**Controller** — read filter params and apply `where` clauses before passing to DataTables:

```php
if ($request->ajax()) {
    $data = $service->getDataTable();

    if ($request->filled('status')) {
        $data->where('is_active', (bool) $request->status);
    }
    if ($request->filled('date_from')) {
        $data->whereDate('created_at', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $data->whereDate('created_at', '<=', $request->date_to);
    }

    return DataTables::of($data)->...->make(true);
}
```

**Common filter keys to add to lang files:** `all`, `filter`, `date_from`, `date_to`.

---

## 10. Permissions

Permissions follow the pattern `{resource}-{action}` e.g. `blogs-create`, `blogs-read`.

### 1. Register the resource

Add to `config/laratrust_seeder.php` under `roles_structure.system_manager`:
```php
'blogs' => 'c,r,u,d',
```

### 2. Translate the permissions (REQUIRED)

Add Arabic display names to `$permissionDisplayNames` in `database/seeders/LaratrustSeeder.php`:
```php
'blogs' => [
    'create' => 'إضافة مقال',
    'read'   => 'عرض المقالات',
    'update' => 'تعديل مقال',
    'delete' => 'حذف مقال',
],
```

Then re-run the seeder to apply:
```bash
php artisan db:seed --class=LaratrustSeeder
```

Without this step, permissions appear in English (`Create Blogs`) instead of Arabic.

### 3. Use in code

```php
checkIfHasPermission('blogs-read')   // returns bool; Developer always returns true
```

---

## 10. Localization

- Use `__('auth.key')` in controllers and Blade views.
- Keys for `__('auth.key')` go in **`lang/ar/auth.php`** and **`lang/en/auth.php`** (PHP array, not JSON).
- `lang/ar.json` / `lang/en.json` are for flat `__('key')` lookups — do NOT put `auth.*` keys there.
- Add keys to **both** language files (`ar` and `en`) whenever adding new UI strings.

---

## 11. Testing — يجب اختبار كل تغيير قبل الإنهاء

**قاعدة:** كل تغيير يجب اختباره قبل اعتباره مكتملاً. لا يكفي أن الكود يبدو صحيحاً.

### ماذا تختبر؟

| ما تغير | اختبر |
|---|---|
| Controller جديد | كل route (index / create / store / edit / update / destroy) |
| Form Request | store بدون بيانات مطلوبة → يرجع validation error |
| Service / Model | create, update, delete — تحقق من القاعدة |
| File upload | رفع صورة صغيرة وكبيرة — تتخزن؟ تُعرض؟ |
| ترجمة | افتح الصفحة بالعربي والإنجليزي — لا يظهر `auth.key` |
| صلاحيات | تحقق أن `checkIfHasPermission` يُظهر/يُخفي الأزرار |
| Modal CRUD | افتح modal الإضافة والتعديل — يحمّل؟ يُرسل؟ |

### كيف تختبر؟

```bash
# تشغيل feature tests
php artisan test --compact

# تشغيل test بعينه
php artisan test --filter=BlogTest --compact

# إنشاء feature test جديد
php artisan make:test --phpunit BlogTest
```

### عند اختبار CRUD يدوياً:
1. افتح الصفحة — تظهر بلا أخطاء؟
2. اضغط "إضافة" — يفتح المودل؟
3. أرسل بيانات ناقصة — يظهر error validation؟
4. أرسل بيانات صحيحة — تُضاف السجل في الجدول؟
5. اضغط تعديل — يفتح المودل بالبيانات الموجودة؟
6. عدّل وأرسل — يُحدَّث السجل؟
7. احذف — يُحذف السجل من الجدول؟

---

## 12. Checklist — New Admin Resource

1. Route in `routes/dashboard.php` with `->parameters(['x' => 'id'])`
2. Controller in `app/Http/Controllers/Sanad/{Domain}/`
3. Service in `app/Services/Sanad/` extending `MainService`
4. FormRequest in `app/Http/Requests/Sanad/{Domain}/` extending `MainRequest`
5. Model with `$fillable` + Translation model if multilingual
6. Migrations (main table + `_translations` table if multilingual)
7. Views: `index.blade.php`, `create.blade.php`, `edit.blade.php`
8. Sidebar link in `resources/views/sanad/layout/inc/sidebar.blade.php`
9. Permission entry in `config/laratrust_seeder.php` + Arabic display name in `LaratrustSeeder::$permissionDisplayNames` → re-run seeder
10. Lang keys in `lang/ar/auth.php` + `lang/en/auth.php` (include `all`, `filter`, `date_from`, `date_to`)
11. Filter bar in index view using `showDataTableWithFilters` — see section 9
12. Test manually (open page, create, edit, delete) — see section 12

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
