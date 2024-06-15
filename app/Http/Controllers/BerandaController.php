<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Pengajaran;
use App\Models\Periode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BerandaController extends Controller
{
    public function index()
    {
        $auth = auth()->user()->pegawai->namaPegawai ?? auth()->user()->siswa->namaSiswa;
        $periode = Periode::where('status', 'Aktif')->first();
        if (Auth::user()->pegawai) {
            $kelas = Kelas::where('idPeriode', $periode->idPeriode)
                ->where('idPegawai', Auth::user()->pegawai->idPegawai)
                ->first();
            # code...
            $kelas_nm = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM', ];
        }
        return view('siakad/content/dashboard/beranda', [
            'judul' => 'Beranda',
            'sub_judul' => 'Beranda',
            'text_singkat' => 'Selamat datang <a href="' . route('profil_pengguna.index') . '" class="fw-semibold">' . $auth . '</a>, di SIAKAD SD Negeri Lemahbang',
            's_idKelas' => '',
            'periode' => $periode,
            'kelas' => $kelas ?? '',
            'kelas_nm' => $kelas_nm ?? '',
        ]);
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
            ->sortBy(function ($item) {
                return $item->jamke ? $item->jamke->jamKe : 0;
            })
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

    public function getDataKalenderJadwalGuru(Request $request)
    {
        try {
            $hari = $request->hari;
            $periode = Periode::where('status', 'Aktif')->first();
            $guru = Auth::user()->pegawai;
            $kelas = Pengajaran::where('idPeriode', $periode->idPeriode)->where('idPegawai', $guru->idPegawai)
                ->first();
            $jadwal = Jadwal::where('hari', $hari)
                ->where('idPeriode', $periode->idPeriode)
                ->get()
                ->sortBy(function ($item) {
                    return $item->jamke ? $item->jamke->jamKe : 0;
                })
                ->filter(function ($item) {
                    // Filter jadwal berdasarkan idPegawai yang login
                    return $item->pengajaran->guru->idPegawai === Auth::user()->pegawai->idPegawai;
                })
                ->groupBy('pengajaran.idMapel')
                ->map(function ($items) {
                    $combinedSchedules = [];
                    foreach ($items as $item) {
                        $pengajaran = $item->pengajaran;
                        $key = $pengajaran->idMapel;
                        if (!isset($combinedSchedules[$key])) {
                            $combinedSchedules[$key] = [
                                'hari' => $item->hari,
                                'kelas' => $pengajaran->kelas ? $pengajaran->kelas->namaKelas : '',
                                'mapel' => $pengajaran->mapel ? $pengajaran->mapel->namaMapel : '',
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
        } catch (Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
            // Handle the exception here
        }
    }
}
