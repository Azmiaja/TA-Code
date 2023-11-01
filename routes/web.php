<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Muser;
use App\Http\Controllers\Mkeuangan;
use App\Http\Controllers\Mkelas;
use App\Http\Controllers\Mcompany;
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
// Route::get('/login', LoginController@index);
// Route::namespace('App\Http\Controllers')->group(function () {
//     Route::get('/login', 'LoginController@index');
//     Route::post('/login', 'LoginController@login');
// });

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', [LoginController::class, 'register'])->name('register');

Route::get('/', function () {
    return view('landingpage', [
        "title" => "SDN Lemahbang",
        "title2" => ""
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('muser')->group(function () {
        Route::get('pegawai', [Muser\PegawaiController::class, 'index'])->name('muser.pegawai');
        Route::get('siswa', [Muser\SiswaController::class, 'index'])->name('muser.siswa');
    });

    Route::prefix('mkeuangan')->group(function () {
        Route::get('laporan', [Mkeuangan\LaporanController::class, 'index'])->name('mkeuangan.laporan');
        Route::get('pemberitahuan', [Mkeuangan\PemberitahuanController::class, 'index'])->name('mkeuangan.pemberitahuan');
    });

    Route::prefix('mkelas')->group(function () {
        Route::get('bagiguru', [Mkelas\BagiGuruController::class, 'index'])->name('mkelas.bagiguru');
        Route::get('bagisiswa', [Mkelas\BagiSiswaController::class, 'index'])->name('mkelas.bagisiswa');
        Route::get('laporan', [Mkelas\LaporanController::class, 'index'])->name('mkelas.laporan');
        Route::get('penilaian', [Mkelas\PenilaianController::class, 'index'])->name('mkelas.penilaian');
        Route::get('penjadwalan', [Mkelas\PenjadwalanController::class, 'index'])->name('mkelas.penjadwalan');
        Route::get('penugasan', [Mkelas\PenugasanController::class, 'index'])->name('mkelas.penugasan');
    });

    Route::prefix('mcompany')->group(function () {
        Route::get('berita', [Mcompany\BeritaController::class, 'index'])->name('mcompany.berita');
        Route::get('profil', [Mcompany\ProfilController::class, 'index'])->name('mcompany.profil');
        Route::get('sejarah', [Mcompany\SejarahController::class, 'index'])->name('mcompany.sejarah');
        Route::get('visimisi', [Mcompany\VisiMisiController::class, 'index'])->name('mcompany.visimisi');
    });
});


//
