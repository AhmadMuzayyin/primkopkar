<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriSimpananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoanCategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavingCategoryController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransaksiJasaController;
use App\Http\Controllers\UserController;
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
        Route::get('product_transactions/save/struk', 'save')->name('save');
        Route::delete('product_transactions/delete/{product_transaction}/{product}', 'delete')->name('delete');
        Route::delete('product_transactions/destroy/{product_transaction}', 'destroy')->name('destroy');
    });
    Route::resource('saving_categories', SavingCategoryController::class)->except('show');
    Route::resource('loan_categories', LoanCategoryController::class)->except('show');
    Route::resource('loans', LoanController::class)->except('show');
    Route::post('loans/{loan}/payment', [LoanController::class, 'payment'])->name('loans.payment');
    Route::controller(SavingController::class)->as('savings.')->group(function () {
        Route::get('savings', 'index')->name('index');
        Route::get('savings/{member}/show', 'show')->name('show');
        Route::post('savings/store', 'store')->name('store');
        Route::get('savings/{saving}/edit', 'edit')->name('edit');
        Route::post('savings/update', 'update')->name('update');
        Route::delete('savings/{saving}/destroy', 'destroy')->name('destroy');
        Route::get('savings/history/{member}', 'history')->name('history');
        Route::delete('savings/history/{saving}/destroy', 'historyDestroy')->name('history.destroy');
    });
    Route::controller(TransaksiJasaController::class)->as('jasa.')->group(function () {
        Route::get('jasa', 'index')->name('index');
    });
    Route::controller(LaporanController::class)->as('laporan.')->group(function () {
        Route::get('laporan', 'index')->name('index');
        Route::get('laporan/toko/piutang_member', 'piutangMember')->name('piutang_member');
        Route::post('laporan/toko/piutang_member/update', 'updatePiutangMember')->name('piutang_member.update');
        Route::get('laporan/toko/perbarang', 'perBarang')->name('perbarang');
    });
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
