<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GiphyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/p', fn() => 200);

Route::post('/login', AuthController::class)->name('login');

Route::get('/gifs', [GiphyController::class, 'index'])->middleware('auth:sanctum')->name('index');

Route::get('/gif/{id}', [GiphyController::class, 'show'])->middleware('auth:sanctum')->name('show');

Route::post('/add-favorite', FavoriteController::class)->middleware('auth:sanctum')->name('favorite');
