<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pegawai;
use App\Models\PPGuru;
use App\Models\Profil;
use App\Models\Siswa;
use Illuminate\Http\Request;


class LandingController extends Controller
{
    public function index()
    {

        $profil = Profil::all();
        $berita = Berita::orderBy('waktu', 'desc')->take(3)
            ->get();
        $guru = Pegawai::where('jenisPegawai', 'Guru')->count();
        $siswa = Siswa::all()->count();
        $ppguru = PPGuru::all();
        return view('landingpage', compact('berita', 'guru', 'profil', 'siswa'), [
            "title" => "SDN Lemahbang",
            "title2" => "",
            'pguru' => $ppguru
        ]);
    }
}
