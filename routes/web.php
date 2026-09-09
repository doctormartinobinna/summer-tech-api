<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC STOREFRONT ROUTES
|--------------------------------------------------------------------------
*/

Route::view('/', 'public.home')
    ->name('public.home');

Route::view('/catalogue', 'public.catalogue')
    ->name('public.catalogue');

Route::view('/products', 'public.products.index')
    ->name('public.products.index');

Route::view('/products/{id}', 'public.products.show')
    ->name('public.products.show');

Route::view('/categories-list', 'public.categories.index')
    ->name('public.categories.index');

Route::view('/contact', 'public.contact')
    ->name('public.contact');


/*
|--------------------------------------------------------------------------
| BLADE API PANEL ROUTES
|--------------------------------------------------------------------------
*/

Route::view('/login', 'blade.auth.login')
    ->name('blade.login');

Route::view('/dashboard', 'blade.dashboard')
    ->name('blade.dashboard');

Route::view('/profile', 'blade.profile')
    ->name('blade.profile');

Route::view('/categories', 'blade.categories')
    ->name('blade.categories.manage');

Route::view('/products/manage', 'blade.products')
    ->name('blade.products.manage');

Route::view('/users', 'blade.users')
    ->name('blade.users');