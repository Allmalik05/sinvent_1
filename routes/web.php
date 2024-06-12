<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangmasukController;
use App\Http\Controllers\BarangkeluarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('login');
});

Route::resource('barang', BarangController::class)->middleware('auth');;

Route::resource('kategori', KategoriController::class)->middleware('auth');;

Route::resource('barangmasuk', BarangmasukController::class)->middleware('auth');;

Route::resource('barangkeluar', BarangkeluarController::class)->middleware('auth');;

// ROUTE LOGIN
Route::get('login', [LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('loginAction', [LoginController::class,'authenticate']);


// ROUTE LOGOUT
Route::get('logout', [LoginController::class,'logout']);
Route::post('logout', [LoginController::class,'logout'])->name('logout');

// ROUTE REGISTER
Route::get('register', [RegisterController::class,'create']);
Route::post('register', [RegisterController::class,'store']);