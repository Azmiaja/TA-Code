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
        $periode = Periode::orderBy('tanggalMulai', 'desc')->get();
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
            $kelasNama = $request->kelas_nama;
            $periodeSiswa = $request->periode_siswa;

            // Ambil siswa dengan kelas dan periode yang sesuai
            $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelasNama, $periodeSiswa) {
                $query->where('namaKelas', $kelasNama)
                    ->where('idPeriode', $periodeSiswa);
            })
                ->orderBy('namaSiswa', 'asc')
                ->get();

            // Map data siswa
            $data = $siswaWithKelas->map(function ($siswa, $key) use ($kelasNama) {
                // Ambil informasi kelas dari siswa
                $kelas = $siswa->kelas->where('namaKelas', $kelasNama)->first();
                $namaKelas = $kelas ? $kelas->namaKelas : '-';
                $faseKelas = $kelas ? $kelas->fase : '-';
                $semester = $kelas && $kelas->periode ? $kelas->periode->semester . ' ' . $kelas->periode->tahun : '-';

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

            // Return response JSON
            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
            // Handle the exception here
        }
    }

    public function getSiswaOption(Request $request)
    {
        // $kelasNama = $id;
        $periodeId = $request->input('idPeriode'); // Ganti dengan ID periode yang Anda inginkan

        $siswaWithoutKelas = Siswa::whereDoesntHave('kelas', function ($query) use ($periodeId) {
            $query->where('idPeriode', $periodeId);
        })->get();
        // $siswaWithoutKelas = Siswa::whereDoesntHave('kelas')->get();

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
        try {
            $siswa = Siswa::findOrFail($id);
            // Hapus kelas siswa dengan detach
            $siswa->kelas()->detach();

            return response()->json([
                'status' => 'success',
                'title' => 'Dihapus!',
                'message' => 'Berhasil menghapus data.'
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
