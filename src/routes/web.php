<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BookController;
use App\Models\Book;

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

Route::get('/', [BookController::class, 'index'])->name('index');
Route::post('/store', [BookController::class, 'store'])->name('books.store');
Route::get('/create', [BookController::class, 'create'])->name('books.create');
Route::delete('/destroy/{id}', [BookController::class, 'destroy'])->name('books.destroy');
Route::get('/export', [BookController::class, 'handleExport'])->name('books.export');