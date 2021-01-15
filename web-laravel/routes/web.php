<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Root Site Routes
Route::get('/', [\App\Http\Controllers\WallpaperController::class, 'index'])->name('index');
Route::get('/wallpapers/{id}', [\App\Http\Controllers\WallpaperController::class, 'show'])->name('single_wallpaper')->where('id', '[0-9]+');
Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('/search', [\App\Http\Controllers\WallpaperController::class, 'search'])->name('search');

// Authentication Routes
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

//Admin Panel Routes
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin_home')->middleware('auth');

//Admin Wallpaper manager routes
Route::get('/admin/wallpapers', [\App\Http\Controllers\AdminController::class, 'wallpapers'])->name('admin_wallpapers')->middleware('auth');
Route::post('/admin/wallpapers',[\App\Http\Controllers\WallpaperController::class,'router'])->middleware('auth');

//Admin Category manager routes
Route::get('/admin/categories',[\App\Http\Controllers\AdminController::class,'category'])->name('admin_categories')->middleware('auth');
Route::post('/admin/categories',[\App\Http\Controllers\CategoryController::class,'router'])->middleware('auth');

Route::post('/like/',[\App\Http\Controllers\WallpaperController::class,'router']);
