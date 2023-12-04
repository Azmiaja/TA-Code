<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\Pengajaran;
use App\Models\Periode;
use Illuminate\Http\Request;
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
        ]);
    }

    public function getJPkelas1(Request $request)
    {
        $periode_id = $request->input('periode_id');

        $data = Jadwal::select(
            'jadwal.*',
            'pegawai.namaPegawai',
            'mapel.namaMapel',
            DB::raw('TIME_TO_SEC(TIMEDIFF(jadwal.jamSelesai, jadwal.jamMulai)) / 60 AS durasi_total_in_minutes')
        )
            ->join('pengajaran', 'jadwal.idPengajaran', '=', 'pengajaran.idPengajaran')
            ->join('pegawai', 'pengajaran.idPegawai', '=', 'pegawai.idPegawai')
            ->join('mapel', 'pengajaran.idMapel', '=', 'mapel.idMapel')
            ->join('periode', 'pengajaran.idPeriode', '=', 'periode.idPeriode')
            ->join('kelas', 'kelas.idPeriode', '=', 'periode.idPeriode')
            ->where('pegawai.jenisPegawai', '=', 'Guru')
            ->where('kelas.namaKelas', '=', '1')
            ->where('periode.idPeriode', '=', $periode_id)
            ->get();

        return DataTables::of($data)->toJson();
    }

    public function getPeriode()
    {
    }

    public function getTeachers(Request $request)
    {
        // Get selected values from the request
        $selectedPeriode = $request->input('periode');
        $selectedKelas = $request->input('kelas');

        // Fetch teachers based on the selected values
        $teachers = Kelas::with('guru')
        ->join('pengajaran')
            ->where('idPeriode', $selectedPeriode)
            ->where('idKelas', $selectedKelas)
            ->get();

        // Return the list of teachers as JSON
        return response()->json($teachers);
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
}
