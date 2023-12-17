<?php

namespace App\Http\Controllers\Mcompany;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = Profil::orderBy('idProfil', 'desc')->take(1)->get();
        // $totalProfil = Profil::all()->count();
        return view('mcompany.profil', compact('profil'), [
            'title' => 'Company Profil',
            'title2' => 'Profil Sekolah',

        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'slogan' => 'required',
            'gambarProfil' => 'required|file|mimes:jpg,jpeg,svg|max:2048',
            'gambarSejarah' => 'required|file|mimes:jpg,jpeg,svg|max:2048',
            'deskripsiProfil' => 'required',
            'deskripsiSejarah' => 'required',
            'visi' => 'required',
            'misi' => 'required',
        ]);

        // Field-file yang akan dicek dan dihapus jika data baru ditambahkan
        $gambarFields = ['gambarProfil', 'gambarSejarah'];

        // Loop melalui field-file
        foreach ($gambarFields as $field) {
            // Cek apakah ada file lama
            if ($request->hasFile($field)) {
                // Hapus file lama sebelum menyimpan yang baru
                $oldFile = Profil::whereNotNull($field)->value($field);
                if ($oldFile) {
                    // Hapus file lama dari storage
                    Storage::delete('public/' . $oldFile);
                }

                // Simpan file baru
                $gambarPath = $request->file($field)->getClientOriginalName();
                $validatedData[$field] = $request->file($field)->storeAs('gambar-profil', $gambarPath, 'public');
            }
        }

        // Hapus semua data yang ada di tabel Profil
        Profil::truncate();

        // Buat atau update profil baru
        Profil::updateOrCreate([], $validatedData);

        return back()->with('success', 'Berhasil menyimpan data.');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $profil = Profil::find($id);
        if (!$profil) {
            // Handle jika profil tidak ditemukan
            return back()->with('error', 'Profil tidak ditemukan.');
        }

        return view(compact('profil'));
    }

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

    public function destroy($id)
    {
        $profil = Profil::find($id);
        $profil->delete();
        // Storage::delete('public/' . $profil->dokumen);
        // Storage::delete('public/' . $profil->gambar);

        return back()->with('success', 'Berhasil menghapus profil.');
    }
}
