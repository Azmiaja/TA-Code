<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        return view('mkelas.mapel', [
            'title' => 'Manajemen Kelas',
            'title2' => 'Mata Pelajaran'
        ]);
    }

    public function getMapel()
    {
        $mapel = Mapel::orderBy('idMapel', 'desc')->get();

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
            'deskripsiMapel' => '',
        ]);

        Mapel::create($validatedData);

        return response()->json([
            'status' => 'success',
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
            return response()->json(['status' => 'error', 'message' => 'Data mapel tidak ditemukan.']);
        }

        return response()->json(['data' => $mapel]);
    }

    public function update(Request $request, $id)
    {
        $mapel = Mapel::find($id);
        if (!$mapel) {
            return response()->json(['status' => 'error', 'message' => 'Data mapel tidak ditemukan.']);
        }
        // Validasi input
        $validatedData = $request->validate([
            'namaMapel' => 'required',
            'deskripsiMapel' => '',
        ]);

        // Perbarui data mapel
        $mapel->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah data.'
        ]);
    }

    public function destroy($id)
    {
        $mapel = Mapel::find($id);
        $mapel->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengapus data.'
        ]);
    }
}
