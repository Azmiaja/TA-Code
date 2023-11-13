<?php

namespace App\Http\Controllers\Muser;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        return view('muser.siswa', compact('siswa'),[
            'title' => 'Manajemen User',
            'title2' => 'Siswa',
        ]);
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
            'noHpOrtu' => 'required',
            'status' => 'required',
        ]);

        $validatedData['tanggalLahir'] = Carbon::createFromFormat('d-m-Y', $request->input('tanggalLahir', Carbon::now()));
        Siswa::create($validatedData);

        return back()
            ->with('success', 'Berhasil menyimpan 1 data.');
    }

    public function edit($id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) {
            // Handle jika berita tidak ditemukan
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        return view(compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return redirect()->route('data-siswa.siswa')->with('error', 'Data siswa tidak ditemukan.');
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
            'noHpOrtu' => 'required',
            'status' => 'required',
        ]);

        $validatedData['tanggalLahir'] = Carbon::createFromFormat('d-m-Y', $request->input('tanggalLahir', Carbon::now()));

        // Perbarui data siswa
        $siswa->update($validatedData);

        return back()->with('success', 'Berhasil memperbarui 1 data.');
    }


    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $siswa->delete();

        return back()->with('success', 'Berhasil menghapus 1 data.');
    }
    
}
