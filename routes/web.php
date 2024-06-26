<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriSimpananController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('kategori_simpanan', KategoriSimpananController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('stocks', StockController::class);
    Route::resource('product_transactions', ProductTransactionController::class);
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
