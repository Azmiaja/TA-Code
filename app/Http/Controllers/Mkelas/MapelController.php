<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

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
        $mapel = Mapel::orderBy('idMapel', 'desc')->get()
            ->map(function ($item, $key) {
                $item['nomor'] = $key + 1;
                $item['mapel'] = $item->namaMapel ?: '-';
                $item['kkm'] = $item->kkm ?: '-';
                $item['deskripsi'] = $item->deskripsiMapel ?: '-';

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
        $validatedData = $request->validate([
            'namaMapel' => 'required',
            'deskripsiMapel' => 'nullable',
            'kkm' => 'required',
        ]);

        Mapel::create($validatedData);

        return response()->json([
            'status' => 'success',
            'title' => 'Sukses',
            'message' => 'Berhasil menyimpan data.'
        ]);
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
        $mapel = Mapel::find($id);
        if (!$mapel) {
            return response()->json(['status' => 'error', 'title' => 'Gagal', 'message' => 'Data mapel tidak ditemukan.']);
        }
        // Validasi input
        $validatedData = $request->validate([
            'namaMapel' => 'required',
            'deskripsiMapel' => 'nullable',
            'kkm' => 'required',
        ]);

        // Perbarui data mapel
        $mapel->update($validatedData);

        return response()->json([
            'status' => 'success',
            'title' => 'Sukses',
            'message' => 'Berhasil mengubah data.'
        ]);
    }

    public function destroy($id)
    {
        $mapel = Mapel::find($id);
        $mapel->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil mengapus data.'
        ]);
    }
}
