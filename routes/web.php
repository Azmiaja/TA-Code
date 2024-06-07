<?php

use App\Http\Controllers\Absensi;
use App\Http\Controllers\AbsenSiswa;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\GuruProfilController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LihatBeritaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Muser;
use App\Http\Controllers\Mkelas;
use App\Http\Controllers\Mcompany;
use App\Http\Controllers\NilaiSiswaController;
use App\Http\Controllers\Sekolah;
use App\Http\Controllers\Controller;
use App\Http\Controllers\KategoriNilaiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\ProfilUserController;
use App\Http\Controllers\RekapitulasiAbsen;
use App\Http\Controllers\RekapNilaiMapel;
use App\Http\Controllers\Rapor;
use App\Http\Controllers\RekapNilaiSiswa;
use CKSource\CKFinderBridge\Controller\CKFinderController;
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

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest:user,siswa');

Route::any('/ckfinder/connector', [CKFinderController::class, 'requestAction'])
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', [CKFinderController::class, 'browserAction'])
    ->name('ckfinder_browser');

Route::middleware('guest')->group(function () {
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    Route::get('/', [Controller::class, 'indexHome'])->name('home');
    Route::get('/berita', [Controller::class, 'indexBerita'])->name('berita');
    Route::get('/berita-sekolah/{slug}', [Controller::class, 'bacaBerita'])->name('baca_berita');
    Route::get('/sambutan-kepala', [Controller::class, 'indexSambutan'])->name('sambutan');

    Route::prefix('tentang')->group(function () {
        Route::get('/profil-sekolah', [Controller::class, 'tentangProfil'])->name('profil');
        Route::get('/sejarah-sekolah', [Controller::class, 'tentangSejarah'])->name('sejarah');
        Route::get('/visi-misi-sekolah', [Controller::class, 'tentangVisiMisi'])->name('visi_misi');
        Route::get('/struktur-organisasi-sekolah', [Controller::class, 'tentangOrg'])->name('struktur_org');
        Route::get('/keuangan-sekolah', [Controller::class, 'tentangKeuangan'])->name('keuangan');
    });

    Route::prefix('galeri')->group(function () {
        Route::get('/foto-kegiatan', [Controller::class, 'galeriFoto'])->name('galeri_foto');
        Route::get('/video-kegiatan', [Controller::class, 'galeriVideo'])->name('galeri_video');
    });

    Route::prefix('kategori')->group(function () {
        Route::get('/guru', [Controller::class, 'kategoriGuru'])->name('kt_guru');
    });

    Route::get('/hubungi-kami', [Controller::class, 'kontak'])->name('kontak');
    Route::post('pesan/store', [PesanController::class, 'store'])->name('pesan.store');
});

// ROUTE SISWA
Route::middleware(['auth:siswa', 'ceklevel:Siswa'])->group(function () {
    Route::prefix('siswa')->group(function () {
        Route::get('/beranda', [BerandaController::class, 'index'])->name('ss.beranda.index');
        Route::get('/catatan-kehadiran', [AbsenSiswa::class, 'index'])->name('absen-siswa.index');
        Route::get('/penjadwalan-siswa', [Mkelas\PenjadwalanController::class, 'index_siswa'])->name('jadwal.siswa');
        Route::get('/get/kehadiran/siswa', [AbsenSiswa::class, 'getKehadiranSiswa'])->name('get-kehadiran-siswa');
        Route::get('/nilai', [RekapNilaiSiswa::class, 'index'])->name('nilai_siswa.index');
        Route::get('/get/nilai/siswa', [RekapNilaiSiswa::class, 'getTabelrekap'])->name('get-nilai-siswa');
    });
    // get kalender siswa
    Route::get('get-kalender-jadwal', [BerandaController::class, 'getDataKalenderJadwal']);

});

