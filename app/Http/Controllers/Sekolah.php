<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sekolah as ModelsSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Sekolah extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('siakad.content.m_sekolah.sekolah.index', [
            'judul' => 'Manajemen Sekolah',
            'sub_judul' => 'Sekolah',
            'text_singkat' => 'Mengelola data informasi sekolah!',
        ]);
    }

    public function getData()
    {
        $sekolah = ModelsSekolah::find(1); // Ganti dengan logic untuk mendapatkan profil yang sesuai

        return response()->json([
            'namaSekolah' => $sekolah->namaSekolah,
            'npsn' => $sekolah->npsn,
            'alamat' => $sekolah->alamat,
            'desa' => $sekolah->desa,
            'kec' => $sekolah->kecamatan,
            'kab' => $sekolah->kabupaten,
            'prov' => $sekolah->provinsi,
            'kd_pos' => $sekolah->kodePos,
            'telp' => $sekolah->telp,
            'web' => $sekolah->website,
            'email' => $sekolah->email,
            'slogan' => $sekolah->slogan,
            'logo' => $sekolah->logo ? (file_exists(public_path('storage/' . $sekolah->logo))
                ? asset('storage/' . $sekolah->logo)
                : asset('assets/media/img/tut-wuri.png'))
                : asset('assets/media/img/tut-wuri.png'),
            'mapsLink' => $sekolah->mapsLink,
            'mapsEmbed' => $sekolah->mapsEmbed,
            'idSekolah' => $sekolah->idSekolah,
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $sekolah = ModelsSekolah::find($id);

            if ($sekolah) {
                $oldLogoPath = $sekolah->logo; // Simpan path logo lama

                $sekolah->fill($request->except(['some_field_to_exclude']));

                if ($request->hasFile('logo')) {
                    $imgName = uniqid() . '.' . $request->file('logo')->getClientOriginalExtension();
                    $logoPath = $request->file('logo')->storeAs('logo-sekolah', $imgName, 'public');

                    // Pastikan file logo lama ada sebelum mencoba menghapus
                    if ($oldLogoPath && Storage::exists('public/' . $oldLogoPath)) {
                        Storage::delete('public/' . $oldLogoPath);
                    }

                    $sekolah->logo = $logoPath;
                }

                $sekolah->save();

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil menyimpan data.'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Sekolah tidak ditemukan.'
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Error storing data.'  . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
