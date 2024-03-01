<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Dokumentasi;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Profil;
use App\Models\Sekolah;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use League\CommonMark\Node\Block\Document;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function indexHome()
    {
        // $bulanSaatIni = date('m');
        $beritaTerbaru = Berita::orderBy('waktu', 'desc')
            ->take(6)
            ->get()
            ->map(function ($berita) {
                $gambar = $berita->gambar ? asset('storage/' . $berita->gambar) : asset('assets/media/img/404.svg');
                $judul = $berita->judulBerita ?: null;
                $isi = $berita->isiBerita ?: null;
                $id = $berita->idBerita ?: null;
                $slug = $berita->slug ?: null;
                $penulis = implode(' ', array_slice(str_word_count($berita->penulis, 1), 0, 2)) ?: null;
                $tanggal = Carbon::parse($berita->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') ?: null;
                $waktu = Carbon::parse($berita->waktu)->locale('id_ID')->diffForHumans() ?: null;
                return compact('gambar', 'judul', 'penulis', 'tanggal', 'waktu', 'isi', 'slug', 'id');
            });

        $dock = Dokumentasi::where('kategoriMedia', 'Foto')
            ->orderBy('waktu', 'desc')
            ->take(4)
            ->get()
            ->map(function ($foto) {
                $gambar = asset('storage/' . $foto->media);
                return compact('gambar');
            });

        $pegawai = Pegawai::with('jabatanPegawai')->whereHas('jabatanPegawai', function ($query) {
            $query->where('jabatan', 'Kepala Sekolah');
        })->first();

        $kepsek = $pegawai->namaPegawai ?: null;
        $gambarKepsek = $pegawai->gambar ? asset('storage/' . $pegawai->gambar) : asset('assets/media/img/404.svg');
        $jabatan = optional($pegawai->jabatanPegawai)->jabatan ?: null;


        $profil = Profil::all()->first();
        $sambutan = $profil->sambutanKepsek ?: null;

        $data = array_merge(
            $this->getCommonData(),
            ['title' => 'Beranda']
        );

        return view(
            'company_profil/content/home/index',
            compact('dock', 'kepsek', 'gambarKepsek', 'jabatan', 'sambutan', 'beritaTerbaru'),
            $data,

        );
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
                ->take(5)
                ->get()
                ->map(function ($berita) {
                    $gambar = $berita->gambar ? asset('storage/' . $berita->gambar) : asset('assets/media/img/404.svg');
                    $judul = $berita->judulBerita ?: null;
                    $isi = $berita->isiBerita ?: null;
                    $id = $berita->idBerita ?: null;
                    $slug = $berita->slug ?: null;
                    $penulis = implode(' ', array_slice(str_word_count($berita->penulis, 1), 0, 2)) ?: null;
                    $tanggal = Carbon::parse($berita->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') ?: null;
                    $waktu = Carbon::parse($berita->waktu)->locale('id_ID')->diffForHumans() ?: null;
                    return compact('gambar', 'judul', 'penulis', 'tanggal', 'waktu', 'isi', 'slug', 'id');
                });

            $beritaSatuTerbaru = $beritaTerbaru->shift();

            $berita = Berita::whereYear('waktu', $tahun)
                ->whereMonth('waktu', $bulan)
                ->orderBy('waktu', 'desc')
                ->skip(5)
                ->take(PHP_INT_MAX)
                ->get()
                ->map(function ($berita) {
                    $gambar = $berita->gambar ? asset('storage/' . $berita->gambar) : asset('assets/media/img/404.svg');
                    $judul = $berita->judulBerita ?: null;
                    $isi = $berita->isiBerita ?: null;
                    $id = $berita->idBerita ?: null;
                    $slug = $berita->slug ?: null;
                    $penulis = implode(' ', array_slice(str_word_count($berita->penulis, 1), 0, 2)) ?: null;
                    $tanggal = Carbon::parse($berita->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') ?: null;
                    $waktu = Carbon::parse($berita->waktu)->locale('id_ID')->diffForHumans() ?: null;
                    return compact('gambar', 'judul', 'penulis', 'tanggal', 'waktu', 'isi', 'slug', 'id');
                });
        } else {
            // $bulanSaatIni = date('m');

            $beritaTerbaru = Berita::orderBy('waktu', 'desc')
                ->take(5)
                ->get()
                ->map(function ($berita) {
                    $gambar = $berita->gambar ? asset('storage/' . $berita->gambar) : asset('assets/media/img/404.svg');
                    $judul = $berita->judulBerita ?: null;
                    $isi = $berita->isiBerita ?: null;
                    $id = $berita->idBerita ?: null;
                    $slug = $berita->slug ?: null;
                    $penulis = implode(' ', array_slice(str_word_count($berita->penulis, 1), 0, 2)) ?: null;
                    $tanggal = Carbon::parse($berita->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') ?: null;
                    $waktu = Carbon::parse($berita->waktu)->locale('id_ID')->diffForHumans() ?: null;
                    return compact('gambar', 'judul', 'penulis', 'tanggal', 'waktu', 'isi', 'slug', 'id');
                });


            $beritaSatuTerbaru = $beritaTerbaru->shift();

            $berita = Berita::orderBy('waktu', 'desc')
                ->skip(5)
                ->take(PHP_INT_MAX)
                ->get()
                ->map(function ($berita) {
                    $gambar = $berita->gambar ? asset('storage/' . $berita->gambar) : asset('assets/media/img/404.svg');
                    $judul = $berita->judulBerita ?: null;
                    $id = $berita->idBerita ?: null;
                    $slug = $berita->slug ?: null;
                    $penulis = implode(' ', array_slice(str_word_count($berita->penulis, 1), 0, 2)) ?: null;
                    $tanggal = Carbon::parse($berita->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') ?: null;
                    $waktu = Carbon::parse($berita->waktu)->locale('id_ID')->diffForHumans() ?: null;
                    return compact('gambar', 'judul', 'penulis', 'tanggal', 'waktu', 'slug', 'id');
                });
        }
        $data = array_merge(
            $this->getCommonData(),
            ['title' => 'Berita Sekolah']
        );

        return view('company_profil/content/berita/index', compact('berita', 'beritaTerbaru', 'beritaSatuTerbaru', 'ambilBulan', 'ambilTahun'), $data);
    }

    public function bacaBerita($slug, $id)
    {
        $berita = Berita::where('slug', $slug)
            ->where('idBerita', $id)
            ->first();


        $beritaImg = $berita->gambar ? asset('storage/' . $berita->gambar) : asset('assets/media/img/404.svg');
        $contenBerita = $berita->isiBerita ?: null;
        $judul = $berita->judulBerita ?: null;
        $penulis = implode(' ', array_slice(str_word_count($berita->penulis, 1), 0, 2)) ?: null;
        $tanggal = Carbon::parse($berita->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') ?: null;
        $waktu = Carbon::parse($berita->waktu)->locale('id_ID')->diffForHumans() ?: null;

        $data = array_merge(
            $this->getCommonData(),
            $this->getBeritaTerbaru(),
            [
                'title' => Str::title(str_replace('-', ' ', $slug)),
            ]
        );

        return view('company_profil/content/berita/baca', compact('beritaImg', 'contenBerita', 'judul', 'penulis', 'tanggal', 'waktu'), $data);
    }

    public function indexSambutan()
    {
        $pegawai = Pegawai::with('jabatanPegawai')->whereHas('jabatanPegawai', function ($query) {
            $query->where('jabatan', 'Kepala Sekolah');
        })->first();

        $kepsek = $pegawai->namaPegawai ?: null;
        $gambarKepsek = $pegawai->gambar ? asset('storage/' . $pegawai->gambar) : asset('assets/media/img/404.svg');
        $jabatan = optional($pegawai->jabatanPegawai)->jabatan ?: null;


        $profil = Profil::all()->first();
        $sambutan = $profil->sambutanKepsek ?: null;

        $data = array_merge(
            $this->getCommonData(),
            $this->getBeritaTerbaru(),
            ['title' => 'Sambutan Kepala Sekolah']
        );

        return view('company_profil/content/home/sambutan', compact('kepsek', 'gambarKepsek', 'jabatan', 'sambutan'), $data);
    }

    protected function getCommonData()
    {

        $sekolah = Sekolah::find(1)->first();
        $namaSD = $sekolah->namaSekolah ?: 'SD Negeri Lemahbang';
        $logoSD = $sekolah->logo ? asset('storage/' . $sekolah->logo) : asset('assets/media/img/tut-wuri.png');
        $sloganSD = $sekolah->slogan ?: 'Sedan Abang Jaya';
        $emailSD = $sekolah->email ?: 'sdnlemahbang@yahoo.co.id';
        $mapsLink = $sekolah->mapsLink ?: '#';
        $telpSD = $sekolah->telp ?: 'Telepon';
        $alamatSD = $sekolah->alamat ?: 'Alamat';
        $mapsEmbed = $sekolah->mapsEmbed ?: '<iframe></iframe>';


        return compact(
            'namaSD',
            'logoSD',
            'sloganSD',
            'emailSD',
            'mapsLink',
            'telpSD',
            'alamatSD',
            'mapsEmbed',
        );
    }
    protected function getProfil()
    {
        $profil = Profil::orderBy('idProfil')->first();

        $profilDeskripsi = $profil->deskripsi ?: null;
        $profilGambar = $profil->gambar ? asset('storage/' . $profil->gambar) : asset('assets/media/img/404.svg');
        $sejarahDeskripsi = $profil->sejarahText ?: null;
        $sejarahGambar = $profil->sejarahImg ? asset('storage/' . $profil->sejarahImg) : asset('assets/media/img/404.svg');
        $orgDeskripsi = $profil->strukturOrgText ?: null;
        $orgGambar = $profil->strukturOrgImg ? asset('storage/' . $profil->strukturOrgImg) : asset('assets/media/img/404.svg');
        $keuanganDeskripsi = $profil->keuanganText ?: null;
        $keuanganGambar = $profil->keuanganImg ? asset('storage/' . $profil->keuanganImg) : asset('assets/media/img/404.svg');
        $visiDeskripsi = $profil->visi ?: null;
        $misiDeskripsi = $profil->misi ?: null;

        return compact(
            // 'profil',
            'profilDeskripsi',
            'profilGambar',
            'sejarahDeskripsi',
            'sejarahGambar',
            'orgDeskripsi',
            'orgGambar',
            'keuanganDeskripsi',
            'keuanganGambar',
            'visiDeskripsi',
            'misiDeskripsi',
        );
    }

    protected function getBeritaTerbaru()
    {
        // $bulanSaatIni = date('m');
        $beritaTerbaru = Berita::orderBy('waktu', 'desc')
            ->take(4)
            ->get()
            ->map(function ($berita) {
                $gambar = $berita->gambar ? asset('storage/' . $berita->gambar) : asset('assets/media/img/404.svg');
                $judul = $berita->judulBerita ?: null;
                $isi = $berita->isiBerita ?: null;
                $id = $berita->idBerita ?: null;
                $slug = $berita->slug ?: null;
                $penulis = implode(' ', array_slice(str_word_count($berita->penulis, 1), 0, 2)) ?: null;
                $tanggal = Carbon::parse($berita->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') ?: null;
                $waktu = Carbon::parse($berita->waktu)->locale('id_ID')->diffForHumans() ?: null;
                return compact('gambar', 'judul', 'penulis', 'tanggal', 'waktu', 'isi', 'slug', 'id');
            });

        return compact('beritaTerbaru');
    }

    public function tentangProfil()
    {
        $data = array_merge(
            $this->getCommonData(),
            $this->getBeritaTerbaru(),
            $this->getProfil(),
            ['title' => 'Profil Sekolah']
        );
        return view('company_profil/content/tentang_sekolah/profil', $data);
    }
    public function tentangSejarah()
    {
        $data = array_merge(
            $this->getCommonData(),
            $this->getBeritaTerbaru(),
            $this->getProfil(),
            ['title' => 'Sejarah Sekolah']
        );
        return view('company_profil/content/tentang_sekolah/sejarah', $data);
    }
    public function tentangVisiMisi()
    {
        $data = array_merge(
            $this->getCommonData(),
            $this->getBeritaTerbaru(),
            $this->getProfil(),
            ['title' => 'Visi & Misi']
        );
        return view('company_profil/content/tentang_sekolah/visi_misi', $data);
    }
    public function tentangOrg()
    {
        $data = array_merge(
            $this->getCommonData(),
            $this->getBeritaTerbaru(),
            $this->getProfil(),
            ['title' => 'Struktur Organisasi']
        );
        return view('company_profil/content/tentang_sekolah/struktur_org', $data);
    }
    public function tentangKeuangan()
    {
        $data = array_merge(
            $this->getCommonData(),
            $this->getBeritaTerbaru(),
            $this->getProfil(),
            ['title' => 'Laporan Keuangan']
        );
        return view('company_profil/content/tentang_sekolah/keuangan', $data);
    }
    public function galeriFoto()
    {
        $dock = Dokumentasi::where('kategoriMedia', 'Foto')
            ->orderBy('waktu', 'desc')->paginate(12);
        $data = array_merge(
            $this->getCommonData(),
            $this->getBeritaTerbaru(),
            ['title' => 'Galeri Foto']
        );
        return view('company_profil/content/galeri/foto', compact('dock'), $data);
    }
    public function galeriVideo()
    {
        $video = Dokumentasi::where('kategoriMedia', 'Video')
            ->orderBy('waktu', 'desc')->paginate(9);

        $data = array_merge(
            $this->getCommonData(),
            $this->getBeritaTerbaru(),
            ['title' => 'Galeri Video']
        );
        return view('company_profil/content/galeri/video', compact('video'), $data);
    }
    public function kategoriGuru()
    {
        $hasilGabungan = $this->getGabunganDataGuru();

        $data = array_merge(
            $this->getCommonData(),
            $this->getBeritaTerbaru(),
            ['title' => 'Guru Kami']
        );

        return view('company_profil/content/guru/guru', compact('hasilGabungan'), $data);
    }

    private function getGabunganDataGuru()
    {
        $guru = Pegawai::with('jabatanPegawai')->get();

        return $guru->map(function ($pegawai) {
            $namaPegawai = $pegawai->namaPegawai;
            $gambar = $pegawai->gambar ? asset('storage/' . $pegawai->gambar) : null;
            $namaJabatan = optional($pegawai->jabatanPegawai)->jabatan;

            return compact('namaPegawai', 'gambar', 'namaJabatan');
        });
    }

    public function kontak()
    {
        $data = array_merge(
            $this->getCommonData(),
            $this->getBeritaTerbaru(),
            ['title' => 'Hubungi Kami']
        );
        return view('company_profil/content/kontak/index', $data);
    }
}
