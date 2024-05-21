<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Pegawai;
use App\Models\Pengajaran;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapNilaiMapel extends Controller
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

        $namaKelas = $kelas->namaKelas ?? null;

        $kelas_nama = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];

        return view('siakad/content/penilaian/rekap_nilai', compact('periodeAktif', 'periodeLewat', 'periode', 'kelas', 'kelas_nama'), [
            'judul' => 'Penilaian Siswa',
            'sub_judul' => 'Rekapitulasi Nilai Kelas ' . $namaKelas,
            'text_singkat' => 'Mengelola rekapitulasi nilai siswa!',
            's_idKelas' => '',
            'kelasName' => '',
            // 'periode' => $periodeGuru
        ]);
    }

    public function getTabelrekap(Request $request)
    {
        $periode = $request->periode;
        $pegawai = Auth::user()->pegawai->idPegawai;
        $kelas = Kelas::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode ?? '')
            ->first();

        $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelas, $periode) {
            $query->where('namaKelas', $kelas->namaKelas)
                ->where('idPeriode', $periode);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();

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
            'siswa' => $siswaWithKelas,
            'nilai' => $nilai,
            'kelas' => $kelas,
        ]);
    }

    public function getTabelrekapSiswa()
    {
        $periode = Periode::orderBy('tanggalMulai', 'desc')->get();
        $kepsek = Pegawai::select('namaPegawai', 'nip')->whereHas('jabatanPegawai', function ($query) {
            $query->where('jabatan', 'Kepala Sekolah');
        })->first();
        return view('siakad.content.penilaian.rekap_nilai_admin', compact('periode', 'kepsek'), [
            'judul' => 'Akademik',
            'sub_judul' => 'Rekap Nilai Siswa',
            'text_singkat' => 'Data ringkasan hasil penilaian siswa!',
            's_idKelas' => '',
        ]);
    }

    public function getTabelrekapAdmin($periode, $kelasN)
    {
        // $periode = $request->periode;
        // $kelasID = $request->kelas;
        // $pegawai = Auth::user()->pegawai->idPegawai;
        $kelas = Kelas::where('idPeriode', $periode)
            ->where('namaKelas', $kelasN)
            ->first();

        $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelas, $periode) {
            $query->where('namaKelas', $kelas->namaKelas)
                ->where('idPeriode', $periode);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();

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
            'siswa' => $siswaWithKelas,
            'nilai' => $nilai,
            'kelas' => $kelas,
        ]);
    }
}
