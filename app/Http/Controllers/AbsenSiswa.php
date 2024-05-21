<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AbsenSiswa extends Controller
{
    public function index()
    {
        $currentDate = Carbon::now();

        $periodeAktif = Periode::where('tanggalMulai', '<=', $currentDate)
            ->where('tanggalSelesai', '>=', $currentDate)
            ->first();
        $periode_2 = Periode::orderBy('tanggalMulai', 'desc')->first();
        $periode = Periode::orderBy('tanggalMulai', 'desc')->get();
        $siswa = Auth::user()->siswa;
        $periodeSiswa = Siswa::where('idSiswa', $siswa->idSiswa)
            ->first();
        $kelas = Kelas::where('idPeriode', $periodeAktif->idPeriode)->whereHas('siswa', function ($Q) use ($siswa) {
            $Q->where('siswa.idSiswa', $siswa->idSiswa);
        })
            ->first();
        return view('siakad/content/absen/siswa/absensi', [
            'judul' => 'Kehadiran Siswa',
            'sub_judul' => 'Catatan Kehadiran',
            'text_singkat' => 'Menampilkan catatan kehadiran siswa dalam kelas!',
            'siswa' => $siswa,
            'kelas' => $kelas,
            'periode' => $periodeAktif,
            'siswaKelas' => $periodeSiswa->kelas->sortByDesc('namaKelas')
        ]);
    }

    public function getKehadiranSiswa(Request $request)
    {
        try {
            $periode = $request->periode;
            $siswa = Auth::user()->siswa;
            $kehadiran = Absensi::select('idSiswa')
                ->selectRaw('DAY(tanggal) as tanggal')
                ->selectRaw('tanggal as bulan')
                ->selectRaw('MONTH(tanggal) as noBulan')
                ->selectRaw("MAX(CASE WHEN presensi = 'hadir' THEN 'H' WHEN presensi = 'izin' THEN 'I' WHEN presensi = 'sakit' THEN 'S' ELSE 'A' END) as presensi")
                ->where('idPeriode', $periode)
                ->where('idSiswa', $siswa->idSiswa)
                ->groupBy('idSiswa', 'tanggal')
                ->get()->map(function ($item) {
                    $item->bulan = Carbon::parse($item->bulan)->translatedFormat('F');
                    return $item;
                });


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

            return response()
                ->json(
                    [
                        'siswa' => $siswa,
                        'presensi' => $kehadiran,
                        'bulan' => $daftarBulan,
                        'no_bulan' => $noBulanString,
                        'periode' => $periodeSelected,
                        'kelas' => $kelas
                    ]
                );
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
        }
    }
}
