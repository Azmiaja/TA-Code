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
use App\Models\Mapel;
use App\Models\TP_sumatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
{
    // Index Penilaian
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

        return view('siakad/content/penilaian/index', compact('periodeAktif', 'periodeLewat', 'periode'), [
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

        $sm_TP = TP_sumatif::where('idMapel', $mapel)->where('kelas', $kelasNama)->orderBy('kodeTP', 'asc')->get();
        $sm_LM = LM_sumatif::where('idMapel', $mapel)->where('kelas', $kelasNama)->orderBy('kodeLM', 'asc')->get();

        $nilai = Nilai::where('idPeriode', $periodeSiswa)
            ->where('idPengajaran', $pengajaran)
            ->get();

        $mapelNilai = Mapel::where('idMapel', $mapel)->value('namaMapel');

        $nilai_tp = Nilai_TP::where('idPeriode', $periodeSiswa)
            ->where('idPengajaran', $pengajaran)
            ->where('mapel', $mapelNilai)
            ->get();
        // $nilai_akhir_tp = NA_TP::where('idPeriode', $periodeSiswa)
        //     ->where('idPengajaran', $pengajaran)
        //     ->get();

        $nilai_lm = Nilai_LM::where('idPeriode', $periodeSiswa)
            ->where('idPengajaran', $pengajaran)
            ->where('mapel', $mapelNilai)
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
                $rules['nilai_tp_' . $siswa] = 'nullable|numeric|max:100|min:0'; // Sesuaikan dengan aturan validasi yang Anda perlukan
            }
            $validator = Validator::make($request->all(), $rules, [
                'nilai_tp_*.numeric' => 'Nilai harus berupa angka',
                'nilai_tp_*.max' => 'Nilai tidak boleh melebihi 100',
                'nilai_tp_*.min' => 'Nilai minimum adalah 0',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $idSiswa = $request->input('idSiswa');
                $idPeriode = $request->input('idPeriode');
                $idPengajar = $request->input('idPengajaran');
                $kode = $request->input('kodeTP');
                $mapel = $request->input('mapel');
                $deskrip = $request->input('deskripsiTP');

                foreach ($idSiswa as $data) {
                    $nilai_tp = $request->input('nilai_tp_' . $data);
                    if ($nilai_tp !== null) {
                        $nilai = Nilai_TP::firstOrNew([
                            'idSiswa' => $data,
                            'idPeriode' => $idPeriode,
                            'idPengajaran' => $idPengajar,
                            'kodeTP' => $kode,
                            'mapel' => $mapel,
                            // 'deskripsiTP' => $deskrip,
                        ]);

                        $nilai->nilaiTP = $nilai_tp;
                        $nilai->deskripsiTP = $deskrip;
                        $nilai->save();

                        $jumlahTP = Nilai_TP::where('idSiswa', $data)
                            ->where('idPeriode', $idPeriode)
                            ->where('idPengajaran', $idPengajar)
                            // ->where('idTP', $idTP)
                            ->avg('nilaiTP');

                        // Update atau buat instance jumlahTP
                        Nilai::updateOrCreate([
                            'idSiswa' => $data,
                            'idPeriode' => $idPeriode,
                            'idPengajaran' => $idPengajar,
                            // 'idTP' => $idTP,
                        ], [
                            'nilaiAkhirTP' => round($jumlahTP, 2),
                        ]);
                        $this->hitungRaport($data, $idPeriode, $idPengajar);
                        $this->capaianSiswaMin($data, $idPeriode, $idPengajar, $mapel);
                        $this->capaianSiswaMax($data, $idPeriode, $idPengajar, $mapel);
                    }
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

    // hitung raport
    protected function hitungRaport($data, $idPeriode, $idPengajar)
    {

        $raport = Nilai::where('idSiswa', $data)
            ->where('idPeriode', $idPeriode)
            ->where('idPengajaran', $idPengajar)
            ->select(DB::raw('ROUND(
            CASE
                WHEN nilaiAkhirTP IS NOT NULL AND nilaiAkhirLM IS NULL AND jumSAkhir IS NULL THEN nilaiAkhirTP
                WHEN nilaiAkhirLM IS NOT NULL AND nilaiAkhirTP IS NULL AND jumSAkhir IS NULL THEN nilaiAkhirLM
                WHEN nilaiAkhirTP IS NOT NULL AND nilaiAkhirLM IS NOT NULL AND jumSAkhir IS NULL THEN (nilaiAkhirTP + nilaiAkhirLM)/2
                WHEN jumSAkhir IS NOT NULL AND nilaiAkhirTP IS NULL AND nilaiAkhirLM IS NULL THEN jumSAkhir
                WHEN nilaiAkhirTP IS NOT NULL AND nilaiAkhirLM IS NULL AND jumSAkhir IS NOT NULL THEN
                    (nilaiAkhirTP + COALESCE(jumSAkhir, 0)) / 2
                WHEN nilaiAkhirLM IS NOT NULL AND nilaiAkhirTP IS NULL AND jumSAkhir IS NOT NULL THEN
                    (nilaiAkhirLM + COALESCE(jumSAkhir, 0)) / 2
                ELSE ((COALESCE(jumSAkhir, 0) * 2) + COALESCE(nilaiAkhirTP, 0) + COALESCE(nilaiAkhirLM, 0)) / 4
            END) AS raport'))
            ->first()->raport;

        // Update nilai rapor
        Nilai::updateOrCreate([
            'idSiswa' => $data,
            'idPeriode' => $idPeriode,
            'idPengajaran' => $idPengajar,
            // 'idTP' => $idTP,
        ], [
            'raport' => $raport
        ]);
    }

    // ambil deskripsi capaian
    protected function capaianSiswaMin($data, $idPeriode, $idPengajar, $mapel)
    {
        $nilai_tp = Nilai_TP::where('idSiswa', $data)
            ->where('idPeriode', $idPeriode)
            ->where('idPengajaran', $idPengajar)
            ->where('mapel', $mapel);

        $minTP = $nilai_tp->min('nilaiTP');
        $desMin = $nilai_tp->where('nilaiTP', 'LIKE', $minTP)->first();

        $minTPBlt = round($minTP);

        switch (true) {
            case ($minTPBlt >= 88 && $minTPBlt <= 100):
                $deskripsi_predikat_R = "Menunjukkan penguasaan yang sangat baik dalam ";
                break;
            case ($minTPBlt >= 74 && $minTPBlt <= 87):
                $deskripsi_predikat_R = "Menunjukkan penguasaan yang cukup dalam ";
                break;
            case ($minTPBlt >= 60 && $minTPBlt <= 73):
                $deskripsi_predikat_R = "Menunjukkan penguasaan yang cukup dalam ";
                break;
            case ($minTPBlt >= 0 && $minTPBlt <= 59):
                $deskripsi_predikat_R = "Perlu bimbingan dalam ";
                break;
            default:
                $deskripsi_predikat_R = "";
                break;
        }

        $nTP = Nilai::where('idSiswa', $data)
            ->where('idPeriode', $idPeriode)
            ->where('idPengajaran', $idPengajar)
            ->value('nilaiAkhirTP');

        if ($nTP !== null) {
            Nilai::updateOrCreate([
                'idSiswa' => $data,
                'idPeriode' => $idPeriode,
                'idPengajaran' => $idPengajar,
                // 'idTP' => $idTP,
            ], [
                // 'deskripsiCPtinggi' => $deskripsi_predikat . $desMax->deskripsiTP,
                'deskripsiCPrendah' => $deskripsi_predikat_R . $desMin->deskripsiTP,
            ]);
        } else {
            Nilai::updateOrCreate([
                'idSiswa' => $data,
                'idPeriode' => $idPeriode,
                'idPengajaran' => $idPengajar,
                // 'idTP' => $idTP,
            ], [
                // 'deskripsiCPtinggi' => null,
                'deskripsiCPrendah' => null,
            ]);
        }
    }

    // capaian maksimum
    protected function capaianSiswaMax($data, $idPeriode, $idPengajar, $mapel)
    {
        $nilai_tp = Nilai_TP::where('idSiswa', $data)
            ->where('idPeriode', $idPeriode)
            ->where('idPengajaran', $idPengajar)
            ->where('mapel', $mapel);

        // $maxTP = (float) $nilai_tp->max('nilaiTP');
        $maxTP = $nilai_tp->max('nilaiTP');
        $maxTPBlt = round($maxTP);
        $desMax = $nilai_tp->where('nilaiTP', 'LIKE', $maxTP)->first();

        switch (true) {
            case ($maxTPBlt >= 88 && $maxTPBlt <= 100):
                $deskripsi_predikat = "Menunjukkan penguasaan yang sangat baik dalam ";
                break;
            case ($maxTPBlt >= 74 && $maxTPBlt <= 87):
                $deskripsi_predikat = "Menunjukkan penguasaan yang cukup dalam ";
                break;
            case ($maxTPBlt >= 60 && $maxTPBlt <= 73):
                $deskripsi_predikat = "Menunjukkan penguasaan yang cukup dalam ";
                break;
            case ($maxTPBlt >= 0 && $maxTPBlt <= 59):
                $deskripsi_predikat = "Perlu bimbingan ";
                break;
            default:
                $deskripsi_predikat = "";
                break;
        }

        $nTP = Nilai::where('idSiswa', $data)
            ->where('idPeriode', $idPeriode)
            ->where('idPengajaran', $idPengajar)
            ->value('nilaiAkhirTP');

        if ($nTP !== null) {
            Nilai::updateOrCreate([
                'idSiswa' => $data,
                'idPeriode' => $idPeriode,
                'idPengajaran' => $idPengajar,
                // 'idTP' => $idTP,
            ], [
                'deskripsiCPtinggi' => $deskripsi_predikat . $desMax->deskripsiTP,
                // 'deskripsiCPrendah' => $deskripsi_predikat_R . $desMin->deskripsiTP, 
            ]);
        } else {
            Nilai::updateOrCreate([
                'idSiswa' => $data,
                'idPeriode' => $idPeriode,
                'idPengajaran' => $idPengajar,
                // 'idTP' => $idTP,
            ], [
                'deskripsiCPtinggi' => null,
                // 'deskripsiCPrendah' => null,
            ]);
        }
    }

    public function storeNilaiLM(Request $request)
    {
        try {
            $rules = [];
            $idSiswa = $request->input('idSiswa');

            foreach ($idSiswa as $siswa) {
                $rules['nilai_lm_' . $siswa] = 'nullable|numeric|max:100|min:0'; // Sesuaikan dengan aturan validasi yang Anda perlukan
            }
            $validator = Validator::make($request->all(), $rules, [
                'nilai_lm_*.numeric' => 'Nilai harus berupa angka',
                'nilai_lm_*.max' => 'Nilai tidak boleh melebihi 100',
                'nilai_lm_*.min' => 'Nilai minimum adalah 0',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $idSiswa = $request->input('idSiswa');
                $idPeriode = $request->input('idPeriode');
                $idPengajar = $request->input('idPengajaran');
                $kode = $request->input('kodeLM');
                $mapel = $request->input('mapel');
                $deskrip = $request->input('deskripsiLM');

                foreach ($idSiswa as $data) {
                    $nilai_lm = $request->input('nilai_lm_' . $data);
                    if ($nilai_lm !== null) {
                        $nilai = Nilai_LM::firstOrNew([
                            'idSiswa' => $data,
                            'idPeriode' => $idPeriode,
                            'idPengajaran' => $idPengajar,
                            'kodeLM' => $kode,
                            'mapel' => $mapel,
                            // 'deskripsiLM' => $deskrip,
                        ]);
    
                        $nilai->nilaiLM = $nilai_lm;
                        $nilai->deskripsiLM = $deskrip;
                        $nilai->save();
    
                        $jumlahLM = Nilai_LM::where('idSiswa', $data)
                            ->where('idPeriode', $idPeriode)
                            ->where('idPengajaran', $idPengajar)
                            // ->where('idLM', $idLM)
                            ->avg('nilaiLM');
    
                        // Update atau buat instance jumlahLM
                        Nilai::updateOrCreate([
                            'idSiswa' => $data,
                            'idPeriode' => $idPeriode,
                            'idPengajaran' => $idPengajar,
                            // 'idLM' => $idLM,
                        ], [
                            'nilaiAkhirLM' => $jumlahLM,
                        ]);
    
                        $this->hitungRaport($data, $idPeriode, $idPengajar);
                    }
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
                $rules['nilai_akhir_nontes_' . $siswa] = 'nullable|numeric|max:100|min:0'; // Sesuaikan dengan aturan validasi yang Anda perlukan
            }
            $validator = Validator::make($request->all(), $rules, [
                'nilai_akhir_nontes_*.numeric' => 'Nilai harus berupa angka',
                'nilai_akhir_nontes_*.max' => 'Nilai tidak boleh melebihi 100',
                'nilai_akhir_nontes_*.min' => 'Nilai minimum adalah 0',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $idSiswa = $request->input('idSiswa');
                $idPeriode = $request->input('idPeriode');
                $idPengajar = $request->input('idPengajaran');

                foreach ($idSiswa as $data) {
                    $nilaiNontes = $request->input('nilai_akhir_nontes_' . $data);
                    if ($nilaiNontes !== null) {
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
                        // Update atau buat instance jumSAkhir
                        Nilai::updateOrCreate(
                            [
                                'idSiswa' => $data,
                                'idPeriode' => $idPeriode,
                                'idPengajaran' => $idPengajar,
                            ],
                            [
                                'jumSAkhir' => $nilaiRata,
                            ]
                        );
    
                        $this->hitungRaport($data, $idPeriode, $idPengajar);
                    }
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
                $rules['nilai_akhir_tes_' . $siswa] = 'nullable|numeric|max:100|min:0'; // Sesuaikan dengan aturan validasi yang Anda perlukan
            }
            $validator = Validator::make($request->all(), $rules, [
                'nilai_akhir_tes_*.numeric' => 'Nilai harus berupa angka',
                'nilai_akhir_tes_*.max' => 'Nilai tidak boleh melebihi 100',
                'nilai_akhir_tes_*.min' => 'Nilai minimum adalah 0',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $idSiswa = $request->input('idSiswa');
                $idPeriode = $request->input('idPeriode');
                $idPengajar = $request->input('idPengajaran');

                foreach ($idSiswa as $data) {
                    $nilaiTes = $request->input('nilai_akhir_tes_' . $data);
                    if ($nilaiTes !== null) {
                        
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
                        // Update atau buat instance jumSAkhir
                        Nilai::updateOrCreate(
                            [
                                'idSiswa' => $data,
                                'idPeriode' => $idPeriode,
                                'idPengajaran' => $idPengajar,
                            ],
                            [
                                'jumSAkhir' => $nilaiRata,
                            ]
                        );
    
                        $this->hitungRaport($data, $idPeriode, $idPengajar);
                    }
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

    public function deleteTP($id)
    {
        try {
            $idNilaiTP = array_map(function ($value) {
                return (int) trim($value);
            }, explode(',', $id));

            foreach ($idNilaiTP as $key) {
                $tp = Nilai_TP::where('idNilaiTP', $key)->first();
                if ($tp) {
                    $tp->delete();
                    $jumlahTP = Nilai_TP::where('idSiswa', $tp->idSiswa)
                        ->where('idPeriode', $tp->idPeriode)
                        ->where('idPengajaran', $tp->idPengajaran)
                        // ->where('idTP', $idTP)
                        ->avg('nilaiTP');

                    // Update atau buat instance jumlahTP
                    Nilai::updateOrCreate([
                        'idSiswa' => $tp->idSiswa,
                        'idPeriode' => $tp->idPeriode,
                        'idPengajaran' => $tp->idPengajaran,
                        // 'idTP' => $idTP,
                    ], [
                        'nilaiAkhirTP' => $jumlahTP,
                    ]);

                    $this->hitungRaport($tp->idSiswa, $tp->idPeriode, $tp->idPengajaran);
                    $this->capaianSiswaMin($tp->idSiswa, $tp->idPeriode, $tp->idPengajaran, $tp->mapel);
                    $this->capaianSiswaMax($tp->idSiswa, $tp->idPeriode, $tp->idPengajaran, $tp->mapel);


                }
            }

            // $tp->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Dihapus!',
                'message' => 'Data penilaian TP berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    public function deleteLM($id)
    {
        try {
            $idNilaiLM = array_map(function ($value) {
                return (int) trim($value);
            }, explode(',', $id));

            foreach ($idNilaiLM as $key) {
                $tp = Nilai_LM::where('idNilaiLM', $key)->first();
                if ($tp) {
                    $tp->delete();
                    $jumlahTP = Nilai_LM::where('idSiswa', $tp->idSiswa)
                        ->where('idPeriode', $tp->idPeriode)
                        ->where('idPengajaran', $tp->idPengajaran)
                        // ->where('idTP', $idTP)
                        ->avg('nilaiLM');
    
                    // Update atau buat instance jumlahTP
                    Nilai::updateOrCreate([
                        'idSiswa' => $tp->idSiswa,
                        'idPeriode' => $tp->idPeriode,
                        'idPengajaran' => $tp->idPengajaran,
                        // 'idTP' => $idTP,
                    ], [
                        'nilaiAkhirLM' => $jumlahTP,
                    ]);
    
                    $this->hitungRaport($tp->idSiswa, $tp->idPeriode, $tp->idPengajaran);
                }

            }

            // $tp->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Dihapus!',
                'message' => 'Data penilaian LM berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }
    public function deleteNTes($id)
    {
        try {
            $idNilai = array_map(function ($value) {
                return (int) trim($value);
            }, explode(',', $id));

            foreach ($idNilai as $key) {
                $tp = Nilai::where('idNilai', $key)->first();
                if ($tp) {
                    $tp->update([
                        'nilaiNtes' => null,
                    ]);
                    $nilaiRata = Nilai::where('idSiswa', $tp->idSiswa)
                        ->where('idPeriode', $tp->idPeriode)
                        ->where('idPengajaran', $tp->idPengajaran)
                        ->select(DB::raw('SUM(CASE
                            WHEN nilaiNtes IS NULL THEN nilaiTes
                            WHEN nilaiTes IS NULL THEN nilaiNtes
                            ELSE (nilaiNtes + nilaiTes) / 2
                            END) AS jumlah_a'))
                        ->get()->first()->jumlah_a;
                    // Update atau buat instance jumSAkhir
                    Nilai::updateOrCreate(
                        [
                            'idSiswa' => $tp->idSiswa,
                            'idPeriode' => $tp->idPeriode,
                            'idPengajaran' => $tp->idPengajaran,
                        ],
                        [
                            'jumSAkhir' => $nilaiRata,
                        ]
                    );
    
                    $this->hitungRaport($tp->idSiswa, $tp->idPeriode, $tp->idPengajaran);
                }

            }
            // $tp->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Dihapus!',
                'message' => 'Data penilaian Non Tes berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    public function deleteTes($id)
    {
        try {
            $idNilai = array_map(function ($value) {
                return (int) trim($value);
            }, explode(',', $id));

            foreach ($idNilai as $key) {
                $tp = Nilai::where('idNilai', $key)->first();
                if ($tp) {
                    $tp->update([
                        'nilaiTes' => null,
                    ]);
                    $nilaiRata = Nilai::where('idSiswa', $tp->idSiswa)
                        ->where('idPeriode', $tp->idPeriode)
                        ->where('idPengajaran', $tp->idPengajaran)
                        ->select(DB::raw('SUM(CASE
                            WHEN nilaiNtes IS NULL THEN nilaiTes
                            WHEN nilaiTes IS NULL THEN nilaiNtes
                            ELSE (nilaiNtes + nilaiTes) / 2
                            END) AS jumlah_a'))
                        ->get()->first()->jumlah_a;
                    // Update atau buat instance jumSAkhir
                    Nilai::updateOrCreate(
                        [
                            'idSiswa' => $tp->idSiswa,
                            'idPeriode' => $tp->idPeriode,
                            'idPengajaran' => $tp->idPengajaran,
                        ],
                        [
                            'jumSAkhir' => $nilaiRata,
                        ]
                    );
    
                    $this->hitungRaport($tp->idSiswa, $tp->idPeriode, $tp->idPengajaran);
                }

            }
            // $tp->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Dihapus!',
                'message' => 'Data penilaian Tes berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }
}
