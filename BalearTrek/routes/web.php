<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterestingPlaceController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\TrekController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/treks', \App\Http\Controllers\Api\TrekController::class);
    Route::resource('interesting-places', InterestingPlaceController::class);
    Route::resource('municipis', \App\Http\Controllers\MunicipalityController::class);
    Route::resource('treks', TrekController::class);
    Route::resource('meetings', \App\Http\Controllers\MeetingController::class);
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
    Route::patch('/comments/{comment}/validate', [CommentController::class, 'validateComment'])->name('comments.validate');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::resource('users', UserController::class);
});
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Listado y búsqueda
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    // Actualización (Rol, Estado, etc.)
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});
require __DIR__.'/auth.php';
