<?php

use App\Http\Controllers\Absensi;
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
use App\Http\Controllers\PesanController;
use App\Http\Controllers\ProfilUserController;
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


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
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

Route::middleware(['auth:siswa', 'ceklevel:Siswa'])->group(function () {
    Route::prefix('siswa')->group(function () {
        Route::get('/beranda', [BerandaController::class, 'index'])->name('ss.beranda.index');
    });
});
Route::middleware(['auth:user', 'ceklevel:Guru'])->group(function () {
    Route::prefix('guru')->group(function () {
        Route::get('/beranda', [BerandaController::class, 'index'])->name('gg.beranda.index');
    });
});


Route::middleware(['auth:user,siswa'])->group(function () {
    //dashboard
    Route::get('/dashboard', [HomeController::class, 'indexBeranda'])->name('dashboard.index');




    // PESAN
    Route::get('pesan/get-data', [PesanController::class, 'getData'])->name('pesan.get-data');
    Route::delete('pesan/destroy/{id}', [PesanController::class, 'destroy']);






    // PROFIL GURU.BLADE
    Route::get('profil-guru/edit/{id}', [GuruProfilController::class, 'edit'])->name('profil-guru.edit');
    Route::delete('profil-guru/destroy/{id}', [GuruProfilController::class, 'destroy'])->name('profil-guru.destroy');
    Route::post('profil-guru/store', [GuruProfilController::class, 'store'])->name('profil-guru.store');

    // MASTER DATA
    Route::get('periode/guru/get-data', [KelasController::class, 'getPeriodeGuru']);
    Route::get('periode/siswa/get-data', [KelasController::class, 'getPeriodeSiswa']);

    // PERIODE
    Route::get('get-data/periode', [Mkelas\PeriodeController::class, 'getPeriode']);
    Route::post('periode/store', [Mkelas\PeriodeController::class, 'store']);
    Route::get('periode/edit/{id}', [Mkelas\PeriodeController::class, 'edit']);
    Route::put('periode/update/{id}', [Mkelas\PeriodeController::class, 'update']);
    Route::delete('periode/destroy/{id}', [Mkelas\PeriodeController::class, 'destroy']);

    // NILAI SISWA
    Route::get('get-nilai-data', [NilaiSiswaController::class, 'getNilaiData'])->name('nilai.get-data');
    Route::get('nilai_siswa/edit/{id}/{idPengajaran}/{idPeriode}', [NilaiSiswaController::class, 'edit'])->name('nilai_siswa.edit');
    Route::post('nilai_siswa/up', [NilaiSiswaController::class, 'up']);

    // get kalender
    Route::get('get-kalender-jadwal', [HomeController::class, 'getDataKalenderJadwal']);

    // Get chart donut user
    Route::get('chart/donat/user', [HomeController::class, 'getChartDuser']);

    // get chart bar pengajar per kelas
    Route::get('jumlah-pengajar-per-kelas/{periode}', [HomeController::class, 'jumlahPengajarPerKelas']);

    // get chart bar jenis kelamin
    Route::get('chart/jenis-kelamin', [HomeController::class, 'getChartJK']);

    // jumlah siswa kelas
    Route::get('jumlah-siswa/{periode}', [HomeController::class, 'jumlahSiswa']);

    // PENJADWALAN
    Route::get('penjadwalan/get-form', [Mkelas\PenjadwalanController::class, 'getForm']);
    Route::get('penjadwalan/get-data', [Mkelas\PenjadwalanController::class, 'getJPkelas1']);
    Route::get('penjadwalan/edit/{id}', [Mkelas\PenjadwalanController::class, 'edit']);
    Route::post('penjadwalan/store', [Mkelas\PenjadwalanController::class, 'store']);
    Route::put('penjadwalan/update/{id}', [Mkelas\PenjadwalanController::class, 'update']);
    Route::delete('penjadwalan/destroy/{id}', [Mkelas\PenjadwalanController::class, 'destroy']);

    //manajemen guru kelas siswa
    Route::get('data-kelas/edit/guru/{id}', [KelasController::class, 'edit']);
    Route::put('data-kelas/update/guru/{id}', [KelasController::class, 'update']);
    Route::delete('data-kelas/destroy/guru/{id}', [KelasController::class, 'destroy']);

    // manajemen siswa kelas
    Route::post('data-kelas/store/siswa', [KelasController::class, 'storeSiswa'])->name('data-kelas.store.siswa');
    Route::get('data-kelas/edit/siswa/{id}', [KelasController::class, 'editSiswa']);
    Route::put('data-kelas/update/siswa/{id}', [KelasController::class, 'updateSiswa']);
    Route::delete('data-kelas/destroy/siswa/{id}', [KelasController::class, 'destroySiswa']);

    // show kelas
    Route::get('data-kelas/kelas/form', [KelasController::class, 'getKelas']);

    // MAPEL.BLADE
    Route::get('mapel/get-data', [Mkelas\MapelController::class, 'getMapel']);
    Route::post('mapel/store', [Mkelas\MapelController::class, 'store']);
    Route::get('mapel/edit/{id}', [Mkelas\MapelController::class, 'edit']);
    Route::put('mapel/update/{id}', [Mkelas\MapelController::class, 'update']);
    Route::delete('mapel/destroy/{id}', [Mkelas\MapelController::class, 'destroy']);

    // PENGAJARAN.BLADE
    Route::get('pengajar/get-data', [Mkelas\PengajarController::class, 'getPengajar']);
    Route::get('pengajar/get-form', [Mkelas\PengajarController::class, 'getForm']);
    Route::post('pengajar/store', [Mkelas\PengajarController::class, 'store']);
    Route::get('pengajar/edit/{id}', [Mkelas\PengajarController::class, 'edit']);
    Route::put('pengajar/update/{id}', [Mkelas\PengajarController::class, 'update'])->name('pengajar.update');
    Route::delete('pengajar/destroy/{id}', [Mkelas\PengajarController::class, 'destroy']);

    // show penilaian siswa
    Route::get('penilaian/get-data', [Mkelas\PenilaianController::class, 'getNilaiSiswa']);

    // show kelas per periode
    Route::get('/get-kelas-by-periode/{periode_id}', [Mkelas\PenilaianController::class, 'getKelasByPeriode']);

    // store kelas & periode
    Route::post('data-kelas/storePeriode', [KelasController::class, 'storePeriode'])->name('data-kelas.storePeriode');
    Route::post('data-kelas/storeKelas', [KelasController::class, 'storeKelas'])->name('data-kelas.storeKelas');

    // show dan store nilai
    Route::get('/nilai_siswa/{slug}/{id}/{kelas_id}/{periode_id}', [NilaiSiswaController::class, 'index'])->name('nilai-siswa.index');
    Route::post('simpan-nilai', [NilaiSiswaController::class, 'simpanNilai']);

    // Profil Pengguna
    Route::get('/profil-pengguna', [ProfilUserController::class, 'index'])->name('profil_pengguna.index');
    Route::get('/profil-pengguna/edit', [ProfilUserController::class, 'edit'])->name('profil_pengguna.edit');
    Route::get('/profil-pengguna/change-password', [ProfilUserController::class, 'chPassword'])->name('profil_pengguna.chpassword');
    Route::put('/profil-pengguna/update/password', [ProfilUserController::class, 'changePassword'])->name('update.password');
    Route::put('/profil-pengguna/update/user/{id}', [ProfilUserController::class, 'updateUsername'])->name('profil_pengguna.update.user');
    Route::put('/profil-pengguna/update/biografi/{id}', [ProfilUserController::class, 'updateBiografi'])->name('profil_pengguna.update.biografi');
    Route::put('/profil-pengguna/update/biografi/siswa/{id}', [ProfilUserController::class, 'updateBiografiSiswa'])->name('profil_pengguna.update.biografi.siswa');
    Route::put('/profil-pengguna/update/biografi/ortu/{id}', [ProfilUserController::class, 'updateBiografiOrtu'])->name('profil_pengguna.update.biografi.ortu');
    Route::put('/profil-pengguna/update/biografi/wali/{id}', [ProfilUserController::class, 'updateBiografiWali'])->name('profil_pengguna.update.biografi.wali');
});

