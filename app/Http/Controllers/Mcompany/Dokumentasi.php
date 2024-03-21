<?php

namespace App\Http\Controllers\Mcompany;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi as ModelsDokumentasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Dokumentasi extends Controller
{
    public function index()
    {
        return view('siakad/content/profil_sekolah/dokumentasi/index', [
            'judul' => 'Profil Sekolah',
            'sub_judul' => 'Dokumentasi',
            'text_singkat' => 'Mengelola dakumentasi kegiatan sekolah!',
        ]);
    }

    public function getData()
    {
        $data = ModelsDokumentasi::where('kategoriMedia', 'Foto')->orderBy('idDokumentasi', 'desc')->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            // $item['waktu'] = Carbon::parse($item['waktu'])->format('Y-m-d');
            return $item;
        });
        return response()->json(['data' => $data]);
    }

    public function getDataVideo()
    {
        $data = ModelsDokumentasi::where('kategoriMedia', 'Video')->orderBy('idDokumentasi', 'desc')->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            // $item['waktu'] = Carbon::parse($item['waktu'])->format('Y-m-d');
            return $item;
        });
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'judulDokumentasi' => 'required|max:255',
                'kategoriMedia' => 'required|string',
            ]);

            $validatedData['judul'] = $request->judulDokumentasi;
            // $validatedData['idUser'] = auth()->user()->idUser;
            $validatedData['waktu'] = Carbon::createFromFormat('d/m/Y h:i A', $request->waktu)->format('Y-m-d H:i:s');

            if ($request->file('gambarDokumentasi')) {
                // $img = $request->file('gambarDokumentasi');
                $imgName = uniqid() . '.' . $request->file('gambarDokumentasi')->getClientOriginalExtension();
                $validatedData['media'] = $request->file('gambarDokumentasi')->storeAs('dokumentasi', $imgName, 'public');
            } else {
                $link = $request->link_video;

                $parsedUrl = parse_url($link);
                $path = $parsedUrl['path'];
                $query = $parsedUrl['query'];
                $videoId = ltrim($path, '/');
                $videoId .= '?' . $query;

                $validatedData['media'] = $videoId;
            }


            ModelsDokumentasi::create($validatedData);

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

    public function edit($id)
    {
        $dokumentasi = ModelsDokumentasi::find($id);
        if (!$dokumentasi) {
            // Handle jika dokumentasi tidak ditemukan
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Data tidak ditemukan.'
            ]);
        }

        return response()->json(['dock' => $dokumentasi]);
    }

    public function update(Request $request, $id)
    {
        try {
            $dock = ModelsDokumentasi::find($id);
            $validatedData = $request->validate([
                'judulDokumentasi' => 'required|max:255',
            ]);

            $validatedData['judul'] = $request->judulDokumentasi;
            $validatedData['waktu'] = Carbon::createFromFormat('d/m/Y h:i A', $request->waktu)->format('Y-m-d H:i:s');

            if ($request->file('gambarDokumentasi')) {
                // $img = $request->file('gambarDokumentasi');
                $imgName = uniqid() . '.' . $request->file('gambarDokumentasi')->getClientOriginalExtension();
                $validatedData['media'] = $request->file('gambarDokumentasi')->storeAs('dokumentasi', $imgName, 'public');

                if ($dock->media) {
                    Storage::delete('public/' . $dock->media);
                }
            } elseif ($link = $request->link_video) {

                $parsedUrl = parse_url($link);
                $path = $parsedUrl['path'];
                $query = $parsedUrl['query'];
                $videoId = ltrim($path, '/');
                $videoId .= '?' . $query;

                $validatedData['media'] = $videoId;
            }

            $dock->update($validatedData);

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

    public function destroy($id)
    {
        $dock = ModelsDokumentasi::find($id);
        Storage::delete('public/' . $dock->media);
        $dock->delete();
        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
