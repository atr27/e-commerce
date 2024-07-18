<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProductListController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


// User Route

Route::get('/', [UserController::class, 'index'])->name('user.index');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //route checkout
    Route::prefix('checkout')->controller(CheckoutController::class)->group(function () {
        Route::post('order', 'store')->name('checkout.store');
        Route::get('success', 'success')->name('checkout.success');
        Route::get('canceled', 'canceled')->name('checkout.canceled');
    });
});

//cart section
Route::prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('view', 'view')->name('cart.view');
    Route::post('store/{product}', 'store')->name('cart.store');
    Route::patch('update/{product}', 'update')->name('cart.update');
    Route::delete('delete/{product}', 'delete')->name('cart.delete');
});

// product list
Route::prefix('products')->controller(ProductListController::class)->group(function () {
    Route::get('/', 'index')->name('products.index');
    Route::get('show/{id}', 'show')->name('products.show');
});

// End

// Admin Route
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    //Product Route
    Route::get('product', [ProductController::class, 'index'])->name('admin.product.index');
    Route::post('product/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::put('product/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::delete('product/image/{id}', [ProductController::class, 'destroyImage'])->name('admin.image.delete');
    Route::delete('product/delete/{id}', [ProductController::class, 'destroy'])->name('admin.product.delete');

    //Order Route
    Route::get('order', [OrderController::class, 'index'])->name('admin.order.index');

    //Category Route
    Route::get('category', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::post('category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::put('category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('category/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.category.delete');

    //Brand Route
    Route::get('brand', [BrandController::class, 'index'])->name('admin.brand.index');
    Route::post('brand/store', [BrandController::class, 'store'])->name('admin.brand.store');
    Route::put('brand/update/{id}', [BrandController::class, 'update'])->name('admin.brand.update');
    Route::delete('brand/delete/{id}', [BrandController::class, 'destroy'])->name('admin.brand.delete');
});


// End

require __DIR__.'/auth.php';
