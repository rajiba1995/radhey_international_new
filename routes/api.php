<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CollectionController;
use App\Http\Controllers\Api\FabricController;
use App\Http\Controllers\Api\BusinessTypeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/country-list', [AuthController::class, 'CountryList']);
Route::get('/country/details/{id}', [AuthController::class, 'CountryDetailsByID']);
Route::post('/check-device', [AuthController::class, 'checkDevice']);
Route::post('/user-login', [AuthController::class, 'userLogin']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/set-mpin', [AuthController::class, 'setMpin']);
Route::post('/mpin-login', [AuthController::class, 'mpinLogin']);

Route::post('/forgot-mpin', [AuthController::class, 'forgotMpin']);
Route::post('/verify-otp-mpin', [AuthController::class, 'verifyOtpMpin']);
Route::post('/reset-mpin', [AuthController::class, 'resetMpin']);


// Route::middleware('auth:sanctum', 'token.expiry')->group(function () {
Route::middleware('auth:sanctum', 'token.session')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // profile
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::get('/customer/list', [AuthController::class, 'customer_list']);





    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/list', [UserController::class, 'list'])->name('user.list');
        Route::get('/search', [UserController::class, 'search'])->name('user.search');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('user.show');
    });

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category-collection-wise/{categoryid}', [CategoryController::class, 'getCategoriesByCollection'])->name('category.collection-wise');
    });
    
    Route::get('/collection', [CollectionController::class, 'index']);
    Route::get('/fabric', [FabricController::class, 'index']);
    Route::get('/business-type', [BusinessTypeController::class, 'index']);
   
    Route::prefix('product')->group(function () {
        Route::get('/products-category-collection-wise', [ProductController::class, 'getProductsByCategoryAndCollection']);
        Route::get('/products-collection-wise', [ProductController::class, 'getProductsByCollection']);
    });
    
    
    Route::prefix('order')->group(function () { 
        Route::post('/store', [OrderController::class, 'createOrder']);
        Route::get('/list', [OrderController::class, 'index']);
    });
    
    // More routes related to products can be added here
    // Route::get('/products', [ProductController::class, 'index']);
    // Route::put('/products/{id}', [ProductController::class, 'update']);
    // Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});