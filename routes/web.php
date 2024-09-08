<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/greeting', [WelcomeController::class,'greeting']);

Route::get('/', [HomeController::class,'index']);

Route::get('/user/{id}/name/{name}', [UserController::class,'user']);

Route::get('/category/food-beverage', [ProductController::class,'foodBeverage']);
Route::get('/category/beauty-health', [ProductController::class,'beautyHealth']);
Route::get('/category/home-care', [ProductController::class,'homeCare']);
Route::get('/category/baby-kid', [ProductController::class,'babyKid']);

Route::get('/transaction', [POSController::class,'transaction']);

// Route::get('/greeting', function () {
//     return view('blog.hello', ['name' => 'Dane']);
//     });

Route::resource('photos', PhotoController::class);

Route::resource('photos', PhotoController::class)->only([
    'index', 'show'
]);

Route::resource('photos', PhotoController::class)->except([
    'create', 'store', 'update', 'destroy'
]);


Route::get('/hello', [WelcomeController::class, 'hello']);

Route::get('/world', function () {
    return 'World';
});

Route::get('/about', [AboutController::class, 'about']);

Route::get('/articles/{id}', [ArticleController::class, 'articles']);

// Route::get('/about', function () {
//     return 'NIM : 2241760113 <br> Nama : Rega Dane Wijayanta';
// });

Route::get('/user/{name}', function ($name) {
    return 'Nama saya '.$name;
});

Route::get('/posts/{post}/comments/{comment}', function
($postId, $commentId) {
    return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
});

// Route::get('/articles/{id}', function
// ($id) {
//     return 'Halaman Artikel dengan ID '.$id;
// });

Route::get('/user/{name?}', function ($name='John') {
    return 'Nama saya '.$name;
});
    
