<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\Pengajaran;
use App\Models\Periode;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RekapitulasiAbsen extends Controller
{
    public function index()
    {
        $periode = Periode::where('status', 'Aktif')
            ->orderBy('tanggalMulai', 'desc')
            ->first();
        $pegawai = Auth::user()->pegawai->idPegawai;
        $kelas = Kelas::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode->idPeriode ?? '')
            ->first();

        $data = array_merge(
            $this->rekap(),
            [
                'judul' => 'Presensi Siswa',
                'sub_judul' => 'Rekapitulasi Presensi Kelas ' . $kelas->namaKelas,
                'text_singkat' => 'Mengelola rekapitulasi kehadiran siswa!',
                's_idKelas' => '',
            ]
        );

        return view('siakad/content/absen/rekapitulasi', $data);
    }

    protected function rekap()
    {
        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->first();
        $pegawai = Auth::user()->pegawai->idPegawai;
        $kelas = Kelas::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode->idPeriode ?? '')
            ->first();
        $kelasNama = $kelas->namaKelas;
        $periodeSiswa = $periode->idPeriode;

        // Ambil siswa dengan kelas dan periode yang sesuai
        $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelasNama, $periodeSiswa) {
            $query->where('namaKelas', $kelasNama)
                ->where('idPeriode', $periodeSiswa);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();


        $pegawai = Auth::user()->pegawai->idPegawai;

        $kehadiran = Absensi::select('idSiswa')
            ->selectRaw('DAY(tanggal) as tanggal')
            ->selectRaw('tanggal as bulan')
            ->selectRaw('MONTH(tanggal) as noBulan')
            ->selectRaw("MAX(CASE WHEN presensi = 'hadir' THEN 'H' WHEN presensi = 'izin' THEN 'I' WHEN presensi = 'sakit' THEN 'S' ELSE 'A' END) as presensi")
            ->where('idKelas', $kelas->idKelas)
            ->where('idPeriode', $periode->idPeriode ?? '')
            ->groupBy('idSiswa', 'tanggal')
            ->get()->map(function ($item) {
                $item->bulan = Carbon::parse($item->bulan)->translatedFormat('F');
                return $item;
            });

        $wakel = Pegawai::select('namaPegawai', 'nip')->whereHas('kelas', function ($query) use ($kelas) {
            $query->where('idKelas', $kelas->idKelas);
        })->first();

        $kepsek = Pegawai::select('namaPegawai', 'nip')->whereHas('jabatanPegawai', function ($query) {
            $query->where('jabatan', 'Kepala Sekolah');
        })->first();

        return compact('periode', 'kelas', 'kehadiran', 'siswaWithKelas', 'wakel', 'kepsek');
    }

    public function getRekap($periode, $kelas)
    {
        try {
            $kelasNama = $kelas;
            $periodeSiswa = $periode;

            // Ambil siswa dengan kelas dan periode yang sesuai
            $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelasNama, $periodeSiswa) {
                $query->where('namaKelas', $kelasNama)
                    ->where('idPeriode', $periodeSiswa);
            })
                ->orderBy('namaSiswa', 'asc')
                ->get();

            $kls = Kelas::select('idKelas')
                ->where('namaKelas', $kelas)
                ->where('idPeriode', $periode)
                ->first();

            $periodeSelected = Periode::where('idPeriode', $periode)->first();

            // $startDate = $periodeSelected->tanggalMulai; // Tanggal awal rentang
            // $endDate = Carbon::parse($tgl)->format('Y-m-d');   // Tanggal akhir rentang


            $kehadiran = Absensi::select('idSiswa')
                ->selectRaw('DAY(tanggal) as tanggal')
                ->selectRaw('tanggal as bulan')
                ->selectRaw('MONTH(tanggal) as noBulan')
                ->selectRaw("MAX(CASE WHEN presensi = 'hadir' THEN 'H' WHEN presensi = 'izin' THEN 'I' WHEN presensi = 'sakit' THEN 'S' ELSE 'A' END) as presensi")
                ->where('idPeriode', $periode)
                ->where('idKelas', $kls->idKelas)
                // ->whereBetween('tanggal', [$startDate, $endDate])
                ->groupBy('idSiswa', 'tanggal')
                ->get()->map(function ($item) {
                    $item->bulan = Carbon::parse($item->bulan)->translatedFormat('F');
                    return $item;
                });



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

            return response()
                ->json(
                    [
                        'siswa' => $siswaWithKelas,
                        'absensi' => $kehadiran,
                        'bulan' => $daftarBulan,
                        'noBulan' => $noBulanString,
                        'periode' => $periodeSelected
                    ]
                );
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
        }
    }
    public function getRekapKelas()
    {
        try {
            $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->first();
            $pegawai = Auth::user()->pegawai->idPegawai;
            $kelas = Kelas::where('idPegawai', $pegawai)
                ->where('idPeriode', $periode->idPeriode ?? '')
                ->first();
            $kelasNama = $kelas->namaKelas;
            $periodeSiswa = $periode->idPeriode;

            // Ambil siswa dengan kelas dan periode yang sesuai
            $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelasNama, $periodeSiswa) {
                $query->where('namaKelas', $kelasNama)
                    ->where('idPeriode', $periodeSiswa);
            })
                ->orderBy('namaSiswa', 'asc')
                ->get();

            $kehadiran = Absensi::select('idSiswa')
                ->selectRaw('DAY(tanggal) as tanggal')
                ->selectRaw('tanggal as bulan')
                ->selectRaw('MONTH(tanggal) as noBulan')
                ->selectRaw("MAX(CASE WHEN presensi = 'hadir' THEN 'H' WHEN presensi = 'izin' THEN 'I' WHEN presensi = 'sakit' THEN 'S' ELSE 'A' END) as presensi")
                ->where('idKelas', $kelas->idKelas)
                ->where('idPeriode', $periode->idPeriode ?? '')
                ->groupBy('idSiswa', 'tanggal')
                ->get()->map(function ($item) {
                    $item->bulan = Carbon::parse($item->bulan)->translatedFormat('F');
                    return $item;
                });



            $tanggalMulai = Carbon::parse($periode->tanggalMulai);
            $tanggalSelesai = Carbon::parse($periode->tanggalSelesai);

            $daftarBulan = [];
            $noBulan = [];

            while ($tanggalMulai <= $tanggalSelesai) {
                $daftarBulan[] = $tanggalMulai->translatedFormat('F');
                $noBulan[] = $tanggalMulai->translatedFormat('m');
                $tanggalMulai->addMonth();
            }

            // Mengonversi array $noBulan menjadi string dipisahkan dengan koma
            $noBulanString = implode(',', $noBulan);

            return response()
                ->json(
                    [
                        'siswa' => $siswaWithKelas,
                        'absensi' => $kehadiran,
                        'bulan' => $daftarBulan,
                        'noBulan' => $noBulanString,
                        'periode' => $periode,
                        'kelas' => $kelas
                    ]
                );
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
        }
    }
}
