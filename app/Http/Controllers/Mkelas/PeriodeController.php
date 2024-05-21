<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

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
            $item['semesterTahun'] = 'Semester ' . $item->semester . ' ' . $item->tahun ?: '-';
            $item['tanggalMulai'] = Carbon::parse($item->tanggalMulai)->locale('id_ID')->isoFormat('Do MMMM YYYY') ?: '-';
            $item['tanggalSelesai'] = Carbon::parse($item->tanggalSelesai)->locale('id_ID')->isoFormat('Do MMMM YYYY') ?: '-';
            $item['status'] = $item->status === 'Aktif' ? '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">' . $item->status . '</span>' : '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">' . $item->status . '</span>';
            return $item;
        });
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'semester' => 'required',
                'tahun' => 'required',
                'status' => 'required',
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
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
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
            'tahun' => 'required',
            'status' => 'required',
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
        try {
            $periode = Periode::find($id);
            $periode->delete();
            
            return response()->json([
                'status' => 'success',
                'title' => 'Dihapus!',
                'message' => 'Berhasil mengapus data.'
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
