<?php

use App\Http\Controllers\TokenControllers;
use Illuminate\Support\Facades\Route;

// ROUTE API untuk mengambil alamat wallet platform (membutuhkan autentikasi)
    Route::get('/platform-wallet', [TokenControllers::class, 'getPlatformWallet'])->name('api.platform-wallet');
