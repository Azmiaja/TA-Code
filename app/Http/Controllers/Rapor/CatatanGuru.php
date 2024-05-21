<?php

namespace App\Http\Controllers\Rapor;

use App\Http\Controllers\Controller;
use App\Models\CatatanGuru as ModelsCatatanGuru;
use App\Models\Kelas;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CatatanGuru extends Controller
{
    public function index()
    {
        $pegawai = Auth::user()->pegawai->idPegawai;
        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->first();


        $today = now();

        $periodeAktif = Periode::where('tanggalMulai', '<=', $today)
            ->where('tanggalSelesai', '>=', $today)
            ->where('status', 'Aktif')
            ->first();

        // Mendapatkan periode yang sudah lewat berdasarkan tanggal selesai kurang dari tanggal hari ini
        $periodeLewat = Periode::where('tanggalSelesai', '<', $today)
            ->first();

        $pegawai = Auth::user()->pegawai->idPegawai;
        $kelas = Kelas::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode->idPeriode ?? '')
            ->first();

        $kelas_nama = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];

        return view('siakad/content/rapor/catatan_guru', compact('periodeAktif', 'periodeLewat', 'periode', 'kelas', 'kelas_nama'), [
            'judul' => 'Rapor Siswa',
            'sub_judul' => 'Catatan Guru',
            'text_singkat' => 'Mengelola catatan guru untuk rapor siswa!',
            's_idKelas' => '',
            'kelasName' => '',
            // 'periode' => $periodeGuru
        ]);
    }

    public function getCatatanGuru(Request $request)
    {
        $pegawai = Auth::user()->pegawai->idPegawai;
        $periode = $request->periode;
        $kelas = Kelas::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode ?? '')
            ->first();

        $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelas, $periode) {
            $query->where('namaKelas', $kelas->namaKelas)
                ->where('idPeriode', $periode);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();

        $ct_guru = ModelsCatatanGuru::where('idPeriode', $periode)
            ->where('idKelas', $kelas->idKelas)
            ->get();

        return response()->json([
            'siswa' => $siswaWithKelas,
            'catatan' => $ct_guru,
            'kelas' => $kelas
        ]);
    }

    public function store(Request $request)
    {
        try {
            $idSiswa = $request->input('idSiswa');
            $idPeriode = $request->input('idPeriode');
            $idKelas = $request->input('idKelas');

            foreach ($idSiswa as $data) {
                $catatan = $request->input('catatan_guru_' . $data);

                if ($catatan !== null) {
                    $ctt = ModelsCatatanGuru::firstOrNew([
                        'idSiswa' => $data,
                        'idPeriode' => $idPeriode,
                        'idKelas' => $idKelas,
                    ]);

                    $ctt->catatan_guru = $catatan;
                    $ctt->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil menyimpan data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $ctt = ModelsCatatanGuru::find($id);
            $ctt->delete();

            return response()->json([
                'status' => 'success',
                'title' => 'Dihapus!',
                'message' => 'Berhasil menghapus data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating data: ' . $e->getMessage());
        }
    }
}
