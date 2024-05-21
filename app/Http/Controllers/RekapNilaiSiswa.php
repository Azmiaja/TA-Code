<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Pengajaran;
use App\Models\Periode;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapNilaiSiswa extends Controller
{
    public function index()
    {
        $currentDate = Carbon::now();

        $periodeAktif = Periode::where('tanggalMulai', '<=', $currentDate)
            ->where('tanggalSelesai', '>=', $currentDate)
            ->first();
        $siswa = Auth::user()->siswa;
        $periodeSiswa = Siswa::where('idSiswa', $siswa->idSiswa)
            ->first();
        $kelas = Kelas::where('idPeriode', $periodeAktif->idPeriode)->whereHas('siswa', function ($Q) use ($siswa) {
            $Q->where('siswa.idSiswa', $siswa->idSiswa);
        })
            ->first();
        return view('siakad/content/penilaian/siswa/index', [
            'judul' => 'Nilai Siswa',
            'sub_judul' => 'Rekap Nilai Siswa',
            'text_singkat' => 'Menampilkan rekapitulasi nilai siswa!',
            'siswa' => $siswa,
            'kelas' => $kelas,
            'periode' => $periodeAktif,
            'siswaKelas' => $periodeSiswa->kelas->sortByDesc('namaKelas')
        ]);
    }

    public function getTabelrekap(Request $request)
    {
        $periode = $request->periode;
        $siswa = Auth::user()->siswa;

        $periodeSelected = Periode::where('idPeriode', $periode)->first();

        $tanggalMulai = Carbon::parse($periodeSelected->tanggalMulai);
        $tanggalSelesai = Carbon::parse($periodeSelected->tanggalSelesai);

        $daftarBulan = [];
        $noBulan = [];

        while ($tanggalMulai <= $tanggalSelesai) {
            $daftarBulan[] = $tanggalMulai->translatedFormat('F');
            $noBulan[] = $tanggalMulai->translatedFormat('m');
            $tanggalMulai->addMonth();
        }

        // Mengonversi array $noBulan menjadi string dipisahkan dengan koma
        $noBulanString = implode(',', $noBulan);

        $ssis = Siswa::where('idSiswa', $siswa->idSiswa)
            ->first();

        $kelas = $ssis->kelas->where('idPeriode', $periodeSelected->idPeriode)->first();

        $pengajar = Pengajaran::where('idPeriode', $periode)
            ->where('idKelas', $kelas->idKelas)
            ->with('mapel')
            ->orderBy('idPengajaran', 'asc')
            ->get();

        $nilai = Nilai::where('idPeriode', $periode)
            ->orderBy('idPengajaran', 'asc')
            // ->whereHas('pengajaran', function ($qq) use ($kelas) {
            //     $qq->where('idKelas', $kelas->idKelas);
            // })
            ->get();

        return response()->json([
            'pengajar' => $pengajar,
            'siswa' => $siswa,
            'nilai' => $nilai,
            'kelas' => $kelas,
            'periode' => $periodeSelected,
        ]);
    }
}
