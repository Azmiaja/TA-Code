<?php

namespace App\Http\Controllers\Mcompany;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profil = Profil::orderBy('idProfil', 'desc')->get();
        // $totalProfil = Profil::all()->count();
        return view('mcompany.profil', compact('profil'), [
            'title' => 'Manajemen Company',
            'title2' => 'Profil Sekolah',

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
        $validatedData = $request->validate([
            'namaSekolah' => 'required',
            // 'gambar' => 'file|mimes:jpeg,png,jpg,gif',
            'deskripsiProfil' => 'required',
            'deskripsiSejarah' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'tahun' => 'required',
            
        ]);

        // $validatedData['tahun'] = Carbon::createFromFormat('d-m-Y', $request->input('tahun', Carbon::now()));
        // if ($request->file('gambar')) {
        //     $gambarPath = $request->file('gambar')->getClientOriginalName();
        //     $validatedData['gambar'] = $request->file('gambar')->storeAs('gambar-profil', $gambarPath, 'public');
        // }
        Profil::create($validatedData);

        return back()
            ->with('success', 'Berhasil menyimpan profil.');
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
        $profil = Profil::find($id);
        if (!$profil) {
            // Handle jika profil tidak ditemukan
            return back()->with('error', 'Profil tidak ditemukan.');
        }

        return view(compact('profil'));
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
        $profil = Profil::find($id);

        if (!$profil) {
            // Handle jika profil tidak ditemukan
            return redirect()->route('data-profil.profil')->with('error', 'Profil tidak ditemukan.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'namaSekolah' => 'required',
            // 'gambar' => 'file|mimes:jpeg,png,jpg,gif',
            'deskripsiProfil' => 'required',
            'deskripsiSejarah' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'tahun' => 'required',
            
        ]);
        // $validatedData['tahun'] = Carbon::createFromFormat('Y', $request->input('tahun', Carbon::now()));
        // if ($request->file('gambar')) {
        //     $gambarPath = $request->file('gambar')->getClientOriginalName();
        //     $validatedData['gambar'] = $request->file('gambar')->storeAs('gambar-profil', $gambarPath, 'public');

        //     Storage::delete('public/' . $profil->gambar);
        // }

        // Perbarui data profil
        $profil->update($validatedData);

        return back()->with('success', 'Berhasil memperbarui profil.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profil = Profil::find($id);
        $profil->delete();
        // Storage::delete('public/' . $profil->dokumen);
        // Storage::delete('public/' . $profil->gambar);

        return back()->with('success', 'Berhasil menghapus profil.');
    }
}
