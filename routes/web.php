<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductImageController;

Route::get('/', function () {
    return view('welcome');
});




Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resources([
        'category' => CategoryController::class,
        'product' => ProductController::class,
        'order' => OrderController::class,
    ]);

    Route::controller(ProductController::class)->group(function () {
        Route::post('product/{product}/toggle-status', 'toggleStatus')->name('product.toggleStatus');
    });

    Route::controller(ProductImageController::class)->group(function () {
        Route::post('products/{product}/images', 'store')->name('product-images.store');
        Route::patch('products/{product}/images/{image}/primary', 'setPrimary')->name('product-images.primary');
        Route::delete('product-images/{image}', 'destroy')->name('product-images.destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';