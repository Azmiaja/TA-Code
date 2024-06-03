<?php

namespace App\Http\Controllers\Rapor;

use App\Http\Controllers\Absensi;
use App\Http\Controllers\Controller;
use App\Models\Absensi as ModelsAbsensi;
use App\Models\Kelas;
use App\Models\KetNaikTidak as ModelsKetNaikTidak;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class KetNaikTidak extends Controller
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

        $kelas = Kelas::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode->idPeriode ?? '')
            ->first();

        $kelas_nama = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];

        return view('siakad/content/rapor/ket_naik_tidak', compact('periodeAktif', 'periodeLewat', 'periode', 'kelas', 'kelas_nama'), [
            'judul' => 'Rapor Siswa',
            'sub_judul' => 'Keterangan Naik/Tidak',
            'text_singkat' => 'Mengelola keterangan naik/tidak naik siswa!',
            's_idKelas' => '',
            'kelasName' => '',
            // 'periode' => $periodeGuru
        ]);
    }

    public function getKetNaikTidak(Request $request)
    {
        $idPeriode = $request->periode;
        $namaKelas = $request->kelas;

        $kelas = Kelas::where('idPeriode', $idPeriode)->where('namaKelas', $namaKelas)->first();

        $siswa = Siswa::whereHas('kelas', function ($query) use ($idPeriode, $namaKelas) {
            $query->where('namaKelas', $namaKelas)
                ->where('idPeriode', $idPeriode);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();

        $ketNaikTidak = ModelsKetNaikTidak::where('idPeriode', $idPeriode)
            ->where('idKelas', $kelas->idKelas)
            ->get();

        return response()->json([
            'siswa' => $siswa,
            'keterangan' => $ketNaikTidak
        ]);
    }

    public function store(Request $request)
    {
        try {
            $idSiswa = $request->input('idSiswa');
            $idKelas = $request->input('idKelas');
            $idPeriode = $request->input('idPeriode');

            $kelas = Kelas::where('idKelas', $idKelas)->first();
            $kk_ls = [2, 3, 4, 5, 6];
            $kk_ls_2 = ['Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];

            // Simpan data absensi ke dalam basis data
            foreach ($idSiswa as $data) {
                $ket = $request->input('keterangan_' . $data);
                if ($ket !== null) {
                    $keterangan = ModelsKetNaikTidak::firstOrNew([
                        'idSiswa' => $data,
                        'idKelas' => $idKelas,
                        'idPeriode' => $idPeriode,
                    ]);

                    $keterangan->keterangan = $ket;
                    $NorT = '';
                    if ($ket == 'Ya') {
                        if ($kelas->namaKelas < 6) {
                            $NorT = 'Naik ke Kelas ' . $kk_ls[$kelas->namaKelas - 1 ?? ''] . ' (' . $kk_ls_2[$kelas->namaKelas - 1 ?? ''] . ')';
                        } else {
                            $NorT = 'LULUS';
                        }
                    } else {
                        $NorT = 'Tinggal kelas';
                    }
                    $keterangan->deskripsi = $NorT;
                    $keterangan->save();
                    # code...
                }
            }

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Data berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $ket = ModelsKetNaikTidak::find($id);
        if ($ket) {
            $ket->delete();
            # code...
        }

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
