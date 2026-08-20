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
Route::view('/blade-products', 'blade.products.index')->name('blade.products.index');
Route::view('/blade-products/{id}', 'blade.products.show')->name('blade.products.show');
Route::view('/blade-categories', 'blade.categories.index')->name('blade.categories.index');

Route::view('/blade-login', 'blade-auth.login')->name('blade.login');
Route::view('/blade-dashboard', 'blade-auth.dashboard')->name('blade.dashboard');
Route::view('/blade-profile', 'blade-auth.profile')->name('blade.profile');
Route::view('/blade-users', 'blade-auth.users')->name('blade.users');
Route::view('/blade-categories-manage', 'blade-auth.categories')->name('blade.categories.manage');
Route::view('/blade-products-manage', 'blade-auth.products')->name('blade.products.manage');