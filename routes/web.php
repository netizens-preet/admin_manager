<?php

use App\Http\Controllers\{
    ProfileController,
    CategoryController,
    ProductController,
    OrderController,
    DashboardController,
    ProductImageController,
    OrderItemsController,
    TagController,
    UserController
};
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('guest.products.index'));
Route::get('/shop', [ProductController::class, 'shopIndex'])->name('guest.products.index');
Route::get('/shop/{product}', [ProductController::class, 'shopShow'])->name('guest.products.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('order', OrderController::class);
    Route::get('order/{order}/billing', [OrderController::class, 'billing'])->name('order.billing');
    Route::post('order/{order}/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::post('order/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');

    Route::resource('order-item', OrderItemsController::class);

    Route::middleware('checkActiveStatus')
        ->post('/shop/{product}/add-to-order', [ProductController::class, 'addToOrder'])
        ->name('guest.products.addToOrder');

    Route::middleware('admin')->group(function () {
        Route::resource('category', CategoryController::class);
        Route::resource('tag', TagController::class);
        Route::resource('product', ProductController::class);
        Route::post('product/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('product.toggleStatus');

        Route::controller(ProductImageController::class)->prefix('products/{product}/images')->group(function () {
            Route::post('/', 'store')->name('product-images.store');
            Route::patch('{image}/primary', 'setPrimary')->name('product-images.primary');
        });
        Route::delete('product-images/{image}', [ProductImageController::class, 'destroy'])->name('product-images.destroy');

        Route::prefix('user')->name('user.')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('{user}/toggle-status', 'toggleStatus')->name('toggleStatus');
        });
    });
});

require __DIR__ . '/auth.php';