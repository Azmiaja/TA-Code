<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\Pengajaran;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PenjadwalanController extends Controller
{
    public function index()
    {
        $periode = Periode::orderBy('idPeriode', 'desc')->get();
        return view('mkelas.penjadwalan', compact('periode'), [
            'title' => 'Manajemen Kelas',
            'title2' => 'Penjadwalan',
            'title3' => 'Kelas',
        ]);
    }

    public function index_siswa()
    {
        $periode = Periode::orderBy('idPeriode', 'desc')->get();
        return view('mkelas.penjadwalan', compact('periode'), [
            'title' => 'Manajemen Kelas',
            'title3' => 'Kelas',
            'title2' => 'Jadwal',
        ]);
    }

    public function getJPkelas1(Request $request)
    {
        $data = Jadwal::selectRaw('*, TIME_TO_SEC(TIMEDIFF(jadwal.jamSelesai, jadwal.jamMulai)) / 60 AS durasi_total_in_minutes')
            ->with(['pengajaran.mapel', 'pengajaran.guru', 'pengajaran.periode', 'pengajaran.kelas'])
            ->whereHas('pengajaran.periode', function ($query) use ($request) {
                $query->where('idPeriode', $request->periode_id);
            })
            ->whereHas('pengajaran.kelas', function ($query) use ($request) {
                $query->where('namaKelas', $request->kelas_id);
            })
            ->get();

        return DataTables::of($data)->toJson();
    }

    public function getPeriode()
    {
    }

    public function getForm(Request $request)
    {
        $periodeId = $request->input('periode_id');
        $kelasId = $request->input('kelas_id');

        $periode = $this->getFormattedPeriode();
        $kelas = $this->getKelasWithGuru($periodeId);
        $pengajaran = $this->getPengajaran($kelasId);

        return response()->json(['periode' => $periode, 'kelas' => $kelas, 'pengajaran' => $pengajaran]);
    }

    private function getFormattedPeriode(): Collection
    {
        return Periode::orderBy('idPeriode', 'desc')->get()->map(function ($periode) {
            $periode->formattedTanggalMulai = $periode->semester . '/' . date('Y', strtotime($periode->tanggalMulai));
            return $periode;
        });
    }

    private function getKelasWithGuru($periodeId): Collection
    {
        return Kelas::where('idPeriode', $periodeId)->orderBy('namaKelas', 'asc')->with('guru')->get();
    }

    private function getPengajaran($kelasId): Collection
    {
        return Pengajaran::where('idKelas', $kelasId)->with('kelas', 'mapel')->get();
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'idPengajaran' => 'required',
                'hari' => 'required',
                'jamMulai' => 'required|date_format:H:i', // Assuming you want a time format
                'jamSelesai' => 'required|date_format:H:i', // Assuming you want a time format
            ]);


            Jadwal::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors(),
            ], 422);
        }
    }

    public function edit($id)
    {
        $jadwal = Jadwal::with(['pengajaran.mapel', 'pengajaran.guru', 'pengajaran.periode', 'pengajaran.kelas'])
            ->find($id);

        return response()->json(['jadwal' => $jadwal]);
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::find($id);

        if (!$jadwal) {
            return response()->json(['status' => 'error', 'message' => 'Data jadwal tidak ditemukan.']);
        }

        $jadwal->update($request->all());


        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah data.'
        ]);
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengapus data.'
        ]);
    }

    // Siswa
    public function getJadwalSiswa(Request $request)
    {
        $data = Jadwal::selectRaw("
            CONCAT(DATE_FORMAT(jadwal.jamMulai, '%H:%i'), ' - ', DATE_FORMAT(jadwal.jamSelesai, '%H:%i')) AS waktu,
            GROUP_CONCAT(DISTINCT
                CASE WHEN hari = 'Senin' THEN mapel.namaMapel END SEPARATOR '<br>'
            ) AS Senin,
            GROUP_CONCAT(DISTINCT
                CASE WHEN hari = 'Selasa' THEN mapel.namaMapel END SEPARATOR '<br>'
            ) AS Selasa,
            GROUP_CONCAT(DISTINCT
                CASE WHEN hari = 'Rabu' THEN mapel.namaMapel END SEPARATOR '<br>'
            ) AS Rabu,
            GROUP_CONCAT(DISTINCT
                CASE WHEN hari = 'Kamis' THEN mapel.namaMapel END SEPARATOR '<br>'
            ) AS Kamis,
            GROUP_CONCAT(DISTINCT
                CASE WHEN hari = 'Jumat' THEN mapel.namaMapel END SEPARATOR '<br>'
            ) AS Jumat,
            GROUP_CONCAT(DISTINCT
                CASE WHEN hari = 'Sabtu' THEN mapel.namaMapel END SEPARATOR '<br>'
            ) AS Sabtu
        ")
            ->join('pengajaran', 'jadwal.idPengajaran', '=', 'pengajaran.idPengajaran')
            ->join('kelas', 'pengajaran.idKelas', '=', 'kelas.idKelas')
            ->join('mapel', 'pengajaran.idMapel', '=', 'mapel.idMapel')
            ->join('periode', 'pengajaran.idPeriode', '=', 'periode.idPeriode')
            ->where('kelas.namaKelas', $request->kelas)
            ->where('periode.idPeriode', $request->idPeriode)
            ->groupBy('jamMulai', 'jamSelesai')
            ->orderBy('jamMulai')
            ->get();

        return Datatables::of($data)
            ->make(true);
    }

    // Guru

    public function getJadwalPGuru(Request $request)
    {
        $data = DB::table('jadwal')
            ->select(
                DB::raw('CONCAT(DATE_FORMAT(jadwal.jamMulai, "%H:%i"), " - ", DATE_FORMAT(jadwal.jamSelesai, "%H:%i")) AS waktu'),
                DB::raw('TRIM(BOTH "," FROM GROUP_CONCAT(IF(jadwal.hari = "Senin", CONCAT(mapel.namaMapel, " - Kelas ", kelas.namaKelas), ""))) AS senin'),
                DB::raw('TRIM(BOTH "," FROM GROUP_CONCAT(IF(jadwal.hari = "Selasa", CONCAT(mapel.namaMapel, " - Kelas ", kelas.namaKelas), ""))) AS selasa'),
                DB::raw('TRIM(BOTH "," FROM GROUP_CONCAT(IF(jadwal.hari = "Rabu", CONCAT(mapel.namaMapel, " - Kelas ", kelas.namaKelas), ""))) AS rabu'),
                DB::raw('TRIM(BOTH "," FROM GROUP_CONCAT(IF(jadwal.hari = "Kamis", CONCAT(mapel.namaMapel, " - Kelas ", kelas.namaKelas), ""))) AS kamis'),
                DB::raw('TRIM(BOTH "," FROM GROUP_CONCAT(IF(jadwal.hari = "Jumat", CONCAT(mapel.namaMapel, " - Kelas ", kelas.namaKelas), ""))) AS jumat'),
                DB::raw('TRIM(BOTH "," FROM GROUP_CONCAT(IF(jadwal.hari = "Sabtu", CONCAT(mapel.namaMapel, " - Kelas ", kelas.namaKelas), ""))) AS sabtu')
            )
            ->join('pengajaran', 'jadwal.idPengajaran', '=', 'pengajaran.idPengajaran')
            ->join('pegawai', 'pengajaran.idPegawai', '=', 'pegawai.idPegawai')
            ->join('mapel', 'pengajaran.idMapel', '=', 'mapel.idMapel')
            ->join('kelas', 'pengajaran.idKelas', '=', 'kelas.idKelas')
            ->join('periode', 'pengajaran.idPeriode', '=', 'periode.idPeriode')
            ->where('pegawai.idPegawai', '=', $request->id_nama)
            ->where('periode.idPeriode', '=', $request->id_periode)
            ->groupBy('jamMulai', 'jamSelesai')
            ->orderBy('jamMulai')
            ->get();

        return Datatables::of($data)->make(true);
    }
}
