<?php

namespace App\Http\Controllers\Muser;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        return view('siakad.content.m_sekolah.pegawai.index', compact('pegawai'), [
            'judul' => 'Data Master',
            'sub_judul' => 'Pegawai',
            'text_singkat' => 'Mengelola data pegawai!',
        ]);
    }

    public function getData()
    {
        // $data = Pegawai::orderBy("idPegawai", "DESC")->get();
        $data = Pegawai::whereNotIn('idPegawai', function ($query) {
            $query->select('idPegawai')
                ->from('user')
                ->where('hakAkses', 'Super Admin');
        })->orderBy("idPegawai", "DESC")->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            return $item;
        });
        return DataTables::of($data)->toJson();
    }



    public function create()
    {
        //
    }

    public function storeFoto(Request $request, $id)
    {
        try {
            $pegawai = Pegawai::find($id);

            $validator = Validator::make($request->all(), [
                'gambar' => 'image|mimes:jpeg,jpg,png,svg|max:2048',
            ], [
                'gambar.image' => 'File yang anda pilih bukan gambar.',
                'gambar.mimes' => 'Format gambar hanya JPEG,JPG,PNG,SVG.',
                'gambar.max' => 'Ukuran file maksimal 2MB.'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 0, 'error' => $validator->errors()->first()]);
            } else {
                if ($request->hasFile('gambar')) {
                    $imgName = uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                    $gambarPath = $request->file('gambar')->storeAs('profil_pegawai', $imgName, 'public');

                    if ($pegawai->gambar) {
                        Storage::delete('public/' . $pegawai->gambar);
                    }
                }
                $pegawai->gambar = $gambarPath;
                $pegawai->save();

                return response()->json(['status' => 'success', 'msg' => 'Foto pegawai berhasil diperbarui.']);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nip' => 'required|numeric',
                'namaPegawai' => 'required|string',
                'tempatLahir' => 'nullable|string',
                'tanggalLahir' => 'required',
                'jenisKelamin' => 'nullable',
                'agama' => 'nullable',
                'alamat' => 'nullable|string',
                'jenisPegawai' => 'required',
                'noHp' => 'nullable|string|max:15',
                'status' => 'required',
                // 'gambar' => 'nullable|file|mimes:jpeg,png,jpg,svg|max:2048',
                'idJabatan' => 'required|numeric',
            ]);

            
            $validatedData['tanggalLahir'] = Carbon::createFromFormat('d/m/Y', $request->tanggalLahir)->format('Y-m-d');

            Pegawai::create($validatedData);

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil menambahkan data.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Error storing data.'  . $e->getMessage(),
            ], 422);
        }
    }

    public function edit($id)
    {
        $pegawai = Pegawai::with('jabatanPegawai')->find($id);
        if (!$pegawai) {
            // Handle jika berita tidak ditemukan
            return back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        return response()->json(['data' => $pegawai]);
    }

    public function update(Request $request, $id)
    {
        try {
            $pegawai = Pegawai::find($id);

            $pegawai->fill($request->except(['some_field_to_exclude']));

            if ($request->file('gambarPegawai')) {
                if ($pegawai->gambar) {
                    Storage::delete('public/' . $pegawai->gambar);
                }
                $imgName = uniqid() . '.' . $request->file('gambarPegawai')->getClientOriginalExtension();
                $pegawai->gambar = $request->file('gambarPegawai')->storeAs('profil_pegawai', $imgName, 'public');
            }

            $pegawai->tanggalLahir = Carbon::createFromFormat('d/m/Y', $request->input('tanggalLahir'))->format('Y-m-d');

            // Perbarui data pegawai
            $pegawai->update();

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil memprbarui data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Error storing data.'  . $e->getMessage(),
            ], 422);
        }
    }


    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);

        Storage::delete('public/' . $pegawai->gambar);
        $pegawai->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
