<?php

use Illuminate\Support\Facades\Route;

Route::domain('crm.sanadcx.com')->name('crm.')->group(function (): void {
    Route::get('/', fn () => view('crm.coming-soon'))->name('home');
});
