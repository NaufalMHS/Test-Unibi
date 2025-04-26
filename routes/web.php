<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterProdukController;
use App\Http\Controllers\MasterTransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// ADMIN ROUTE
Route::middleware(['auth', 'role:admin'])->prefix('admin')
    ->name('admin.')->group(function () {
        Route::resource('produk', MasterProdukController::class);
        Route::get(('transaksi'), [MasterTransaksiController::class, 'indexAdmin'])->name('transaksi.index');
        Route::resource('transaksi', MasterTransaksiController::class)->only(['show', 'destroy']);
    });

// USER ROUTE

Route::middleware(['auth', 'role:user'])->prefix('user')->as('user.')->group(function () {
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::resource('transaksi', MasterTransaksiController::class)->only(['index', 'show', 'destroy']);
});   