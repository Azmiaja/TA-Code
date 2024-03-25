<?php

namespace App\Http\Controllers\MUser;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $data = Jabatan::whereDoesntHave('pegawai')->orderBy('idJabatan', 'desc')->get();
        return response()->json($data);
    }

    public function getJabatanOptionsEdit()
    {
        $data = Jabatan::all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            $jabatan = new Jabatan;

            $jabatan->jabatan = $request->input('jabatan');
            $jabatan->jenis = $request->input('jenis');

            $jabatan->save();

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

    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