Route::middleware(['auth:user'])->group(function () {
    // Data master sekolah
    Route::prefix('data-master')->group(function () {
        Route::resource('pegawai', Muser\PegawaiController::class);
        Route::get('siswa', [Muser\SiswaController::class, 'index'])->name('siswa.index');
        Route::get('sekolah', [Sekolah::class, 'index'])->name('sekolah.index');
        Route::resource('user', Muser\UserController::class);
    });
    //manajemen profil sekolah
    Route::prefix('profil-sekolah')->group(function () {
        Route::get('berita', [Mcompany\BeritaController::class, 'index'])->name('berita.index');
        Route::get('profil', [Mcompany\ProfilController::class, 'index'])->name('profil.index');
        Route::get('dokumentasi', [Mcompany\Dokumentasi::class, 'index'])->name('dokumentasi.index');
        Route::get('pesan', [PesanController::class, 'index'])->name('pesan.index');
    });

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
    
    // PEGAWAI.BLADE
    Route::get('pegawai/edit/{id}', [Muser\PegawaiController::class, 'edit']);
    Route::put('pegawai/update/{id}', [Muser\PegawaiController::class, 'update']);
    Route::delete('pegawai/destroy/{id}', [Muser\PegawaiController::class, 'destroy']);
    Route::get('pegawai/get-data', [Muser\PegawaiController::class, 'getData'])->name('pegawai.get-data');

    Route::get('get-jabatan', [Muser\JabatanController::class, 'getJabatan'])->name('get-jabatan');
    Route::post('jabatan/store', [Muser\JabatanController::class, 'store'])->name('jabatan.store');
    Route::delete('jabatan/destroy/{id}', [Muser\JabatanController::class, 'destroy']);
});

