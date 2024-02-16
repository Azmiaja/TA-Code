<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function indexHome()
    {
        return view('company_profil/content/home/index');
    }
    public function indexBerita()
    {
        $ambilBulan = Berita::selectRaw('DISTINCT DATE_FORMAT(waktu, "%m") as bulan')
            ->orderBy('bulan', 'desc')
            ->get();
        $ambilTahun = Berita::selectRaw('DISTINCT DATE_FORMAT(waktu, "%Y") as tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        $bulan = request('bulanBerita');
        $tahun = request('tahunBerita');

        if ($bulan && $tahun) {
            // list($tahun, $bulan) = explode('/', $bulan);

            $beritaTerbaru = Berita::whereYear('waktu', $tahun)
                ->whereMonth('waktu', $bulan)
                ->orderBy('waktu', 'desc')
                ->take(4)
                ->get();

            $beritaSatuTerbaru = $beritaTerbaru->shift();

            $berita = Berita::whereYear('waktu', $tahun)
                ->whereMonth('waktu', $bulan)
                ->orderBy('waktu', 'desc')
                ->skip(4)
                ->take(PHP_INT_MAX)
                ->get();
        } else {
            $bulanSaatIni = date('m');

            $beritaTerbaru = Berita::whereMonth('waktu', $bulanSaatIni)
                ->orderBy('waktu', 'desc')
                ->take(4)
                ->get();

            $beritaSatuTerbaru = $beritaTerbaru->shift();

            $berita = Berita::whereMonth('waktu', $bulanSaatIni)
                ->orderBy('waktu', 'desc')
                ->skip(4)
                ->take(PHP_INT_MAX)
                ->get();
        }

        return view('company_profil/content/berita/index', compact('berita', 'beritaTerbaru', 'beritaSatuTerbaru', 'ambilBulan', 'ambilTahun'));
    }

    public function bacaBerita()
    {
        return view('company_profil/content/berita/baca');
    }
    public function tentangProfil()
    {
        return view('company_profil/content/tentang_sekolah/profil');
    }
    public function tentangSejarah()
    {
        return view('company_profil/content/tentang_sekolah/sejarah');
    }
    public function tentangVisiMisi()
    {
        return view('company_profil/content/tentang_sekolah/visi_misi');
    }
    public function tentangOrg()
    {
        return view('company_profil/content/tentang_sekolah/struktur_org');
    }
    public function tentangKeuangan()
    {
        return view('company_profil/content/tentang_sekolah/keuangan');
    }
    public function galeriFoto()
    {
        return view('company_profil/content/galeri/foto');
    }
    public function galeriVideo()
    {
        return view('company_profil/content/galeri/video');
    }
    public function kategoriGuru()
    {
        return view('company_profil/content/guru/guru');
    }
    public function kontak()
    {
        return view('company_profil/content/kontak/index');
    }
}
