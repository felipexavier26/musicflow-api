<?php

use App\Http\Controllers\Api\MusicaController;
use Illuminate\Support\Facades\Route;


Route::get('/musicas', [MusicaController::class, 'index']);
Route::get('/musicas/{id}', [MusicaController::class, 'show']);
Route::post('/musicas', [MusicaController::class, 'store']);
Route::put('/musicas/{id}', [MusicaController::class, 'update']);
Route::delete('/musicas/{id}', [MusicaController::class, 'destroy']);