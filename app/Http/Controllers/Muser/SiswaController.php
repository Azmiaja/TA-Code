<?php

namespace App\Http\Controllers\Muser;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        return view('muser.siswa', compact('siswa'), [
            'title' => 'Manajemen User',
            'title2' => 'Siswa',
        ]);
    }

    public function getData()
    {
        $data = Siswa::orderBy('idSiswa', 'desc')->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
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
        $validatedData = $request->validate([
            'nisn' => 'required',
            'namaSiswa' => 'required',
            'tempatLahir' => 'required',
            'tanggalLahir' => 'required|date',
            'jenisKelamin' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'noHpOrtu' => '',
            'status' => 'required',
        ]);

        // $validatedData['tanggalLahir'] = Carbon::createFromFormat('d-m-Y', $request->input('tanggalLahir', Carbon::now()));
        Siswa::create($validatedData);

        // return back()
        //     ->with('success', 'Berhasil menyimpan 1 data.');
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menyimpan data.'
        ]);
    }

    public function edit($id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) {
            // Handle jika berita tidak ditemukan
            return response()->json(['status' => 'error', 'message' => 'Data siswa tidak ditemukan.']);
        }

        return response()->json(['siswa' => $siswa]);
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json(['status' => 'error', 'message' => 'Data siswa tidak ditemukan.']);
        }
        // Validasi input
        $validatedData = $request->validate([
            'nisn' => 'required',
            'namaSiswa' => 'required',
            'tempatLahir' => 'required',
            'tanggalLahir' => 'required|date',
            'jenisKelamin' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'noHpOrtu' => '',
            'status' => 'required',
        ]);

        // $validatedData['tanggalLahir'] = Carbon::createFromFormat('Y-m-d', $request->input('tanggalLahir', Carbon::now()));

        // Perbarui data siswa
        $siswa->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah data.'
        ]);
    }


    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $siswa->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengapus data.'
        ]);
    }
}
