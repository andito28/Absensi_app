<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AbsensiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Authentication
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::get('logout',[AuthController::class,'logout'])->middleware('auth:api');

//Absen
Route::group(['middleware' => 'auth:api'], function(){
	Route::post('absen-masuk',[AbsensiController::class,'absenMasuk']);
});
