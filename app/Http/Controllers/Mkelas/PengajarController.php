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
            'text_singkat' => 'Mengelola pengajar mapel dan kelas!',
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

            $groupedData = $data->groupBy('guru.namaPegawai')->map(function ($group, $key) {
                // $subjects = $group->pluck('mapel.namaMapel')->implode(',<br>');
                $subjects = $group->map(function ($item) {
                    $mapel = $item->mapel;
                    $namaMapel = $mapel->singkatan ? $mapel->singkatan : $mapel->namaMapel;
                    return '<button type="button" id="mapel_btn" class="btn btn-sm btn-alt-info my-1" value="' . $mapel->idMapel . '">' . $namaMapel . '</button>';
                })->implode(' ');
                $kelas = $group->first()->kelas->namaKelas;
                $teacherName = $group->first()->guru->namaPegawai;
                $nip = $group->first()->guru->nip;
                $semester = $group->first()->periode ?  $group->first()->periode->semester . ' ' . $group->first()->periode->tahun : '-';
                $idPengajar = $group->first()->idPegawai;
                return [
                    'namaPengajar' => $teacherName,
                    'mapelDiampu' => $subjects,
                    'kelasPengajar' => 'Kelas ' . $kelas,
                    'nipPengajar' => $nip,
                    'semester' => $semester,
                    'idPengajaran' => $idPengajar,
                ];
            })->values(); // Re-index the array to start from index 0

            return response()->json(['data' => $groupedData]);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
        }
    }

    public function getMapel(Request $request, $id)
    {
        try {
            $data = Mapel::whereDoesntHave('pengajar', function ($query) use ($id) {
                $query->where('idKelas', '=', $id);
            })
                ->get();

            return response()->json($data);

            // $data = Mapel::select('mapel.namaMapel', 'mapel.deskripsiMapel', 'mapel.idMapel')
            //     ->leftJoin('pengajaran as p', 'p.idMapel', '=', 'mapel.idMapel')
            //     ->whereNull('p.idKelas')
            //     ->orWhere('p.idKelas', '<>', $id)
            //     ->get();


            // return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
        }
    }

    public function getForm(Request $request)
    {
        $periodeId = $request->input('periode_id');
        $pegawai = Pegawai::where('jenisPegawai', 'Guru')->orderBy('idPegawai', 'desc')->get();
        $mapel = Mapel::whereDoesntHave('pengajar')->orderBy('idMapel', 'desc')->get();
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
        $data = Pegawai::with('kelas')->where('status', 'Aktif')->whereNotIn('idPegawai', function ($query) {
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
            Log::error('Error storing data: ' . $e->getMessage() . dd($idMapel));
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

    public function destroy($id, $idP)
    {
        try {
            $pengajar = Pengajaran::where('idPegawai', $id)->where('idPeriode', $idP);
            $pengajar->delete();

            return response()->json([
                'status' => 'success',
                'title' => 'Dihapus!',
                'message' => 'Berhasil mengapus data.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal!',
                'message' => 'Tidak dapat menghapus data karena memiliki relasi dengan data lain!.'
            ]);
        }
    }

    public function getMapelPengajar(Request $request)
    {
        $idMapel = $request->input('idMapel');
        $namaKelas = $request->input('namaKelas');
        $idPeriode = $request->input('idPeriode');

        $mapelPengajar = Pengajaran::where('idPeriode', $idPeriode)
            ->where('idMapel', $idMapel)
            ->whereHas('kelas', function ($query) use ($namaKelas) {
                $query->where('namaKelas', $namaKelas);
            })
            ->with('mapel', 'guru', 'periode', 'kelas')
            ->first();

        return response()->json($mapelPengajar);
    }

    public function destroyMapel($id)
    {
        try {
            $pengajar = Pengajaran::find($id);
            $pengajar->delete();

            return response()->json([
                'status' => 'success',
                'title' => 'Dihapus!',
                'message' => 'Berhasil mengapus data.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal!',
                'message' => 'Tidak dapat menghapus data karena memiliki relasi dengan data lain!.'
            ]);
        }
    }
}
