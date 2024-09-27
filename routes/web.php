<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;

Route::get('/', [WelcomeController::class,'index']);

Route::get('/level', [LevelController::class,'index']);
Route::get('/kategori', [KategoriController::class,'index']);
Route::get('/user', [UserController::class,'index']);
Route::get('/user/tambah', [UserController::class,'tambah']);
Route::post('/user/tambah_simpan', [UserController::class,'tambahSimpan']);
Route::get('/user/ubah/{id}', [UserController::class,'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class,'ubahSimpan']);
Route::get('/user/hapus/{id}', [UserController::class,'hapus']);


