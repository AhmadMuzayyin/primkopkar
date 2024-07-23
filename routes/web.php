<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriSimpananController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('members', MemberController::class);
    Route::resource('kategori_simpanan', KategoriSimpananController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('products', ProductController::class)->except('show');
    Route::get('products/print', [ProductController::class, 'print'])->name('product.print');
    Route::resource('stocks', StockController::class);
    Route::controller(ProductTransactionController::class)->as('product_transactions.')->group(function () {
        Route::get('product_transactions', 'index')->name('index');
        Route::get('product_transactions/find/{product:barcode}', 'find')->name('find');
        Route::post('product_transactions/store/{product:barcode}', 'store')->name('store');
        Route::post('product_transactions/bayar/{product_transaction}', 'bayar')->name('bayar');
        Route::delete('product_transactions/delete/{product_transaction}/{product}', 'delete')->name('delete');
        Route::delete('product_transactions/destroy/{product_transaction}', 'destroy')->name('destroy');
    });
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
