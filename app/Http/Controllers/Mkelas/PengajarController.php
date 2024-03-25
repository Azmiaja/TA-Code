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
        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->get();
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
                $item['mapelDiampu'] = $item->mapel ? $item->mapel->namaMapel : '-';
                $item['semester'] = $item->periode ? 'Semester ' . $item->periode->semester . '/' . date('Y', strtotime($item->periode->tanggalMulai)) : '-';

                return $item;
            });

            return response()->json(['data' => $data]);

            // $data = Pengajaran::with(['periode', 'guru', 'mapel', 'kelas'])
            //     ->when($request->filled('periode'), function ($query) use ($request) {
            //         return $query->where('idPeriode', $request->input('periode'));
            //     })
            //     ->whereHas('kelas', function ($query) use ($request) {
            //         $query->where('namaKelas', $request->input('namaKelas'));
            //     })
            //     ->orderBy('idPengajaran', 'desc')
            //     ->get();

            // $groupedData = $data->groupBy('guru.namaPegawai')->map(function ($group, $key) {
            //     $subjects = $group->pluck('mapel.namaMapel')->implode(', ');
            //     $kelas = $group->first()->kelas->namaKelas;
            //     $teacherName = $group->first()->guru->namaPegawai;
            //     $nip = $group->first()->guru->nip;
            //     $semester = $group->first()->periode ?  $group->first()->periode->semester . ' ' . $group->first()->periode->tahun : '-';
            //     $idPengajar = $group->first()->idPegawai;
            //     return [
            //         'namaPengajar' => $teacherName,
            //         'mapelDiampu' => $subjects,
            //         'kelasPengajar' => 'Kelas ' . $kelas,
            //         'nipPengajar' => $nip,
            //         'semester' => $semester,
            //         'idPengajaran' => $idPengajar,
            //     ];
            // })->values(); // Re-index the array to start from index 0

            // return response()->json(['data' => $groupedData]);
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

    public function getPegawaiOption()
    {
        $data = Pegawai::where('status', 'Aktif')->whereNotIn('idPegawai', function ($query) {
            $query->select('idPegawai')
                ->from('user')
                ->where('hakAkses', 'Super Admin');
        })->get();

        return response()->json($data);
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
                $existingPengajaran = Pengajaran::where('idMapel', $data)
                    ->where('idKelas', $idKelas)
                    ->where('idPeriode', $idPeriode)
                    ->exists();

                if ($existingPengajaran) {
                    return response()->json([
                        'status' => 'error',
                        'title' => 'Gagal',
                        'message' => 'Mata pelajaran sudah ada dalam kelas.'
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
        // $pengajar = Pengajaran::with(['periode', 'guru', 'mapel', 'kelas'])->where('idPegawai', $id)->get();
        // $groupedData = $pengajar->groupBy('guru.namaPegawai')->map(function ($group, $key) {
        //     $subjects = $group->pluck('mapel.idMapel')->toArray();
        //     $kelas = $group->first()->kelas->idKelas;
        //     $teacherName = $group->first()->guru->namaPegawai;
        //     $nip = $group->first()->guru->nip;
        //     $semester = $group->first()->periode ?  $group->first()->periode->idPeriode : '-';
        //     $idPengajar = $group->first()->idPegawai;
        //     $idPengajar_2 = $group->pluck('idPengajaran')->toArray();
        //     return [
        //         'namaPengajar' => $teacherName,
        //         'mapelDiampu' => $subjects,
        //         'kelasPengajar' => $kelas,
        //         'nipPengajar' => $nip,
        //         'semester' => $semester,
        //         'idPengajaran' => $idPengajar,
        //         'idPengajar' => $idPengajar_2,
        //     ];
        // })->values();
        // return response()->json(['data' => $groupedData]);
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
        try {
            $pengajar = Pengajaran::find($id);

            // Cek apakah pengajar sudah mengajar mata pelajaran pada kelas yang dipilih
            $existingPengajaran = Pengajaran::where('idMapel', $request->input('idMapel_two'))
                ->where('idKelas', $request->input('idKelas'))
                ->where('idPeriode', $request->input('idPeriode'))
                ->exists();

            if ($existingPengajaran) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Mata pelajaran sudah ada.'
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
            // $idPengajaran = $request->input('idPengajaran');
            // $idPegawai = $request->input('idPegawai');
            // $idMapel = $request->input('idMapel');
            // $idKelas = $request->input('idKelas');

            // // Pastikan jumlah data yang diterima sama untuk semua input
            // $count = count($idPengajaran);

            // for ($i = 0; $i < $count; $i++) {
            //     Pengajaran::where('idPengajaran', $idPengajaran[$i])->update([
            //         'idPegawai' => $idPegawai,
            //         'idMapel' => $idMapel[$i],
            //         'idKelas' => $idKelas,
            //     ]);
            // }

            // return response()->json([
            //     'status' => 'success',
            //     'title' => 'Sukses',
            //     'message' => 'Berhasil mengubah data.'
            // ]);
        } catch (\Exception $e) {
            Log::error('Error update data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pengajar = Pengajaran::where('idPegawai', $id);
        $pengajar->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil mengapus data.'
        ]);
    }
}
