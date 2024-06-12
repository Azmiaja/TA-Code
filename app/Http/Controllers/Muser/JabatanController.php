<?php

namespace App\Http\Controllers\MUser;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    public function getJabatan()
    {
        try {

            $dataGuru = Jabatan::where('jenis', 'Guru')->get();
            $dataTendik = Jabatan::where('jenis', 'Tendik')->get();

            return response()->json([
                'guru' => $dataGuru,
                'tendik' => $dataTendik,
            ]);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
        }
    }


    public function getJabatanOptions()
    {
        // $data = Jabatan::whereDoesntHave('pegawai')->orderBy('idJabatan', 'desc')->get();
        // // $data = Jabatan::orderBy('idJabatan', 'desc')->get();
        // return response()->json($data);
        $data = Jabatan::orderBy('idJabatan', 'desc')->get();
        $data_2 = Jabatan::whereDoesntHave('pegawai')->orderBy('idJabatan', 'desc')->get();
        return response()->json(['jabatan1' => $data, 'jabatan2' => $data_2]);
    }

    public function getJabatanOptionsEdit()
    {
        $data = Jabatan::orderBy('idJabatan', 'desc')->get();
        $data_2 = Jabatan::whereDoesntHave('pegawai')->orderBy('idJabatan', 'desc')->get();
        return response()->json(['jabatan1' => $data, 'jabatan2' => $data_2]);
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'jabatan' => 'required|max:100',
                'jenis' => 'required',
            ], [
                'jabatan.required' => 'Jabatan harus diisi.',
                'jabatan.max' => 'Jabatan terlalu panjang, maksimal 100 karakter.',
                'jenis.required' => 'Kategori harus diisi.',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $jabatan = new Jabatan;

                $jabatan->jabatan = $request->input('jabatan');
                $jabatan->jenis = $request->input('jenis');

                $jabatan->save();

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

    public function update(Request $request, $id)
    {
        try {
            $jabatan = Jabatan::find($id);
            $validator = Validator::make($request->all(), [
                'jabatan' => 'required|max:100',
            ], [
                'jabatan.required' => 'Jabatan harus diisi.',
                'jabatan.max' => 'Jabatan terlalu panjang, maksimal 100 karakter.',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {

                $jabatan->jabatan = $request->input('jabatan');
                // $jabatan->jenis = $request->input('jenis');

                $jabatan->update();

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil mengubah data.',
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

    public function destroy($id)
    {
        try {
            $jabatan = Jabatan::find($id);
            $jabatan->delete();

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
