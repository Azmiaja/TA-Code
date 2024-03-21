<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PesanController extends Controller
{

    public function index()
    {
        // $profil = Profil::orderBy('idProfil')->first();

        // $totalProfil = Profil::all()->count();
        return view('siakad.content.profil_sekolah.pesan.index', [
            'judul' => 'Profil Sekolah',
            'sub_judul' => 'Pesan Masuk',
            'text_singkat' => 'Mengelola pesan masuk dari halaman profil sekolah!',

        ]);
    }

    public function getData()
    {
        $data = Pesan::orderBy("idPesan", "DESC")->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            return $item;
        });
        return DataTables::of($data)->toJson();
    }


    public function store(Request $request)
    {
        try {
            $pesan = new Pesan;

            $pesan->namaPengirim = $request->input('nama');
            $pesan->email = $request->input('email');
            $pesan->telp = $request->input('noHp');
            $pesan->pesan = $request->input('pesan');
            $pesan->waktu = now();

            // dd($pesan);
            $pesan->save();

            return back()->with('success', 'Pesan berhasil dikirim.');
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
        $pesan = Pesan::find($id);
        $pesan->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
