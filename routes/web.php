<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/books', [App\Http\Controllers\HomeController::class, 'books'])->name('books');
Route::post('/store', [App\Http\Controllers\HomeController::class, 'store'])->name('store');
Route::post('/update/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('update');
Route::delete('/archive/{id}', [App\Http\Controllers\HomeController::class, 'archive'])->name('archive');
Route::delete('/delete/{id}', [App\Http\Controllers\HomeController::class, 'destroy'])->name('delete');

