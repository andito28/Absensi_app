<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\LaporanHarianController;
use App\Http\Controllers\Admin\LaporanKunjunganController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;

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

//route Authentication
Auth::routes();
Route::match(["GET", "POST"], '/password/reset', function () {
    return redirect('/login');
})->name('password.reset');
Route::match(["GET", "POST"], '/password/reset', function () {
    return redirect('/login');
});
Route::match(["GET", "POST"], '/password/reset/{token}', function () {
    return redirect('/login');
})->name('password.reset');
Route::match(["GET", "POST"], '/register', function () {
    return redirect('/login');
})->name('register');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//route adminn
Route::group(['middleware' => ['auth','checkrole:admin']], function () {

//dashboard
Route::get('/',[HomeController::class,'index'])->name('dashboard');

//user
Route::get('/daftar-karyawan', [UserController::class, 'index'])->name('user');
Route::get('/get-user', [UserController::class, 'dataUser'])->name('user.get');
Route::post('/store-user', [UserController::class, 'store'])->name('user.store');
Route::get('/delete-user/{id}', [UserController::class, 'destroy'])->name('user.delete');
Route::get('/edit-user/{id}', [UserController::class, 'edit'])->name('user.edit');

//absensi
Route::get('/daftar-absen', [AbsensiController::class, 'index'])->name('absen');
Route::get('/get-absen', [AbsensiController::class, 'dataAbsen'])->name('absen.get');

//laporan
Route::get('/laporan-harian', [LaporanHarianController::class, 'index'])->name('laporan.harian');
Route::get('/data-laporan-harian', [LaporanHarianController::class, 'dataLaporanHarian'])->name('laporan.harian.get');
Route::get('/laporan-kunjungan', [LaporanKunjunganController::class, 'index'])->name('laporan.kunjungan');
Route::get('/data-laporan-kunjungan', [LaporanKunjunganController::class, 'dataLaporanKunjungan'])->name('laporan.kunjungan.get');

});
