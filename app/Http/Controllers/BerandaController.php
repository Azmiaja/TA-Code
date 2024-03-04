<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(){
        $pegawai = auth()->user()->pegawai->namaPegawai ?? auth()->user()->namaSiswa;
        return view('siakad/content/dashboard/index', [
            'judul' => 'Beranda',
            'sub_judul' => 'Beranda',
            'text_singkat' => 'Selamat datang <a href="' . route('profil_pengguna.index') . '" class="fw-semibold">' . $pegawai . '</a>, di SIAKAD SD Negeri Lemahbang',
        ]);
    }
}
