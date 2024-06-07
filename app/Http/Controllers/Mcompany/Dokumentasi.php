<?php

namespace App\Http\Controllers\Mcompany;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi as ModelsDokumentasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
            $validator = Validator::make($request->all(), [
                'judulDokumentasi' => 'required|max:255',
                'kategoriMedia' => 'required',
                'waktu' => 'required',
            ], [
                'judulDokumentasi.required' => 'Judul dokumentasi tidak boleh kosong!',
                'judulDokumentasi.max' => 'Judul dokumentasi tidak boleh melebihi 255 karakter!',
                'kategoriMedia.required' => 'Media tidak boleh kosong!',
                'waktu.required' => 'Tanggal tidak boleh kosong!',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {

                $judul = $request->input('judulDokumentasi');
                $ktmedia = $request->input('kategoriMedia');
                $waktu = Carbon::createFromFormat('d/m/Y h:i A', $request->waktu)->format('Y-m-d H:i:s');

                $media = '';
                if ($request->file('gambarDokumentasi')) {
                    // $img = $request->file('gambarDokumentasi');
                    $imgName = uniqid() . '.' . $request->file('gambarDokumentasi')->getClientOriginalExtension();
                    $media = $request->file('gambarDokumentasi')->storeAs('dokumentasi', $imgName, 'public');
                } else {
                    $link = $request->link_video;

                    $parsedUrl = parse_url($link);
                    $path = $parsedUrl['path'];
                    $query = $parsedUrl['query'];
                    $videoId = ltrim($path, '/');
                    $videoId .= '?' . $query;

                    $media = $videoId;
                }


                ModelsDokumentasi::create([
                    'judul' => $judul,
                    'kategoriMedia' => $ktmedia,
                    'waktu' => $waktu,
                    'media' => $media
                ]);

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil menyimpan data.'
                ]);
            }
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

            $validator = Validator::make($request->all(), [
                'judulDokumentasi' => 'required|max:255',
                // 'kategoriMedia' => 'required',
            ], [
                'judulDokumentasi.required' => 'Judul dokumentasi tidak boleh kosong!',
                'judulDokumentasi.max' => 'Judul dokumentasi tidak boleh melebihi 255 karakter!',
                // 'kategoriMedia.required' => 'Kategori media tidak boleh kosong!',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {

                $judul = $request->input('judulDokumentasi');
                // $ktmedia = $request->input('kategoriMedia');
                $waktu = Carbon::createFromFormat('d/m/Y h:i A', $request->waktu)->format('Y-m-d H:i:s');

                $media_data = $dock->media;

                if ($request->file('gambarDokumentasi')) {
                    // $img = $request->file('gambarDokumentasi');
                    $imgName = uniqid() . '.' . $request->file('gambarDokumentasi')->getClientOriginalExtension();
                    $media_data = $request->file('gambarDokumentasi')->storeAs('dokumentasi', $imgName, 'public');

                    if ($dock->media) {
                        Storage::delete('public/' . $dock->media);
                    }
                } elseif ($link = $request->link_video) {

                    $parsedUrl = parse_url($link);
                    $path = $parsedUrl['path'];
                    $query = $parsedUrl['query'];
                    $videoId = ltrim($path, '/');
                    $videoId .= '?' . $query;

                    $media_data = $videoId;
                }

                $dock->update([
                    'judul' => $judul,
                    // 'kategoriMedia' => $ktmedia,
                    'waktu' => $waktu,
                    'media' => $media_data
                ]);

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil memperbarui data.'
                ]);
            }
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
