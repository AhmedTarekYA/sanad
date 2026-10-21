<?php

use App\Http\Controllers\Sanad\Authentication\AdminController;
use App\Http\Controllers\Sanad\Authentication\AdminLoginController;
use App\Http\Controllers\Sanad\Authentication\ChangePasswordController;
use App\Http\Controllers\Sanad\Authentication\ProfileController;
use App\Http\Controllers\Sanad\Blog\BlogController;
use App\Http\Controllers\Sanad\Command\CommandController;
use App\Http\Controllers\Sanad\Command\TerminalController;
use App\Http\Controllers\Sanad\Command\UpdateController;
use App\Http\Controllers\Sanad\DashboardController;
use App\Http\Controllers\Sanad\Env\EnvController;
use App\Http\Controllers\Sanad\Permission\PermissionController;
use App\Http\Controllers\Sanad\Permission\RoleController;
use App\Http\Controllers\Sanad\Settings\MainSettingController;
use App\Http\Controllers\Sanad\Settings\SettingController;
use App\Http\Controllers\Sanad\Translator\TranslatorController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/user', [UserController::class, 'index']);

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['adminLocale', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ], function () {
        // --------------------------------------------------------
        Route::get('/', [AdminLoginController::class, 'index'])->name('admin.root');

        Route::group(['prefix' => 'dashboard'], function () {
            Route::group(['middleware' => ['admin', 'preventBack', 'checkPermission']], function () {
                Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('admin', 'preventBack');

                // ---------------------------------------------------
                Route::resource('settings', SettingController::class);
                Route::resource('main-settings', MainSettingController::class);

                Route::resource('env', EnvController::class);
                // ---------------------------------------------------
                Route::resource('profile', ProfileController::class);
                Route::resource('change-password', ChangePasswordController::class);
                Route::resource('admins', AdminController::class);
                // ---------------------------------------------------
                Route::resource('commands', CommandController::class);
                Route::resource('terminal', TerminalController::class);

                // ------------------------------------
                Route::resource('permissions', PermissionController::class);
                Route::resource('roles', RoleController::class);

                Route::resource('blogs', BlogController::class)->parameters(['blogs' => 'id']);

            });

            // ---------------------- pull new updates -------------------------
            Route::resource('updates', UpdateController::class);
            // -----------------------------------------------------------------

            Route::get('login', [AdminLoginController::class, 'index'])->name('admin.form.login');
            Route::post('/login', [AdminLoginController::class, 'create'])->name('admin.login');
            Route::get('/logout', [AdminLoginController::class, 'store'])->name('admin.logout');

            Route::resource('translator', TranslatorController::class);

        });
    });
