<?php

namespace App\Http\Controllers\Muser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        return view('muser.pegawai', compact('pegawai'), [
            'title' => 'Manajemen User',
            'title2' => 'Pegawai'

        ]);
    }

    public function getData()
    {
        $data = Pegawai::orderBy("idPegawai", "DESC")->get();
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
        $validatedData = $request->validate([
            'nip' => 'required',
            'namaPegawai' => 'required',
            'tempatLahir' => 'required',
            'tanggalLahir' => 'required|date',
            'jenisKelamin' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'jenisPegawai' => 'required',
            'noHp' => '',
            'status' => 'required',
        ]);

        Pegawai::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambahkan data.',
        ]);
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
        $pegawai = Pegawai::find($id);

        if (!$pegawai) {
            return redirect()->route('data-pegawai.pegawai')->with('error', 'Data pegawai tidak ditemukan.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'nip' => 'required',
            'namaPegawai' => 'required',
            'tempatLahir' => 'required',
            'tanggalLahir' => 'required|date',
            'jenisKelamin' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'jenisPegawai' => 'required',
            'noHp' => '',
            'status' => 'required',
        ]);

        // $validatedData['tanggalLahir'] = Carbon::createFromFormat('d-m-Y', $request->input('tanggalLahir', Carbon::now()));

        // Perbarui data pegawai
        $pegawai->update($validatedData);

        return response()->json([
            'status'=>'success',
            'message'=>'Berhasil memprbarui data.'
        ]);
    }


    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->delete();

        return response()->json([
            'status'=>'success',
            'message'=>'Berhasil menghapus data.'
        ]);
    }
}
