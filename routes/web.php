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

Route::get('/', [\App\Http\Controllers\MainController::class,'main'])->name('main');
Route::get('/sync', [\App\Http\Controllers\MainController::class,'syncPage'])->name('sri');
Route::get('/data', [\App\Http\Controllers\MainController::class,'data'])->name('data');
Route::post('/sri_sync', [\App\Http\Controllers\MainController::class,'sync'])->name('sri_sync');
