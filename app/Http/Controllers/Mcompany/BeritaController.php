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
use Illuminate\Support\Str;

class BeritaController extends Controller
{

    public function index()
    {
        return view('siakad/content/profil_sekolah/berita/index', [
            'judul' => 'Profil Sekolah',
            'sub_judul' => 'Berita Sekolah',
            'text_singkat' => 'Mengelola berita kegiatan di sekolah!',
            // 'link' => 'berita.index',
            // 'beritaTerbaru' => $beritaTerbaru,

        ]);
    }

    public function getDataBerita()
    {
        $data = Berita::orderBy('waktu', 'desc')->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            // $item['waktu'] = Carbon::parse($item['waktu'])->format('Y-m-d');
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
                'judulBerita' => 'required|max:255',
                'isiBerita' => 'required',
                'gambar' => 'file|mimes:jpeg,png,jpg,svg',
            ]);

            $validatedData['penulis'] = auth()->user()->pegawai->namaPegawai;
            $validatedData['waktu'] = Carbon::createFromFormat('d/m/Y h:i A', $request->waktu)->format('Y-m-d H:i:s');
            $validatedData['slug'] = Str::slug($request->input('judulBerita'));


            if ($request->file('gambarBerita')) {
                // $img = $request->file('gambarBerita');
                $imgName = uniqid() . '.' . $request->file('gambarBerita')->getClientOriginalExtension();
                $validatedData['gambar'] = $request->file('gambarBerita')->storeAs('gambar-berita', $imgName, 'public');
            }

            Berita::create($validatedData);

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil menyimpan data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Error storing data.',
            ], 422);
        }
        // return response()->json(['status' => 'success', 'idBerita' => $idBerita]);
    }



    public function upload(Request $request)
    {
        if ($request->file('gambar')) {

            $img = $request->file('gambar');

            $idBerita = $request->idBerita;

            // $imageName = strtotime(now()) . rand(11111, 99999) . '.' . $img->getClientOriginalExtension();
            $imageName = $request->file('gambar')->getClientOriginalName();
            $berita_img = new Berita();
            // $original_name = $img->getClientOriginalName();
            $berita_img->gambar = $imageName;

            if (!is_dir(public_path() . '/uploads/berita/')) {
                mkdir(public_path() . '/uploads/berita/', 0777, true);
            }

            $beritaImgPath = '/storage/gambar-berita/' . $imageName;

            $request->file('gambar')->move(public_path() . '/storage/gambar-berita/', $imageName);

            $berita_img->where('idBerita', $idBerita)->update(['gambar' => asset($beritaImgPath)]);

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil menyimpan data.'
            ]);
        }
    }

    public function ck_upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $image = $request->file('upload');
            $imageName = strtotime(now()) . rand(11111, 99999) . '.' . $image->getClientOriginalExtension();
            if (!is_dir(public_path() . '/uploads/dokumentasi/')) {
                mkdir(public_path() . '/uploads/dokumentasi/', 0777, true);
            }
            $request->file('upload')->move(public_path() . '/uploads/dokumentasi/', $imageName);

            $url = asset('uploads/dokumentasi/' . $imageName);
            return response()->json(['uploaded' => 1, 'url' => $url]);
        }
    }


    public function show($id)
    {
        $data = Berita::findOrFail($id);
        return view('layouts.modals.edit-berita', ['berita' => $data]);
    }



    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        // if (!$berita) {
        //     // Handle jika berita tidak ditemukan
        //     return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        // }

        return response()->json(['berita' => $berita]);
    }

    // BeritaController.php

    public function update(Request $request, $id)
    {
        try {
            $berita = Berita::find($id);
            $validatedData = $request->validate([
                'judulBerita' => 'required|max:255',
                'isiBerita' => 'required',
                'gambar' => 'file|mimes:jpeg,png,jpg,svg',
            ]);

            $validatedData['penulis'] = auth()->user()->pegawai->namaPegawai;
            $validatedData['waktu'] = Carbon::createFromFormat('d/m/Y h:i A', $request->waktu)->format('Y-m-d H:i:s');
            $validatedData['slug'] = Str::slug($request->input('judulBerita'));

            if ($request->file('gambarBerita')) {
                // $img = $request->file('gambarBerita');
                $imgName = uniqid() . '.' . $request->file('gambarBerita')->getClientOriginalExtension();
                $validatedData['gambar'] = $request->file('gambarBerita')->storeAs('gambar-berita', $imgName, 'public');

                if ($berita->gambar) {
                    Storage::delete('public/' . $berita->gambar);
                }
            }

            $berita->update($validatedData);

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil memperbarui data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Error storing data.',
            ], 422);
        }
    }




    public function showDelete($id)
    {
        $data = Berita::findOrFail($id);
        return view('layouts.modals.hapus-berita', compact('data'));
    }

    public function destroy($id)
    {
        $berita = Berita::find($id);
        Storage::delete('public/' . $berita->gambar);

        $berita->delete();

        return response()->json([
            'status' => 'success',                    
            'title' => 'Dihapus!',
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
