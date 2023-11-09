<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class LihatBeritaController extends Controller
{
    public function show($id, $slug)
    {
        $berita = Berita::find($id);
        return view('lihatberita', [
            "title" => "Berita Sekolah",
            "title2" => "",
            "berita" => $berita,

        ]);
    }
}
