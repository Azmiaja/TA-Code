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
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class KelasController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        $guru = Pegawai::where('jenisPegawai', 'Guru')->get();
        $kelas = Kelas::orderBy('idKelas', 'desc')->get();
        $periode = Periode::orderBy('tanggalMulai', 'desc')->get();
        $siswa = Siswa::whereDoesntHave('kelas')->orderBy('idSiswa', 'desc')->get();
        return view('siakad.content.m_sekolah.akademik.kelas.index', compact('periode', 'kelas', 'pegawai', 'guru', 'siswa'), [
            'judul' => 'Data Master',
            'sub_judul' => 'Akademik',
            'sub_sub_judul' => 'Kelas',
            'text_singkat' => 'Mengelola kelas untuk guru dan siswa sekolah!',
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
            }

            $kelas = $kelas->get();

            $kelas = $kelas->map(function ($item, $key) {
                $item['nomor'] = $key + 1;
                $item['kelas'] = $item->namaKelas ? 'Kelas ' . $item->namaKelas : '-';
                $item['fase'] = $item->fase;
                $item['namaGuru'] = $item->guru->namaPegawai ?? '-';
                $item['nip'] = $item->guru->nip ?? '-';
                $item['semester'] = $item->periode ? 'Semester ' . $item->periode->semester . '/' . date('Y', strtotime($item->periode->tanggalMulai)) : '-';
                return $item;
            });

            return response()->json(['data' => $kelas]);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
        }
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

    // store Periode
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
                        'message' => 'Siswa sudah terdaftar dalam kelas dan periode yang diinputkan.'
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
        $kelas = Kelas::find($id);

        return response()->json(['kelas' => $kelas]);
    }

    public function editSiswa($id)
    {
        $data = Siswa::with('kelas:idKelas,namaKelas,idPeriode')->select('idSiswa', 'namaSiswa')->find($id);

        return response()->json($data);
    }

    // Fungsi Update data Wali Kelas
    public function update(Request $request, $id)
    {
        try {
            $kelas = Kelas::find($id);

            // Periksa apakah kelas sudah ada
            if ($kelas->idPeriode == $request->input('idPeriode') && $kelas->namaKelas == $request->input('namaKelas')) {
                $existingKelas = false;
            } else {
                $existingKelas = Kelas::where('idPeriode', $request->input('idPeriode'))
                    ->where('namaKelas', $request->input('namaKelas'))
                    ->exists();
            }

            if ($existingKelas) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Kelas sudah ada.'
                ]);
            }

            $kelas->idPeriode = $request->input('idPeriode');
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
