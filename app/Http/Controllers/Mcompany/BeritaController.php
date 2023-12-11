<?php

namespace App\Http\Controllers\Mcompany;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\PPGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{

    public function index()
    {
        $beritaM = Berita::all();
        $berita = Berita::orderBy('waktuBerita', 'desc')->get();
        $totalBerita = Berita::all()->count();
        return view('mcompany.berita', compact('berita', 'totalBerita'), [
            'm_berita' => $beritaM,
            'title' => 'Company Profil',
            'title2' => 'Berita Sekolah',

        ]);
    }

    public function getData()
    {
        $data = Berita::orderBy('idBerita', 'desc')->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            $item['waktuBerita'] = Carbon::parse($item['waktuBerita'])->format('Y-m-d');
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
            $validatedData = $request->validate([
                'judulBerita' => 'required',
                'gambar' => 'file|mimes:jpeg,png,jpg',
                'isiBerita' => '',
                'waktuBerita' => 'required|date',
                'sumberBerita' => '',
            ]);

            // Logging for debugging
            Log::info('Received data:', $request->all());
            Log::info('Validated data:', $validatedData);

            if ($request->file('gambar')) {
                $gambarPath = $request->file('gambar')->getClientOriginalName();
                $validatedData['gambar'] = $request->file('gambar')->storeAs('gambar-berita', $gambarPath, 'public');
            }

            Berita::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Error storing data.',
            ], 422);
        }
    }


    public function show($id)
    {
        $data = Berita::findOrFail($id);
        return view('layouts.modals.edit-berita', ['berita' => $data]);
    }



    public function edit($id)
    {
        $berita = Berita::find($id);
        if (!$berita) {
            // Handle jika berita tidak ditemukan
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }

        return response()->json(['berita' => $berita]);
    }

    // BeritaController.php

    public function update(Request $request, $id)
    {
        // Find Berita data by ID
        $berita = Berita::find($id);

        $validatedData = $request->validate([
            'judulBerita' => 'required',
            'gambar' => 'file|mimes:jpeg,png,jpg',
            'isiBerita' => '',
            'waktuBerita' => 'required|date',
            'sumberBerita' => '',
        ]);

        // If there is a new image file
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->getClientOriginalName();
            $validatedData['gambar'] = $request->file('gambar')->storeAs('gambar-berita', $gambarPath, 'public');

            // Delete the old image
            if ($berita->gambar) {
                Storage::delete('public/' . $berita->gambar);
            }
        }

        // Update Berita data
        $berita->update($validatedData);

        // Successfully updated data, send JSON response
        return back()
            ->with('success', 'Berhasil memperbarui data.');
    }




    public function showDelete($id)
    {
        $data = Berita::findOrFail($id);
        return view('layouts.modals.hapus-berita', compact('data'));
    }

    public function destroy($id)
    {
        $berita = Berita::find($id);
        $berita->delete();
        // Storage::delete('public/' . $berita->dokumen);
        Storage::delete('public/' . $berita->gambar);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus data.'
        ]);
    }

}
