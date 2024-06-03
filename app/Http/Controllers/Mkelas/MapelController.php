<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakulikuler;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MapelController extends Controller
{
    public function index()
    {
        return view('siakad.content.m_sekolah.akademik.mapel.index', [
            'judul' => 'Data Master',
            'sub_judul' => 'Akademik',
            'sub_sub_judul' => 'Mata Pelajaran',
            'text_singkat' => 'Mengelola data mata pelajaran akademik sekolah!',
        ]);
    }
    public function index_admin()
    {
        return view('mkelas.mapel', [
            'title' => 'Manajemen Kelas',
            'title2' => 'Mata Pelajaran'
        ]);
    }

    public function getMapel()
    {
        $mapel = Mapel::orderBy('idMapel', 'asc')->get()
            ->map(function ($item, $key) {
                $item['nomor'] = $key + 1;
                $item['mapel'] = $item->namaMapel ?: '-';
                $item['kkm'] = $item->kkm ?: '-';
                $item['deskripsi'] = $item->deskripsiMapel ?: '-';
                $item['sngkatan'] = $item->singkatan ?: '-';

                return $item;
            });

        return response()->json(['data' => $mapel]);
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
        $validator = Validator::make($request->all(), [
            'namaMapel' => 'required|max:45',
            'deskripsiMapel' => 'nullable|max:255',
            'singkatan' => 'nullable|max:10',
            'kkm' => 'required|max:6',
            'kategori' => 'required'
        ], [
            'namaMapel.required' => 'Nama mata pelajaran tidak boleh kosong!',
            'namaMapel.max' => 'Nama mata pelajaran tidak boleh lebih dari 45 karakter!',
            'deskripsiMapel.max' => 'Deskripsi mata pelajaran tidak boleh lebih dari 255 karakter!',
            'singkatan.max' => 'Singkatan mata pelajaran tidak boleh lebih dari 10 karakter!',
            'kkm.required' => 'KKM tidak boleh kosong!',
            'kkm.numeric' => 'KKM harus berupa angka!',
            'kkm.max' => 'KKM tidak boleh lebih dari 6 angka!',
            'kategori.required' => 'Kategori tidak boleh kosong!'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        } else {

            Mapel::create($request->all());

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil menyimpan data.'
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $mapel = Mapel::find($id);
        if (!$mapel) {
            return response()->json(['status' => 'error', 'title' => 'Gagal', 'message' => 'Data mapel tidak ditemukan.']);
        }

        return response()->json(['data' => $mapel]);
    }

    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'namaMapel' => 'required|max:45',
            'deskripsiMapel' => 'nullable|max:255',
            'singkatan' => 'nullable|max:10',
            'kkm' => 'required|max:6',
            'kategori' => 'required'
        ], [
            'namaMapel.required' => 'Nama mata pelajaran tidak boleh kosong!',
            'namaMapel.max' => 'Nama mata pelajaran tidak boleh lebih dari 45 karakter!',
            'deskripsiMapel.max' => 'Deskripsi mata pelajaran tidak boleh lebih dari 255 karakter!',
            'singkatan.max' => 'Singkatan mata pelajaran tidak boleh lebih dari 10 karakter!',
            'kkm.required' => 'KKM tidak boleh kosong!',
            'kkm.numeric' => 'KKM harus berupa angka!',
            'kkm.max' => 'KKM tidak boleh lebih dari 6 angka!',
            'kategori.required' => 'Kategori tidak boleh kosong!'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        } else {
            // Perbarui data mapel
            $mapel->update($request->all());

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil mengubah data.'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $mapel = Mapel::find($id);
            $mapel->delete();

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

    public function indexEkstra()
    {
        return view('siakad.content.m_sekolah.akademik.ekstra.index', [
            'judul' => 'Data Master',
            'sub_judul' => 'Akademik',
            'sub_sub_judul' => 'Ekstrakulikuler',
            'text_singkat' => 'Mengelola data ekstrakulikuler akademik sekolah!',
        ]);
    }

    public function getEkstra()
    {
        $ekstra = Ekstrakulikuler::orderBy('idEks', 'asc')->get()
            ->map(function ($item, $key) {
                $item['nomor'] = $key + 1;
                $item['ekstra'] = $item->ekstra ?: '-';
                $item['status'] = $item->status ?: '-';

                return $item;
            });

        return response()->json(['data' => $ekstra]);
    }

    public function storeEkstra(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'ekstra' => 'required|max:65',
                'status' => 'required'
            ], [
                'ekstra.required' => 'Nama ekstrakulikuler tidak boleh kosong!',
                'status.required' => 'Presikat tidak boleh kosong!',
                'ekstra.max' => 'Nama ekstrakulikuler tidak boleh lebih dari 60 karakter'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {

                Ekstrakulikuler::create([
                    'ekstra' => $request->ekstra,
                    'status' => $request->status
                ]);

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Data presensi berhasil diperbarui.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error updating data: ' . $e->getMessage());
        }
    }
    public function updateEkstra($id, Request $request)
    {
        try {
            $ekstra = Ekstrakulikuler::find($id);

            if ($ekstra) {
                $validator = Validator::make($request->all(), [
                    'ekstra' => 'required|max:65',
                    'status' => 'required'
                ], [
                    'ekstra.required' => 'Nama ekstrakulikuler tidak boleh kosong!',
                    'status.required' => 'Presikat tidak boleh kosong!',
                    'ekstra.max' => 'Nama ekstrakulikuler tidak boleh lebih dari 60 karakter'
                ]);

                if ($validator->fails()) {
                    return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
                } else {

                    $ekstra->update([
                        'ekstra' => $request->ekstra,
                        'status' => $request->status
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'title' => 'Sukses',
                        'message' => 'Data presensi berhasil diperbarui.'
                    ]);
                }
            } else {
                return response()->json(['status' => 'error', 'title' => 'Gagal', 'message' => 'Data ekstrakulikuler tidak ditemukan.']);
            }
        } catch (\Exception $e) {
            Log::error('Error updating data: ' . $e->getMessage());
        }
    }

    public function editEkstra($id)
    {
        $ekstra = Ekstrakulikuler::find($id);
        if (!$ekstra) {
            return response()->json(['status' => 'error', 'title' => 'Gagal', 'message' => 'Data ekstrakulikuler tidak ditemukan.']);
        }

        return response()->json(['data' => $ekstra]);
    }

    public function destroyEkstra($id)
    {
        $ekstra = Ekstrakulikuler::find($id);

        // Pengecekan apakah ekstra digunakan dalam tabel kelas
        if ($ekstra->kegiatan()->exists()) {
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Ekstrakulikuler digunakan dalam raport. Gagal dihapus.'
            ]);
        } else {
            $ekstra->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Dihapus!',
                'message' => 'Berhasil menghapus data.'
            ]);
        }
    }
}
