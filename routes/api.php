<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KategoriApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('kategoriApi', KategoriApiController::class);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::post('/kategori', [KategoriController::class, 'store']);
// Route::get('/kategori/{kategori_id}', [KategoriController::class, 'show']);
// Route::put('/kategori/{kategori_id}', [KategoriController::class, 'update']);
// Route::delete('/kategori/{kategori_id}', [KategoriController::class, 'destroy']);



