<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/training', function () {
    return 'Welcome to 2026 Summer Tech Training';
});

//the blade page routes
Route::view('/blade-products', 'blade.products.index')
    ->name('blade.products.index');

Route::view('/blade-products/{id}', 'blade.products.show')
    ->name('blade.products.show');

Route::view('/blade-categories', 'blade.categories.index')
    ->name('blade.categories.index');