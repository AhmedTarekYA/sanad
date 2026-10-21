<?php

namespace App\Providers;

use App\Models\Nami\MainSetting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Models\Nami\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        //Register custom migration paths
        $migrationsPath = database_path('migrations');
        $directories = glob($migrationsPath . '/*', GLOB_ONLYDIR);
        $paths = array_merge([$migrationsPath], $directories);

        $this->loadMigrationsFrom($paths);
         // تسجيل الإعدادات كـ Singleton
         $this->app->singleton('settings', function () {
            return Setting::with('translations')->first();
        });

        // تسجيل الإعدادات الرئيسية كـ Singleton
        $this->app->singleton('main_setting', function () {
            return MainSetting::with('translations')->first();
        });

         // تسجيل صلاحيات المستخدم كـ Singleton
        $this->app->singleton('user_permission_list', function () {
            if (Auth::guard('admin')->user() && Auth::guard('admin')->user()->roles->count() > 0) {
                return Auth::guard('admin')->user()->roles->first()->permissions->pluck('name')->toArray();
            }
            return [];
        });

         // مشاركة البيانات مع جميع الـ Views
         View::composer('*', function ($view) {
            $view->with('settings', app('settings'));
            $view->with('main_setting', app('main_setting'));
            $view->with('user_permission_list', app('user_permission_list'));
        });
    }
}
