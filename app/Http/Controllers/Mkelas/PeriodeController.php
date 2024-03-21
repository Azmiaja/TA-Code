<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PeriodeController extends Controller
{
    public function index()
    {
        $periode = Periode::all();
        return view('siakad.content.m_sekolah.akademik.periode.index', compact('periode'), [
            'judul' => 'Data Master',
            'sub_judul' => 'Akademik',
            'sub_sub_judul' => 'Periode',
            'text_singkat' => 'Mengelola periode akademik sekolah!',
        ]);
    }

    public function getPeriode()
    {
        $data = Periode::orderBy("tanggalMulai", "desc")->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            $item['tanggalMulai'] = Carbon::parse($item->tanggalMulai)->locale('id_ID')->isoFormat('Do MMMM YYYY') ?: null;;
            $item['tanggalSelesai'] = Carbon::parse($item->tanggalSelesai)->locale('id_ID')->isoFormat('Do MMMM YYYY') ?: null;;
            return $item;
        });
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'semester' => 'required',
            'tanggalMulai' => 'required',
            'tanggalSelesai' => 'required',
        ]);

        $validatedData['tanggalMulai'] = Carbon::createFromFormat('d/m/Y', $request->input('tanggalMulai'))->format('Y-m-d');
        $validatedData['tanggalSelesai'] = Carbon::createFromFormat('d/m/Y', $request->input('tanggalSelesai'))->format('Y-m-d');

        Periode::create($validatedData);

        return response()->json([
            'status' => 'success',
            'title' => 'Sukses',
            'message' => 'Berhasil menyimpan data.'
        ]);
    }

    public function edit($id)
    {
        $periode = Periode::find($id);
        if (!$periode) {
            return response()->json(['status' => 'error', 'title' => 'Gagal', 'message' => 'Data periode tidak ditemukan.']);
        }

        return response()->json([
            'periode' => $periode
        ]);
    }

    public function update(Request $request, $id)
    {
        $periode = Periode::find($id);
        // Validasi input
        $validatedData = $request->validate([
            'semester' => 'required',
            'tanggalMulai' => 'required',
            'tanggalSelesai' => 'required',
        ]);

        $validatedData['tanggalMulai'] = Carbon::createFromFormat('d/m/Y', $request->input('tanggalMulai'))->format('Y-m-d');
        $validatedData['tanggalSelesai'] = Carbon::createFromFormat('d/m/Y', $request->input('tanggalSelesai'))->format('Y-m-d');

        // Perbarui data periode
        $periode->update($validatedData);

        return response()->json([
            'status' => 'success',
            'title' => 'Sukses',
            'message' => 'Berhasil mengubah data.'
        ]);
    }

    public function destroy($id)
    {
        $periode = Periode::find($id);
        $periode->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil mengapus data.'
        ]);
    }
}
