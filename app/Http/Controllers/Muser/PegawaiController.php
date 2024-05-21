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
        })->orderBy("idPegawai", "desc")->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            $item['jenisKelamin'] = $item->jenisKelamin == 'Laki-Laki' ? 'L' : 'P';
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
            $validator = Validator::make($request->all(), [
                'nip' => 'integer|digits:18|unique:pegawai,nip',
                'alamat' => 'max:125',
                'noHp' => 'max:15',
                'namaPegawai' => 'max:45'
            ], [
                'nip.integer' => 'NIP harus berupa angka.',
                'nip.unique' => 'NIP sudah terdaftar.',
                'nip.digits' => 'Panjang NIP harus 18 digit.',
                'alamat.max' => 'Alamat terlalu panjang maksimal 125 karakter.',
                'noHp.max' => 'Panjang Nomor telepon maksimal 15',
                'namaPegawai.max' => 'Nama pegawai terlalu panjang maksimal 45 karakter.'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                Pegawai::create([
                    'nip'  => $request->nip,
                    'namaPegawai' => $request->namaPegawai,
                    'tempatLahir' => $request->tempatLahir,
                    'tanggalLahir' => Carbon::createFromFormat('d/m/Y', $request->tanggalLahir)->format('Y-m-d'),
                    'jenisKelamin' => $request->jenisKelamin,
                    'agama' => $request->agama,
                    'alamat' => $request->alamat,
                    'jenisPegawai' => $request->jenisPegawai,
                    'noHp' => $request->noHp,
                    'idJabatan' => $request->idJabatan
                ]);

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil menambahkan data.',
                ]);
            }
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

            $validator = Validator::make($request->all(), [
                'nip' => [
                    'integer',
                    'digits:18',
                    'unique:pegawai,nip,' . $id . ',idPegawai'
                ],
                'alamat' => 'max:125',
                'noHp' => 'max:15',
                'idJabatan' => 'unique:pegawai,idJabatan,' . $id . ',idPegawai',
                'namaPegawai' => 'max:45'
            ], [
                'nip.integer' => 'NIP harus berupa angka.',
                'nip.unique' => 'NIP sudah terdaftar.',
                'nip.digits' => 'Panjang NIP harus 18 digit.',
                'alamat.max' => 'Alamat terlalu panjang maksimal 125 karakter.',
                'noHp.max' => 'Panjang Nomor telepon maksimal 15',
                'idJabatan.unique' => 'Jabatan sudah digunakan pegawai lain.',
                'namaPegawai.max' => 'Nama pegawai terlalu panjang maksimal 45 karakter.'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $pegawai->update([
                    'nip'  => $request->nip,
                    'namaPegawai' => $request->namaPegawai,
                    'tempatLahir' => $request->tempatLahir,
                    'tanggalLahir' => Carbon::createFromFormat('d/m/Y', $request->tanggalLahir)->format('Y-m-d'),
                    'jenisKelamin' => $request->jenisKelamin,
                    'agama' => $request->agama,
                    'alamat' => $request->alamat,
                    'jenisPegawai' => $request->jenisPegawai,
                    'noHp' => $request->noHp,
                    'idJabatan' => $request->idJabatan,
                    'status' => $request->status
                ]);

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil memprbarui data.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $pegawai = Pegawai::find($id);
    
            Storage::delete('public/' . $pegawai->gambar);
            $pegawai->delete();
    
            return response()->json([
                'status' => 'success',
                'title' => 'Dihapus!',
                'message' => 'Berhasil menghapus data.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal!',
                'message' => 'Tidak dapat menghapus data karena memiliki relasi dengan data lain!.'
            ]);
        }
    }
}
