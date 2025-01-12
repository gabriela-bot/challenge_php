<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GiphyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', AuthController::class)->name('login');

Route::middleware('auth:api')->group(function () {

    Route::get('/gifs', [GiphyController::class, 'index'])->name('index');

    Route::get('/gif/{id}', [GiphyController::class, 'show'])->name('show');

    Route::post('/add-favorite', FavoriteController::class)->name('favorite');
});

