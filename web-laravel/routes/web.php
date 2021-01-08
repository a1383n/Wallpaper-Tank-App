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

Route::get('/',[\App\Http\Controllers\WallpaperController::class,'index']);
Route::get('/wallpapers/{id}',[\App\Http\Controllers\WallpaperController::class,'show'])->where('id','[0-9]+')->name('single_wallpaper');
