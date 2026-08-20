<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Public Authentication Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Public Catalogue Routes
|--------------------------------------------------------------------------
*/
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Public Contact Routes
|--------------------------------------------------------------------------
*/
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| Product Management Routes: Admin and Manager
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:admin,manager'])->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::patch('/products/{product}', [ProductController::class, 'update']);
});

/*
|--------------------------------------------------------------------------
| Product Dangerous Operations: Admin Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);

    Route::patch('/users/{user}/role', [UserController::class, 'updateRole']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::post('/products/bulk-store', [ProductController::class, 'bulkStore']);
});

/*
|--------------------------------------------------------------------------
| Category Management Routes: Admin Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::patch('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
});

// some simple test routes to demonstrate role-based access control using the custom RoleMiddleware
Route::middleware(['auth:sanctum'])->get('/profile', function (Request $request) {
    return response()->json([
        'status' => true,
        'message' => 'Authenticated user profile fetched successfully',
        'user' => $request->user(),
    ]);
});

Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin-dashboard', function () {
    return response()->json([
        'status' => true,
        'message' => 'Welcome Admin. You can manage the whole catalogue.',
    ]);
});

Route::middleware(['auth:sanctum', 'role:admin,manager'])->get('/manager-area', function () {
    return response()->json([
        'status' => true,
        'message' => 'Welcome. Admins and managers can access this area.',
    ]);
});

Route::middleware(['auth:sanctum', 'role:admin,manager,staff'])->get('/staff-area', function () {
    return response()->json([
        'status' => true,
        'message' => 'Welcome. All authenticated staff-level users can access this area.',
    ]);
});


/*
|--------------------------------------------------------------------------
| Contact Messages Management Routes: Admin Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::get('/contacts/{contactMessage}', [ContactController::class, 'show']);
});