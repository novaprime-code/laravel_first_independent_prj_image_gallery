<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/category-create', [App\Http\Controllers\HomeController::class, 'createCategory'])->name('category-create');
Route::post('/image-store', 'App\Http\Controllers\GalleryImageController@storeImage')->name('image-store');
Route::post('/image_delete/{id}', 'App\Http\Controllers\GalleryImageController@deleteImage')->name('image_delete');

// category create routes

Route::get('/category-create', 'App\Http\Controllers\CategoryController@create')->name('category-create');
Route::post('/category-create', 'App\Http\Controllers\CategoryController@store')->name('category-store');
