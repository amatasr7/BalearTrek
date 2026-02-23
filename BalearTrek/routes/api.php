<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Trek;
use App\Models\User;
use App\Http\Controllers\Api\TrekController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MeetingController;
use App\Http\Controllers\Api\InterestingPlaceController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Api\Auth\ApiLoginController;
use App\Http\Controllers\Api\Auth\ApiRegisterController;

Route::post('/register-api', [ApiRegisterController::class, 'register']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [ApiLoginController::class, 'login']);

// RUTES PROTEGIDES PER MÚLTIPLES MÈTODES D'AUTENTICACIÓ
Route::middleware('MULTI-AUTH')->group(function () {  // Protegit per 'auth:sanctum' i per 'api-key'
// Route::middleware('auth:sanctum')->group(function () {  // Protegit per 'auth:sanctum'
// Route::middleware('API-KEY')->group(function () {  // Protegit per 'api-key'
    Route::post('/logout', [ApiLoginController::class, 'logout']);

    // Binding de 'user' (ha d'estar abans de les rutes que l'utilitzen)
    Route::bind('user', function ($value) {
        return is_numeric($value)
            ? User::where('id', $value)->firstOrFail()
            : User::where('dni', $value)->firstOrFail();
    });

    // Rutes 'user'
    Route::apiResource('user', UserController::class)->except('index');  // Totes menys 'index'
    Route::middleware('CHECK-ROLEADMIN')->group(function () {
        Route::apiResource('user', UserController::class)->only('index');  // Només admin pot veure tots els usuaris
    });

    // Rutes 'trek' - Alias com 'treks' para que funcione con el frontend
    Route::get('/treks', [TrekController::class, 'index']);
    Route::post('/treks', [TrekController::class, 'store']);
    Route::get('/treks/{trek}', [TrekController::class, 'show']);
    Route::put('/treks/{trek}', [TrekController::class, 'update']);
    Route::delete('/treks/{trek}', [TrekController::class, 'destroy']);
    Route::get('/trek/find/{value}', [TrekController::class, 'find']);  // 'find' substitueix 'show'

    // Rutes 'meetings'
    Route::get('/meetings', [MeetingController::class, 'index']);
    Route::post('/meetings', [MeetingController::class, 'store']);
    Route::get('/meetings/{meeting}', [MeetingController::class, 'show']);
    Route::put('/meetings/{meeting}', [MeetingController::class, 'update']);
    Route::delete('/meetings/{meeting}', [MeetingController::class, 'destroy']);

    // Rutes 'interesting-places'
    Route::get('/interesting-places', [InterestingPlaceController::class, 'index']);
    Route::post('/interesting-places', [InterestingPlaceController::class, 'store']);
    Route::get('/interesting-places/{interestingPlace}', [InterestingPlaceController::class, 'show']);
    Route::put('/interesting-places/{interestingPlace}', [InterestingPlaceController::class, 'update']);
    Route::delete('/interesting-places/{interestingPlace}', [InterestingPlaceController::class, 'destroy']);
});





