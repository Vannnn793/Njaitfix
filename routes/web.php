<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingReplyController;
use App\Http\Controllers\RatingController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('landing');

// Route::get('/dashboard', function () {
//     $user = Auth::user();

//     if ($user->role === 'tailor') {
//         $users = User::where('role', 'customer')->get();
//     } else {
//         $users = User::where('role', 'tailor')->get();
//     }

//     return view('dashboard', compact('users'));
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
// });

// Route::middleware(['auth', 'role:user'])->group(function () {
//     Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
// });

// 🔒 Untuk admin / penjahit
Route::middleware(['web','auth','role:tailor'])->group(function () {
    // Dashboard penjahit (admin)
    Route::get('/admin/dashboard', [AdminController::class, 'index'] )
        ->name('admin.dashboard');
    Route::get('/edit', [AdminController::class, 'edit'])->name('edit');
    Route::post('/admin/dashboard', [AdminController::class, 'update'])->name('update');
    Route::post('/upload', [AdminController::class, 'handleTailorPhoto'])->name('upload');

    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.show');
    Route::delete('/admin/photo/{id}', [AdminController::class, 'deletePhoto'])->name('tailor.photo.delete');


    Route::get('/admin/orders', [OrderController::class, 'Admin'])->name('admin.orders');
    Route::post('/admin/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    Route::delete('/del/{id}',[AdminController::class,'deletephoto'])->name('destroy');
    // Dashboard user biasa
    
    });
Route::middleware(['web','auth','role:customer'])->group(function () {

    Route::get('/user/dashboard', [UserController::class, 'index'])
        ->name('user.dashboard');

    route::get('user/welcome', function(){
        return view('user.welcome');
    })->name('user.welcome');

    Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/payment/{order}', [OrderController::class, 'payment'])->name('order.payment');

    // Callback dari Midtrans
    // Route::post('/midtrans/callback', [OrderController::class, 'handleCallback'])->name('midtrans.callback');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/del/{id}',[OrderController::class,'del'])->name('rmv');
    Route::get('/tailor/{userId}', [AdminController::class, 'show'])->name('user.tailor-detail');

    Route::post('/order/{order}/rate', [RatingController::class, 'store'])->name('order.rate');

    Route::get('/search-tailor', [UserController::class, 'search'])->name('tailor.search');

});

Route::post('/tailor/{tailorId}/rate', [App\Http\Controllers\RatingController::class, 'store'])
    ->middleware('auth')
    ->name('tailor.rate');

    Route::post('/rating/{rating}/reply', [RatingReplyController::class, 'store'])->name('rating.reply.store');
Route::put('/rating/reply/{reply}', [RatingReplyController::class, 'update'])->name('rating.reply.update');


Route::post('/midtrans/callback', [OrderController::class, 'handleCallback'])
    ->name('midtrans.callback');
