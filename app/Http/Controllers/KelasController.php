<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\Tr_kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class KelasController extends Controller
{
    public function index()
    {
        $periode = Periode::orderBy('tanggalMulai', 'desc')->get();
        return view('siakad.content.m_sekolah.akademik.kelas.index', compact('periode'), [
            'judul' => 'Data Master',
            'sub_judul' => 'Akademik',
            'sub_sub_judul' => 'Kelas',
            'text_singkat' => 'Mengelola kelas sekolah!',
        ]);
    }

    // Tabel Wali Kelas
    public function getGuru(Request $request)
    {
        try {
            $kelas = Kelas::orderBy('namaKelas', 'asc');

            // Filter berdasarkan periode_guru jika ada
            $periodeGuru = $request->input('periode_guru');
            if (!empty($periodeGuru)) {
                $kelas->where('idPeriode', $periodeGuru);
            } else {
                $kelas->whereNull('idPeriode');
            }

            $kelas = $kelas->get();

            $kelas = $kelas->map(function ($item, $key) {
                $item['nomor'] = $key + 1;
                $item['kelas'] = $item->namaKelas ? 'Kelas ' . $item->namaKelas : '-';
                $item['fase'] = $item->fase;
                $item['namaGuru'] = $item->guru->namaPegawai ?? '-';
                $item['nip'] = $item->guru->nip ?? '-';
                $item['semester'] = $item->periode ?  $item->periode->semester . ' ' . $item->periode->tahun : '-';
                return $item;
            });

            return response()->json(['data' => $kelas]);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
        }
    }

    public function getOptions()
    {
        $data = Periode::orderBy('tanggalMulai', 'desc')->get();

        return response()->json($data);
    }

    public function getKelas(Request $request)
    {
        $periode = $request->input('periode');
        $kelas = Kelas::orderBy('namaKelas', 'asc');
        if ($periode) {
            $kelas->where('idPeriode', $periode);
        }
        $kelas = $kelas->get()->map(function ($kelas) {
            $kelas->periode->semester ? 'Semester ' . $kelas->periode->semester . '/' . date('Y', strtotime($kelas->periode->tanggalMulai)) : '-';
            $kelas->guru->namaPegawai = $kelas->guru->namaPegawai ?? '-';
            return $kelas;
        });

        $siswa = Siswa::orderBy('idSiswa', 'desc')->get();

        return response()->json(['siswa' => $siswa, 'kelas' => $kelas]);
    }

    public function create()
    {
        //
    }

    //store Kelas
    public function store(Request $request)
    {
        try {
            // Periksa apakah kelas sudah ada
            $existingKelas = Kelas::where('idPeriode', $request->input('idPeriode'))
                ->where('namaKelas', $request->input('namaKelas'))
                ->exists();

            if ($existingKelas) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Kelas sudah ada.'
                ]);
            }

            // Buat instance baru dari model Kelas
            $kelas = new Kelas([
                'idPeriode' => $request->input('idPeriode'),
                'namaKelas' => $request->input('namaKelas'),
                'idPegawai' => $request->input('idPegawai')
            ]);

            // Tentukan nilai kolom fase
            $namaKelas = $request->input('namaKelas');
            if ($namaKelas == '1' || $namaKelas == '2') {
                $kelas->fase = 'A';
            } elseif ($namaKelas == '3' || $namaKelas == '4') {
                $kelas->fase = 'B';
            } elseif ($namaKelas == '5' || $namaKelas == '6') {
                $kelas->fase = 'C';
            }

            // Simpan data ke dalam database
            $kelas->save();

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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $kelas = Kelas::with('guru')->find($id);

        return response()->json(['kelas' => $kelas]);
    }

    public function getGuruOption($idPeriode)
    {
        // $periode = $request->input('periode');
        $guru = Pegawai::where('status', 'Aktif')->whereDoesntHave('kelas', function ($query) use ($idPeriode) {
            $query->where('idPeriode', $idPeriode);
        })->whereNotIn('idPegawai', function ($query) {
            $query->select('idPegawai')
                ->from('user')
                ->where('hakAkses', 'Super Admin');
        })->get();

        return response()->json($guru);
    }

    public function getExistingClasses($idPeriode)
    {
        try {
            $usedClasses = Kelas::where('idPeriode', $idPeriode)->pluck('namaKelas')->toArray();

            return response()->json($usedClasses);
        } catch (\Exception $e) {
            Log::error('Error updating data: ' . $e->getMessage());
        }
    }

    // Fungsi Update data Wali Kelas
    public function update(Request $request, $id)
    {
        try {
            $kelas = Kelas::find($id);

            // // Periksa apakah kelas sudah ada
            // if ($kelas->idPeriode == $request->input('idPeriode') && $kelas->namaKelas == $request->input('namaKelas')) {
            //     $existingKelas = false;
            // } else {
            //     $existingKelas = Kelas::where('idPeriode', $request->input('idPeriode'))
            //         ->where('namaKelas', $request->input('namaKelas'))
            //         ->exists();
            // }

            // if ($existingKelas) {
            //     return response()->json([
            //         'status' => 'error',
            //         'title' => 'Gagal',
            //         'message' => 'Kelas sudah ada.'
            //     ]);
            // }
            if ($request->input('idPeriode')) {
                $kelas->idPeriode = $request->input('idPeriode');
            }
            $kelas->namaKelas = $request->input('namaKelas');
            $kelas->idPegawai = $request->input('idPegawai');

            $namaKelas = $request->input('namaKelas');
            if ($namaKelas == '1' || $namaKelas == '2') {
                $kelas->fase = 'A';
            } elseif ($namaKelas == '3' || $namaKelas == '4') {
                $kelas->fase = 'B';
            } elseif ($namaKelas == '5' || $namaKelas == '6') {
                $kelas->fase = 'C';
            }

            // Perbarui data kelas
            $kelas->save();

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil mengubah data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating data: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ]);
        }
    }

    public function destroy($id)
    {
        $kelas = Kelas::find($id);
        $kelas->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
