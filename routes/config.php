<?php

use App\Http\Controllers\Config\ConfigController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
  Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ["adminLocale", 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        //--------------------------------------------------------
         Route::group(['prefix' => "dashboard"], function () {
            Route::group(["middleware" => ["admin", "preventBack", 'checkPermission']], function () {
                  Route::resource('configs',ConfigController::class);
            });
        });
    }
);
