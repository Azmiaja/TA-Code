<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pegawai;
use App\Models\Pengajaran;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class PengajarController extends Controller
{
    public function index()
    {
        $periode = Periode::orderBy('tanggalMulai', 'desc')->get();
        return view('siakad.content.m_sekolah.akademik.pengajaran.index', compact('periode'), [
            'judul' => 'Data Master',
            'sub_judul' => 'Akademik',
            'sub_sub_judul' => 'Pengajar',
            'text_singkat' => 'Mengelola pengajar mapel dan kelas akademik sekolah!',
        ]);
    }

    public function getPengajar(Request $request)
    {
        try {

            $data = Pengajaran::with(['periode', 'guru', 'mapel', 'kelas'])
                ->when($request->filled('periode'), function ($query) use ($request) {
                    return $query->where('idPeriode', $request->input('periode'));
                })
                ->whereHas('kelas', function ($query) use ($request) {
                    $query->where('namaKelas', $request->input('namaKelas'));
                })
                ->orderBy('idPengajaran', 'desc')
                ->get();

            $data = $data->map(function ($item, $key) {
                $item['nomor'] = $key + 1;
                $item['kelasPengajar'] = $item->kelas ? 'Kelas ' . $item->kelas->namaKelas : '-';
                $item['namaPengajar'] = $item->guru ? $item->guru->namaPegawai : '-';
                $item['nipPengajar'] = $item->guru ? $item->guru->nip : '-';
                $item['mapelDiapu'] = $item->mapel ? $item->mapel->namaMapel : '-';
                $item['semester'] = $item->periode ? 'Semester ' . $item->periode->semester . '/' . date('Y', strtotime($item->periode->tanggalMulai)) : '-';

                return $item;
            });

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
        }
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
        try {
            $idMapel = $request->input('idMapel');
            $idPeriode = $request->input('idPeriode');
            $idKelas = $request->input('idKelas');
            $idPegawai = $request->input('idPegawai');


            foreach ($idMapel as $data) {
                $existingPengajaran = Pengajaran::where('idPegawai', $idPegawai)
                    ->where('idMapel', $data)
                    ->where('idKelas', $idKelas)
                    ->where('idPeriode', $idPeriode)
                    ->exists();

                if ($existingPengajaran) {
                    return response()->json([
                        'status' => 'error',
                        'title' => 'Gagal',
                        'message' => 'Guru yang dipilih sudah mengajar mata pelajaran pada kelas yang dipilih.'
                    ]);
                }

                Pengajaran::create([
                    'idMapel' => $data,
                    'idPeriode' => $idPeriode,
                    'idPegawai' => $idPegawai,
                    'idKelas' => $idKelas,
                ]);
            }


            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil menyimpan data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage() . $idMapel);
        }
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
        return response()->json(['data' => $pengajar]);
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

        // Cek apakah pengajar sudah mengajar mata pelajaran pada kelas yang dipilih
        $existingPengajaran = Pengajaran::where('idPegawai', $request->input('idPegawai'))
            ->where('idMapel', $request->input('idMapel_two'))
            ->where('idKelas', $request->input('idKelas'))
            ->where('idPeriode', $request->input('idPeriode'))
            ->exists();

        if ($existingPengajaran) {
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Guru yang dipilih sudah mengajar mata pelajaran pada kelas yang dipilih.'
            ]);
        }

        // Update data pengajar
        $pengajar->update([
            'idMapel' => $request->input('idMapel_two'),
            'idPeriode' => $request->input('idPeriode'),
            'idKelas' => $request->input('idKelas'),
            'idPegawai' => $request->input('idPegawai'),
        ]);

        return response()->json([
            'status' => 'success',
            'title' => 'Sukses',
            'message' => 'Berhasil mengubah data.'
        ]);
    }

    public function destroy($id)
    {
        $pengajar = Pengajaran::find($id);
        $pengajar->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil mengapus data.'
        ]);
    }
}
