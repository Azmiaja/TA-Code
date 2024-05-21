<?php

namespace App\Http\Controllers\Rapor;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakulikuler;
use App\Models\KegEkstra;
use App\Models\Kelas;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KegiatanEkstra extends Controller
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

        return view('siakad/content/rapor/ekstra', compact('periodeAktif', 'periodeLewat', 'periode', 'kelas', 'kelas_nama'), [
            'judul' => 'Rapor Siswa',
            'sub_judul' => 'Ekstrakulikuler',
            'text_singkat' => 'Mengelola ekstrakulikuler yang diikuti siswa!',
            's_idKelas' => '',
            'kelasName' => '',
            // 'periode' => $periodeGuru
        ]);
    }

    public function getEkstraSiswa(Request $request)
    {
        $pegawai = Auth::user()->pegawai->idPegawai;
        $periode = $request->periode;
        $ekskul = $request->ekskul;
        $kelas = Kelas::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode ?? '')
            ->first();

        $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelas, $periode) {
            $query->where('namaKelas', $kelas->namaKelas)
                ->where('idPeriode', $periode);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();

        $ekstra = KegEkstra::select('idKegiatan', 'idEks', 'deskripsi', 'idSiswa')
            ->where('idPeriode', $periode)
            ->where('idKelas', $kelas->idKelas)
            ->whereHas('ekstra', function ($query) use ($ekskul) {
                $query->where('status', $ekskul);
            })
            ->orderBy('idEks', 'asc')
            ->get();

        $eks = Ekstrakulikuler::all();

        return response()->json([
            'siswa' => $siswaWithKelas,
            'ekstra' => $ekstra,
            'kelas' => $kelas,
            'ekskul' => $eks,
        ]);
    }

    public function storeData(Request $request)
    {
        try {
            $idSiswa = $request->input('idSiswa');
            $idPeriode = $request->input('idPeriode');
            $idKelas = $request->input('idKelas');
            $ekstrakulikuler = $request->input('eksid');

            // Loop melalui setiap ekstrakurikuler untuk menyimpan atau memperbarui
            foreach ($ekstrakulikuler as $ekstra) {
                $desk = $request->input('ekstra_' . $ekstra);
                if (!empty($desk)) {
                    $eks = KegEkstra::firstOrNew([
                        'idSiswa' => $idSiswa,
                        'idPeriode' => $idPeriode,
                        'idKelas' => $idKelas,
                        'idEks' => $ekstra
                    ]);

                    $eks->deskripsi = $desk;
                    $eks->save();
                    # code...
                }
                // else {
                //     $eks = KegEkstra::where('idSiswa', $idSiswa)
                //         ->where('idPeriode', $idPeriode)
                //         ->where('idKelas', $idKelas)
                //         ->where('idEks', $ekstra)
                //         ->first();

                //     $eks->delete();
                //     # code...
                // }
            }

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Data ekstrakulikuler siswa berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $eks = KegEkstra::find($id);

        if ($eks) {
            $eks->delete();
        }

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
