<?php

use Illuminate\Support\Facades\Route;

Route::prefix('crm')->name('crm.')->group(function (): void {
    Route::get('/', fn () => view('crm.coming-soon'))->name('home');
});
