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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard', [
        "title" => "Dashboard",
        "title2" => ""
    ]);
});

Route::get('/home', function () {
    return view('home', [
        "title" => "Home",
        "title2" => ""
    ]);
});

Route::get('/manajemen-{user}', function ($user) {
    return view("muser-{$user}", [
        "title" => "Manajemen User",
        "title2" => $user,
    ]);
})->where('user', 'pegawai|siswa');

Route::get('/pembagianguru', function () {
    return view('pembagianguru', [
        "title" => "Pembagian Guru",
        "title2" => ""
    ]);
});

Route::get('/profile-sekolah', function () {
    return view('profile-sekolah', [
        "title" => "Profile Sekolah",
        "title2" => ""
    ]);
});

Route::get('/sejarah', function () {
    return view('sejarah', [
        "title" => "Sejarah",
        "title2" => ""
    ]);
});

Route::get('/visimisi', function () {
    return view('visimisi', [
        "title" => "Visi Misi",
        "title2" => ""
    ]);
});

Route::get('/beritasekolah', function () {
    return view('beritasekolah', [
        "title" => "Berita Sekolah",
        "title2" => ""
    ]);
});

Route::get('/pembagiansiswa', function () {
    return view('pembagiansiswa', [
        "title" => "Pembagian Siswa",
        "title2" => ""
    ]);
});

Route::get('/penjadwalanpelajaran', function () {
    return view('penjadwalanpelajaran', [
        "title" => "Penjadwalan Pelajaran",
        "title2" => ""
    ]);
});

Route::get('/penugasansiswa', function () {
    return view('penugasansiswa', [
        "title" => "Penugasan Siswa",
        "title2" => ""
    ]);
});

Route::get('/penilaiansiswa', function () {
    return view('penilaiansiswa', [
        "title" => "Penilaian Siswa",
        "title2" => ""
    ]);
});

Route::get('/laporannilai', function () {
    return view('laporannilai', [
        "title" => "Laporan Nilai",
        "title2" => ""
    ]);
});

Route::get('/pemberitahuanpembayaran', function () {
    return view('pemberitahuanpembayaran', [
        "title" => "Pemberitahuan Pembayaran",
        "title2" => ""
    ]);
});

Route::get('/laporanpembayaran', function () {
    return view('laporanpembayaran', [
        "title" => "Laporan Pembayaran",
        "title2" => ""
    ]);
});