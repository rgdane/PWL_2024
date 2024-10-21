<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;

Route::pattern ('id','[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('create', [UserController::class, 'create']); //form tambah user
Route::post('store', [UserController::class, 'store']); //data user baru

Route::middleware( ['auth'])->group(function(){
        
    Route::get('/', [WelcomeController::class,'index']);

    Route::middleware(['authorize:ADM,CEO'])->group(function(){
        Route::group(['prefix' => 'user'], function(){
            Route::get('/', [UserController::class, 'index']); //halaman awal
            Route::post('/list', [UserController::class, 'list']);  //data user (json)
            // Route::get('/create', [UserController::class, 'create']); //form tambah user
            // Route::post('/', [UserController::class, 'store']); //data user baru
            
            Route::get('/create_ajax', [UserController::class, 'createAjax']); //form tambah user Ajax
            Route::post('/ajax', [UserController::class, 'storeAjax']); //data user baru Ajax

            Route::get('/{id}', [UserController::class, 'show']); //detail user
            Route::get('/{id}/edit', [UserController::class, 'edit']); //form edit
            Route::put('/{id}', [UserController::class, 'update']); // simpan perubahan data
            
            Route::get('/{id}/edit_ajax', [UserController::class, 'editAjax']); //form edit Ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'updateAjax']); // simpan perubahan data Ajax
            
            Route::get('/{id}/confirm_ajax', [UserController::class, 'confirmAjax']); //menampilkan confirm delete user Ajax
            Route::delete('/{id}/delete_ajax', [UserController::class, 'deleteAjax']); //hapus data user Ajax

            Route::delete('/{id}', [UserController::class, 'destroy']); //hapus data user

            Route::get('/import', [UserController::class, 'import']); //ajax form upload excel
            Route::post('/import_ajax', [UserController::class, 'import_ajax']); //ajax import excel
            Route::get('/export_excel', [UserController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [UserController::class, 'export_pdf']); //export pdf
        });
    });

    Route::middleware(['authorize:ADM,CEO'])->group(function(){
        Route::group(['prefix' => 'level'], function(){
            Route::get('/', [LevelController::class, 'index']); //halaman awal
            Route::post('/list', [LevelController::class, 'list']);  //data level (json)
            Route::get('/create', [LevelController::class, 'create']); //form tambah level
            Route::post('/', [LevelController::class, 'store']); //data level baru
            Route::get('/{id}/edit', [LevelController::class, 'edit']); //form edit
            Route::put('/{id}', [LevelController::class, 'update']); // simpan perubahan data
            Route::delete('/{id}', [LevelController::class, 'destroy']); //hapus data level
            
            Route::get('/create_ajax', [LevelController::class, 'createAjax']); //menamilkan halaman tamabh user ajax
            Route::post('/ajax', [LevelController::class, 'storeAjax']);
    
            Route::get('/{id}', [LevelController::class, 'show']); //detail level

            Route::get('/{id}/edit_ajax', [LevelController::class, 'editAjax']); //form edit
            Route::put('/{id}/update_ajax', [LevelController::class, 'updateAjax']); // simpan perubahan data
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirmAjax']);
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'deleteAjax']);

            Route::get('/import', [LevelController::class, 'import']); //ajax form upload excel
            Route::post('/import_ajax', [LevelController::class, 'import_ajax']); //ajax import excel
            Route::get('/export_excel', [LevelController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [LevelController::class, 'export_pdf']); //export pdf
        });
    });

    Route::middleware(['authorize:ADM,STF,MNG,CEO'])->group(function(){
        Route::group(['prefix' => 'kategori'], function(){
            Route::get('/', [KategoriController::class, 'index']); //halaman awal
            Route::post('/list', [KategoriController::class, 'list']);  //data kategori (json)
            Route::get('/create', [KategoriController::class, 'create']); //form tambah kategori
            Route::post('/', [KategoriController::class, 'store']); //data kategori baru

            Route::get('/create_ajax', [KategoriController::class, 'createAjax']); //menamilkan halaman tamabh user ajax
            Route::post('/ajax', [KategoriController::class, 'storeAjax']);

            Route::get('/{id}', [KategoriController::class, 'show']); //detail kategori
            Route::get('/{id}/edit', [KategoriController::class, 'edit']); //form edit
            Route::put('/{id}', [KategoriController::class, 'update']); // simpan perubahan data

            Route::get('/{id}/edit_ajax', [KategoriController::class, 'editAjax']); //form edit
            Route::put('/{id}/update_ajax', [KategoriController::class, 'updateAjax']); // simpan perubahan data
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirmAjax']);
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'deleteAjax']);

            Route::delete('/{id}', [KategoriController::class, 'destroy']); //hapus data kategori
            
            Route::get('/import', [KategoriController::class, 'import']); //ajax form upload excel
            Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); //ajax import excel
            Route::get('/export_excel', [KategoriController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [KategoriController::class, 'export_pdf']); //export pdf
        });
    });

    Route::middleware(['authorize:ADM,CEO,MNG'])->group(function(){
        Route::group(['prefix' => 'supplier'], function(){
            Route::get('/', [SupplierController::class, 'index']); //halaman awal
            Route::post('/list', [SupplierController::class, 'list']);  //data supplier (json)
            Route::get('/create', [SupplierController::class, 'create']); //form tambah supplier
            Route::post('/', [SupplierController::class, 'store']); //data supplier baru

            Route::get('/create_ajax', [SupplierController::class, 'createAjax']); //menamilkan halaman tamabh user ajax
            Route::post('/ajax', [SupplierController::class, 'storeAjax']);

            Route::get('/{id}', [SupplierController::class, 'show']); //detail supplier
            Route::get('/{id}/edit', [SupplierController::class, 'edit']); //form edit
            Route::put('/{id}', [SupplierController::class, 'update']); // simpan perubahan data
            
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'editAjax']); //form edit
            Route::put('/{id}/update_ajax', [SupplierController::class, 'updateAjax']); // simpan perubahan data
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirmAjax']);
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'deleteAjax']);

            Route::delete('/{id}', [SupplierController::class, 'destroy']); //hapus data supplier

            Route::get('/import', [SupplierController::class, 'import']); //ajax form upload excel
            Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); //ajax import excel
            Route::get('/export_excel', [SupplierController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [SupplierController::class, 'export_pdf']); //export pdf
        });
    });

    Route::middleware(['authorize:ADM,MNG,STF,CEO'])->group(function(){
        Route::group(['prefix' => 'barang'], function(){
            Route::get('/', [BarangController::class, 'index']); //halaman awal
            Route::post('/list', [BarangController::class, 'list']);  //data barang (json)
            Route::get('/create', [BarangController::class, 'create']); //form tambah barang
            Route::post('/', [BarangController::class, 'store']); //data barang baru
            
            Route::get('/create_ajax', [BarangController::class, 'createAjax']); //menamilkan halaman tamabh user ajax
            Route::post('/ajax', [BarangController::class, 'storeAjax']);

            Route::get('/{id}', [BarangController::class, 'show']); //detail barang
            Route::get('/{id}/edit', [BarangController::class, 'edit']); //form edit
            Route::put('/{id}', [BarangController::class, 'update']); // simpan perubahan data
            
            Route::get('/{id}/edit_ajax', [BarangController::class, 'editAjax']); //form edit
            Route::put('/{id}/update_ajax', [BarangController::class, 'updateAjax']); // simpan perubahan data
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirmAjax']);
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'deleteAjax']);
            
            Route::delete('/{id}', [BarangController::class, 'destroy']); //hapus data barang
            
            Route::get('/import', [BarangController::class, 'import']); //ajax form upload excel
            Route::post('/import_ajax', [BarangController::class, 'import_ajax']); //ajax import excel
            Route::get('/export_excel', [BarangController::class, 'export_excel']); //export excel
            Route::get('/export_pdf', [BarangController::class, 'export_pdf']); //export pdf
        });
    });

});

