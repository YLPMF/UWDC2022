<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [\App\Http\Controllers\API\AuthController::class, 'me'])->name('me');
    Route::get('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout'])->name('logout');

    Route::resource('entries', \App\Http\Controllers\API\EntryController::class)->except('update');
    Route::post('/entries/{id}', [\App\Http\Controllers\API\EntryController::class, 'update'])->name('entry_update');
    Route::get('/options', [\App\Http\Controllers\API\EntryController::class, 'options'])->name('options');
    Route::get('/statistics', [\App\Http\Controllers\API\EntryController::class, 'statistics'])->name('statistics');

});
