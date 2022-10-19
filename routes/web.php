<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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

Route::get('/list',[App\Http\Controllers\ProductController::class,'index']);
Route::post('/update',[App\Http\Controllers\ProductController::class,'update']);
Route::get('/list',[App\Http\Controllers\ProductController::class,'index']);
Route::post('/destroy',[App\Http\Controllers\ProductController::class,'destroy']);


