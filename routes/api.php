<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\TailorController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\RatingController;

// User Auth
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/users', [UserController::class, 'index']);

// Tailor
Route::get('/tailors', [TailorController::class, 'index']);
Route::get('/tailors/{id}', [TailorController::class, 'show']);
Route::post('/tailors', [TailorController::class, 'store']);

// Ratings
Route::get('/ratings', [RatingController::class, 'index']);
Route::post('/ratings', [RatingController::class, 'store']);
Route::post('/ratings/reply', [RatingController::class, 'reply']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);

    Route::post('/mobile/payment/token', [OrderController::class, 'createSnapTokenMobile']);
    Route::get('/mobile/order/{id}', [OrderController::class, 'getOrderStatus']);
});