// --------------------------------------------- SUPER ADMIN -------------------------------------------------------------
Route::middleware(['auth:user', 'ceklevel:Super Admin'])->group(function () {

    // Route::get('/absensi', [Mkelas\Absensi::class, 'index'])->name('absensi.index');
    Route::resource('/absensi', Absensi::class);

    Route::get('siswa/deletall', [Muser\SiswaController::class, 'dropAllSiswaData'])->name('siswa.delete.all');



    // berita
    Route::post('/posts/upload', [MCompany\BeritaController::class, 'upload'])->name('posts.upload');
    Route::post('/ckberita/upload', [MCompany\BeritaController::class, 'ck_upload'])->name('ckberita.upload');

    //manajemen user
    Route::get('user/pegawai/get-data', [Muser\UserController::class, 'getUsrPegawai'])->name('get-user.pegawai');
    Route::get('user/siswa/get-data', [Muser\UserController::class, 'getUsrSiswa'])->name('get-user.siswa');
    Route::put('user/siswa/store/{id}', [Muser\UserController::class, 'storeUsrSiswa'])->name('store-user.siswa');
    Route::get('user/edit/pegawai/{id}', [Muser\UserController::class, 'edit']);
    Route::put('user/update/pegawai/{id}', [Muser\UserController::class, 'update']);
    Route::put('user/update/siswa/{id}', [Muser\UserController::class, 'updateUsrSiswa']);
    Route::get('user/edit/siswa/{id}', [Muser\UserController::class, 'editUsrSiswa']);
    Route::delete('user/destroy/pegawai/{id}', [Muser\UserController::class, 'destroy']);
    Route::delete('user/destroy/siswa/{id}', [Muser\UserController::class, 'destroyUsrSiswa']);






    Route::prefix('manajemen-kelas')->group(function () {
        Route::resource('data-kelas', KelasController::class)->except(['index']);
        Route::get('data-kelas', [KelasController::class, 'indexMasterDataKelas'])->name('data-kelas.index');
        Route::resource('penjadwalan', Mkelas\PenjadwalanController::class);
        Route::resource('periode', Mkelas\PeriodeController::class);
        Route::resource('mapel', Mkelas\MapelController::class);
        Route::resource('pengajaran', Mkelas\PengajarController::class);
        Route::resource('penilaian', Mkelas\PenilaianController::class);
    });
});

