<?php

namespace App\Http\Controllers\Mcompany;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = Profil::orderBy('idProfil')->first();

        // $totalProfil = Profil::all()->count();
        return view('siakad.content.profil_sekolah.sekolah.index', compact('profil'), [
            'judul' => 'Profil Sekolah',
            'sub_judul' => 'Sekolah',
            'text_singkat' => 'Mengelola informasi profil sekolah!',

        ]);
    }

    public function getProfil()
    {
        $profil = Profil::find(1); // Ganti dengan logic untuk mendapatkan profil yang sesuai

        return response()->json([
            'image' => asset('storage/' . $profil->gambar),
            'deskripsi' => $profil->deskripsi,
            'imageSejarah' => asset('storage/' . $profil->sejarahImg),
            'deskripsiSejarah' => $profil->sejarahText,
            'imageOrganisasi' => asset('storage/' . $profil->strukturOrgImg),
            'deskripsiOrganisasi' => $profil->strukturOrgText,
            'imageKeuangan' => asset('storage/' . $profil->keuanganImg),
            'deskripsiKeuangan' => $profil->keuanganText,
            'visi' => $profil->visi,
            'misi' => $profil->misi,
            'sambutanKepsek' => $profil->sambutanKepsek,
        ]);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
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
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }

        return response()->json(['profil' => $profil]);
    }

    public function update(Request $request, $id)
    {
        try {
            $profil = Profil::find($id);

            $deskripsi = $request->input('isiProfilSekolah');

            if ($request->hasFile('gambarProfilSekolah')) {
                $imgName = uniqid() . '.' . $request->file('gambarProfilSekolah')->getClientOriginalExtension();
                $gambarPath = $request->file('gambarProfilSekolah')->storeAs('tentang-sekolah', $imgName, 'public');

                if ($profil->gambar) {
                    Storage::delete('public/' . $profil->gambar);
                }
                $profil->gambar = $gambarPath;
            }

            $profil->deskripsi = $deskripsi;

            $profil->update();

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil memperbarui data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title'=> 'Gagal',
                'message' => 'Error storing data.',
            ], 422);
        }
    }

    // fungsi update sejarah
    public function updateSejarah(Request $request, $id)
    {
        try {
            $profil = Profil::find($id);

            $deskripsi = $request->input('isiProfilSekolah');

            if ($request->hasFile('gambarProfilSekolah')) {
                $imgName = uniqid() . '.' . $request->file('gambarProfilSekolah')->getClientOriginalExtension();
                $gambarPath = $request->file('gambarProfilSekolah')->storeAs('tentang-sekolah', $imgName, 'public');

                if ($profil->sejarahImg) {
                    Storage::delete('public/' . $profil->sejarahImg);
                }
                $profil->sejarahImg = $gambarPath;
            }

            $profil->sejarahText = $deskripsi;

            $profil->update();

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil memperbarui data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title'=> 'Gagal',
                'message' => 'Error storing data.',
            ], 422);
        }
    }

    // fungsi update organisasi
    public function updateOrganisasi(Request $request, $id)
    {
        try {
            $profil = Profil::find($id);

            $deskripsi = $request->input('isiProfilSekolah');

            if ($request->hasFile('gambarProfilSekolah')) {
                $imgName = uniqid() . '.' . $request->file('gambarProfilSekolah')->getClientOriginalExtension();
                $gambarPath = $request->file('gambarProfilSekolah')->storeAs('tentang-sekolah', $imgName, 'public');

                if ($profil->strukturOrgImg) {
                    Storage::delete('public/' . $profil->strukturOrgImg);
                }
                $profil->strukturOrgImg = $gambarPath;
            }

            $profil->strukturOrgText = $deskripsi;

            $profil->update();

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil memperbarui data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title'=> 'Gagal',
                'message' => 'Error storing data.',
            ], 422);
        }
    }

    // fungsi update keuangan
    public function updateKeuangan(Request $request, $id)
    {
        try {
            $profil = Profil::find($id);

            $deskripsi = $request->input('isiProfilSekolah');

            if ($request->hasFile('gambarProfilSekolah')) {
                $imgName = uniqid() . '.' . $request->file('gambarProfilSekolah')->getClientOriginalExtension();
                $gambarPath = $request->file('gambarProfilSekolah')->storeAs('tentang-sekolah', $imgName, 'public');

                if ($profil->keuanganImg) {
                    Storage::delete('public/' . $profil->keuanganImg);
                }
                $profil->keuanganImg = $gambarPath;
            }

            $profil->keuanganText = $deskripsi;

            $profil->update();

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil memperbarui data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title'=> 'Gagal',
                'message' => 'Error storing data.',
            ], 422);
        }
    }

    // fungsi update visi misi
    public function updateVisiMisi(Request $request, $id)
    {
        try {
            $profil = Profil::find($id);

            $visi = $request->input('isiVisi');
            $misi = $request->input('isiMisi');

            $profil->visi = $visi;
            $profil->misi = $misi;

            $profil->update();

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil memperbarui data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title'=> 'Gagal',
                'message' => 'Error storing data.',
            ], 422);
        }
    }

    // fungsi update Sambutan
    public function updateSambutan(Request $request, $id)
    {
        try {
            $profil = Profil::find($id);

            $sambutanKepsek = $request->input('sambutanKepsek');

            $profil->sambutanKepsek = $sambutanKepsek;

            $profil->update();

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil memperbarui data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title'=> 'Gagal',
                'message' => 'Error storing data.',
            ], 422);
        }
    }

    private function deleteProfil($profil, $columnName, $imageColumn)
    {
        // Hapus gambar profil
        if ($profil->{$imageColumn}) {
            Storage::delete('public/' . $profil->{$imageColumn});
        }

        // Hapus kolom deskripsi dan gambar
        $profil->{$columnName} = null;
        $profil->{$imageColumn} = null;
        $profil->save();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil menghapus data.'
        ]);
    }

    public function destroy($id)
    {
        $profil = Profil::find($id);
    
        return $this->deleteProfil($profil, 'deskripsi', 'gambar');
    }

    public function destroySejarah($id)
    {
        $profil = Profil::find($id);
    
        return $this->deleteProfil($profil, 'sejarahText', 'sejarahImg');
    }

    public function destroyOrg($id)
    {
        $profil = Profil::find($id);
    
        return $this->deleteProfil($profil, 'strukturOrgText', 'strukturOrgImg');
    }
    
    public function destroyKeuangan($id)
    {
        $profil = Profil::find($id);
    
        return $this->deleteProfil($profil, 'keuanganText', 'keuanganImg');
    }
    public function destroySam($id)
    {
        $profil = Profil::find($id);
    
        return $this->deleteProfil($profil, 'sambutanKepsek', '');
    }
    
}
