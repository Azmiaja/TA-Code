<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\Tr_kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KelasController extends Controller
{
    public function indexMasterDataKelas()
    {
        $pegawai = Pegawai::all();
        $guru = Pegawai::where('jenisPegawai', 'Guru')->get();
        $kelas = Kelas::orderBy('idKelas', 'desc')->get();
        $periode = Periode::orderBy('tanggalMulai', 'asc')->get();
        $siswa = Siswa::orderBy('idSiswa', 'desc')->get();
        return view('mkelas.data-kelas', compact('periode', 'kelas', 'pegawai', 'guru', 'siswa'), [
            "title" => "Manajemen Kelas",
            "title2" => "Master Data Kelas"
        ]);
    }

    public function getPeriodeGuru(Request $request)
    {
        $kelas = Kelas::with(['periode', 'guru'])
            ->where('idPeriode', $request->periode_id)
            ->get()
            ->map(function ($kelas) {
                // Tambahkan properti baru 'formattedTanggalMulai'
                $kelas->periode->formattedTanggalMulai = $kelas->periode->semester . '/' . date('Y', strtotime($kelas->periode->tanggalMulai));

                return $kelas;
            });
        $kelas = $kelas->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            return $item;
        });

        return DataTables::of($kelas)->toJson();
    }

    public function getKelas()
    {
        $kelas = Kelas::with('periode')->get()
            ->map(function ($kelas) {
                $kelas->periode->formattedTanggalMulai = $kelas->periode->semester . '/' . date('Y', strtotime($kelas->periode->tanggalMulai));
                return $kelas;
            });
        $siswa = Siswa::orderBy('idSiswa', 'desc')->get();
        $periode = Periode::orderBy('idPeriode', 'desc')->get()->map(function ($periode) {
            $periode->formattedTanggalMulai = $periode->semester . '/' . date('Y', strtotime($periode->tanggalMulai));
            return $periode;
        });
        $guru = Pegawai::orderBy('idPegawai', 'desc')->where('jenisPegawai', 'Guru')->get();

        return response()->json(['kelas' => $kelas, 'siswa' => $siswa, 'periode' => $periode, 'guru' => $guru]);
    }

    public function getPeriodeSiswa(Request $request)
    {
        $idPeriode = $request->input('periode_id');

        $data = Tr_kelas::select(
            'tr_kelas.idKelas',
            'tr_kelas.idtrKelas',
            'kelas.namaKelas',
            'siswa.namaSiswa',
            'siswa.status',
            'siswa.idSiswa',
            'periode.semester',
            'periode.tanggalMulai'
        )
            ->join('kelas', 'tr_kelas.idKelas', '=', 'kelas.idKelas')
            ->join('siswa', 'tr_kelas.idSiswa', '=', 'siswa.idSiswa')
            ->join('periode', 'kelas.idPeriode', '=', 'periode.idPeriode')
            ->where('periode.idPeriode', $idPeriode)
            ->get()
            ->map(function ($data) {
                $data->formattedTanggalMulai = $data->semester . '/' . date('Y', strtotime($data->tanggalMulai));

                return $data;
            });

        $data = $data->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            return $item;
        });

        return Datatables::of($data)->make(true);
    }

    public function create()
    {
        //
    }

    // store Periode
    public function storeSiswa(Request $request)
    {
        
        $idKelas = $request->idKelas;
        $idSiswa = $request->idSiswa;
        $insert = [];
        for ($i = 0; $i < count($idSiswa); $i++) {
            array_push($insert, ['idKelas' => $idKelas, 'idSiswa'=>$idSiswa[$i]]);
        }
        Tr_kelas::insertOrIgnore($insert);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menyimpan data.'
        ]);
    }
    
    //store Kelas
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'idPeriode' => 'required',
            'idPegawai' => 'required',
            'namaKelas' => 'required',
        ]);

        $kelas = Kelas::where('idPeriode', $validatedData['idPeriode'])->where('namaKelas', $validatedData['namaKelas'])->first();

        if ($kelas) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kelas sudah ada.'
            ]);
        } else {
            Kelas::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data.'
            ]);
        }
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $kelas = Kelas::find($id);
        if (!$kelas) {
            // Handle jika berita tidak ditemukan
            return response()->json(['status' => 'error', 'message' => 'Data kelas tidak ditemukan.']);
        }

        return response()->json(['kelas' => $kelas]);
    }

    public function editSiswa($id)
    {
        $data = Tr_kelas::find($id);
        if (!$data) {
            // Handle jika berita tidak ditemukan
            return response()->json(['status' => 'error', 'message' => 'Data kelas tidak ditemukan.']);
        }

        return response()->json(['tr_kelas' => $data]);
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return response()->json(['status' => 'error', 'message' => 'Data kelas tidak ditemukan.']);
        }
        // Validasi input
        $validatedData = $request->validate([
            'idPeriode' => 'required',
            'idPegawai' => 'required',
            'namaKelas' => 'required',
        ]);

        // Perbarui data kelas
        $kelas->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah data.'
        ]);
    }

    public function updateSiswa(Request $request, $id)
    {
        $kelas = Tr_kelas::find($id);

        if (!$kelas) {
            return response()->json(['status' => 'error', 'message' => 'Data kelas tidak ditemukan.']);
        }
        // Validasi input
        $validatedData = $request->validate([
            'idKelas' => 'required',
            'idSiswa' => 'required',
        ]);

        // Perbarui data kelas
        $kelas->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah data.'
        ]);
    }

    public function destroy($id)
    {
        $kelas = Kelas::find($id);
        $kelas->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus data.'
        ]);
    }

    public function destroySiswa($id)
    {
        $kelas = Tr_kelas::find($id);
        $kelas->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
