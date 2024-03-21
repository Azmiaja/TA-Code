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
        $data = Siswa::orderBy('idSiswa', 'desc')->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            $item['nama'] = $item->namaSiswa;
            $item['ttl'] = $item->tempatLahir && $item->tanggalLahir ? $item->tempatLahir . ', ' . Carbon::createFromFormat('Y-m-d', $item->tanggalLahir)->format('d-m-Y') : null;
            $item['status'] = $item->status === 'Aktif' ? '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">' . $item->status . '</span>' : '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">' . $item->status . '</span>';
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
        $siswa = new Siswa;

        $siswa->nisn = $request->input('nisn');
        $siswa->nis = $request->input('nis');
        $siswa->namaSiswa = $request->input('namaSiswa');
        $siswa->panggilan = $request->input('namaPanggilan');
        $siswa->tempatLahir = $request->input('tempatLahir');
        $siswa->tanggalLahir = $request->input('tanggalLahir');
        $siswa->jenisKelamin = $request->input('jenisKelamin');
        $siswa->agama = $request->input('agama');
        $siswa->status = $request->input('status');
        $siswa->alamat = $request->input('alamat');
        $siswa->namaAyah = $request->input('namaAyah');
        $siswa->pekerjaanAyah = $request->input('pekerjaanAyah');
        $siswa->noTlpAyah = $request->input('noTlpAyah');
        $siswa->alamatAyah = $request->input('alamatAyah');
        $siswa->namaIbu = $request->input('namaIbu');
        $siswa->pekerjaanIbu = $request->input('pekerjaanIbu');
        $siswa->noTlpIbu = $request->input('noTlpIbu');
        $siswa->alamatIbu = $request->input('alamatIbu');
        $siswa->namaWali = $request->input('namaWali');
        $siswa->pekerjaanWali = $request->input('pekerjaanWali');
        $siswa->noTlpWali = $request->input('noTlpWali');
        $siswa->alamatWali = $request->input('alamatWali');


        $siswa->save();

        return response()->json([
            'status' => 'success',
            'title' => 'Sukses',
            'message' => 'Berhasil menyimpan data.'
        ]);
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

            $siswa->nisn = $request->input('nisn');
            $siswa->nis = $request->input('nis');
            $siswa->namaSiswa = $request->input('namaSiswa');
            $siswa->panggilan = $request->input('namaPanggilan');
            $siswa->tempatLahir = $request->input('tempatLahir');
            $siswa->tanggalLahir = $request->input('tanggalLahir');
            $siswa->jenisKelamin = $request->input('jenisKelamin');
            $siswa->agama = $request->input('agama');
            $siswa->status = $request->input('status');
            $siswa->alamat = $request->input('alamat');
            $siswa->namaAyah = $request->input('namaAyah');
            $siswa->pekerjaanAyah = $request->input('pekerjaanAyah');
            $siswa->noTlpAyah = $request->input('noTlpAyah');
            $siswa->alamatAyah = $request->input('alamatAyah');
            $siswa->namaIbu = $request->input('namaIbu');
            $siswa->pekerjaanIbu = $request->input('pekerjaanIbu');
            $siswa->noTlpIbu = $request->input('noTlpIbu');
            $siswa->alamatIbu = $request->input('alamatIbu');
            $siswa->namaWali = $request->input('namaWali');
            $siswa->pekerjaanWali = $request->input('pekerjaanWali');
            $siswa->noTlpWali = $request->input('noTlpWali');
            $siswa->alamatWali = $request->input('alamatWali');

            $siswa->update();

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil mengubah data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Error storing data.'  . $e->getMessage(),
            ], 422);
        }
    }


    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $siswa->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Sukses',
            'message' => 'Berhasil mengapus data.'
        ]);
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
                'message' => 'Error storing data.'  . $e->getMessage(),
            ], 422);
        }
    }

    public function exportSiswa()
    {
        return Excel::download(new SiswaExport, 'data-siswa.xlsx');
    }
}
