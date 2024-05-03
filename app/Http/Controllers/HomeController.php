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
use Illuminate\Support\Facades\Log;

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
        $periode = Periode::orderBy('tanggalMulai', 'desc')->get();
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

    public function chart()
    {
        try {
            $data = User::where('hakAkses', 'Admin')->count();


            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error updating data: ' . $e->getMessage());
        }
    }

    public function getDataKalenderJadwal(Request $request)
    {
        $hari = $request->hari;
        $periode = Periode::where('status', 'Aktif')->first();
        $siswa = Auth::user()->siswa;
        $kelas = Kelas::where('idPeriode', $periode->idPeriode)->whereHas('siswa', function ($Q) use ($siswa) {
            $Q->where('siswa.idSiswa', $siswa->idSiswa);
        })
            ->first();
        $jadwal = Jadwal::where('hari', $hari)
            ->where('idPeriode', $periode->idPeriode)
            ->whereHas('kelas', function ($query) use ($kelas) {
                $query->where('namaKelas', $kelas->namaKelas);
            })
            ->get()
            ->groupBy('pengajaran.idMapel')
            ->map(function ($items) {
                $combinedSchedules = [];
                foreach ($items as $item) {
                    $key = $item->pengajaran->mapel_id;
                    if (!isset($combinedSchedules[$key])) {
                        $combinedSchedules[$key] = [
                            'hari' => $item->hari,
                            'mapel' => $item->pengajaran->mapel ? $item->pengajaran->mapel->namaMapel : '',
                            'guru' => $item->pengajaran->guru ? $item->pengajaran->guru->namaPegawai : '',
                            'mulai' => $item->jamke ? date('H:i', strtotime($item->jamke->jamMulai)) : '',
                            'selesai' => $item->jamke ? date('H:i', strtotime($item->jamke->jamSelesai)) : '',
                        ];
                    } else {
                        $combinedSchedules[$key]['selesai'] = $item->jamke ? date('H:i', strtotime($item->jamke->jamSelesai)) : '';
                    }
                }
                return array_values($combinedSchedules);
            })
            ->values();

        return response()->json(['jadwal' => $jadwal]);
    }

    // chart donat user function
    public function getChartUser()
    {
        $usersData = User::select('hakAkses', DB::raw('count(*) as total'))
            ->groupBy('hakAkses')
            ->get();

        $siswaData = UserSiswa::select('hakAkses', DB::raw('count(*) as total'))
            ->groupBy('hakAkses')
            ->get();

        return response()->json(['siswa' => $siswaData, 'guru' => $usersData]);
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

    public function jumlahSiswa(Request $request)
    {
        $periode = $request->periode;
        $data = Kelas::where('idPeriode', $periode)
            ->with('siswa')
            ->get();

        return response()->json($data);
    }

    public function jumlahSiswaAktif()
    {
        $data = Siswa::select('jenisKelamin')
            ->where('status', 'Aktif')
            ->get();

        $jkL = $data->where('jenisKelamin', 'Laki-Laki')->count();
        $jkP = $data->where('jenisKelamin', 'Perempuan')->count();

        return response()->json(['L' => $jkL, 'P' => $jkP]);
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
