<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LihatBeritaController;
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

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest:user,siswa');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout']);
// Route::post('/register', [LoginController::class, 'register'])->name('register');

Route::get('/berita-sekolah/{id}/{slug}', [LihatBeritaController::class, 'show'])->name('lihatberita');
Route::get('/', [LandingController::class, 'index'])->name('landingpage');

Route::middleware(['auth:user,siswa'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::middleware('ceklevel:Admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard', [
                'title' => 'Dashboard',
                'title2' => 'Dashboard'
            ]);
        })->name('dashboard');

        Route::prefix('mcompany')->group(function () {
            Route::resource('berita', Mcompany\BeritaController::class);
            Route::resource('profil', Mcompany\ProfilController::class);
            // Route::resource('sejarah', Mcompany\SejarahController::class);
            Route::get('visimisi', [Mcompany\VisiMisiController::class, 'index'])->name('mcompany.visimisi');
        });

        Route::prefix('muser')->group(function () {
            Route::resource('pegawai', Muser\PegawaiController::class);
            Route::resource('siswa', Muser\SiswaController::class);
        });

        Route::prefix('mkelas')->group(function () {
            Route::get('bagiguru', [Mkelas\BagiGuruController::class, 'index'])->name('mkelas.bagiguru');
            Route::get('bagisiswa', [Mkelas\BagiSiswaController::class, 'index'])->name('mkelas.bagisiswa');
            Route::get('penjadwalan', [Mkelas\PenjadwalanController::class, 'index'])->name('mkelas.penjadwalan');
        });

        Route::prefix('mkeuangan')->group(function () {
            Route::get('laporan', [Mkeuangan\LaporanController::class, 'index'])->name('mkeuangan.laporan');
            Route::get('pemberitahuan', [Mkeuangan\PemberitahuanController::class, 'index'])->name('mkeuangan.pemberitahuan');
        });
    });

    // guru
    Route::middleware('ceklevel:Guru')->group(function () {
        Route::prefix('mkelas')->group(function () {
            Route::get('penugasan', [Mkelas\PenugasanController::class, 'index'])->name('mkelas.penugasan');
            Route::get('penilaian', [Mkelas\PenilaianController::class, 'index'])->name('mkelas.penilaian');
            Route::get('laporan', [Mkelas\LaporanController::class, 'index'])->name('mkelas.laporan');
        });

        Route::prefix('mkeuangan')->group(function () {
            Route::get('laporan', [Mkeuangan\LaporanController::class, 'index'])->name('mkeuangan.laporan');
            Route::get('pemberitahuan', [Mkeuangan\PemberitahuanController::class, 'index'])->name('mkeuangan.pemberitahuan');
        });
    });

    // siswa
    Route::prefix('mkeuangan')->group(function () {
        Route::get('pemberitahuan', [Mkeuangan\PemberitahuanController::class, 'index'])->name('mkeuangan.pemberitahuan');
    });

    Route::prefix('mkelas')->group(function () {
        Route::get('penugasan', [Mkelas\PenugasanController::class, 'index'])->name('mkelas.penugasan');
        Route::get('penilaian', [Mkelas\PenilaianController::class, 'index'])->name('mkelas.penilaian');
    });
});





//
