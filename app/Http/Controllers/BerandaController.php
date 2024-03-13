<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(){
        $auth = auth()->user()->pegawai->namaPegawai ?? auth()->user()->namaSiswa;
        return view('siakad/content/dashboard/beranda', [
            'judul' => 'Beranda',
            'sub_judul' => 'Beranda',
            'text_singkat' => 'Selamat datang <a href="' . route('profil_pengguna.index') . '" class="fw-semibold">' . $auth . '</a>, di SIAKAD SD Negeri Lemahbang',
        ]);
    }
}
