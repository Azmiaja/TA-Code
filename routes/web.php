<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelasController;
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
    // SISWA.BLADE
    Route::get('siswa/get-data', [Muser\SiswaController::class, 'getData'])->name('siswa.get-data');
    Route::get('siswa/edit/{id}', [Muser\SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('siswa/update/{id}', [Muser\SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('siswa/destroy/{id}', [Muser\SiswaController::class, 'destroy'])->name('siswa.destroy');

    // PEGAWAI.BLADE
    Route::get('pegawai/get-data', [Muser\PegawaiController::class, 'getData']);
    Route::get('pegawai/edit/{id}', [Muser\PegawaiController::class, 'edit']);
    Route::put('pegawai/update/{id}', [Muser\PegawaiController::class, 'update']);
    Route::delete('pegawai/destroy/{id}', [Muser\PegawaiController::class, 'destroy']);

    // BERITA.BLADE
    Route::get('berita/get-data', [Mcompany\BeritaController::class, 'getData'])->name('berita.get-data');
    Route::get('berita/edit/{id}', [Mcompany\BeritaController::class, 'edit']);
    Route::get('berita/showDelete/{id}', [Mcompany\BeritaController::class, 'showDelete']);
    Route::put('berita/update/{id}', [Mcompany\BeritaController::class, 'update'])->name('berita.update');
    Route::delete('berita/destroy/{id}', [Mcompany\BeritaController::class, 'destroy']);

    // MASTER DATA
    Route::get('periode/guru/get-data', [KelasController::class, 'getPeriodeGuru']);
    Route::get('periode/siswa/get-data', [KelasController::class, 'getPeriodeSiswa']);

    // PERIODE
    Route::get('get-data/periode', [Mkelas\PeriodeController::class, 'getPeriode']);
    Route::get('periode/edit/{id}', [Mkelas\PeriodeController::class, 'edit']);
    Route::put('periode/update/{id}', [Mkelas\PeriodeController::class, 'update']);
    Route::delete('periode/destroy/{id}', [Mkelas\PeriodeController::class, 'destroy']);
});

// --------------------------------------------- SUPER ADMIN -------------------------------------------------------------
Route::middleware(['auth:user', 'ceklevel:Super Admin'])->group(function () {

    //dashboard
    Route::get('/dashboard-super-admin', [HomeController::class, 'indexDashboard'])->name('dashboard.super_admin');
    //manajemen user
    Route::get('user/pegawai/get-data', [Muser\UserController::class, 'getUsrPegawai'])->name('get-user.pegawai');
    Route::get('user/siswa/get-data', [Muser\UserController::class, 'getUsrSiswa'])->name('get-user.siswa');
    Route::put('user/siswa/store/{id}', [Muser\UserController::class, 'storeUsrSiswa'])->name('store-user.siswa');
    Route::get('user/edit/pegawai/{id}', [Muser\UserController::class, 'edit']);
    Route::put('user/update/pegawai/{id}', [Muser\UserController::class, 'update']);
    Route::put('user/update/siswa/{id}', [Muser\UserController::class, 'updateUsrSiswa']);
    Route::get('user/edit/siswa/{id}', [Muser\UserController::class, 'editUsrSiswa']);
    Route::delete('user/destroy/pegawai/{id}', [Muser\UserController::class, 'destroy']);
    Route::delete('user/destroy/siswa/{id}', [Muser\UserController::class, 'destroyUsrSiswa']);

    Route::prefix('manajemen-user')->group(function () {
        Route::resource('pegawai', Muser\PegawaiController::class);
        Route::resource('siswa', Muser\SiswaController::class);
        Route::resource('user', Muser\UserController::class);
    });

    //manajemen profil sekolah
    Route::prefix('company-profil')->group(function () {
        Route::resource('berita', Mcompany\BeritaController::class);
        Route::resource('profil', Mcompany\ProfilController::class);
        Route::put('profil/updateProfil/{id}', [Mcompany\ProfilController::class, 'updateProfil'])->name('profil.updateProfil');
        Route::put('profil/updateSejarah/{id}', [Mcompany\ProfilController::class, 'updateSejarah'])->name('profil.updateSejarah');
        Route::put('profil/updateVisiMisi/{id}', [Mcompany\ProfilController::class, 'updateVisiMisi'])->name('profil.updateVisiMisi');
        // Route::resource('sejarah', Mcompany\SejarahController::class);
        // Route::get('visimisi', [Mcompany\VisiMisiController::class, 'index'])->name('mcompany.visimisi');

    });
    //manajemen guru kelas siswa
    Route::get('data-kelas/edit/guru/{id}', [KelasController::class, 'edit']);
    Route::put('data-kelas/update/guru/{id}', [KelasController::class, 'update']);
    Route::delete('data-kelas/destroy/guru/{id}', [KelasController::class, 'destroy']);

    Route::post('data-kelas/store/siswa', [KelasController::class, 'storeSiswa'])->name('data-kelas.store.siswa');
    Route::get('data-kelas/edit/siswa/{id}', [KelasController::class, 'editSiswa']);
    Route::put('data-kelas/update/siswa/{id}', [KelasController::class, 'updateSiswa']);
    Route::delete('data-kelas/destroy/siswa/{id}', [KelasController::class, 'destroySiswa']);

    Route::get('data-kelas/kelas/form', [KelasController::class, 'getKelas']);

    Route::get('mapel/get-data', [Mkelas\MapelController::class, 'getMapel']);
    Route::get('mapel/edit/{id}', [Mkelas\MapelController::class, 'edit']);
    Route::put('mapel/update/{id}', [Mkelas\MapelController::class, 'update']);
    Route::delete('mapel/destroy/{id}', [Mkelas\MapelController::class, 'destroy']);

    Route::get('pengajar/get-data', [Mkelas\PengajarController::class, 'getPengajar']);
    Route::get('pengajar/get-form', [Mkelas\PengajarController::class, 'getForm']);
    Route::get('pengajar/edit/{id}', [Mkelas\PengajarController::class, 'edit']);
    Route::put('pengajar/update/{id}', [Mkelas\PengajarController::class, 'update']);
    Route::delete('pengajar/destroy/{id}', [Mkelas\PengajarController::class, 'destroy']);

    Route::get('penjadwalan/get-data', [Mkelas\PenjadwalanController::class, 'getJPkelas1']);
    Route::get('penjadwalan/get-form', [Mkelas\PenjadwalanController::class, 'getForm']);
    Route::get('penjadwalan/edit/{id}', [Mkelas\PenjadwalanController::class, 'edit']);
    Route::put('penjadwalan/update/{id}', [Mkelas\PenjadwalanController::class, 'update']);
    Route::delete('penjadwalan/destroy/{id}', [Mkelas\PenjadwalanController::class, 'destroy']);

    Route::prefix('manajemen-kelas')->group(function () {
        Route::resource('data-kelas', KelasController::class)->except(['index']);
        Route::get('data-kelas', [KelasController::class, 'indexMasterDataKelas'])->name('data-kelas.index');
        Route::post('data-kelas/storePeriode', [KelasController::class, 'storePeriode'])->name('data-kelas.storePeriode');
        Route::post('data-kelas/storeKelas', [KelasController::class, 'storeKelas'])->name('data-kelas.storeKelas');
        // Route::get('bagiguru', [Mkelas\BagiGuruController::class, 'index'])->name('mkelas.bagiguru');
        // Route::get('bagisiswa', [Mkelas\BagiSiswaController::class, 'index'])->name('mkelas.bagisiswa');
        Route::resource('penjadwalan', Mkelas\PenjadwalanController::class);
        // Route::get('penugasan', [Mkelas\PenugasanController::class, 'index'])->name('mkelas.penugasan');
       
        Route::get('laporan', [Mkelas\LaporanController::class, 'indexLaporanNilai'])->name('mkelas.laporan');
        Route::resource('periode', Mkelas\PeriodeController::class);
        Route::resource('kelas', Mkelas\KelasController::class);
        Route::resource('mapel', Mkelas\MapelController::class);
        Route::resource('pengajaran', Mkelas\PengajarController::class);
        Route::resource('penilaian', Mkelas\PenilaianController::class);
    });
    //manajemen keuangan
    Route::prefix('keuangan')->group(function () {
        Route::get('laporan', [Mkeuangan\LaporanController::class, 'index'])->name('mkeuangan.laporan');
        Route::get('pemberitahuan', [Mkeuangan\PemberitahuanController::class, 'index'])->name('mkeuangan.pemberitahuan');
    });
});

// ------------------------------------------------ ADMIN -----------------------------------------------------------------
Route::middleware(['auth:user', 'ceklevel:Admin'])->group(function () {

    //dashboard
    Route::get('/dashboard-admin', [HomeController::class, 'indexDashboard'])->name('dashboard.admin');
    //manajemen guru kelas siswa
    Route::prefix('manajemen-kelas')->group(function () {
        // Route::get('bagiguru', [Mkelas\BagiGuruController::class, 'index'])->name('mkelas.bagiguru');
        // Route::get('bagisiswa', [Mkelas\BagiSiswaController::class, 'index'])->name('mkelas.bagisiswa');
        // Route::get('penjadwalan', [Mkelas\PenjadwalanController::class, 'index'])->name('mkelas.penjadwalan');
        Route::get('penugasan', [Mkelas\PenugasanController::class, 'index'])->name('mkelas.penugasan');
        // Route::get('penilaian', [Mkelas\PenilaianController::class, 'index'])->name('mkelas.penilaian');
        Route::get('laporan', [Mkelas\LaporanController::class, 'indexLaporanNilai'])->name('mkelas.laporan');
        // Route::resource('penilaian', Mkelas\PenilaianController::class);
    });
    //manajemen keuangan
    //manajemen keuangan
    Route::prefix('keuangan')->group(function () {
        Route::get('laporan', [Mkeuangan\LaporanController::class, 'index'])->name('mkeuangan.laporan');
        Route::get('pemberitahuan', [Mkeuangan\PemberitahuanController::class, 'index'])->name('mkeuangan.pemberitahuan');
    });
});

// ------------------------------------------------ GURU -----------------------------------------------------------------
Route::middleware('auth:user', 'ceklevel:Guru')->group(function () {
    //dashboard
    Route::get('/dashboard-guru', [HomeController::class, 'indexDashboard'])->name('dashboard.guru');
    //kelas
    Route::prefix('manajemen-kelas')->group(function () {
        Route::get('penugasan', [Mkelas\PenugasanController::class, 'index'])->name('mkelas.penugasan');
        // Route::get('penilaian', [Mkelas\PenilaianController::class, 'index'])->name('mkelas.penilaian');
        Route::get('laporan', [Mkelas\LaporanController::class, 'indexLaporanNilai'])->name('mkelas.laporan');
        // Route::resource('penilaian', Mkelas\PenilaianController::class);
    });
    //keuangan
    Route::prefix('keuangan')->group(function () {
        Route::get('laporan', [Mkeuangan\LaporanController::class, 'index'])->name('mkeuangan.laporan');
        Route::get('pemberitahuan', [Mkeuangan\PemberitahuanController::class, 'index'])->name('mkeuangan.pemberitahuan');
    });
});

// ------------------------------------------------ SISWA -----------------------------------------------------------------
Route::middleware('auth:siswa', 'ceklevel:Siswa')->group(function () {
    //dashboard
    Route::get('/dashboard-siswa', [HomeController::class, 'indexDashboard'])->name('dashboard.siswa');
    //kelas
    Route::prefix('kelas')->group(function () {
        Route::get('penugasan', [Mkelas\PenugasanController::class, 'index'])->name('mkelas.penugasan');
        // Route::get('penilaian', [Mkelas\PenilaianController::class, 'index'])->name('mkelas.penilaian');
        // Route::resource('penilaian', Mkelas\PenilaianController::class);
    });
    //keuangan
    Route::prefix('keuangan')->group(function () {
        Route::get('pemberitahuan', [Mkeuangan\PemberitahuanController::class, 'index'])->name('mkeuangan.pemberitahuan');
    });
});

