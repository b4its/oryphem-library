<?php

use App\Http\Controllers\BookControllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(BookControllers::class)->group(function () {
    Route::get('/api/books', 'api_getBook_all')->name('getBook');       // Tampilkan semua post
}); 