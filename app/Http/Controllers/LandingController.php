<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;


class LandingController extends Controller
{
    public function index()
    {

        $berita = Berita::orderBy('tanggalBerita', 'desc')
            ->skip(1)
            ->take(6) 
            ->get();
        $beritaUtama = Berita::orderBy('tanggalBerita', 'desc')->take(1)->get();
        return view('landingpage', [
            "berita" => $berita,
            "beritaUtama" => $beritaUtama,
            "title" => "SDN Lemahbang",
            "title2" => "",
        ]);
    }
}
