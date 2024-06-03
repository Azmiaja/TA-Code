<?php

namespace App\Http\Controllers\Rapor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mkelas\Absensi;
use App\Models\Absensi as ModelsAbsensi;
use App\Models\CatatanGuru;
use App\Models\KegEkstra;
use App\Models\Kelas;
use App\Models\KetNaikTidak;
use App\Models\Nilai;
use App\Models\Pegawai;
use App\Models\Pengajaran;
use App\Models\Periode;
use App\Models\Sekolah;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RaporSiswa extends Controller
{
    public function index()
    {
        $pegawai = Auth::user()->pegawai->idPegawai;
        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->first();


        $today = now();

        $periodeAktif = Periode::where('tanggalMulai', '<=', $today)
            ->where('tanggalSelesai', '>=', $today)
            ->where('status', 'Aktif')
            ->first();

        // Mendapatkan periode yang sudah lewat berdasarkan tanggal selesai kurang dari tanggal hari ini
        $periodeLewat = Periode::where('tanggalSelesai', '<', $today)
            ->first();

        $pegawai = Auth::user()->pegawai->idPegawai;
        $kelas = Kelas::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode->idPeriode ?? '')
            ->first();

        $kelas_nama = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];


        $sekolah = Sekolah::select('namaSekolah', 'alamat', 'kepsek', 'nip')->first() ?? null;


        return view('siakad/content/rapor/index', compact('periodeAktif', 'periodeLewat', 'periode', 'kelas', 'kelas_nama', 'sekolah'), [
            'judul' => 'Rapor Siswa',
            'sub_judul' => 'Rapor Semester',
            'text_singkat' => 'Mencetak rapor semester siswa!',
            's_idKelas' => '',
            'kelasName' => '',
            'guru_kls' => Auth::user()->pegawai,
            // 'periode' => $periodeGuru
        ]);
    }


    public function getSiswa(Request $request)
    {
        $idPeriode = $request->idPeriode;
        $namaKelas = $request->namaKelas;

        $siswa = Siswa::whereHas('kelas', function ($query) use ($idPeriode, $namaKelas) {
            $query->where('namaKelas', $namaKelas)
                ->where('idPeriode', $idPeriode);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();

        return response()->json($siswa);
    }

    public function getRapor(Request $request)
    {
        $idPeriode = $request->idPeriode;
        $namaKelas = $request->namaKelas;
        $idSiswa = $request->idSiswa;

        $kelas = Kelas::where('namaKelas', $namaKelas)
            ->where('idPeriode', $idPeriode ?? '')
            ->first();

        $siswa = Siswa::where('idSiswa', $idSiswa)
            ->whereHas('kelas', function ($query) use ($idPeriode, $namaKelas) {
                $query->where('namaKelas', $namaKelas)
                    ->where('idPeriode', $idPeriode);
            })
            ->orderBy('namaSiswa', 'asc')
            ->first();

        $pengajar = Pengajaran::where('idPeriode', $idPeriode)
            ->where('idKelas', $kelas->idKelas)
            ->with('mapel')
            ->orderBy('idMapel', 'asc')
            ->get();

        $nilai = Nilai::where('idPeriode', $idPeriode)
            ->where('idSiswa', $idSiswa)
            ->get();

        $ekstra = KegEkstra::where('idPeriode', $idPeriode)
            ->where('idKelas', $kelas->idKelas)
            ->where('idSiswa', $idSiswa)
            ->with('ekstra')
            ->orderBy('idEks', 'asc')
            ->get();

        $ct_guru = CatatanGuru::where('idPeriode', $idPeriode)
            ->where('idKelas', $kelas->idKelas)
            ->where('idSiswa', $idSiswa)
            ->first();

        $kehadiran = ModelsAbsensi::select('idSiswa')
            ->selectRaw('DAY(tanggal) as tanggal')
            ->selectRaw('tanggal as bulan')
            ->selectRaw('MONTH(tanggal) as noBulan')
            ->selectRaw("MAX(CASE WHEN presensi = 'hadir' THEN 'H' WHEN presensi = 'izin' THEN 'I' WHEN presensi = 'sakit' THEN 'S' ELSE 'A' END) as presensi")
            ->where('idPeriode', $idPeriode)
            ->where('idKelas', $kelas->idKelas)
            ->where('idSiswa', $idSiswa)
            // ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('idSiswa', 'tanggal')
            ->get()->map(function ($item) {
                $item->bulan = Carbon::parse($item->bulan)->translatedFormat('F');
                return $item;
            });

        $ketNaikTidak = KetNaikTidak::where('idPeriode', $idPeriode)
            ->where('idKelas', $kelas->idKelas)
            ->where('idSiswa', $idSiswa)
            ->first();

        return response()->json([
            'siswa' => $siswa,
            'mapel' => $pengajar,
            'nilai' => $nilai,
            'kegiatan' => $ekstra,
            'catatan' => $ct_guru,
            'absen' => $kehadiran,
            'keterangan' => $ketNaikTidak
        ]);
    }

    public function getMapelData(Request $request)
    {
        $idPeriode = $request->idPeriode;
        $idKelas = $request->idKelas;

        $pengajar = Pengajaran::where('idPeriode', $idPeriode)
            ->where('idKelas', $idKelas)
            ->orderBy('idMapel', 'asc')
            ->with('mapel')
            ->get();

        return response()->json($pengajar);
    }

    public function indexRPA()
    {
        $periode = Periode::orderBy('tanggalMulai', 'desc')->get();

        $kelas_nama = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];


        $sekolah = Sekolah::select('namaSekolah', 'alamat', 'kepsek', 'nip')->first() ?? null;


        return view('siakad/content/rapor/rpadmin/index', compact('periode', 'kelas_nama', 'sekolah'), [
            'judul' => 'Akademik',
            'sub_judul' => 'Rapor Siswa',
            'text_singkat' => 'Data rapor siswa!',
            's_idKelas' => '',
            'kelasName' => '',
            // 'periode' => $periodeGuru
        ]);
    }
}
