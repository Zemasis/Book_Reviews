<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PreviewController;

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::resource('books', BookController::class);

Route::resource('authors', AuthorController::class)
    ->only(['index','show','create','store']);

    // Authentication routes

Route::get('register', [AuthController::class, 'showRegister'])
->name('register');
Route::get('login', [AuthController::class, 'showLogin'])
->name('login');
Route::post('register', [AuthController::class, 'register'])
->name('register');
Route::post('login', [AuthController::class, 'login'])
->name('login');
Route::post('logout', [AuthController::class, 'logout'])
->name('logout');
