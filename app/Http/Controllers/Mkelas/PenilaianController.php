<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kategori_nilai;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Pengajaran;
use App\Models\Periode;
use App\Models\Tr_kelas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::with('periode')
            ->where('idPeriode', $request->periode_id)
            ->orderBy('namaKelas', 'asc')
            ->get();
        $periode = Periode::orderBy('idPeriode', 'desc')->get();
        $mapel = Mapel::orderBy('idMapel', 'desc')->get();
        // $kategori = Kategori_nilai::orderBy('idKategoriNilai', 'desc')->get();
        return view('mkelas.penilaian', compact('periode', 'mapel', 'kelas'), [
            'title' => 'Manajemen Kelas',
            'title2' => 'Penilaian',
        ]);
    }



    public function getKelasByPeriode($periode_id)
    {
        $kelas = Kelas::where('idPeriode', $periode_id)->get();

        return response()->json($kelas);
    }

    public function getNilaiSiswa(Request $request)
    {
        $data = Pengajaran::with(['periode', 'kelas', 'mapel'])
            ->whereHas('periode', function ($query) use ($request) {
                $query->where('idPeriode', $request->periode_id);
            })
            ->whereHas('kelas', function ($query) use ($request) {
                $query->where('namaKelas', $request->kelas_id);
            })
            ->get();


        return DataTables::of($data)->toJson();
    }


    //siswa controller
    public function index_siswa(Request $request)
    {
        $kelas = Kelas::with('periode')
            ->where('idPeriode', $request->periode_id)
            ->orderBy('namaKelas',)
            ->get();
        $periode = Periode::orderBy('idPeriode', 'desc')->get();
        $mapel = Mapel::orderBy('idMapel', 'desc')->get();
        // $kategori = Kategori_nilai::orderBy('idKategoriNilai', 'desc')->get();
        return view('mkelas.penilaian', compact('periode', 'mapel', 'kategori', 'kelas'), [
            'title' => 'Manajemen Kelas',
            'title3' => 'Kelas',
            'title2' => 'Penilaian',
        ]);
    }

    public function getNilaiSiswaKelas(Request $request)
    {

        $data = Nilai::select('mapel.namaMapel', 'nilai.nilaiUH', 'nilai.nilaiUTS', 'nilai.nilaiUAS', 'pegawai.namaPegawai')
            ->from('mapel')
            ->join('pengajaran', 'mapel.idMapel', '=', 'pengajaran.idMapel')
            ->leftJoin('nilai', 'pengajaran.idPengajaran', '=', 'nilai.idPengajaran')
            ->leftJoin('pegawai', 'pengajaran.idPegawai', '=', 'pegawai.idPegawai')
            ->leftJoin('tr_kelas', 'nilai.idSiswa', '=', 'tr_kelas.idSiswa')
            ->leftJoin('periode', 'pengajaran.idPeriode', '=', 'periode.idPeriode')
            ->leftJoin('kelas', 'tr_kelas.idKelas', '=', 'kelas.idKelas')
            ->where('tr_kelas.idSiswa', '=', $request->siswa_id)
            ->where('periode.idPeriode', '=', $request->periode_id)
            ->get();

        return DataTables::of($data)->toJson();
    }

    // Guru
    public function index_guru(Request $request)
    {
        $kelas = Kelas::with('periode')
            ->where('idPeriode', $request->periode_id)
            ->orderBy('namaKelas',)
            ->get();
        $periode = Periode::orderBy('idPeriode', 'desc')->get();
        $mapel = Mapel::orderBy('idMapel', 'desc')->get();
        // $kategori = Kategori_nilai::orderBy('idKategoriNilai', 'desc')->get();
        return view('mkelas.penilaian', compact('periode', 'mapel', 'kategori', 'kelas'), [
            'title' => 'Manajemen Kelas',
            'title3' => 'Kelas',
            'title2' => 'Penilaian Siswa',
        ]);
    }

    public function getMapelGuru(Request $request)
    {
        $data = Mapel::join('pengajaran', 'pengajaran.idMapel', '=', 'mapel.idMapel')
            ->join('kelas', 'pengajaran.idKelas', '=', 'kelas.idKelas')
            ->join('periode', 'pengajaran.idPeriode', '=', 'periode.idPeriode')
            ->join('pegawai', 'pengajaran.idPegawai', '=', 'pegawai.idPegawai')
            ->where('pegawai.idPegawai', '=', $request->nama)
            ->where('kelas.namaKelas', '=', $request->kelas)
            ->where('periode.idPeriode', '=', $request->periode)
            ->get();

        return DataTables::of($data)->toJson();
    }
}
