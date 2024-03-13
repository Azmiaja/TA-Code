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
        $data = Jabatan::all();
        return response()->json($data);
    }

    public function getJabatanOptions()
    {
        $data = Jabatan::whereDoesntHave('pegawai')->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            $jabatan = new Jabatan;

            $jabatan->jabatan = $request->input('jabatan');

            $jabatan->save();

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

    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