// ROUTE GURU
Route::middleware(['auth:user', 'ceklevel:Guru'])->group(function () {
    Route::prefix('guru')->group(function () {
        Route::get('/beranda', [BerandaController::class, 'index'])->name('gg.beranda.index');
        Route::get('/presensi/kelas', [Absensi::class, 'index'])->name('presensi.index');
        Route::get('/presensi/get-data', [Absensi::class, 'getData']);
        Route::get('/presensi/rekapitulasi', [RekapitulasiAbsen::class, 'index'])->name('rekap.index');
        Route::get('presensi/rekap/kelas', [RekapitulasiAbsen::class, 'getRekapKelas']);
        Route::get('presensi/rekap/bulanan/{periode}/{kelas}', [RekapitulasiAbsen::class, 'getRekap']);

        Route::prefix('kategori-penilaian')->group(function () {
            Route::get('/kelas', [KategoriNilaiController::class, 'index'])->name('kategori-nilai.index');
            Route::get('/get-tujuan-pembelajaran', [KategoriNilaiController::class, 'getTP'])->name('get.tp-data');
            Route::post('/store-tujuan-pembelajaran', [KategoriNilaiController::class, 'storeTP'])->name('store.data-tp');
            Route::delete('/delete-tujuan-pembelajaran/{id}', [KategoriNilaiController::class, 'deleteTP']);
            Route::get('/get-lingkup-materi', [KategoriNilaiController::class, 'getLM'])->name('get.lm-data');
            Route::post('/store-lingkup-materi', [KategoriNilaiController::class, 'storeLM'])->name('store.data-lm');
            Route::delete('/delete-lingkup-materi/{id}', [KategoriNilaiController::class, 'deleteLM']);

            Route::get('/get-mapel/guru', [KategoriNilaiController::class, 'getMapelGuru'])->name('get.mapel.gurupengajar');

            Route::get('/get-tp/{id}', [KategoriNilaiController::class, 'getTPById']);
            Route::get('/get-lm/{id}', [KategoriNilaiController::class, 'getLMById']);
            Route::put('/update-tujuan-pembelajaran/{id}', [KategoriNilaiController::class, 'updateTP']);
            Route::put('/update-lingkup-materi/{id}', [KategoriNilaiController::class, 'updateLM']);
        });

        Route::prefix('penilaian-siswa')->group(function () {
            Route::get('/kelas', [PenilaianController::class, 'index'])->name('penilaian.index');
            Route::get('/get-kelas/guru', [PenilaianController::class, 'getKelasGuru'])->name('get.kelas.gurupengajar');
            Route::get('/get-mapel/guru', [PenilaianController::class, 'getMapelGuru'])->name('get.mapel.gurupengajar.nilai');
            Route::delete('/delete-nilaiTP/{id}', [PenilaianController::class, 'deleteTP']);
            Route::delete('/delete-nilaiLM/{id}', [PenilaianController::class, 'deleteLM']);
            Route::delete('/delete-Ntes/{id}', [PenilaianController::class, 'deleteNtes']);
            Route::delete('/delete-Tes/{id}', [PenilaianController::class, 'deleteTes']);

            Route::get('/rekapitulasi-nilai', [RekapNilaiMapel::class, 'index'])->name('rekap_nilai_mapel.index');
            Route::get('/get-tabel-rekap', [RekapNilaiMapel::class, 'getTabelrekap'])->name('get.rekap.nilai');
        });

        Route::prefix('rapor-siswa')->group(function () {
            // Route::get('catatan-guru', [Rapor\CatatanGuru::class, 'index'])->name('catatan.guru.index');
            // Route::get('get-catatan', [Rapor\CatatanGuru::class, 'getCatatanGuru'])->name('get.catatan-guru');
            // Route::post('store/catatan-guru', [Rapor\CatatanGuru::class, 'store'])->name('store.catatan-guru');
            Route::delete('destroy/catatan-guru/{id}', [Rapor\CatatanGuru::class, 'destroy']);

            // Route::get('ekstrakulikuler', [Rapor\KegiatanEkstra::class, 'index'])->name('ekstrakulikuler.index');
            // Route::get('get-ekstrakulikuler', [Rapor\KegiatanEkstra::class, 'getEkstraSiswa'])->name('get.ekstra-siswa');
            // Route::post('store/ekstrakulikuler', [Rapor\KegiatanEkstra::class, 'storeData'])->name('store.ekstra');
            Route::delete('delete/ekstrakulikuler/{id}', [Rapor\KegiatanEkstra::class, 'destroy']);

            // Route::get('keterangan-naik-tidak', [Rapor\KetNaikTidak::class, 'index'])->name('ket.naik-tidak.index');
            // Route::get('get/keterangan-naik-tidak', [Rapor\KetNaikTidak::class, 'getKetNaikTidak'])->name('get-data.ket.naik-tidak');
            // Route::post('store/keterangan-naik-tidak', [Rapor\KetNaikTidak::class, 'store'])->name('store-data.ket.naik-tidak');
            Route::delete('delete/keterangan-naik-tidak/{id}', [Rapor\KetNaikTidak::class, 'destroy']);

            Route::get('cetak-rapor', [Rapor\RaporSiswa::class, 'index'])->name('cetak_rapor.index');

            Route::get('input-rapor', [Rapor\InputRapor::class, 'index'])->name('input.rapor.index');
            Route::get('form/input-rapor', [Rapor\InputRapor::class, 'getForm'])->name('get-form.input.rapor');
            Route::post('store/input-rapor', [Rapor\InputRapor::class, 'store'])->name('store.input.rapor');
        });
    });
    // get kalender guru
    Route::get('get-guru-jadwal', [BerandaController::class, 'getDataKalenderJadwalGuru']);
});

