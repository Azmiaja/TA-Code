<?php

namespace App\Http\Controllers\Mcompany;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $berita = Berita::orderBy('tanggalBerita', 'desc')->get();
        $totalBerita = Berita::all()->count();
        return view('mcompany.berita', compact('berita', 'totalBerita'), [
            'title' => 'Manajemen Company',
            'title2' => 'Berita Sekolah',

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
            'judulBerita' => 'required',
            'gambar' => 'file|mimes:jpeg,png,jpg,gif',
            'isiBerita' => '',
            'tanggalBerita' => 'required|date',
            'sumberBerita' => '',
        ]);

        $validatedData['tanggalBerita'] = Carbon::createFromFormat('d-m-Y', $request->input('tanggalBerita', Carbon::now()));
        if ($request->file('gambar')) {
            $gambarPath = $request->file('gambar')->getClientOriginalName();
            $validatedData['gambar'] = $request->file('gambar')->storeAs('gambar-berita', $gambarPath, 'public');
        }
        Berita::create($validatedData);

        return back()
            ->with('success', 'Berhasil menyimpan 1 berita.');
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
        $berita = Berita::find($id);
        if (!$berita) {
            // Handle jika berita tidak ditemukan
            return back()->with('error', 'Berita tidak ditemukan.');
        }

        return view(compact('berita'));
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
        $berita = Berita::find($id);

        if (!$berita) {
            // Handle jika berita tidak ditemukan
            return redirect()->route('data-berita.berita')->with('error', 'Berita tidak ditemukan.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'judulBerita' => 'required',
            'gambar' => 'file|mimes:jpeg,png,jpg,gif',
            'isiBerita' => '',
            'tanggalBerita' => 'required|date',
            'sumberBerita' => '',
        ]);
        $validatedData['tanggalBerita'] = Carbon::createFromFormat('d-m-Y', $request->input('tanggalBerita', Carbon::now()));
        if ($request->file('gambar')) {
            $gambarPath = $request->file('gambar')->getClientOriginalName();
            $validatedData['gambar'] = $request->file('gambar')->storeAs('gambar-berita', $gambarPath, 'public');

            Storage::delete('public/' . $berita->gambar);
        }

        // Perbarui data berita
        $berita->update($validatedData);

        return back()->with('success', 'Berhasil memperbarui 1 berita.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $berita = Berita::find($id);
        $berita->delete();
        Storage::delete('public/' . $berita->dokumen);
        Storage::delete('public/' . $berita->gambar);

        return back()->with('success', 'Berhasil menghapus 1 berita.');
    }
}
