<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('books.index');
});


// registering book routes
Route::resource('books', BookController::class);

// register reviews route
Route::resource('books.reviews', ReviewController::class)
    ->scoped(['review' => 'book'])
    ->only('create', 'store');
