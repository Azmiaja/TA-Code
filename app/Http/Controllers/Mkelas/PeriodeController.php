<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periode = Periode::all();
        return view('mkelas.periode', compact('periode'), [
            "title" => "Manajemen Kelas",
            "title2" => "Periode"
        ]);
    }

    public function getPeriode()
    {
        $data = Periode::orderBy("idPeriode", "asc")->get();
        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            return $item;
        });
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'semester' => 'required',
            'tanggalMulai' => 'required|date',
            'tanggalSelesai' => 'required|date',
        ]);

        // $validatedData['tanggalLahir'] = Carbon::createFromFormat('d-m-Y', $request->input('tanggalLahir', Carbon::now()));
        Periode::create($validatedData);

        // return back()
        //     ->with('success', 'Berhasil menyimpan 1 data.');
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menyimpan data.'
        ]);
    }

    public function edit($id)
    {
        $periode = Periode::find($id);
        if (!$periode) {
            return response()->json(['status' => 'error', 'message' => 'Data periode tidak ditemukan.']);
        }

        return response()->json([
            'periode' => $periode
        ]);
    }

    public function update(Request $request, $id)
    {
        $periode = Periode::find($id);

        if (!$periode) {
            return response()->json(['status' => 'error', 'message' => 'Data periode tidak ditemukan.']);
        }
        // Validasi input
        // $validatedData = $request->all([
        //     'semester' => 'required',
        //     'tanggalMulai' => 'required|date',
        //     'tanggalSelesai' => 'required|date',
        // ]);

        // Perbarui data periode
        $periode->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah data.'
        ]);
    }

    public function destroy($id)
    {
        $periode = Periode::find($id);
        $periode->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengapus data.'
        ]);
    }
}
