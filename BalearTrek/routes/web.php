<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\InterestingPlaceController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\TrekController;
use Illuminate\Support\Facades\Route;

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
});
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Listado y búsqueda
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    // Actualización (Rol, Estado, etc.)
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});
require __DIR__.'/auth.php';