// ROUTE ALL
Route::middleware(['auth:user,siswa'])->group(function () {
    //dashboard
    Route::get('/get-jadwal/siswa', [Mkelas\PenjadwalanController::class, 'getJadwalSiswa'])->name('get-jadwal.siswa');

    // absen
    Route::get('rekap/absen/siswa/kelas{name}/{bulan}', [Absensi::class, 'rekapitulasi'])->name('rekapitulasi.index');
    Route::get('get/siswa/absen/{kelas}/{periode}', [Absensi::class, 'show']);
    Route::get('get/absen/siswa/{idSiswa}/{tgl}', [Absensi::class, 'getKehadiran']);
    Route::get('get/tanggal/absen/{kelas}/{periode}', [Absensi::class, 'getTanggalBulan']);
    Route::post('siswa/absen/store', [Absensi::class, 'store'])->name('absen.siswa.store');
    Route::put('siswa/absen/update', [Absensi::class, 'update'])->name('absen.siswa.update');
    Route::delete('siswa/absen/delete/{id}', [Absensi::class, 'destroy'])->name('absen.siswa.delete');


    // PESAN
    Route::get('pesan/get-data', [PesanController::class, 'getData'])->name('pesan.get-data');
    Route::delete('pesan/destroy/{id}', [PesanController::class, 'destroy']);

    // PROFIL GURU.BLADE
    Route::get('profil-guru/edit/{id}', [GuruProfilController::class, 'edit'])->name('profil-guru.edit');
    Route::delete('profil-guru/destroy/{id}', [GuruProfilController::class, 'destroy'])->name('profil-guru.destroy');
    Route::post('profil-guru/store', [GuruProfilController::class, 'store'])->name('profil-guru.store');


    // PERIODE
    Route::get('get-data/periode', [Mkelas\PeriodeController::class, 'getPeriode'])->name('get.periode');
    // Route::post('periode/store', [Mkelas\PeriodeController::class, 'store'])->name('periode.store');
    Route::get('periode/edit/{id}', [Mkelas\PeriodeController::class, 'edit']);
    Route::put('periode/update/{id}', [Mkelas\PeriodeController::class, 'update']);
    Route::delete('periode/destroy/{id}', [Mkelas\PeriodeController::class, 'destroy']);

    // NILAI SISWA
    Route::get('get-nilai-data', [NilaiSiswaController::class, 'getNilaiData'])->name('nilai.get-data');
    Route::get('nilai_siswa/edit/{id}/{idPengajaran}/{idPeriode}', [NilaiSiswaController::class, 'edit'])->name('nilai_siswa.edit');
    Route::post('nilai_siswa/up', [NilaiSiswaController::class, 'up']);

    // RAPOR
    Route::get('siswa-rapor', [Rapor\RaporSiswa::class, 'getSiswa'])->name('get-siswa.rapor');
    Route::get('rapor-data/mapel', [Rapor\RaporSiswa::class, 'getMapelData'])->name('get-data.rapor.mapel');
    Route::get('rapor-data', [Rapor\RaporSiswa::class, 'getRapor'])->name('get-data.rapor');


    // CHART
    Route::get('chart/donat/user', [HomeController::class, 'getChartUser']);
    Route::get('chart/jenis-kelamin', [HomeController::class, 'getChartJK']);
    Route::get('chart/jumlah-siswa', [HomeController::class, 'jumlahSiswa']);
    Route::get('chart/jumlah-siswa-aktif', [HomeController::class, 'jumlahSiswaAktif']);

    // get chart bar pengajar per kelas
    Route::get('jumlah-pengajar-per-kelas/{periode}', [HomeController::class, 'jumlahPengajarPerKelas']);


    // PENJADWALAN
    Route::get('penjadwalan/get-form', [Mkelas\PenjadwalanController::class, 'getForm']);
    Route::get('penjadwalan/get-data', [Mkelas\PenjadwalanController::class, 'getJPkelas1']);
    Route::get('penjadwalan/edit/{id}', [Mkelas\PenjadwalanController::class, 'edit']);
    Route::post('penjadwalan/store', [Mkelas\PenjadwalanController::class, 'store']);
    Route::put('penjadwalan/update/{id}', [Mkelas\PenjadwalanController::class, 'update']);
    Route::delete('penjadwalan/destroy/{id}', [Mkelas\PenjadwalanController::class, 'destroy']);

    //manajemen guru kelas siswa
    Route::get('kelas/options', [KelasController::class, 'getOptions'])->name('get.kelas.options');
    Route::get('/get-existing-classes/{id}', [KelasController::class, 'getExistingClasses'])->name('get-existing-classes');


    Route::get('data-kelas/edit/guru/{id}', [KelasController::class, 'edit']);
    Route::put('data-kelas/update/guru/{id}', [KelasController::class, 'update']);
    Route::delete('data-kelas/destroy/guru/{id}', [KelasController::class, 'destroy']);
    Route::post('data-kelas/store/guru', [KelasController::class, 'store'])->name('data-kelas.store.guru');
    Route::get('data-kelas/get/guru', [KelasController::class, 'getGuru']);
    Route::get('data-kelas/option/guru/{id}', [KelasController::class, 'getGuruOption']);

    // manajemen siswa kelas
    Route::get('data-kelas/get/siswa', [Mkelas\DataSiswaController::class, 'getSiswa']);
    Route::post('data-kelas/store/siswa', [Mkelas\DataSiswaController::class, 'storeSiswa'])->name('data-kelas.store.siswa');
    Route::get('data-kelas/edit/siswa/{id}', [Mkelas\DataSiswaController::class, 'editSiswa']);
    Route::put('data-kelas/update/siswa/{id}', [Mkelas\DataSiswaController::class, 'updateSiswa']);
    Route::delete('data-kelas/destroy/siswa/{id}', [Mkelas\DataSiswaController::class, 'destroySiswa']);
    Route::get('data-kelas/option/siswa', [Mkelas\DataSiswaController::class, 'getSiswaOption']);

    // show kelas
    Route::get('data-kelas/kelas/form', [KelasController::class, 'getKelas'])->name('form.kelas');


    Route::get('penjadwalan/get-jam', [Mkelas\PenjadwalanController::class, 'getJamKe']);
    Route::post('penjadwalan/store/jam', [Mkelas\PenjadwalanController::class, 'storeJam'])->name('penjadawalan.store.jam');
    Route::put('penjadwalan/update/jam/{id}', [Mkelas\PenjadwalanController::class, 'updateJam']);
    Route::get('penjadwalan/jam/{id}', [Mkelas\PenjadwalanController::class, 'showJamKe']);
    Route::delete('penjadwalan/destroy/jam/{id}', [Mkelas\PenjadwalanController::class, 'deleteJam']);


    // show penilaian siswa
    // Route::get('penilaian/get-data', [Mkelas\PenilaianController::class, 'getNilaiSiswa']);

    // show kelas per periode
    // Route::get('/get-kelas-by-periode/{periode_id}', [Mkelas\PenilaianController::class, 'getKelasByPeriode']);

    // store kelas & periode
    Route::post('data-kelas/storePeriode', [KelasController::class, 'storePeriode'])->name('data-kelas.storePeriode');
    Route::post('data-kelas/storeKelas', [KelasController::class, 'storeKelas'])->name('data-kelas.storeKelas');

    // show dan store nilai
    Route::get('/nilai_siswa/{slug}/{id}/{kelas_id}/{periode_id}', [NilaiSiswaController::class, 'index'])->name('nilai-siswa.index');
    Route::post('simpan-nilai', [NilaiSiswaController::class, 'simpanNilai']);

    // Profil Pengguna
    Route::get('/profil-pengguna', [ProfilUserController::class, 'index'])->name('profil_pengguna.index');
    Route::put('/profil-pengguna/update/password', [ProfilUserController::class, 'changePassword'])->name('update.password');
    Route::put('/profil-pengguna/update/foto-profil/{id}', [ProfilUserController::class, 'updateFotoProfil'])->name('profil_pengguna.update.foto-profil');
    Route::put('/profil-pengguna/update/biografi/{id}', [ProfilUserController::class, 'updateBiografi'])->name('profil_pengguna.update.biografi');
    Route::put('/profil-pengguna/update/biografi/siswa/{id}', [ProfilUserController::class, 'updateBiografiSiswa'])->name('profil_pengguna.update.biografi.siswa');
    Route::get('/get/data/user', [ProfilUserController::class, 'getDataUser'])->name('get.profil');


    // penilaian
    Route::get('get-data/penilaian-siswa', [PenilaianController::class, 'getPenilaian']);
    Route::post('store/penilaian-siswa/tp', [PenilaianController::class, 'storeNilaiTP'])->name('store.nilai.tp');
    Route::post('store/penilaian-siswa/lm', [PenilaianController::class, 'storeNilaiLM'])->name('store.nilai.lm');
    Route::post('store/penilaian-siswa/non-tes', [PenilaianController::class, 'storeNANonTes'])->name('store.nilai.akhir.nontes');
    Route::post('store/penilaian-siswa/tes', [PenilaianController::class, 'storeNATes'])->name('store.nilai.akhir.tes');
});

