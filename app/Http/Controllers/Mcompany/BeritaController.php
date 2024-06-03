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
            $validator = Validator::make($request->all(), [
                'judulBerita' => 'required|max:255',
                'isiBerita' => 'required',
                'gambarBerita' => 'required|file|mimes:jpeg,png,jpg,svg|max:2048',
                'waktu' => 'required',
            ], [
                'judulBerita.required' => 'Judul berita tidak boleh kosong!',
                'judulBerita.max' => 'Judul berita tidak boleh melebihi 255 karakter!',
                'isiBerita.required' => 'Deskripsi berita tidak boleh kosong!',
                'gambarBerita.required' => 'Gambar berita tidak boleh kosong!',
                'gambarBerita.file' => 'Gambar berita harus berupa file yang valid!',
                'gambarBerita.mimes' => 'Gambar berita harus berupa file dengan format: jpeg, png, jpg, atau svg!',
                'gambarBerita.max' => 'Ukuran gambar berita tidak boleh melebihi 2 MB!',
                'waktu.required' => 'Waktu berita tidak boleh kosong!',
                // 'waktu.date_format' => 'Waktu berita harus dalam format dd/mm/yyyy hh:mm!',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $judul = $request->input('judulBerita');
                $isi = $request->input('isiBerita');
                $penulis = auth()->user()->pegawai->namaPegawai;
                $waktu = Carbon::createFromFormat('d/m/Y h:i A', $request->waktu)->format('Y-m-d H:i:s');
                $slug = Str::slug($request->input('judulBerita'));

                if ($request->file('gambarBerita')) {
                    // $img = $request->file('gambarBerita');
                    $imgName = uniqid() . '.' . $request->file('gambarBerita')->getClientOriginalExtension();
                    $gambarPath = $request->file('gambarBerita')->storeAs('gambar-berita', $imgName, 'public');
                }

                Berita::create([
                    'judulBerita' => $judul,
                    'isiBerita' => $isi,
                    'penulis' => $penulis,
                    'waktu' => $waktu,
                    'slug' => $slug,
                    'gambar' => $gambarPath,
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



    public function upload(Request $request)
    {
        // if ($request->file('gambar')) {

        //     $img = $request->file('gambar');

        //     $idBerita = $request->idBerita;

        //     // $imageName = strtotime(now()) . rand(11111, 99999) . '.' . $img->getClientOriginalExtension();
        //     $imageName = $request->file('gambar')->getClientOriginalName();
        //     $berita_img = new Berita();
        //     // $original_name = $img->getClientOriginalName();
        //     $berita_img->gambar = $imageName;

        //     if (!is_dir(public_path() . '/uploads/berita/')) {
        //         mkdir(public_path() . '/uploads/berita/', 0777, true);
        //     }

        //     $beritaImgPath = '/storage/gambar-berita/' . $imageName;

        //     $request->file('gambar')->move(public_path() . '/storage/gambar-berita/', $imageName);

        //     $berita_img->where('idBerita', $idBerita)->update(['gambar' => asset($beritaImgPath)]);
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/berita', $filename);

            $url = Storage::url($path);

            return response()->json([
                'url' => $url
            ]);
        }
    }

    public function ck_upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $image = $request->file('upload');
            $imageName = strtotime(now()) . rand(11111, 99999) . '.' . $image->getClientOriginalExtension();
            if (!is_dir(public_path() . '/storage/gambar-berita/')) {
                mkdir(public_path() . '/storage/gambar-berita/', 0777, true);
            }
            $request->file('upload')->move(public_path() . '/storage/gambar-berita/', $imageName);

            $url = asset('/storage/gambar-berita/' . $imageName);
            return response()->json(['uploaded' => 1, 'url' => $url]);
        }
    }

    public function deleteImage(Request $request)
    {
        $filePath = public_path('storage/gambar-berita/' . $request->get('file_name'));

        if (File::exists($filePath)) {
            File::delete($filePath);
            return response()->json(['success' => true, 'message' => 'File deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'File not found']);
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
            $validator = Validator::make($request->all(), [
                'judulBerita' => 'required|max:255',
                'isiBerita' => 'required',
                'gambarBerita' => 'file|mimes:jpeg,png,jpg,svg|max:2048',
                'waktu' => 'required',
            ], [
                'judulBerita.required' => 'Judul berita tidak boleh kosong!',
                'judulBerita.max' => 'Judul berita tidak boleh melebihi 255 karakter!',
                'isiBerita.required' => 'Deskripsi berita tidak boleh kosong!',
                // 'gambarBerita.required' => 'Gambar berita tidak boleh kosong!',
                'gambarBerita.file' => 'Gambar berita harus berupa file yang valid!',
                'gambarBerita.mimes' => 'Gambar berita harus berupa file dengan format: jpeg, png, jpg, atau svg!',
                'gambarBerita.max' => 'Ukuran gambar berita tidak boleh melebihi 2 MB!',
                'waktu.required' => 'Waktu berita tidak boleh kosong!',
                // 'waktu.date_format' => 'Waktu berita harus dalam format dd/mm/yyyy hh:mm!',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $berita = Berita::find($id);

                $judul = $request->input('judulBerita');
                $isi = $request->input('isiBerita');
                $penulis = auth()->user()->pegawai->namaPegawai;
                $waktu = Carbon::createFromFormat('d/m/Y h:i A', $request->waktu)->format('Y-m-d H:i:s');
                $slug = Str::slug($request->input('judulBerita'));

                $gambarPath = $berita->gambar;

                if ($request->file('gambarBerita')) {
                    // $img = $request->file('gambarBerita');
                    $imgName = uniqid() . '.' . $request->file('gambarBerita')->getClientOriginalExtension();
                    $gambarPath = $request->file('gambarBerita')->storeAs('gambar-berita', $imgName, 'public');

                    if ($berita->gambar) {
                        Storage::delete('public/' . $berita->gambar);
                    }
                }

                $berita->update([
                    'judulBerita' => $judul,
                    'isiBerita' => $isi,
                    'penulis' => $penulis,
                    'waktu' => $waktu,
                    'slug' => $slug,
                    'gambar' => $gambarPath,
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
