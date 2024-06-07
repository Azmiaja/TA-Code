<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\JamKe;
use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\Pengajaran;
use App\Models\Periode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PenjadwalanController extends Controller
{
    public function index()
    {
        $periode = Periode::orderBy('tanggalMulai', 'desc')->get();
        $jam = JamKe::all();
        return view('siakad.content.m_sekolah.akademik.jadwal.index', compact('periode', 'jam'), [
            'judul' => 'Data Master',
            'sub_judul' => 'Akademik',
            'sub_sub_judul' => 'Penjadwalan',
            'text_singkat' => 'Mengelola penjadwalan kelas untuk guru dan siswa sekolah!',
        ]);
    }

    public function index_siswa()
    {
        $periode = Periode::where('status', 'Aktif')
            ->orderBy('tanggalMulai', 'desc')
            ->first();
        $siswa = Auth::user()->siswa;
        $kelas = Kelas::where('idPeriode', $periode->idPeriode)
            ->whereHas('siswa', function ($query) use ($siswa) {
                $query->where('siswa.idSiswa',  $siswa->idSiswa);
            })
            ->first();
        return view('siakad.content.m_sekolah.akademik.jadwal.jadwal_siswa', compact('periode', 'kelas'), [
            'judul' => 'Jadwal Pelajaran',
            'sub_judul' => 'Jadwal Pelajaran',
            'text_singkat' => 'Informasi jadawal pelajaran siswa kelas ' . $kelas->namaKelas . '!',
        ]);
    }


    public function getJadwalGuru()
    {
        $periode = Periode::where('status', 'Aktif')
            ->orderBy('tanggalMulai', 'desc')
            ->first();
        $jadwal = Jadwal::where('idPeriode', $periode->idPeriode)
            ->with('pengajaran', 'jamke')
            ->get()
            ->groupBy('hari');
        $jamKe = JamKe::all();

        $kelas = Kelas::where('idPeriode', $periode->idPeriode)
            ->orderBy('namaKelas', 'asc')
            ->get();

        return response()->json([
            'jadwal' => $jadwal,
            'jam' => $jamKe,
            'kelas' => $kelas
        ]);
    }



    public function getJPkelas1(Request $request)
    {
        try {

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
                'idjamKe' => 'required',
            ]);

            // Tentukan kriteria pencarian berdasarkan data yang ingin Anda update
            $criteria = [
                'idjamKe' => $validatedData['idjamKe'],
                'hari' => $validatedData['hari'],
                'idKelas' => $validatedData['idKelas'],
                'idPeriode' => $validatedData['idPeriode'],
            ];

            // Data yang akan dimasukkan atau diperbarui
            $data = [
                'idPengajaran' => $validatedData['idPengajaran'],
                // Tambahkan field lain yang perlu dimasukkan atau diperbarui
            ];

            // Lakukan operasi create atau update
            Jadwal::updateOrCreate($criteria, $data);

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
            $periode = $request->idPeriode;
            $kelas = $request->kelas;

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
                return $jadwal->jamke->jamMulai . '-' . $jadwal->jamke->jamSelesai;
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
                    $jamMulai = date('H:i', strtotime($item->jamke->jamMulai));
                    $jamSelesai = date('H:i', strtotime($item->jamke->jamSelesai));

                    $mapel = $item->pengajaran->mapel;
                    $formattedData[$item->hari] = '<a href="javascript:void(0)" title="Info ' . ($mapel->singkatan ?? $mapel->namaMapel) . '" data-id-jadwal="' . $item->idJadwal . '" id="hapus_jadwal" class="link-warning">';
                    if (!empty($mapel->singkatan)) {
                        $formattedData[$item->hari] .= $mapel->singkatan;
                    } elseif (!empty($mapel->namaMapel)) {
                        $formattedData[$item->hari] .= $mapel->namaMapel;
                    } else {
                        $formattedData[$item->hari] .= '-';
                    }
                    $formattedData[$item->hari] .= '</a>';

                    $formattedData['Guru' . $item->hari] = $item->pengajaran->guru->namaPegawai . ' (' . ($item->pengajaran->mapel ? ($item->pengajaran->mapel->singkatan ? $item->pengajaran->mapel->singkatan : $item->pengajaran->mapel->namaMapel) : '-') . ')';
                    $formattedData['waktu'] = $jamMulai . ' - ' . $jamSelesai;
                }

                return $formattedData;
            })->values();

            // return DataTables::of($data)->toJson();
            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
            // Handle the exception here
        }
    }

    public function getHpJadwal(Request $request)
    {
        $idJadwal = $request->idJadwal;
        $idPeriode = $request->idPeriode;
        $namaKelas = $request->namaKelas;

        $jadwal = Jadwal::where('idJadwal', $idJadwal)
            ->where('idPeriode', $idPeriode)
            ->whereHas('kelas', function ($query) use ($namaKelas) {
                $query->where('namaKelas', $namaKelas);
            })
            ->with('periode', 'kelas', 'jamke', 'pengajaran.mapel', 'pengajaran.guru')
            ->first();

        return response()->json($jadwal);
    }

    // Guru

    public function getJadwalPGuru(Request $request)
    {

        try {
            $periode = $request->idPeriode;
            $kelas = $request->kelas;

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

            $data = $data->groupBy('hari')->map(function ($groupedData, $hari) {
                $groupedData = $groupedData->groupBy('pengajaran.guru.namaPegawai');

                $formattedData = [];

                foreach ($groupedData as $guru => $jadwals) {
                    $jadwalsData = [];

                    foreach ($jadwals as $item) {
                        $jamMulai = date('H:i', strtotime($item->jamke->jamMulai));
                        $jamSelesai = date('H:i', strtotime($item->jamke->jamSelesai));

                        $jadwalsData[] = [
                            'Mapel' => $item->pengajaran->mapel->singkatan ?? ($item->pengajaran->mapel->namaMapel ?? '-'),
                            'Pengajar' => $item->pengajaran->guru->namaPegawai,
                            'Waktu' => $jamMulai . ' - ' . $jamSelesai,
                            'JamKe' => $item->jamke->jamKe
                        ];
                    }

                    $formattedData[] = [
                        'Guru' => $guru,
                        'Jadwals' => $jadwalsData
                    ];
                }

                return [
                    $hari => $formattedData
                ];
            });

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
            // Handle the exception here
        }
    }

    public function getJamKe()
    {
        $data = JamKe::orderBy('jamKe', 'asc')->get();
        $data = $data->map(function ($item, $i) {
            $item['jamMulai'] = date('H:i', strtotime($item->jamMulai));
            $item['jamSelesai'] = date('H:i', strtotime($item->jamSelesai));

            return $item;
        });

        return response()->json($data);
    }

    public function showJamKe($id)
    {
        $data = JamKe::find($id);
        $data['jamMulai'] = date('H:i', strtotime($data->jamMulai));
        $data['jamSelesai'] = date('H:i', strtotime($data->jamSelesai));

        return response()->json($data);
    }

    public function storeJam(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jamKe' => 'max:2|unique:jamke,jamKe',
            ], [
                'jamKe.unique' => 'Jam Ke -' . $request->jamKe . ' sudah terdaftar.',
                'jamKe.max' => 'Panjang Jam Ke - maksimal 2 karakter.',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                JamKe::create([
                    'jamKe' => $request->jamKe,
                    'jamMulai' => $request->jamMulai,
                    'jamSelesai' => $request->jamSelesai,
                ]);

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil menyimpan data.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error store data: ' . $e->getMessage());
            // Handle the exception here
        }
    }

    public function updateJam(Request $request, $id)
    {
        try {
            $jam = JamKe::find($id);
            $validator = Validator::make($request->all(), [
                'jamKe' => 'max:2|unique:jamke,jamKe,' . $id . ',idjamKe',
            ], [
                'jamKe.unique' => 'Jam Ke -' . $request->jamKe . ' sudah terdaftar.',
                'jamKe.max' => 'Panjang Jam Ke - maksimal 2 karakter.',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $jam->update([
                    'jamKe' => $request->jamKe,
                    'jamMulai' => $request->jamMulai,
                    'jamSelesai' => $request->jamSelesai,
                ]);

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil mengubah data.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error update data: ' . $e->getMessage());
            // Handle the exception here
        }
    }

    public function deleteJam($id)
    {
        try {
            $jam = JamKe::find($id);
            $jam->delete();

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

    public function destroyJadwal($id)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