// ROUTE ADMIN && SUPER ADMIN
Route::middleware(['auth:user', 'ceklevel:Super Admin|Admin'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'indexBeranda'])->name('dashboard.index');
    Route::get('/chart/pengguna', [HomeController::class, 'chart'])->name('chart.pengguna');

    // Data master sekolah
    Route::prefix('data-master')->group(function () {
        Route::resource('pegawai', Muser\PegawaiController::class);
        Route::get('siswa', [Muser\SiswaController::class, 'index'])->name('siswa.index');
        Route::get('sekolah', [Sekolah::class, 'index'])->name('sekolah.index');
        Route::prefix('akademik')->group(function () {
            Route::resource('periode', Mkelas\PeriodeController::class);
            Route::get('kelas', [KelasController::class, 'index'])->name('kelas.index');
            Route::resource('mapel', Mkelas\MapelController::class);
            Route::get('ekstrakuliuler', [Mkelas\MapelController::class, 'indexEkstra'])->name('ekstrakuliuler.index');
            Route::resource('pengajaran', Mkelas\PengajarController::class);
            Route::resource('penjadwalan', Mkelas\PenjadwalanController::class);
            Route::get('data_siswa', [Mkelas\DataSiswaController::class, 'index'])->name('data_siswa.index');
        });
    });

    //manajemen profil sekolah
    Route::prefix('profil-sekolah')->group(function () {
        Route::get('berita', [Mcompany\BeritaController::class, 'index'])->name('berita.index');
        Route::get('profil', [Mcompany\ProfilController::class, 'index'])->name('profil.index');
        Route::get('dokumentasi', [Mcompany\Dokumentasi::class, 'index'])->name('dokumentasi.index');
        Route::get('pesan', [PesanController::class, 'index'])->name('pesan.index');
    });

    // rekap presensi admin/super admin
    Route::prefix('akademik')->group(function () {
        Route::get('presensi', [Absensi::class, 'rekapPresensiAdmin'])->name('re-presensi.index');
        Route::get('presensi/rekap/{periode}/{kelas}', [RekapitulasiAbsen::class, 'getRekap']);
        Route::get('nilai-siswa', [RekapNilaiMapel::class, 'getTabelrekapSiswa'])->name('re-nilai.index');
        Route::get('niali-siswa/rekap/{periode}/{kelas}', [RekapNilaiMapel::class, 'getTabelrekapAdmin']);
        Route::get('rapor-siswa', [Rapor\RaporSiswa::class, 'indexRPA'])->name('sa.rapor-siswa.index');
    });

    // PENGAJARAN.BLADE
    Route::get('pengajar/get-data', [Mkelas\PengajarController::class, 'getPengajar']);
    // Route::get('pengajar/get-form', [Mkelas\PengajarController::class, 'getForm'])->name('pengajar.form');
    Route::get('pengajar/get-mapel/{id}', [Mkelas\PengajarController::class, 'getMapel']);
    Route::get('pengajar/option/guru', [Mkelas\PengajarController::class, 'getPegawaiOption']);
    Route::post('pengajar/store', [Mkelas\PengajarController::class, 'store'])->name('pengajar.store');
    Route::get('pengajar/edit/{id}', [Mkelas\PengajarController::class, 'edit']);
    Route::put('pengajar/update/{id}', [Mkelas\PengajarController::class, 'update'])->name('pengajar.update');
    Route::delete('pengajar/destroy/{id}/{idP}', [Mkelas\PengajarController::class, 'destroy']);

    Route::get('pengajar/mapel/data', [Mkelas\PengajarController::class, 'getMapelPengajar'])->name('data.mapel.pengajar');
    Route::delete('pengajar/destroy/mapel{id}', [Mkelas\PengajarController::class, 'destroyMapel']);
    
    Route::get('jadwal/mapel/data', [Mkelas\PenjadwalanController::class, 'getHpJadwal'])->name('data.mapel.jadwal');
    Route::delete('jadwal/mapel/destroy/{id}', [Mkelas\PenjadwalanController::class, 'destroyJadwal']);

    Route::get('/get-jadwal-guru', [Mkelas\PenjadwalanController::class, 'getJadwalPGuru'])->name('get-jadwalP.guru');

    // MAPEL.BLADE
    Route::get('mapel/get-data', [Mkelas\MapelController::class, 'getMapel']);
    Route::get('mapel/edit/{id}', [Mkelas\MapelController::class, 'edit']);
    Route::put('mapel/update/{id}', [Mkelas\MapelController::class, 'update']);
    Route::delete('mapel/destroy/{id}', [Mkelas\MapelController::class, 'destroy']);

    // EKSTRAKULIKULER
    Route::get('ekstra/get-data', [Mkelas\MapelController::class, 'getEkstra']);
    Route::post('ekstra/store', [Mkelas\MapelController::class, 'storeEkstra'])->name('storeEkstra');
    Route::get('ekstra/edit/{id}', [Mkelas\MapelController::class, 'editEkstra']);
    Route::put('ekstra/update/{id}', [Mkelas\MapelController::class, 'updateEkstra']);
    Route::delete('ekstra/destroy/{id}', [Mkelas\MapelController::class, 'destroyEkstra']);

    // PROFIL SEKOLAH HANDLE
    Route::get('profil/get-data', [Mcompany\ProfilController::class, 'getProfil'])->name('profil.get-data');
    Route::get('profil/edit/{id}', [Mcompany\ProfilController::class, 'edit']);
    Route::put('profil/update/{id}', [Mcompany\ProfilController::class, 'update'])->name('profil.update');
    Route::put('profil-sejarah/update/{id}', [Mcompany\ProfilController::class, 'updateSejarah'])->name('profil-sejarah.update');
    Route::put('profil-organisai/update/{id}', [Mcompany\ProfilController::class, 'updateOrganisasi'])->name('profil-organisasi.update');
    Route::put('profil-keuangan/update/{id}', [Mcompany\ProfilController::class, 'updateKeuangan'])->name('profil-keuangan.update');
    Route::put('profil-visimisi/update/{id}', [Mcompany\ProfilController::class, 'updateVisiMisi'])->name('profil-visimisi.update');
    Route::put('profil-sambutan/update/{id}', [Mcompany\ProfilController::class, 'updateSambutan'])->name('profil-sambutan.update');
    Route::delete('profil/delete/{id}', [Mcompany\ProfilController::class, 'destroy']);
    Route::delete('profil-sejarah/delete/{id}', [Mcompany\ProfilController::class, 'destroySejarah']);
    Route::delete('profil-organisasi/delete/{id}', [Mcompany\ProfilController::class, 'destroyOrg']);
    Route::delete('profil-keuangan/delete/{id}', [Mcompany\ProfilController::class, 'destroyKeuangan']);
    Route::delete('profil-sambutan/delete/{id}', [Mcompany\ProfilController::class, 'destroySam']);

    Route::get('sekolah/get-data', [Sekolah::class, 'getData'])->name('sekolah.get-data');
    Route::put('sekolah/update/{id}', [Sekolah::class, 'update'])->name('sekolah.update');

    // BERITA.BLADE
    Route::get('berita/get-data', [Mcompany\BeritaController::class, 'getDataBerita'])->name('berita.get-data');
    Route::post('berita/store', [Mcompany\BeritaController::class, 'store'])->name('berita.store');
    Route::get('berita/edit/{id}', [Mcompany\BeritaController::class, 'edit']);
    Route::get('berita/showDelete/{id}', [Mcompany\BeritaController::class, 'showDelete']);
    Route::put('berita/update/{id}', [Mcompany\BeritaController::class, 'update'])->name('berita.update');
    Route::delete('berita/destroy/{id}', [Mcompany\BeritaController::class, 'destroy']);

    // DOKUMENTASI.BLADE
    Route::get('dock/get-data', [Mcompany\Dokumentasi::class, 'getData'])->name('dock.get-data');
    Route::get('dock/get-data/video', [Mcompany\Dokumentasi::class, 'getDataVideo'])->name('dock.get-data.video');
    Route::get('dock/edit/{id}', [Mcompany\Dokumentasi::class, 'edit']);
    Route::get('berita/showDelete/{id}', [Mcompany\Dokumentasi::class, 'showDelete']);
    Route::put('dock/update/{id}', [Mcompany\Dokumentasi::class, 'update'])->name('dock.update');
    Route::post('dock/store', [Mcompany\Dokumentasi::class, 'store'])->name('dock.store');
    Route::delete('dock/destroy/{id}', [Mcompany\Dokumentasi::class, 'destroy']);

    // SISWA.BLADE
    Route::get('siswa/get-data', [Muser\SiswaController::class, 'getData'])->name('siswa.get-data');
    Route::get('siswa/edit/{id}', [Muser\SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('siswa/update/{id}', [Muser\SiswaController::class, 'update'])->name('siswa.update');
    Route::post('siswa/store', [Muser\SiswaController::class, 'store'])->name('siswa.store');
    Route::delete('siswa/destroy/{id}', [Muser\SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('siswa/import', [Muser\SiswaController::class, 'importSiswa'])->name('siswa.import');
    Route::get('siswa/export', [Muser\SiswaController::class, 'exportSiswa'])->name('siswa.export');
    Route::get('siswa/deletall', [Muser\SiswaController::class, 'dropAllSiswaData'])->name('siswa.delete.all');


    // PEGAWAI.BLADE
    Route::get('pegawai/edit/{id}', [Muser\PegawaiController::class, 'edit']);
    Route::put('pegawai/update/{id}', [Muser\PegawaiController::class, 'update']);
    Route::delete('pegawai/destroy/{id}', [Muser\PegawaiController::class, 'destroy']);
    Route::get('pegawai/get-data', [Muser\PegawaiController::class, 'getData'])->name('pegawai.get-data');
    Route::put('pegawai/ubah-image/{id}', [Muser\PegawaiController::class, 'storeFoto']);

    Route::get('get-jabatan', [Muser\JabatanController::class, 'getJabatan'])->name('get-jabatan');
    Route::get('get-jabatan/options', [Muser\JabatanController::class, 'getJabatanOptions'])->name('get-jabatan.options');
    Route::get('get-jabatan/options/edit', [Muser\JabatanController::class, 'getJabatanOptionsEdit'])->name('get-jabatan.options.edit');
    Route::post('jabatan/store', [Muser\JabatanController::class, 'store'])->name('jabatan.store');
    Route::delete('jabatan/destroy/{id}', [Muser\JabatanController::class, 'destroy']);
});

// --------------------------------------------- SUPER ADMIN -------------------------------------------------------------
Route::middleware(['auth:user', 'ceklevel:Super Admin'])->group(function () {

    // Route::get('/absensi', [Mkelas\Absensi::class, 'index'])->name('absensi.index');
    // Route::resource('/absensi', Absensi::class);
    Route::prefix('manajemen-user')->group(function () {
        Route::resource('user', Muser\UserController::class);
    });

    // berita
    Route::post('/posts/upload', [MCompany\BeritaController::class, 'upload'])->name('posts.upload');
    Route::post('/ckberita/upload', [MCompany\BeritaController::class, 'ck_upload'])->name('ckberita.upload');
    Route::delete('/ckberita/delete', [MCompany\BeritaController::class, 'deleteImage'])->name('ckberita.delete');

    //manajemen user
    Route::get('user/siswa/get-data', [Muser\UserController::class, 'getUsrSiswa'])->name('get-user.siswa');
    Route::get('user/siswa/select', [Muser\UserController::class, 'getOptions'])->name('siswa.select');
    Route::post('user/siswa/store', [Muser\UserController::class, 'storeUsrSiswa'])->name('user.siswa.store');
    Route::put('user/update/siswa/{id}', [Muser\UserController::class, 'updateUsrSiswa']);
    Route::get('user/edit/siswa/{id}', [Muser\UserController::class, 'editUsrSiswa']);
    Route::delete('user/destroy/siswa/{id}', [Muser\UserController::class, 'destroyUsrSiswa']);

    Route::post('user/pegawai/store', [Muser\UserController::class, 'store'])->name('user.pegawai.store');
    Route::get('user/pegawai/get-data', [Muser\UserController::class, 'getUsrPegawai'])->name('get-user.pegawai');
    Route::get('user/pegawai/select', [Muser\UserController::class, 'getOptionsPegawai'])->name('pegawai.select');
    Route::get('user/edit/pegawai/{id}', [Muser\UserController::class, 'edit']);
    Route::put('user/update/pegawai/{id}', [Muser\UserController::class, 'update']);
    Route::delete('user/destroy/pegawai/{id}', [Muser\UserController::class, 'destroy']);
});
