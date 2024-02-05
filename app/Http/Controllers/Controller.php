<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function indexHome(){
        return view('company_profil/content/home/index');
    }
    public function indexBerita(){
        return view('company_profil/content/berita/index');
    }
    public function bacaBerita(){
        return view('company_profil/content/berita/baca');
    }
    public function tentangProfil(){
        return view('company_profil/content/tentang_sekolah/profil');
    }
    public function tentangSejarah(){
        return view('company_profil/content/tentang_sekolah/sejarah');
    }
    public function tentangVisiMisi(){
        return view('company_profil/content/tentang_sekolah/visi_misi');
    }
    public function tentangOrg(){
        return view('company_profil/content/tentang_sekolah/struktur_org');
    }
    public function tentangKeuangan(){
        return view('company_profil/content/tentang_sekolah/keuangan');
    }
    public function galeriFoto(){
        return view('company_profil/content/galeri/foto');
    }
    public function galeriVideo(){
        return view('company_profil/content/galeri/video');
    }
    public function kategoriGuru(){
        return view('company_profil/content/guru/guru');
    }
    public function kontak(){
        return view('company_profil/content/kontak/index');
    }
}
