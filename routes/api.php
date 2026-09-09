<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;


/*
|--------------------------------------------------------------------------
| Public Authentication Routes
|--------------------------------------------------------------------------
|
| These routes are accessible without authentication.
| Registration creates a new account, while login verifies credentials
| and returns an authentication token when the credentials are valid.
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Public Catalogue Routes
|--------------------------------------------------------------------------
|
| These routes allow products and categories to be viewed without
| authentication. They perform read-only operations on catalogue data.
|
*/

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{product}', [ProductController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/categories/{category}', [CategoryController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Public Contact Route
|--------------------------------------------------------------------------
|
| This route receives contact messages submitted from the frontend.
|
*/

Route::post('/contact', [ContactController::class, 'store']);


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
|
| These routes require a valid Laravel Sanctum authentication token.
| Any authenticated user can retrieve their account information
| and log out of the application.
|
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [AuthController::class, 'user']);

    Route::post('/logout', [AuthController::class, 'logout']);

});


/*
|--------------------------------------------------------------------------
| Product Management Routes: Admin and Manager
|--------------------------------------------------------------------------
|
| Product creation and modification are available to authenticated
| users whose role is either admin or manager.
|
*/

Route::middleware(['auth:sanctum', 'role:admin,manager'])->group(function () {

    Route::post('/products', [ProductController::class, 'store']);


    /*
     * This POST route supports product updates that contain FormData.
     *
     * The frontend can send:
     *
     * _method = PUT
     *
     * Laravel then treats the request as a PUT request while the browser
     * sends the uploaded file using multipart/form-data.
     */
    Route::post('/products/{product}', [ProductController::class, 'update']);


    Route::put('/products/{product}', [ProductController::class, 'update']);

    Route::patch('/products/{product}', [ProductController::class, 'update']);

});


/*
|--------------------------------------------------------------------------
| Product Administrative Operations: Admin Only
|--------------------------------------------------------------------------
|
| These operations are restricted to administrators.
| Bulk-store allows several products to be created through one request.
| Product deletion permanently removes a product from the catalogue.
|
*/

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::post('/products/bulk-store', [ProductController::class, 'bulkStore']);

    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

});


/*
|--------------------------------------------------------------------------
| Category Management Routes: Admin Only
|--------------------------------------------------------------------------
|
| Administrators can create, update and delete categories.
| PUT and PATCH both call the update() method but represent slightly
| different HTTP update conventions.
|
*/

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::post('/categories', [CategoryController::class, 'store']);

    Route::put('/categories/{category}', [CategoryController::class, 'update']);

    Route::patch('/categories/{category}', [CategoryController::class, 'update']);

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

});


/*
|--------------------------------------------------------------------------
| User Management Routes: Admin Only
|--------------------------------------------------------------------------
|
| Administrators can retrieve users, create users and change the role
| assigned to an existing user.
|
*/

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::get('/users', [UserController::class, 'index']);

    Route::post('/users', [UserController::class, 'store']);

    Route::patch('/users/{user}/role', [UserController::class, 'updateRole']);

});


/*
|--------------------------------------------------------------------------
| Contact Messages Management Routes: Admin Only
|--------------------------------------------------------------------------
|
| Contact messages submitted through the public contact endpoint can
| only be viewed by authenticated administrators.
|
*/

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::get('/contacts', [ContactController::class, 'index']);

    Route::get('/contacts/{contactMessage}', [ContactController::class, 'show']);

});