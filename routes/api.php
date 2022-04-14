<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\IzinController;
use App\Http\Controllers\Api\SakitController;
use App\Http\Controllers\Api\LaporanHarianController;
use App\Http\Controllers\Api\LaporanKunjunganController;

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

//cek absen
Route::post('cek-absen-masuk',[AbsensiController::class,'cekAbsenMasuk']);
Route::post('cek-absen-pulang',[AbsensiController::class,'cekAbsenPulang']);

//Absensi
Route::group(['middleware' => 'auth:api'], function(){
	Route::post('absen-masuk',[AbsensiController::class,'absenMasuk']);
    Route::put('absen-pulang',[AbsensiController::class,'absenPulang']);
    Route::post('izin',[IzinController::class,'izin']);
    Route::get('daftar-pengajuan-izin',[IzinController::class,'daftarIzin']);
    Route::post('sakit',[SakitController::class,'sakit']);
    Route::get('daftar-pengajuan-sakit',[SakitController::class,'daftarSakit']);
    Route::post('laporan-harian',[LaporanHarianController::class,'laporanHarian']);
    Route::post('laporan-kunjungan',[LaporanKunjunganController::class,'laporanKunjungan']);
    Route::get('get-absensi',[AbsensiController::class,'getCountAbsensi']);
    Route::get('get-profile',[AuthController::class,'getProfile']);
    Route::put('update-profile',[AuthController::class,'updateProfile']);
    Route::put('update-password',[AuthController::class,'updatePassword']);
});
