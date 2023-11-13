<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Profil;
use Illuminate\Http\Request;


class LandingController extends Controller
{
    public function index()
    {

        $profil = Profil::orderBy('idProfil', 'desc')->take(1)->get();
        $berita = Berita::orderBy('waktuBerita', 'desc')
            ->skip(1)
            ->take(6) 
            ->get();
        $beritaUtama = Berita::orderBy('waktuBerita', 'desc')->take(1)->get();
        return view('landingpage', compact('berita', 'beritaUtama', 'profil'), [
            "title" => "SDN Lemahbang",
            "title2" => "",
        ]);
    }
}
