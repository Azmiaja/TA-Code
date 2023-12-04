<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pegawai;
use App\Models\Pengajaran;
use App\Models\Periode;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class PengajarController extends Controller
{
    public function index()
    {
        $periode = Periode::orderBy('idPeriode', 'desc')->get();
        return view('mkelas.pengajaran', compact('periode'), [
            'title' => "Manajemen Kelas",
            'title2' => "Pengajar",
        ]);
    }

    public function getPengajar(Request $request)
    {
        $data = Pengajaran::with(['periode', 'guru', 'mapel', 'kelas'])
            ->where('idPeriode', $request->periode_id)
            ->whereHas('kelas', function ($query) use ($request) {
                $query->where('namaKelas', $request->nama_kls);
            })
            ->get();

        return DataTables::of($data)->toJson();
    }

    public function getForm(Request $request)
    {
        $periodeId = $request->input('periode_id');
        $pegawai = Pegawai::where('jenisPegawai', 'Guru')->orderBy('idPegawai', 'desc')->get();
        $mapel = Mapel::orderBy('idMapel', 'desc')->get();
        $periode = Periode::orderBy('idPeriode', 'desc')->get()
            ->map(function ($periode) {
                // Tambahkan properti baru 'formattedTanggalMulai'
                $periode->formattedTanggalMulai = $periode->semester . '/' . date('Y', strtotime($periode->tanggalMulai));
                return $periode;
            });
        $kelas = Kelas::where('idPeriode', $periodeId)->orderBy('namaKelas', 'asc')->with('guru')->get();

        return response()->json(['pegawai' => $pegawai, 'mapel' => $mapel, 'periode' => $periode, 'kelas' => $kelas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'idPeriode' => 'required',
            'idMapel' => 'required',
            'idPegawai' => 'required',
            'idKelas' => 'required',
        ]);

        Pengajaran::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menyimpan data.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pengajar = Pengajaran::find($id);
        return response()->json(['pengajar' => $pengajar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pengajar = Pengajaran::find($id);

        if (!$pengajar) {
            return response()->json(['status' => 'error', 'message' => 'Data pengajar tidak ditemukan.']);
        }
        // Validasi input
        $validatedData = $request->validate([
            'idPeriode' => 'required',
            'idMapel' => 'required',
            'idPegawai' => 'required',
        ]);

        // Perbarui data pengajar
        $pengajar->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah data.'
        ]);
    }

    public function destroy($id)
    {
        $pengajar = Pengajaran::find($id);
        $pengajar->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengapus data.'
        ]);
    }
}
