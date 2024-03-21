<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\Pengajaran;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\User;
use App\Models\userSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // Di dalam HomeController
    public function indexHome()
    {
        return view('home', [
            'title' => 'Home',
            'title2' => 'Home',
        ]);
    }

    // for Dashboard
    public function indexBeranda()
    {
        $pegawai = Pegawai::where('status', 'Aktif')->count();
        $siswa = Siswa::where('status', 'Aktif')->count();
        $periode = Periode::orderBy('idPeriode', 'desc')->get();
        $jumlahPegawaiAktif = Pegawai::where('status', 'Aktif')->count();
        $jumlahSiswaAktif = Siswa::where('status', 'Aktif')->count();


        $jumlahUserPegawai = User::whereHas('pegawai', function ($query) {
            $query->where('status', 'Aktif');
        })->count();
        $jumlahUserSiswa = userSiswa::whereHas('siswa', function ($query) {
            $query->where('status', 'Aktif');
        })->count();

        $jumlahUser = $jumlahUserPegawai + $jumlahUserSiswa;

        



        return view('siakad.content.dashboard.index', compact('pegawai', 'siswa', 'periode', 'jumlahPegawaiAktif', 'jumlahSiswaAktif', 'jumlahUser'), [
            'judul' => 'Dashboard',
            'sub_judul' => 'Dashboard',
            'text_singkat' => 'Selamat datang <a href="' . route('profil_pengguna.index') . '" class="fw-semibold">' . auth()->user()->pegawai->namaPegawai . '</a>, di SIAKAD SD Negeri Lemahbang',
        ]);
    }

    public function getDataKalenderJadwal(Request $request)
    {
        $jadwal = Jadwal::query()
            ->join('pengajaran', 'jadwal.idPengajaran', '=', 'pengajaran.idPengajaran')
            ->join('mapel', 'pengajaran.idMapel', '=', 'mapel.idMapel')
            ->join('pegawai', 'pengajaran.idPegawai', '=', 'pegawai.idPegawai')
            ->join('kelas', 'pengajaran.idKelas', '=', 'kelas.idKelas')
            ->where('jadwal.hari', $request->hari)
            ->where('kelas.namaKelas', $request->kelas)
            ->where('pengajaran.idPeriode', $request->periode)
            ->orderBy('jadwal.jamMulai', 'asc')
            ->get();

        return response()->json(['data' => $jadwal]);
    }

    // chart donat user function
    public function getChartDuser()
    {
        $usersData = User::select('hakAkses', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('hakAkses');

        $siswaData = Siswa::select('hakAkses', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('hakAkses')
            ->union($usersData)
            ->get();

        return response()->json(['data' => $siswaData]);
    }

    public function jumlahPengajarPerKelas(Int $periode)
    {
        $data = Pengajaran::select('kelas.namaKelas', DB::raw('COUNT(*) as jumlah'))
            ->join('kelas', 'pengajaran.idKelas', '=', 'kelas.idKelas')
            ->where('pengajaran.idPeriode', $periode)
            ->groupBy('kelas.idKelas', 'kelas.namaKelas')
            ->get();

        return response()->json($data);
    }

    public function getChartJK()
    {
        $pegawai = Pegawai::select('jenisKelamin', DB::raw('COUNT(*) as Jumlah'))
            ->groupBy('jenisKelamin')
            ->get();

        $siswa = Siswa::select('jenisKelamin', DB::raw('COUNT(*) as Jumlah'))
            ->groupBy('jenisKelamin')
            ->get();

        // $data = array_merge($pegawai->toArray(), $siswa->toArray());

        return response()->json(['pegawai' => $pegawai, 'siswa' => $siswa]);
    }

    public function jumlahSiswa(Int $periode)
    {
        $data = Kelas::select('kelas.namaKelas', DB::raw('COALESCE(COUNT(tr_kelas.idSiswa), 0) AS jumlah'))
            ->leftJoin('tr_kelas', 'kelas.idKelas', '=', 'tr_kelas.idKelas')
            ->join('periode', 'kelas.idPeriode', '=', 'periode.idPeriode')
            ->where('periode.idPeriode', $periode)
            ->groupBy('kelas.namaKelas')
            ->get();



        // $data = array_merge($pegawai->toArray(), $siswa->toArray());

        return response()->json($data);
    }

    // siswa
    public function countMapel(Request $request)
    {

        $jumlahMapel = Pengajaran::join('kelas', 'pengajaran.idKelas', '=', 'kelas.idKelas')
            ->join('mapel', 'pengajaran.idMapel', '=', 'mapel.idMapel')
            ->where('kelas.namaKelas', $request->kelas)
            ->where('pengajaran.idPeriode', $request->periode)
            ->count();

        $wakel = Kelas::join('pegawai', 'kelas.idPegawai', '=', 'pegawai.idPegawai')
            ->where('kelas.namaKelas', $request->kelas)
            ->where('kelas.idPeriode', $request->periode)
            ->select('pegawai.namaPegawai', 'pegawai.nip', 'pegawai.noHp')
            ->get();


        return response()->json(['jumlah_mapel' => $jumlahMapel, 'wakel' => $wakel]);
    }

    public function getNilaiSiswa(Request $request)
    {
        $data = Siswa::join('tr_kelas', 'tr_kelas.idSiswa', '=', 'siswa.idSiswa')
            ->join('kelas', 'kelas.idKelas', '=', 'tr_kelas.idKelas')
            ->join('pengajaran', 'kelas.idKelas', '=', 'pengajaran.idKelas')
            ->join('mapel', 'pengajaran.idMapel', '=', 'mapel.idMapel')
            ->join('nilai', 'nilai.idPengajaran', '=', 'pengajaran.idPengajaran')
            ->where('kelas.namaKelas', '=', $request->kelas)
            ->where('siswa.idSiswa', '=', $request->idSiswa)
            ->where('nilai.idPeriode', '=', $request->periode)
            ->select('mapel.namaMapel', 'nilai.' . $request->nilai, 'siswa.idSiswa')
            ->get();


        return response()->json($data);
    }

    public function getJadwalGuru(Request $request)
    {

        $jadwal = Jadwal::join('pengajaran', 'jadwal.idPengajaran', '=', 'pengajaran.idPengajaran')
            ->join('pegawai', 'pengajaran.idPegawai', '=', 'pegawai.idPegawai')
            ->join('mapel', 'pengajaran.idMapel', '=', 'mapel.idMapel')
            ->join('kelas', 'pengajaran.idKelas', '=', 'kelas.idKelas')
            ->join('periode', 'pengajaran.idPeriode', '=', 'periode.idPeriode')
            ->where('jadwal.hari', $request->hari)
            ->where('pegawai.namaPegawai', '=', $request->nama)
            ->where('periode.idPeriode', '=', $request->periode)
            ->orderBy('jadwal.hari', 'asc')
            ->orderBy('jadwal.jamMulai', 'asc')
            ->get();

        $data = [];
        foreach ($jadwal as $item) {
            $data[] = [
                'hari' => $item->hari,
                'jamMulai' => $item->jamMulai,
                'jamSelesai' => $item->jamSelesai,
                'namaMapel' => $item->namaMapel,
                'namaKelas' => $item->namaKelas,
            ];
        }

        return response()->json($data);
    }

    // Guru
    public function getJumlahKL(Request $request)
    {
        $jumlah_kelas = DB::table('kelas AS k')
            ->join('pengajaran AS p', 'p.idKelas', '=', 'k.idKelas')
            ->join('pegawai AS pg', 'pg.idPegawai', '=', 'p.idPegawai')
            ->where('pg.namaPegawai', 'LIKE', "%{$request->nama}%")
            ->where('p.idPeriode', '=', $request->periode)
            ->distinct('k.idKelas')
            ->count();

        $data = DB::table('kelas AS k')
            ->join('pegawai AS pg', 'pg.idPegawai', '=', 'k.idPegawai')
            ->where('pg.namaPegawai', 'LIKE', "{$request->periode}%")
            ->where('k.idPeriode', '=', $request->periode)
            ->select('k.namaKelas')
            ->get();

        $jumlahSiswa = DB::table('siswa AS s')
            ->join('tr_kelas AS tk', 's.idSiswa', '=', 'tk.idSiswa')
            ->join('kelas AS k', 'tk.idKelas', '=', 'k.idKelas')
            ->where('k.namaKelas', $request->kelas)
            ->where('k.idPeriode', $request->periode)
            ->count();


        $response = [
            'jumlah_kelas' => $jumlah_kelas,
            'nama_kelas' => $data,
            'jumlahSiswa' => $jumlahSiswa
        ];



        return response()->json($response);
    }
}
