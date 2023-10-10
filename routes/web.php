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

Route::get('/', function () {
    return view('dashboard', [
        "title" => "Dashboard",
        "title2" => ""
    ]);
});

Route::get('/login', function () {
    return view('login', [
        "title" => "Login",
        "title2" => ""
    ]);
});

Route::get('/home', function () {
    return view('home', [
        "title" => "Home",
        "title2" => ""
    ]);
});

Route::get('/muser-{user}', function ($user) {
    return view("muser/{$user}", [
        "title" => "Manajemen User",
        "title2" => $user,
    ]);
})->where('user', 'pegawai|siswa');

Route::get('/mcompany-{company}', function ($company) {
    return view("mcompany/{$company}", [
        "title" => "Manajemen Company",
        "title2" => $company,
    ]);
})->where('company', 'berita|profil|sejarah|visimisi');

Route::get('/mkelas-{kelas}', function ($kelas) {
    return view("mkelas/{$kelas}", [
        "title" => "Manajemen Kelas",
        "title2" => $kelas,
    ]);
})->where('kelas', 'bagiguru|bagisiswa|laporan|penilaian|penjadwalan|penugasan');

Route::get('/mkeuangan-{keuangan}', function ($keuangan) {
    return view("mkeuangan/{$keuangan}", [
        "title" => "Manajemen Keuangan",
        "title2" => $keuangan,
    ]);
})->where('keuangan', 'laporan|pemberitahuan');

//