<?php

use App\Http\Controllers\BookControllers;
use App\Http\Controllers\MetamaskController;
use App\Http\Controllers\TokenControllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ROUTE METAMASK: Menunjuk ke MetamaskController
Route::controller(MetamaskController::class)->group(function () {
    Route::post('/connect-metamask', 'connectMetamask')->name('metamask.connect'); 
});

Route::controller(TokenControllers::class)->group(function () {
    Route::post('/buy-token', 'buyToken')->name('token.buy'); 
});

Route::controller(BookControllers::class)->group(function () {
    Route::get('/', 'index')->name('dashboard');       // Tampilkan semua post
    Route::get('/api/books', 'api_getBook_all')->name('getBook');       // Tampilkan semua post
}); 