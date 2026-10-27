<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Website\WebsiteController;

Route::group(
    [
        'as' => 'website.',
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ], function () {
        Route::get('/', [WebsiteController::class, 'home'])->name('home');
        Route::get('/about', [WebsiteController::class, 'about'])->name('about');
        Route::get('/services', [WebsiteController::class, 'services'])->name('services');
        Route::get('/how-it-works', [WebsiteController::class, 'howItWorks'])->name('how-it-works');
        Route::get('/blog', [WebsiteController::class, 'blog'])->name('blog');
        Route::get('/blog/{slug?}', [WebsiteController::class, 'blogArticle'])->name('blog.article');
        Route::get('/privacy-policy', [WebsiteController::class, 'privacy'])->name('privacy');
        Route::get('/terms', [WebsiteController::class, 'terms'])->name('terms');
        Route::get('/404', [WebsiteController::class, 'notFound'])->name('404');
    });
