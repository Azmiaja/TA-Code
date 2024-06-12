<?php

namespace App\Http\Controllers\Muser;

use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        return view('siakad.content.m_sekolah.siswa.index', compact('siswa'), [
            'judul' => 'Data Master',
            'sub_judul' => 'Siawa',
            'text_singkat' => 'Mengelola data siswa!',
        ]);
    }

    public function getData()
    {
        $data = Siswa::orderBy('nis', 'asc')->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            $item['nama'] = $item->namaSiswa;
            $item['ttl'] = $item->tempatLahir || $item->tanggalLahir ? $item->tempatLahir . ', ' . Carbon::createFromFormat('Y-m-d', $item->tanggalLahir)->format('d-m-Y') : '-';
            $item['status'] = $item->status === 'Aktif' ? '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">' . $item->status . '</span>' : '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">' . $item->status . '</span>';
            $item['angkatan'] = $item->tahunMasuk ? $item->tahunMasuk : '-';
            $item['jenisKelamin'] = $item->jenisKelamin === 'Laki-Laki' ? 'L' : 'P';
            return $item;
        });
        return response()->json(['data' => $data]);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nisn' => [
                    'integer',
                    'digits:10',
                    'unique:siswa,nisn'
                ],
                'nis' => 'integer|unique:siswa,nis|digits:4',
                'namaSiswa' => 'max:45',
                'panggilan' => 'max:20',
                'alamat' => 'max:125',
                'namaAyah' => 'max:45',
                'namaIbu' => 'max:45',
                'namaWali' => 'max:45',
                'alamatAyah' => 'max:125',
                'alamatIbu' => 'max:125',
                'alamatWali' => 'max:125',
                'pekerjaanAyah' => 'max:45',
                'pekerjaanIbu' => 'max:45',
                'pekerjaanWali' => 'max:45',
                'noTlpAyah' => 'max:15',
                'noTlpIbu' => 'max:15',
                'noTlpWali' => 'max:15',
            ], [
                'nisn.integer' => 'NISN harus berupa angka.',
                'nis.integer' => 'NIS harus berupa angka.',
                'nisn.unique' => 'NISN sudah terdaftar.',
                'nis.unique' => 'NIS sudah terdaftar.',
                'nisn.digits' => 'Panjang NISN harus 10 digit.',
                'nis.digits' => 'Panjang NIS harus 4 digit.',
                'namaSiswa.max' => 'Panjang nama lengkap maksimal 45 karakter.',
                'namaAyah.max' => 'Panjang nama ayah maksimal 45 karakter.',
                'namaIbu.max' => 'Panjang nama ibu maksimal 45 karakter.',
                'namaWali.max' => 'Panjang nama wali maksimal 45 karakter.',
                'panggilan.max' => 'Panjang nama panggilan maksimal 20 karakter.',
                'alamat.max' => 'Alamat terlalu panjang maksimal 125 karakter.',
                'alamatAyah.max' => 'Alamat ayah terlalu panjang maksimal 125 karakter.',
                'alamatIbu.max' => 'Alamat ibu terlalu panjang maksimal 125 karakter.',
                'alamatWali.max' => 'Alamat wali terlalu panjang maksimal 125 karakter.',
                'noTlpAyah.max' => 'Nomor telepon ayah maksimal 15',
                'noTlpIbu.max' => 'Nomor telepon ibu maksimal 15',
                'noTlpWali.max' => 'Nomor telepon wali maksimal 15',
                'pekerjaanAyah' => 'Pekerjaan ayah terlalu pajang maksimal 45 karakter.',
                'pekerjaanIbu' => 'Pekerjaan ibu terlalu pajang maksimal 45 karakter.',
                'pekerjaanWali' => 'Pekerjaan wali terlalu pajang maksimal 45 karakter.',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                Siswa::create([
                    'nisn' => $request->nisn,
                    'nis' => $request->nis,
                    'namaSiswa' => $request->namaSiswa,
                    'panggilan' => $request->namaPanggilan,
                    'tempatLahir' => $request->tempatLahir,
                    'tanggalLahir' => Carbon::createFromFormat('d/m/Y', $request->tanggalLahir)->format('Y-m-d'),
                    'jenisKelamin' => $request->jenisKelamin,
                    'agama' => $request->agama,
                    'alamat' => $request->alamat,
                    'namaAyah' => $request->namaAyah,
                    'namaIbu' => $request->namaIbu,
                    'namaWali' => $request->namaWali,
                    'pekerjaanAyah' => $request->pekerjaanAyah,
                    'pekerjaanIbu' => $request->pekerjaanIbu,
                    'pekerjaanWali' => $request->pekerjaanWali,
                    'noTlpAyah' => $request->noTlpAyah,
                    'noTlpIbu' => $request->noTlpIbu,
                    'noTlpWali' => $request->noTlpWali,
                    'alamatAyah' => $request->alamatAyah,
                    'alamatIbu' => $request->alamatIbu,
                    'alamatWali' => $request->alamatWali,
                    'tahunMasuk' => $request->tahunMasuk
                ]);

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil menyimpan data.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) {
            // Handle jika berita tidak ditemukan
            return response()->json(['status' => 'error', 'title' => 'Gagal', 'message' => 'Data siswa tidak ditemukan.']);
        }

        return response()->json(['siswa' => $siswa]);
    }

    public function update(Request $request, $id)
    {
        try {
            $siswa = Siswa::find($id);

            $validator = Validator::make($request->all(), [
                'nisn' => [
                    'integer',
                    'digits:10',
                    'unique:siswa,nisn,' . $id . ',idSiswa'
                ],
                'nis' => [
                    'integer',
                    'digits:4',
                    'unique:siswa,nis,' . $id . ',idSiswa',
                ],
                'namaSiswa' => 'max:45',
                'panggilan' => 'max:20',
                'alamat' => 'max:125',
                'namaAyah' => 'max:45',
                'namaIbu' => 'max:45',
                'namaWali' => 'max:45',
                'alamatAyah' => 'max:125',
                'alamatIbu' => 'max:125',
                'alamatWali' => 'max:125',
                'pekerjaanAyah' => 'max:45',
                'pekerjaanIbu' => 'max:45',
                'pekerjaanWali' => 'max:45',
                'noTlpAyah' => 'max:15',
                'noTlpIbu' => 'max:15',
                'noTlpWali' => 'max:15',
            ], [
                'nisn.integer' => 'NISN harus berupa angka.',
                'nis.integer' => 'NIS harus berupa angka.',
                'nisn.unique' => 'NISN sudah terdaftar.',
                'nis.unique' => 'NIS sudah terdaftar.',
                'nisn.digits' => 'Panjang NISN harus 10 digit.',
                'nis.digits' => 'Panjang NIS harus 4 digit.',
                'namaSiswa.max' => 'Panjang nama lengkap maksimal 45 karakter.',
                'namaAyah.max' => 'Panjang nama ayah maksimal 45 karakter.',
                'namaIbu.max' => 'Panjang nama ibu maksimal 45 karakter.',
                'namaWali.max' => 'Panjang nama wali maksimal 45 karakter.',
                'panggilan.max' => 'Panjang nama panggilan maksimal 20 karakter.',
                'alamat.max' => 'Alamat terlalu panjang maksimal 125 karakter.',
                'alamatAyah.max' => 'Alamat ayah terlalu panjang maksimal 125 karakter.',
                'alamatIbu.max' => 'Alamat ibu terlalu panjang maksimal 125 karakter.',
                'alamatWali.max' => 'Alamat wali terlalu panjang maksimal 125 karakter.',
                'noTlpAyah.max' => 'Nomor telepon ayah maksimal 15',
                'noTlpIbu.max' => 'Nomor telepon ibu maksimal 15',
                'noTlpWali.max' => 'Nomor telepon wali maksimal 15',
                'pekerjaanAyah' => 'Pekerjaan ayah terlalu pajang maksimal 45 karakter.',
                'pekerjaanIbu' => 'Pekerjaan ibu terlalu pajang maksimal 45 karakter.',
                'pekerjaanWali' => 'Pekerjaan wali terlalu pajang maksimal 45 karakter.',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $siswa->update([
                    'nisn' => $request->nisn,
                    'nis' => $request->nis,
                    'namaSiswa' => $request->namaSiswa,
                    'panggilan' => $request->namaPanggilan,
                    'tempatLahir' => $request->tempatLahir,
                    'tanggalLahir' => Carbon::createFromFormat('d/m/Y', $request->tanggalLahir)->format('Y-m-d'),
                    'jenisKelamin' => $request->jenisKelamin,
                    'agama' => $request->agama,
                    'alamat' => $request->alamat,
                    'namaAyah' => $request->namaAyah,
                    'namaIbu' => $request->namaIbu,
                    'namaWali' => $request->namaWali,
                    'pekerjaanAyah' => $request->pekerjaanAyah,
                    'pekerjaanIbu' => $request->pekerjaanIbu,
                    'pekerjaanWali' => $request->pekerjaanWali,
                    'noTlpAyah' => $request->noTlpAyah,
                    'noTlpIbu' => $request->noTlpIbu,
                    'noTlpWali' => $request->noTlpWali,
                    'alamatAyah' => $request->alamatAyah,
                    'alamatIbu' => $request->alamatIbu,
                    'alamatWali' => $request->alamatWali,
                    'tahunMasuk' => $request->tahunMasuk,
                    'status' => $request->status
                ]);

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil mengubah data.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error update data: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $siswa = Siswa::find($id);
            $siswa->delete();

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

    public function dropAllSiswaData()
    {
        // Kosongkan tabel siswa
        Siswa::query()->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil mengapus semua data siswa.'
        ]);
    }

    public function importSiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        try {
            // Import data menggunakan class import yang telah Anda buat
            Excel::import(new SiswaImport, $file);

            return response()->json([
                'status' => 'success',
                'title' => 'Import Sukses',
                'message' => 'Berhasil mengimport data siswa.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title' => 'Import Gagal',
                'message' => 'Terjadi kesalahan saat import data.',
            ], 422);
        }
    }

    public function exportSiswa()
    {
        return Excel::download(new SiswaExport, 'Data Siswa.xlsx');
    }
}
