<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/admin', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('books', \App\Http\Controllers\Admin\BookController::class);
    Route::get('/admin/books', [\App\Http\Controllers\Admin\BookController::class, 'index'])->name('admin.books');
    Route::patch('/admin/books/status/{id}', [\App\Http\Controllers\Admin\BookController::class, 'changeStatus'])->name('admin.books.changeStatus');

    Route::resource('genres', \App\Http\Controllers\Admin\GenreController::class);
    Route::get('/admin/genres', [\App\Http\Controllers\Admin\GenreController::class, 'index'])->name('admin.genres');
});

require __DIR__.'/auth.php';
