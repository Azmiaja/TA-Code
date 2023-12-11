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
        $profil = Profil::orderBy('idProfil', 'desc')->take(1)->get();
        // $totalProfil = Profil::all()->count();
        return view('mcompany.profil', compact('profil'), [
            'title' => 'Company Profil',
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
            'slogan' => 'required',
            'gambarProfil' => 'required|file|mimes:jpg,jpeg,svg|max:2048',
            'gambarSejarah' => 'required|file|mimes:jpg,jpeg,svg|max:2048',
            'deskripsiProfil' => 'required',
            'deskripsiSejarah' => 'required',
            'visi' => 'required',
            'misi' => 'required',

        ]);

        // $validatedData['tahun'] = Carbon::createFromFormat('d-m-Y', $request->input('tahun', Carbon::now()));
        $gambarFields = ['gambarProfil', 'gambarSejarah'];

        foreach ($gambarFields as $field) {
            if ($request->hasFile($field)) {
                $gambarPath = $request->file($field)->getClientOriginalName();
                $validatedData[$field] = $request->file($field)->storeAs('gambar-profil', $gambarPath, 'public');
            }
        }

        Profil::create($validatedData);

        return back()
            ->with('success', 'Berhasil menyimpan 1 data.');
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

    //  fungsi update profil
    public function updateProfil(Request $request, $id)
    {
        $profil = Profil::find($id);

        $validatedData = $request->validate([
            'gambarProfil' => 'file|mimes:jpg,jpeg,svg|max:2048',
            'deskripsiProfil' => 'required',
            'timestampProfil' => 'required',

        ]);
        $validatedData = $request->only(['deskripsiProfil', 'timestampProfil']);
        if ($request->file('gambarProfil')) {
            $gambarPath = $request->file('gambarProfil')->getClientOriginalName();
            $validatedData['gambarProfil'] = $request->file('gambarProfil')->storeAs('gambar-profil', $gambarPath, 'public');

            Storage::delete('public/' . $profil->gambarProfil);
        }
        $profil->update($validatedData);

        return redirect()->route('profil.index')->with('success', 'Data profil berhasil diperbarui.');
    }

    // fungsi update sejarah
    public function updateSejarah(Request $request, $id)
    {
        $profil = Profil::find($id);

        $validatedData = $request->validate([
            'gambarSejarah' => 'file|mimes:jpg,jpeg,svg|max:2048',
            'deskripsiSejarah' => 'required',
            'timestampSejarah' => 'required',
        ]);

        $validatedData = $request->only(['deskripsiSejarah', 'timestampSejarah']);
        if ($request->hasFile('gambarSejarah')) {
            $gambarPath = $request->file('gambarSejarah')->getClientOriginalName();
            $validatedData['gambarSejarah'] = $request->file('gambarSejarah')->storeAs('gambar-profil', $gambarPath, 'public');

            Storage::delete('public/' . $profil->gambarSejarah);
        }
        $profil->update($validatedData);

        return redirect()->route('profil.index')->with('success', 'Data sejarah berhasil diperbarui.');
    }

    // fungsi update visi misi
    public function updateVisi(Request $request, $id)
    {
        $profil = Profil::find($id);

        $validatedData = $request->validate([
            'visi' => 'required',
            'timestampVisi' => 'required',

        ]);
        
        $profil->update($validatedData);

        return redirect()->route('profil.index')->with('success', 'Data Visi berhasil diperbarui.');
    }

    public function updateMisi(Request $request, $id)
    {
        $profil = Profil::find($id);

        $validatedData = $request->validate([
            'misi' => 'required',
            'timestampMisi' => 'required',

        ]);
        
        $profil->update($validatedData);

        return redirect()->route('profil.index')->with('success', 'Data Misi berhasil diperbarui.');
    }

    public function updateSlogan(Request $request, $id)
    {
        $profil = Profil::find($id);

        $validatedData = $request->validate([
            'slogan' => 'required',

        ]);
        
        $profil->update($validatedData);

        return redirect()->route('profil.index')->with('success', 'Data Slogan berhasil diperbarui.');
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
