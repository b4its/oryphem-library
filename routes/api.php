<?php

use App\Http\Controllers\BookControllers;
use App\Http\Controllers\TokenControllers;
use Illuminate\Support\Facades\Route;

// ROUTE API untuk mengambil alamat wallet platform (membutuhkan autentikasi)
    Route::get('/platform-wallet', [TokenControllers::class, 'getPlatformWallet'])->name('api.platform-wallet');
// Mengelompokkan rute API di bawah BookControllers
Route::controller(BookControllers::class)->group(function () {
    
    // 1. Mengambil SEMUA buku (TANPA Eager Loading Kategori)
    // URL: /api/books/all
    Route::get('/books', 'api_getBook_all'); 


});