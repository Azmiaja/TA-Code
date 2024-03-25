<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataSiswaController extends Controller
{
    public function index()
    {
        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->get();
        return view('siakad.content.m_sekolah.akademik.kelas.data_siswa', compact('periode'), [
            'judul' => 'Data Master',
            'sub_judul' => 'Akademik',
            'sub_sub_judul' => 'Data Siswa Kelas',
            'text_singkat' => 'Mengelola data siswa kelas sekolah!',
        ]);
    }

    public function getSiswa(Request $request)
    {
        try {
            $siswaWithKelas = Siswa::where(function ($query) use ($request) {
                $kelasNama = $request->input('kelas_nama');
                $periodeSiswa = $request->input('periode_siswa');

                if (!empty($kelasNama)) {
                    $query->whereHas('kelas', function ($subQuery) use ($kelasNama) {
                        $subQuery->where('namaKelas', $kelasNama);
                    });
                } else {
                    // Menampilkan siswa yang tidak memiliki kelas
                    $query->doesntHave('kelas');
                }

                // Pengecekan untuk request periode_siswa
                if (!empty($periodeSiswa)) {
                    $query->whereHas('kelas.periode', function ($subQuery) use ($periodeSiswa) {
                        $subQuery->where('idPeriode', $periodeSiswa);
                    });
                }
            })
                ->with('kelas.periode')
                ->get();

            $data = $siswaWithKelas->map(function ($siswa, $key) {
                $kelas = $siswa->kelas->isEmpty() ? null : $siswa->kelas->first();
                $namaKelas = $kelas ? $kelas->namaKelas : '-';
                $faseKelas = $kelas ? $kelas->fase : '-';
                $semester = $kelas && $kelas->periode ? 'Semester ' . $kelas->periode->semester . '/' . date('Y', strtotime($kelas->periode->tanggalMulai)) : '-';

                return [
                    'nomor' => $key + 1,
                    'kelas' => 'Kelas ' . $namaKelas,
                    'fase' => $faseKelas,
                    'namaSiswa' => $siswa->namaSiswa,
                    'nis' => $siswa->nis,
                    'semester' => $semester,
                    'idSiswa' => $siswa->idSiswa,
                ];
            });

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
            // Handle the exception here
        }
    }

    public function getSiswaOption()
    {
        // $kelasNama = $id;

        $siswaWithoutKelas = Siswa::whereDoesntHave('kelas')->get();

        return response()->json(['siswa' => $siswaWithoutKelas]);
    }






    public function storeSiswa(Request $request)
    {
        try {
            $idSiswa = $request->input('idSiswa');
            $idKelas = $request->input('idKelas');
            $idPeriode = $request->input('pilih_periode');

            foreach ($idSiswa as $data) {
                $siswa = Siswa::findOrFail($data);

                // Periksa apakah siswa sudah terdaftar dalam kelas dan periode yang diinputkan
                if ($siswa->kelas()->where('kelas.idKelas', $idKelas)
                    ->whereHas('periode', function ($query) use ($idPeriode) {
                        $query->where('periode.idPeriode', $idPeriode);
                    })->exists()
                ) {
                    return response()->json([
                        'status' => 'error',
                        'title' => 'Gagal',
                        'message' => 'Siswa ' . $siswa->namaSiswa . ' sudah terdaftar dalam kelas dan periode yang diinputkan.'
                    ]);
                }

                $kelas = Kelas::findOrFail($idKelas);

                $siswa->kelas()->attach($kelas);
            }

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil menyimpan data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ]);
        }
    }

    public function editSiswa($id)
    {
        $data = Siswa::with('kelas.guru')->find($id);

        return response()->json($data);
    }

    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $kelasIds = $request->input('idKelas'); // ID kelas yang dipilih dari form
        $siswa->kelas()->sync($kelasIds);

        return response()->json([
            'status' => 'success',
            'title' => 'Sukses',
            'message' => 'Berhasil mengubah data.'
        ]);
    }


    public function destroySiswa($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus kelas siswa dengan detach
        $siswa->kelas()->detach();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
