<?php

use App\Http\Controllers\Nami\Env\EnvController;
use App\Http\Controllers\Nami\Settings\MainSettingController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Nami\DashboardController;
use App\Http\Controllers\Nami\Authentication\AdminLoginController;
use App\Http\Controllers\Nami\Settings\SettingController;
use App\Http\Controllers\Nami\Authentication\ProfileController;
use App\Http\Controllers\Nami\Authentication\ChangePasswordController;
use App\Http\Controllers\Nami\Authentication\AdminController;
use App\Http\Controllers\Nami\Command\CommandController;
use App\Http\Controllers\Nami\Command\TerminalController;
use App\Http\Controllers\Nami\Command\UpdateController;
use App\Http\Controllers\Nami\Permission\PermissionController;
use App\Http\Controllers\Nami\Permission\RoleController;
use App\Http\Controllers\Nami\Translator\TranslatorController;

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
        'middleware' => ["adminLocale",'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
    //--------------------------------------------------------
    Route::get('/', [AdminLoginController::class,'index'])->name('admin.root');

    Route::group(['prefix' =>"dashboard"], function () {
        Route::group(["middleware" => ["admin","preventBack", 'checkPermission']], function () {
            Route::get('/', [DashboardController::class,"index"])->name('dashboard.index')->middleware('admin','preventBack');

            //---------------------------------------------------
            Route::resource('settings', SettingController::class);
            Route::resource('main-settings', MainSettingController::class);

            Route::resource('env', EnvController::class);
            //---------------------------------------------------
            Route::resource('profile', ProfileController::class);
            Route::resource('change-password', ChangePasswordController::class);
            Route::resource('admins', AdminController::class);
            //---------------------------------------------------
            Route::resource('commands', CommandController::class);
            Route::resource('terminal', TerminalController::class);

            // ------------------------------------
            Route::resource('permissions', PermissionController::class);
            Route::resource('roles', RoleController::class);


        });

        // ---------------------- pull new updates -------------------------
        Route::resource('updates', UpdateController::class);
        // -----------------------------------------------------------------

        Route::get('login', [AdminLoginController::class,'index'])->name("admin.form.login");
        Route::post('/login', [AdminLoginController::class,'create'])->name('admin.login');
        Route::get('/logout', [AdminLoginController::class,'store'])->name('admin.logout');

        Route::resource('translator', TranslatorController::class);

    });
});

