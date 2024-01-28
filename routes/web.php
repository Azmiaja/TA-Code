<?php

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
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth:user,siswa');

Route::get('/berita-sekolah/{id}/{slug}', [LihatBeritaController::class, 'show'])->name('lihatberita')->middleware('guest:user,siswa');
Route::get('/', [LandingController::class, 'index'])->name('landingpage')->middleware('guest:user,siswa');
Route::get('/home', function(){
    return view('company_profil/content/home/index');
});

Route::middleware(['auth:user,siswa'])->group(function () {
    //dashboard
    Route::get('/dashboard', [HomeController::class, 'indexDashboard'])->name('dashboard.index');

    Route::get('/sekolah', [Sekolah::class, 'index'])->name('sekolah.index');

    // SISWA.BLADE
    Route::get('siswa/get-data', [Muser\SiswaController::class, 'getData'])->name('siswa.get-data');
    Route::get('siswa/edit/{id}', [Muser\SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('siswa/update/{id}', [Muser\SiswaController::class, 'update'])->name('siswa.update');
    Route::post('siswa/store', [Muser\SiswaController::class, 'store'])->name('siswa.store');
    Route::delete('siswa/destroy/{id}', [Muser\SiswaController::class, 'destroy'])->name('siswa.destroy');

    // PEGAWAI.BLADE
    Route::get('pegawai/get-data', [Muser\PegawaiController::class, 'getData']);
    Route::get('pegawai/edit/{id}', [Muser\PegawaiController::class, 'edit']);
    Route::put('pegawai/update/{id}', [Muser\PegawaiController::class, 'update']);
    Route::delete('pegawai/destroy/{id}', [Muser\PegawaiController::class, 'destroy']);

    // BERITA.BLADE
    Route::get('berita/get-data', [Mcompany\BeritaController::class, 'getData'])->name('berita.get-data');
    Route::get('berita/edit/{id}', [Mcompany\BeritaController::class, 'edit']);
    Route::get('berita/showDelete/{id}', [Mcompany\BeritaController::class, 'showDelete']);
    Route::put('berita/update/{id}', [Mcompany\BeritaController::class, 'update'])->name('berita.update');
    Route::post('berita/store', [Mcompany\BeritaController::class, 'store'])->name('berita.store');
    Route::delete('berita/destroy/{id}', [Mcompany\BeritaController::class, 'destroy']);

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
});

// --------------------------------------------- SUPER ADMIN -------------------------------------------------------------
Route::middleware(['auth:user', 'ceklevel:Super Admin'])->group(function () {

    Route::get('/absensi', [Mkelas\Absensi::class, 'index'])->name('absensi.index');

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

    Route::prefix('manajemen-user')->group(function () {
        Route::resource('pegawai', Muser\PegawaiController::class);
        Route::get('siswa', [Muser\SiswaController::class, 'index'])->name('siswa.index');
        Route::resource('user', Muser\UserController::class);
    });

    //manajemen profil sekolah
    Route::prefix('company-profil')->group(function () {
        Route::get('berita', [Mcompany\BeritaController::class, 'index'])->name('berita.index');
        Route::resource('profil', Mcompany\ProfilController::class);
        Route::get('profil-guru', [GuruProfilController::class, 'index'])->name('profil-guru.index');
        Route::put('profil/updateProfil/{id}', [Mcompany\ProfilController::class, 'updateProfil'])->name('profil.updateProfil');
        Route::put('profil/updateSejarah/{id}', [Mcompany\ProfilController::class, 'updateSejarah'])->name('profil.updateSejarah');
        Route::put('profil/updateVisi/{id}', [Mcompany\ProfilController::class, 'updateVisi'])->name('profil.updateVisi');
        Route::put('profil/updateMisi/{id}', [Mcompany\ProfilController::class, 'updateMisi'])->name('profil.updateMisi');
        Route::put('profil/updateSlogan/{id}', [Mcompany\ProfilController::class, 'updateSlogan'])->name('profil.updateSlogan');
        Route::get('profil-guru/table', [GuruProfilController::class, 'show'])->name('profil-guru.show');
        // Route::post('profil-guru/store', [GuruProfilController::class, 'store'])->name('profil-guru.store');
    });


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
