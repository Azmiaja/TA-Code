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

