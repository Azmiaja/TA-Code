<?php

namespace App\Http\Controllers\Muser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
            'noHp' => 'required',
            'status' => 'required',
        ]);

        $validatedData['tanggalLahir'] = Carbon::createFromFormat('d-m-Y', $request->input('tanggalLahir', Carbon::now()));
        Pegawai::create($validatedData);

        return back()
            ->with('success', 'Berhasil menyimpan 1 data.');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
        if (!$pegawai) {
            // Handle jika berita tidak ditemukan
            return back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        return view(compact('pegawai'));
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
            'noHp' => 'required',
            'status' => 'required',
        ]);

        $validatedData['tanggalLahir'] = Carbon::createFromFormat('d-m-Y', $request->input('tanggalLahir', Carbon::now()));

        // Perbarui data pegawai
        $pegawai->update($validatedData);

        return back()->with('success', 'Berhasil memperbarui 1 data.');
    }


    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->delete();

        return back()->with('success', 'Berhasil menghapus 1 data.');
    }
}
