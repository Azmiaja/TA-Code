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
        $data = Pegawai::whereNotIn('idPegawai', function($query) {
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

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nip' => 'required|numeric',
                'namaPegawai' => 'required|string',
                'tempatLahir' => 'nullable|string',
                'tanggalLahir' => 'nullable|date',
                'jenisKelamin' => 'nullable',
                'agama' => 'nullable',
                'alamat' => 'nullable|string',
                'jenisPegawai' => 'required',
                'noHp' => 'nullable|string|max:15',
                'status' => 'required',
                'gambar' => 'nullable|file|mimes:jpeg,png,jpg,svg|max:2048',
                'idJabatan' => 'required|numeric',
            ]);

            if ($request->file('gambarPegawai')) {
                $imgName = uniqid() . '.' . $request->file('gambarPegawai')->getClientOriginalExtension();
                $validatedData['gambar'] = $request->file('gambarPegawai')->storeAs('profil-pegawai', $imgName, 'public');
            }

            Pegawai::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menambahkan data.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Error storing data.'  . $e->getMessage(),
            ], 422);
        }
    }

    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
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
                $pegawai->gambar = $request->file('gambarPegawai')->storeAs('profil-pegawai', $imgName, 'public');
            }

            // Perbarui data pegawai
            $pegawai->update();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil memprbarui data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
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
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
