<?php

use App\Http\Controllers\BookControllers;
use App\Http\Controllers\MetamaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ROUTE METAMASK: Menunjuk ke MetamaskController
Route::controller(MetamaskController::class)->group(function () {
    Route::post('/connect-metamask', 'connectMetamask')->name('metamask.connect'); 
});

Route::controller(BookControllers::class)->group(function () {
    Route::get('/', 'index')->name('dashboard');       // Tampilkan semua post
    Route::get('/api/books', 'api_getBook_all')->name('getBook');       // Tampilkan semua post
}); 