// ------------------------------------------------ ADMIN -----------------------------------------------------------------
Route::middleware(['auth:user', 'ceklevel:Admin'])->group(function () {
    //manajemen guru kelas siswa
    Route::prefix('manajemen-kelas')->group(function () {
        Route::resource('data-kelas-admin', KelasController::class)->except(['index']);
        Route::get('data-kelas-admin', [KelasController::class, 'indexMasterDataKelas'])->name('data-kelas-admin.index');

        Route::resource('penjadwalan-admin', Mkelas\PenjadwalanController::class);
        Route::resource('periode-admin', Mkelas\PeriodeController::class);
        Route::resource('mapel-admin', Mkelas\MapelController::class);
        Route::resource('pengajaran-admin', Mkelas\PengajarController::class);
        Route::resource('penilaian-admin', Mkelas\PenilaianController::class);
    });
});

// ------------------------------------------------ GURU -----------------------------------------------------------------
Route::middleware('auth:user', 'ceklevel:Guru')->group(function () {
    Route::get('/jadwal-guru', [HomeController::class, 'getJadwalGuru'])->name('get-jadwal.guru');
    Route::get('/kelas-guru', [HomeController::class, 'getJumlahKL'])->name('get-jml.kelas');
    //kelas
    Route::prefix('manajemen-kelas')->group(function () {
        Route::get('/penilaian-guru', [Mkelas\PenilaianController::class, 'index_guru'])->name('penilaian.guru');
        Route::get('/penjadwalan-guru', [Mkelas\PenjadwalanController::class, 'index'])->name('jadwal.guru');
        Route::get('/get-jadwal-guru', [Mkelas\PenjadwalanController::class, 'getJadwalPGuru'])->name('get-jadwalP.guru');
        Route::get('get-mapel-guru', [Mkelas\PenilaianController::class, 'getMapelGuru'])->name('get-mapel.guru');
        Route::get('/nilai_siswa_guru/{slug}/{id}/{kelas_id}/{periode_id}', [NilaiSiswaController::class, 'index'])->name('nilai-siswa.guru');
    });
});

// ------------------------------------------------ SISWA -----------------------------------------------------------------
Route::middleware('auth:siswa', 'ceklevel:Siswa')->group(function () {

    Route::get('/count-mapel', [HomeController::class, 'countMapel'])->name('count-mapel.siswa');
    Route::get('/get-nilai-siswa', [HomeController::class, 'getNilaiSiswa'])->name('get-nilai.siswa');
    //kelas
    Route::prefix('kelas')->group(function () {
        Route::get('/penilaian-siswa', [Mkelas\PenilaianController::class, 'index_siswa'])->name('penilaian.siswa');
        Route::get('/penjadwalan-siswa', [Mkelas\PenjadwalanController::class, 'index_siswa'])->name('jadwal.siswa');
        Route::get('/penilaian-siswa/get-nilai', [Mkelas\PenilaianController::class, 'getNilaiSiswaKelas'])->name('siswa_nilai.get');
        Route::get('/get-jadwal/siswa', [Mkelas\PenjadwalanController::class, 'getJadwalSiswa'])->name('get-jadwal.siswa');
    });
});
