<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\Pengajaran;
use App\Models\Periode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PenjadwalanController extends Controller
{
    public function index()
    {
        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->get();
        return view('siakad.content.m_sekolah.akademik.jadwal.index', compact('periode'), [
            'judul' => 'Data Master',
            'sub_judul' => 'Akademik',
            'sub_sub_judul' => 'Penjadwalan',
            'text_singkat' => 'Mengelola penjadwalan kelas untuk guru dan siswa sekolah!',
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
        try {

            // $periode = $request->input('periode');
            // $kelas = $request->input('kelas_id');

            // $query = Jadwal::with('pengajaran.mapel')
            //     ->when(!empty($kelas), function ($query) use ($kelas) {
            //         $query->whereHas('kelas', function ($subQuery) use ($kelas) {
            //             $subQuery->where('namaKelas', $kelas);
            //         });
            //     })
            //     ->when(!empty($periode), function ($query) use ($periode) {
            //         $query->where('idPeriode', $periode);
            //     });

            // $data = $query->get();

            // $data = $data->groupBy(function ($jadwal) {
            //     return $jadwal->jamMulai . '-' . $jadwal->jamSelesai;
            // })->map(function ($groupedData) {
            //     $formattedData = [
            //         'nomor' => $groupedData->keys()->first() + 1,
            //         'Senin' => '-',
            //         'Selasa' => '-',
            //         'Rabu' => '-',
            //         'Kamis' => '-',
            //         'Jumat' => '-',
            //         'Sabtu' => '-',
            //         'waktu' => '',
            //         'idJadwal' => $groupedData->first()->idJadwal,
            //         'idPeriode' => $groupedData->first()->idPeriode,
            //         'idKelas' => $groupedData->first()->idKelas,
            //     ];

            //     foreach ($groupedData as $item) {
            //         $jamMulai = date('H:i', strtotime($item->jamMulai));
            //         $jamSelesai = date('H:i', strtotime($item->jamSelesai));
            //         $formattedData[$item->hari] = $item->pengajaran->mapel ? $item->pengajaran->mapel->namaMapel : '-';
            //         $formattedData['waktu'] = $jamMulai . ' - ' . $jamSelesai;
            //     }

            //     return $formattedData;
            // });

            // return DataTables::of($data)->toJson();
            $periode = $request->input('periode');
            $kelas = $request->input('kelas_id');

            $data = Jadwal::when(!empty($kelas), function ($query) use ($kelas) {
                $query->whereHas('kelas', function ($subQuery) use ($kelas) {
                    $subQuery->where('namaKelas', $kelas);
                });
            })
                ->when(!empty($periode), function ($query) use ($periode) {
                    $query->where('idPeriode', $periode);
                })
                ->get();

            $data = $data->map(function ($item, $key) {
                $jamMulai = Carbon::parse($item->jamMulai);
                $jamSelesai = Carbon::parse($item->jamSelesai);
                $perbedaanMenit = $jamMulai->diffInMinutes($jamSelesai);
                // $item['nomor'] = $key + 1;
                $item['hari'] = $item->hari ? $item->hari : '-';
                $item['kelasMapel'] = $item->kelas ? 'Kelas ' . $item->kelas->namaKelas : '-';
                $item['mapel'] = $item->pengajaran->mapel ? $item->pengajaran->mapel->namaMapel : '-';
                $item['guru'] = $item->pengajaran->guru ? $item->pengajaran->guru->namaPegawai : '-';
                $item['waktu'] = $perbedaanMenit . ' Menit' ?: '-';
                return $item;
            });

            return DataTables::of($data)->toJson();
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
            // Handle the exception here
        }
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
                'idKelas' => 'required',
                'idPeriode' => 'required',
                'hari' => 'required',
                'jamMulai' => 'required', // Assuming you want a time format
                'jamSelesai' => 'required', // Assuming you want a time format
            ]);

            Jadwal::create($validatedData);

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil menyimpan data.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error get data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $jadwal = Jadwal::find($id);

        return response()->json(['jadwal' => $jadwal]);
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::find($id);

        $validatedData = $request->validate([
            'idPengajaran' => 'required',
            'idKelas' => 'required',
            'idPeriode' => 'required',
            'hari' => 'required',
            'jamMulai' => 'required', // Assuming you want a time format
            'jamSelesai' => 'required', // Assuming you want a time format
        ]);

        $jadwal->update($validatedData);


        return response()->json([
            'status' => 'success',
            'title' => 'Sukses',
            'message' => 'Berhasil mengubah data.'
        ]);
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil mengapus data.'
        ]);
    }

    // Siswa
    public function getJadwalSiswa(Request $request)
    {
        try {
            $periode = $request->input('idPeriode');
            $kelas = $request->input('kelas');

            $query = Jadwal::with('pengajaran.mapel')
                ->when(!empty($kelas), function ($query) use ($kelas) {
                    $query->whereHas('kelas', function ($subQuery) use ($kelas) {
                        $subQuery->where('namaKelas', $kelas);
                    });
                })
                ->when(!empty($periode), function ($query) use ($periode) {
                    $query->where('idPeriode', $periode);
                });

            $data = $query->get();

            $data = $data->groupBy(function ($jadwal) {
                return $jadwal->jamMulai . '-' . $jadwal->jamSelesai;
            })->map(function ($groupedData) {
                $formattedData = [
                    'nomor' => $groupedData->keys()->first() + 1,
                    'Senin' => '-',
                    'Selasa' => '-',
                    'Rabu' => '-',
                    'Kamis' => '-',
                    'Jumat' => '-',
                    'Sabtu' => '-',
                    'waktu' => '',
                    'idJadwal' => $groupedData->first()->idJadwal,
                    'idPeriode' => $groupedData->first()->idPeriode,
                    'idKelas' => $groupedData->first()->idKelas,
                ];

                foreach ($groupedData as $item) {
                    $jamMulai = date('H:i', strtotime($item->jamMulai));
                    $jamSelesai = date('H:i', strtotime($item->jamSelesai));
                    $formattedData[$item->hari] = $item->pengajaran->mapel ? $item->pengajaran->mapel->namaMapel : '-';
                    $formattedData['waktu'] = $jamMulai . ' - ' . $jamSelesai;
                }

                return $formattedData;
            });

            return DataTables::of($data)->toJson();
            // $periode = $request->input('idPeriode');
            // $kelas = $request->input('kelas');

            // $data = Jadwal::when(!empty($kelas), function ($query) use ($kelas) {
            //     $query->whereHas('kelas', function ($subQuery) use ($kelas) {
            //         $subQuery->where('namaKelas', $kelas);
            //     });
            // })
            //     ->when(!empty($periode), function ($query) use ($periode) {
            //         $query->where('idPeriode', $periode);
            //     })
            //     ->get();

            // $data = $data->map(function ($item, $key) {
            //     $jamMulai = date('H:i', strtotime($item->jamMulai));
            //     $jamSelesai = date('H:i', strtotime($item->jamSelesai));
            //     $item['Senin'] = $item->hari === 'Senin' ? ($item->pengajaran->mapel ? $item->pengajaran->mapel->namaMapel : '-') : '-';
            //     $item['Selasa'] = $item->hari === 'Selasa' ? ($item->pengajaran->mapel ? $item->pengajaran->mapel->namaMapel : '-') : '-';
            //     $item['Rabu'] = $item->hari === 'Rabu' ? ($item->pengajaran->mapel ? $item->pengajaran->mapel->namaMapel : '-') : '-';
            //     $item['Kamis'] = $item->hari === 'Kamis' ? ($item->pengajaran->mapel ? $item->pengajaran->mapel->namaMapel : '-') : '-';
            //     $item['Jumat'] = $item->hari === 'Jumat' ? ($item->pengajaran->mapel ? $item->pengajaran->mapel->namaMapel : '-') : '-';
            //     $item['Sabtu'] = $item->hari === 'Sabtu' ? ($item->pengajaran->mapel ? $item->pengajaran->mapel->namaMapel : '-') : '-';
            //     $item['waktu'] = $jamMulai . ' - ' . $jamSelesai ?: '-';
            //     return $item;
            // });


            // return DataTables::of($data)->toJson();
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
            // Handle the exception here
        }
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
