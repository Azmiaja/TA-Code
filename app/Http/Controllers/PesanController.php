<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
        $data = Pesan::orderBy("waktu", "DESC")->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            return $item;
        });
        return DataTables::of($data)->toJson();
    }


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:50',
                'email' => 'required|max:100|email',
                'noHp' => ['required', 'max:15', 'regex:/^(\+62|62)?[\s-]?[1-9]{1}[0-9]{1,14}$/'],
                'pesan' => ['required', 'max:500'],
            ], [
                'nama.required' => 'Nama pengirim tidak boleh kosong!',
                'nama.string' => 'Nama pengirim harus berupa huruf!',
                'nama.max' => 'Nama pengirim maksimal 50 karakter!',
                'email.required' => 'Email pengirim tidak boleh kosong!',
                'email.max' => 'Email pengirim maksimal 100 karakter!',
                'email.email' => 'Email pengirim harus berformat email!',
                'noHp.required' => 'No Hp pengirim tidak boleh kosong!',
                'noHp.max' => 'No Hp pengirim maksimal 15 karakter!',
                'noHp.regex' => 'No Hp pengirim harus berformat nomor Hp!',
                'pesan.required' => 'Pesan tidak boleh kosong!',
                'pesan.max' => 'Pesan maksimal 500 karakter!',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {

                $pesan = new Pesan;

                $pesan->namaPengirim = $request->input('nama');
                $pesan->email = $request->input('email');
                $pesan->telp = $request->input('noHp');
                $pesan->pesan = $request->input('pesan');
                $pesan->waktu = now();

                // dd($pesan);
                $pesan->save();

                return back()->with('success', 'Pesan berhasil dikirim.');
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
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
