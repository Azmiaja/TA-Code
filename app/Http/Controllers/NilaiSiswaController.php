<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kategori_nilai;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Pengajaran;
use App\Models\TrKelas;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NilaiSiswaController extends Controller
{


    private function getColumns()
    {
        $columns = DB::select('SHOW COLUMNS FROM your_table_name');
        return array_map(function ($column) {
            return $column->Field;
        }, $columns);
    }
    public function index($slug, $id, $kelas_id, $periode_id)
    {
        // Anda dapat menggunakan $slug untuk keperluan apapun, misalnya validasi atau filtering
        // ...
        // $columns = $this->getColumns();

        $periode = Periode::where('idPeriode', $periode_id)->get();
        $mapel = Pengajaran::with('mapel')->where('idPengajaran', $id)->get();
        // $kelas = Kelas::where('namaKelas', $kelas_id)->get();
        $nilai = Nilai::where('idPeriode', $periode_id)->where('idPengajaran', $id)->get();
        $siswa = Siswa::with('nilai', 'tr_kelas.kelas')
            ->whereHas('tr_kelas.kelas', function ($query) use ($kelas_id) {
                $query->where('namaKelas', $kelas_id);
            })
            ->get();

        // $kategori = Kategori_nilai::all();

        // $dynamicColumns = DB::table('kategori_nilai')
        //     ->pluck('kategori')
        //     ->toArray();
        $kelas = Kelas::where('namaKelas', $kelas_id)->get();

        // $kategoris = Kategori_nilai::with('nilai')->get();
        return view('mkelas.nilai_siswa', compact('periode', 'mapel', 'siswa', 'nilai'), [
            'title' => 'Manajemen Kelas',
            'title2' => 'Penilaian Siswa',
            'kelas_id' => $kelas_id,
            'kelas' => $kelas,
            'periode_id' => $periode_id,
            'pengajaran_id' => $id,
        ]);
    }


    public function getNilaiData(Request $request)
    {
        $periodeId = $request->input('periode_id');
        $kelasId = $request->input('kelas_id');
        $pengajaranId = $request->input('pengajaran_id');

        $results = DB::table('siswa as s')
            ->select('s.idSiswa', 's.namaSiswa', 'n.nilaiUH', 'n.nilaiUTS', 'n.nilaiUAS', 'n.idNilai')
            ->leftJoin('nilai as n', function ($join) use ($pengajaranId, $periodeId) {
                $join->on('s.idSiswa', '=', 'n.idSiswa')
                    ->where('n.idPeriode', '=', $periodeId)
                    ->where('n.idPengajaran', '=', $pengajaranId);
            })
            ->leftJoin('tr_kelas as tk', 's.idSiswa', '=', 'tk.idSiswa')
            ->leftJoin('kelas as k', 'tk.idKelas', '=', 'k.idKelas')
            ->where('k.idKelas', '=', $kelasId)
            ->get();

        // return response()->json(['data' => $results]);

        return DataTables::of($results)->make(true);
    }

    public function edit($id, $idPengajaran, $idPeriode)
    {
        $siswa = Siswa::with(['nilai' => function ($query) use ($idPengajaran, $idPeriode) {
            $query->where('idPengajaran', $idPengajaran)
                ->where('idPeriode', $idPeriode);
        }])->find($id);

        return response()->json(['data' => $siswa]);
    }




    public function up(Request $request)
    {
        $idPengajaran = $request->input('idPengajaran');
        $idNilai = $request->input('idNilai');

        // Cek apakah data dengan idPengajaran dan idNilai yang baru diinput sudah ada
        $existingNilai = Nilai::where('idPengajaran', $idPengajaran)->where('idNilai', $idNilai)->first();

        if ($existingNilai) {
            // Jika data sudah ada, lakukan update
            $data = $request->all();

            // Cek apakah ada nilai yang ingin diupdate
            if (isset($data['nilaiUH'])) {
                $existingNilai->nilaiUH = $data['nilaiUH'];
            }

            if (isset($data['nilaiUTS'])) {
                $existingNilai->nilaiUTS = $data['nilaiUTS'];
            }

            if (isset($data['nilaiUAS'])) {
                $existingNilai->nilaiUAS = $data['nilaiUAS'];
            }

            $existingNilai->update();
            return response()->json(['message' => 'Data berhasil diperbarui.']);
        } else {
            // Jika data belum ada, lakukan insert
            $validatedData = $request->validate([
                'idSiswa' => 'required',
                'idPeriode' => 'required',
                'idPengajaran' => 'required',
                'nilaiUH' => '',
                'nilaiUTS' => '',
                'nilaiUAS' => '',
            ]);

            $nilai = new Nilai($validatedData);
            $nilai->idNilai = $idNilai;
            $nilai->save();

            return response()->json(['message' => 'Data berhasil disimpan.']);
        }
    }










    public function simpanNilai(Request $request)
    {
        try {
            $data = $request->input('data');

            foreach ($data as $item) {
                Nilai::updateOrCreate([
                    'idSiswa' => $item['idSiswa'],
                    'idPeriode' => $item['idPeriode'],
                    'idKategoriNilai' => $item['idKategoriNilai'],
                    'idPengajaran' => $item['idPengajaran'],
                ], [
                    'nilai' => $item['value'],
                ]);
            }

            // Respon berhasil
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
