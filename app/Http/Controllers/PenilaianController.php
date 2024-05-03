<?php

namespace App\Http\Controllers;

use App\Models\LM_sumatif;
use App\Models\NA_LM;
use App\Models\NA_TP;
use App\Models\Nilai;
use App\Models\Nilai_LM;
use App\Models\Nilai_TP;
use App\Models\Pengajaran;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\TP_sumatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
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

        return view('siakad/content/penilaian/index', compact('periodeAktif', 'periodeLewat'), [
            'judul' => 'Penilaian Siswa',
            'sub_judul' => 'Nilai Siswa',
            'text_singkat' => 'Mengelola nilai siswa untuk setiap mata pelajaran!',
            's_idKelas' => '',
            'kelasName' => '',
            // 'periode' => $periodeGuru
        ]);
    }

    public function getMapelGuru(Request $request)
    {
        $kelas = $request->kelas;
        $pegawai = Auth::user()->pegawai->idPegawai;
        $periode = $request->periode;
        $data = Pengajaran::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode)
            ->whereHas('kelas', function ($query) use ($kelas) {
                $query->where('namaKelas', $kelas);
            })
            // ->select('idKelas')
            ->with('mapel')
            ->distinct()
            ->get();

        return response()->json(['mapel' => $data]);
    }

    public function getKelasGuru(Request $request)
    {
        $pegawai = Auth::user()->pegawai->idPegawai;
        $periode = $request->periode;

        $klsPengajaran = Pengajaran::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode)
            ->whereHas('kelas', function ($query) {
                $query->orderBy('namaKelas', 'asc');
            })
            // ->with('guru')
            ->select('idKelas')
            ->with('kelas')
            ->distinct()
            ->get();

        return response()->json($klsPengajaran);
    }

    public function getPenilaian(Request $request)
    {

        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->first();
        $kelasNama = $request->kelas;
        $mapel = $request->mapel;
        $periodeSiswa = $request->periode;
        $pengajaran = $request->pengajaran;

        // Ambil siswa dengan kelas dan periode yang sesuai
        $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelasNama, $periodeSiswa) {
            $query->where('namaKelas', $kelasNama)
                ->where('idPeriode', $periodeSiswa);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();

        $sm_TP = TP_sumatif::where('idMapel', $mapel)->where('kelas', $kelasNama)->get();
        $sm_LM = LM_sumatif::where('idMapel', $mapel)->where('kelas', $kelasNama)->get();

        $nilai = Nilai::where('idPeriode', $periodeSiswa)
            ->where('idPengajaran', $pengajaran)
            ->get();

        $nilai_tp = Nilai_TP::where('idPeriode', $periodeSiswa)
            ->where('idPengajaran', $pengajaran)
            ->get();
        // $nilai_akhir_tp = NA_TP::where('idPeriode', $periodeSiswa)
        //     ->where('idPengajaran', $pengajaran)
        //     ->get();

        $nilai_lm = Nilai_LM::where('idPeriode', $periodeSiswa)
            ->where('idPengajaran', $pengajaran)
            ->get();

        // $nilai_akhir_lm = NA_LM::where('idPeriode', $periodeSiswa)
        //     ->where('idPengajaran', $pengajaran)
        //     ->get();

        return response()->json(
            [
                'siswa' => $siswaWithKelas,
                'tp' => $sm_TP,
                'lm' => $sm_LM,
                'nilai' => $nilai,
                'nilai_tp' => $nilai_tp,
                'nilai_lm' => $nilai_lm,
                // 'na_tp' => $nilai_akhir_tp,
                // 'na_lm' => $nilai_akhir_lm,
            ]
        );
    }

    public function storeNilaiTP(Request $request)
    {
        try {
            $rules = [];
            $idSiswa = $request->input('idSiswa');

            foreach ($idSiswa as $siswa) {
                $rules['nilai_tp_' . $siswa] = 'nullable|numeric|max:100'; // Sesuaikan dengan aturan validasi yang Anda perlukan
            }
            $validator = Validator::make($request->all(), $rules, [
                'nilai_tp_*.numeric' => 'Nilai harus berupa angka',
                'nilai_tp_*.max' => 'Nilai tidak boleh melebihi 100',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $idSiswa = $request->input('idSiswa');
                $idPeriode = $request->input('idPeriode');
                $idPengajar = $request->input('idPengajaran');
                $idTP = $request->input('idTP');

                foreach ($idSiswa as $data) {
                    $nilai_tp = $request->input('nilai_tp_' . $data);
                    $nilai = Nilai_TP::firstOrNew([
                        'idSiswa' => $data,
                        'idPeriode' => $idPeriode,
                        'idPengajaran' => $idPengajar,
                        'idTP' => $idTP,
                    ]);

                    $nilai->nilaiTP = $nilai_tp;
                    $nilai->save();

                    $jumlahTP = Nilai_TP::where('idSiswa', $data)
                        ->where('idPeriode', $idPeriode)
                        ->where('idPengajaran', $idPengajar)
                        // ->where('idTP', $idTP)
                        ->avg('nilaiTP');

                    $raport = Nilai::where('idSiswa', $data)
                        ->where('idPeriode', $idPeriode)
                        ->where('idPengajaran', $idPengajar)
                        ->select(DB::raw('ROUND(SUM(CASE
                            WHEN nilaiAkhirTP IS NULL THEN COALESCE(nilaiAkhirLM + (COALESCE(jumSAkhir, 0) * 2))/2
                            WHEN nilaiAkhirLM IS NULL THEN COALESCE(nilaiAkhirTP + (COALESCE(jumSAkhir, 0) * 2))/2
                            WHEN jumSAkhir IS NULL THEN COALESCE(nilaiAkhirTP + nilaiAkhirLM)/2
                            ELSE ((COALESCE(jumSAkhir, 0) * 2) + COALESCE(nilaiAkhirTP, 0) + COALESCE(nilaiAkhirLM, 0)) / 4
                            END)) AS jumlah_a'))
                        ->get()->first()->jumlah_a;

                    // Update atau buat instance jumlahTP
                    Nilai::updateOrCreate([
                        'idSiswa' => $data,
                        'idPeriode' => $idPeriode,
                        'idPengajaran' => $idPengajar,
                        // 'idTP' => $idTP,
                    ], [
                        'nilaiAkhirTP' => $jumlahTP,
                        'raport' => $raport
                    ]);
                }

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Data nilai siswa berhasil disimpan.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    public function storeNilaiLM(Request $request)
    {
        try {
            $rules = [];
            $idSiswa = $request->input('idSiswa');

            foreach ($idSiswa as $siswa) {
                $rules['nilai_lm_' . $siswa] = 'nullable|numeric|max:100'; // Sesuaikan dengan aturan validasi yang Anda perlukan
            }
            $validator = Validator::make($request->all(), $rules, [
                'nilai_lm_*.numeric' => 'Nilai harus berupa angka',
                'nilai_lm_*.max' => 'Nilai tidak boleh melebihi 100',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $idSiswa = $request->input('idSiswa');
                $idPeriode = $request->input('idPeriode');
                $idPengajar = $request->input('idPengajaran');
                $idLM = $request->input('idLM');

                foreach ($idSiswa as $data) {
                    $nilai_lm = $request->input('nilai_lm_' . $data);
                    $nilai = Nilai_LM::firstOrNew([
                        'idSiswa' => $data,
                        'idPeriode' => $idPeriode,
                        'idPengajaran' => $idPengajar,
                        'idLM' => $idLM,
                    ]);

                    $nilai->nilaiLM = $nilai_lm;
                    $nilai->save();

                    $jumlahLM = Nilai_LM::where('idSiswa', $data)
                        ->where('idPeriode', $idPeriode)
                        ->where('idPengajaran', $idPengajar)
                        // ->where('idLM', $idLM)
                        ->avg('nilaiLM');

                    $raport = Nilai::where('idSiswa', $data)
                        ->where('idPeriode', $idPeriode)
                        ->where('idPengajaran', $idPengajar)
                        ->select(DB::raw('ROUND(SUM(CASE
                            WHEN nilaiAkhirTP IS NULL THEN COALESCE(nilaiAkhirLM + (COALESCE(jumSAkhir, 0) * 2))/2
                            WHEN nilaiAkhirLM IS NULL THEN COALESCE(nilaiAkhirTP + (COALESCE(jumSAkhir, 0) * 2))/2
                            WHEN jumSAkhir IS NULL THEN COALESCE(nilaiAkhirTP + nilaiAkhirLM)/2
                            ELSE ((COALESCE(jumSAkhir, 0) * 2) + COALESCE(nilaiAkhirTP, 0) + COALESCE(nilaiAkhirLM, 0)) / 4
                            END)) AS jumlah_a'))
                        ->get()->first()->jumlah_a;
                    // Update atau buat instance jumlahLM
                    Nilai::updateOrCreate([
                        'idSiswa' => $data,
                        'idPeriode' => $idPeriode,
                        'idPengajaran' => $idPengajar,
                        // 'idLM' => $idLM,
                    ], [
                        'nilaiAkhirLM' => $jumlahLM,
                        'raport' => $raport
                    ]);
                }

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Data nilai siswa berhasil disimpan.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    public function storeNANonTes(Request $request)
    {
        try {
            $rules = [];
            $idSiswa = $request->input('idSiswa');

            foreach ($idSiswa as $siswa) {
                $rules['nilai_akhir_nontes_' . $siswa] = 'nullable|numeric|max:100'; // Sesuaikan dengan aturan validasi yang Anda perlukan
            }
            $validator = Validator::make($request->all(), $rules, [
                'nilai_akhir_nontes_*.numeric' => 'Nilai harus berupa angka',
                'nilai_akhir_nontes_*.max' => 'Nilai tidak boleh melebihi 100',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $idSiswa = $request->input('idSiswa');
                $idPeriode = $request->input('idPeriode');
                $idPengajar = $request->input('idPengajaran');

                foreach ($idSiswa as $data) {
                    $nilaiNontes = $request->input('nilai_akhir_nontes_' . $data);
                    $nilai = Nilai::firstOrNew([
                        'idSiswa' => $data,
                        'idPeriode' => $idPeriode,
                        'idPengajaran' => $idPengajar,
                    ]);

                    $nilai->nilaiNtes = $nilaiNontes;
                    $nilai->save();

                    // Hitung nilai rata-rata
                    $nilaiRata = Nilai::where('idSiswa', $data)
                        ->where('idPeriode', $idPeriode)
                        ->where('idPengajaran', $idPengajar)
                        ->select(DB::raw('SUM(CASE
                        WHEN nilaiNtes IS NULL THEN nilaiTes
                        WHEN nilaiTes IS NULL THEN nilaiNtes
                        ELSE (nilaiNtes + nilaiTes) / 2
                    END) AS jumlah_a'))
                        ->get()->first()->jumlah_a;

                    $raport = Nilai::where('idSiswa', $data)
                        ->where('idPeriode', $idPeriode)
                        ->where('idPengajaran', $idPengajar)
                        ->select(DB::raw('ROUND(SUM(CASE
                            WHEN nilaiAkhirTP IS NULL THEN COALESCE(nilaiAkhirLM + (COALESCE(jumSAkhir, 0) * 2))/2
                            WHEN nilaiAkhirLM IS NULL THEN COALESCE(nilaiAkhirTP + (COALESCE(jumSAkhir, 0) * 2))/2
                            WHEN jumSAkhir IS NULL THEN COALESCE(nilaiAkhirTP + nilaiAkhirLM)/2
                            ELSE ((COALESCE(jumSAkhir, 0) * 2) + COALESCE(nilaiAkhirTP, 0) + COALESCE(nilaiAkhirLM, 0)) / 4
                            END)) AS jumlah_a'))
                        ->get()->first()->jumlah_a;

                    // Update atau buat instance jumSAkhir
                    $jumlah = Nilai::updateOrCreate(
                        [
                            'idSiswa' => $data,
                            'idPeriode' => $idPeriode,
                            'idPengajaran' => $idPengajar,
                        ],
                        [
                            'jumSAkhir' => $nilaiRata,
                            'raport' => $raport
                        ]
                    );
                }

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Data nilai siswa berhasil disimpan.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    public function storeNATes(Request $request)
    {
        try {
            $rules = [];
            $idSiswa = $request->input('idSiswa');

            foreach ($idSiswa as $siswa) {
                $rules['nilai_akhir_tes_' . $siswa] = 'nullable|numeric|max:100'; // Sesuaikan dengan aturan validasi yang Anda perlukan
            }
            $validator = Validator::make($request->all(), $rules, [
                'nilai_akhir_tes_*.numeric' => 'Nilai harus berupa angka',
                'nilai_akhir_tes_*.max' => 'Nilai tidak boleh melebihi 100',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $idSiswa = $request->input('idSiswa');
                $idPeriode = $request->input('idPeriode');
                $idPengajar = $request->input('idPengajaran');

                foreach ($idSiswa as $data) {
                    $nilaiTes = $request->input('nilai_akhir_tes_' . $data);
                    $nilai = Nilai::firstOrNew([
                        'idSiswa' => $data,
                        'idPeriode' => $idPeriode,
                        'idPengajaran' => $idPengajar,
                    ]);

                    $nilai->nilaiTes = $nilaiTes;
                    $nilai->save();
                    // Hitung nilai rata-rata
                    $nilaiRata = Nilai::where('idSiswa', $data)
                        ->where('idPeriode', $idPeriode)
                        ->where('idPengajaran', $idPengajar)
                        ->select(DB::raw('SUM(CASE
                        WHEN nilaiNtes IS NULL THEN nilaiTes
                        WHEN nilaiTes IS NULL THEN nilaiNtes
                        ELSE (nilaiNtes + nilaiTes) / 2
                        END) AS jumlah_a'))
                        ->get()->first()->jumlah_a;

                    $raport = Nilai::where('idSiswa', $data)
                        ->where('idPeriode', $idPeriode)
                        ->where('idPengajaran', $idPengajar)
                        ->select(DB::raw('ROUND(SUM(CASE
                            WHEN nilaiAkhirTP IS NULL THEN COALESCE(nilaiAkhirLM + (COALESCE(jumSAkhir, 0) * 2))/2
                            WHEN nilaiAkhirLM IS NULL THEN COALESCE(nilaiAkhirTP + (COALESCE(jumSAkhir, 0) * 2))/2
                            WHEN jumSAkhir IS NULL THEN COALESCE(nilaiAkhirTP + nilaiAkhirLM)/2
                            ELSE ((COALESCE(jumSAkhir, 0) * 2) + COALESCE(nilaiAkhirTP, 0) + COALESCE(nilaiAkhirLM, 0)) / 4
                            END)) AS jumlah_a'))
                        ->get()->first()->jumlah_a;

                    // Update atau buat instance jumSAkhir
                    $jumlah = Nilai::updateOrCreate(
                        [
                            'idSiswa' => $data,
                            'idPeriode' => $idPeriode,
                            'idPengajaran' => $idPengajar,
                        ],
                        [
                            'jumSAkhir' => $nilaiRata,
                            'raport' => $raport
                        ]
                    );
                }

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Data nilai siswa berhasil disimpan.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }
}
