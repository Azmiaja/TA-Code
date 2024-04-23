<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Absensi as ModelsAbsensi;
use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\Pengajaran;
use App\Models\Periode;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Absensi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->first();
        $kelasNama = $name;
        $periodeSiswa = $periode->idPeriode;

        // Ambil siswa dengan kelas dan periode yang sesuai
        $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelasNama, $periodeSiswa) {
            $query->where('namaKelas', $kelasNama)
                ->where('idPeriode', $periodeSiswa);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();


        $pegawai = Auth::user()->pegawai->idPegawai;
        $kelas = Kelas::where('idPegawai', $pegawai)->where('idPeriode', $periode->idPeriode)->get();


        $data = Pengajaran::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode->idPeriode)
            ->whereHas('kelas', function ($query) use ($name) {
                $query->where('namaKelas', $name);
            })
            // ->select('idKelas')
            ->distinct()
            ->get();
        $idP = $data[0]->idPengajaran;

        $kehadiran = ModelsAbsensi::select('idSiswa')
            ->selectRaw('DAY(tanggal) as tanggal')
            ->selectRaw('tanggal as bulan')
            ->selectRaw('MONTH(tanggal) as noBulan')
            ->selectRaw("MAX(CASE WHEN presensi = 'hadir' THEN 'H' WHEN presensi = 'izin' THEN 'I' WHEN presensi = 'sakit' THEN 'S' ELSE 'A' END) as presensi")
            ->whereMonth('tanggal', now()->month)
            ->where('idKelas', $data[0]->idKelas)
            ->where('idPeriode', $periode->idPeriode)
            ->groupBy('idSiswa', 'tanggal')
            ->get()->map(function ($item) {
                $item->bulan = Carbon::parse($item->bulan)->translatedFormat('F');
                return $item;
            });

        $kehadiran_2 = ModelsAbsensi::select('idSiswa')
            ->selectRaw('DAY(tanggal) as tanggal')
            ->selectRaw('tanggal as bulan')
            ->selectRaw('MONTH(tanggal) as noBulan')
            ->where('idKelas', $data[0]->idKelas)
            ->where('idPeriode', $periode->idPeriode)
            ->groupBy('idSiswa', 'tanggal')
            ->get()->map(function ($item) {
                $item->bulan = Carbon::parse($item->bulan)->translatedFormat('F');
                return $item;
            });

        $wakel = Pegawai::select('idPegawai')->whereHas('kelas', function ($query) use ($data) {
            $query->where('idKelas', $data[0]->idKelas);
        })->first();

        return view('siakad/content/absen/index', compact('periode', 'kelas', 'data', 'kehadiran', 'siswaWithKelas', 'kehadiran_2', 'wakel'), [
            'judul' => 'Presensi Siswa',
            'sub_judul' => 'Kelas ' . $data[0]->kelas->namaKelas,
            'text_singkat' => 'Mengelola kehadiran siswa dalam kelas!',
            's_idKelas' => $data[0]->idKelas,
            'kelasName' => $name,
        ]);
    }

    public function getData($name)
    {
        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->first();
        $kelasNama = $name;
        $periodeSiswa = $periode->idPeriode;

        // Ambil siswa dengan kelas dan periode yang sesuai
        $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelasNama, $periodeSiswa) {
            $query->where('namaKelas', $kelasNama)
                ->where('idPeriode', $periodeSiswa);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();


        $pegawai = Auth::user()->pegawai->idPegawai;

        $kelas = Kelas::where('idPegawai', $pegawai)->where('idPeriode', $periode->idPeriode)->get();

        $data = Pengajaran::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode->idPeriode)
            ->whereHas('kelas', function ($query) use ($name) {
                $query->where('namaKelas', $name);
            })
            // ->select('idKelas')
            ->distinct()
            ->get();

        $kehadiran = ModelsAbsensi::select('idSiswa')
            ->selectRaw('DAY(tanggal) as tanggal')
            ->selectRaw('tanggal as bulan')
            ->selectRaw('MONTH(tanggal) as noBulan')
            ->selectRaw("MAX(CASE WHEN presensi = 'hadir' THEN 'H' WHEN presensi = 'izin' THEN 'I' WHEN presensi = 'sakit' THEN 'S' ELSE 'A' END) as presensi")
            ->whereMonth('tanggal', now()->month)
            ->where('idKelas', $data[0]->idKelas)
            ->where('idPeriode', $periode->idPeriode)
            ->groupBy('idSiswa', 'tanggal')
            ->get()->map(function ($item) {
                $item->bulan = Carbon::parse($item->bulan)->translatedFormat('F');
                return $item;
            });

        $wakel = Pegawai::select('idPegawai')->whereHas('kelas', function ($query) use ($data) {
            $query->where('idKelas', $data[0]->idKelas);
        })->first();

        return response()->json(
            [
                'periode' => $periode,
                'siswa' => $siswaWithKelas,
                'kelas' => $kelas,
                'kehadiran' => $kehadiran,
                'wakel' => $wakel
            ]
        );
    }

    public function rekapPresensiAdmin()
    {
        $periode = Periode::orderBy('tanggalMulai', 'desc')->get();
        $kepsek = Pegawai::select('namaPegawai', 'nip')->whereHas('jabatanPegawai', function ($query) {
            $query->where('jabatan', 'Kepala Sekolah');
        })->first();
        return view('siakad.content.absen.ssadmin.index_absensi', compact('periode', 'kepsek'), [
            'judul' => 'Akademik',
            'sub_judul' => 'Rekap Kehadiran Siswa',
            'text_singkat' => 'Data ringkasan kehadiran siswa dalam kelas!',
            's_idKelas' => '',
        ]);
    }



    public function getKehadiran($idSiswa, $tgl)
    {
        $kehadiran = ModelsAbsensi::select('idSiswa')
            ->selectRaw('DAY(tanggal) as tanggal')
            ->selectRaw("MAX(CASE WHEN presensi = 'hadir' THEN 'H' WHEN presensi = 'izin' THEN 'I' WHEN presensi = 'sakit' THEN 'S' ELSE 'A' END) as presensi")
            ->whereMonth('tanggal', 4)
            ->groupBy('idSiswa', 'tanggal')
            ->get();
        $presence = $kehadiran
            ->where('idSiswa', $idSiswa)
            ->where('tanggal', $tgl)
            ->first();

        return response()->json($presence);
    }

    public function getTanggalBulan(Request $request, $kelasNama, $periodeSiswa)
    {
        $kelasNama = $kelasNama;
        $periodeSiswa = $periodeSiswa;

        // Ambil siswa dengan kelas dan periode yang sesuai
        $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelasNama, $periodeSiswa) {
            $query->where('namaKelas', $kelasNama)
                ->where('idPeriode', $periodeSiswa);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();

        $data = ModelsAbsensi::orderBy('tanggal', 'asc')->whereMonth('tanggal', now()->month)->where('idKelas', $request->kelas)->get();
        $data = $data->groupBy(function ($tgl) {
            return  Carbon::parse($tgl->tanggal)->format('d');
        })->map(function ($item) {
            $formatedData = [
                'idSiswa' => $item->first()->idSiswa,
            ];

            foreach ($item as $data) {
                $presensi = $data->presensi;
                $formatedData['tanggal'] = Carbon::parse($data->tanggal)->format('d');
                $formatedData['bulan'] = $data->tanggal ? $data->tanggal : '-';
                $formatedData['presensi'] = $presensi ? $presensi : '-';
            }

            return $formatedData;
        });

        $kehadiran = ModelsAbsensi::select('idSiswa')
            ->selectRaw('DAY(tanggal) as tanggal')
            ->selectRaw("MAX(CASE WHEN presensi = 'hadir' THEN 'H' WHEN presensi = 'izin' THEN 'I' WHEN presensi = 'sakit' THEN 'S' ELSE 'A' END) as presensi")
            ->whereMonth('tanggal', now()->month)
            ->groupBy('idSiswa', 'tanggal')
            ->get();

        return response()->json(['absen' => $data, 'siswa' => $siswaWithKelas, 'presensi' => $kehadiran]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Carbon::setLocale('id');

            $validator = Validator::make($request->all(), [
                'tanggal' => 'required'
            ], [
                'tanggal.required' => 'Tanggal tidak boleh kosong!'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {

                $idSiswa = $request->input('idSiswa');
                $idKelas = $request->input('idKelas');
                $idPeriode = $request->input('idPeriode');
                $idPengajar = $request->input('idPengajaran');

                // Simpan data absensi ke dalam basis data
                foreach ($idSiswa as $data) {
                    $presensi = $request->input('presensi_' . $data);
                    $tanggal = Carbon::parse($request->tanggal);
                    ModelsAbsensi::create([
                        'idSiswa' => $data,
                        'idKelas' => $idKelas,
                        'idPeriode' => $idPeriode,
                        'idPengajaran' => $idPengajar,
                        'tanggal' => $tanggal->translatedFormat('Y-m-d'),
                        'presensi' => $presensi,
                        // 'keterangan' => $request->keterangan[$key] ?? null,
                        // Tambahkan kolom lain yang diperlukan
                    ]);
                }

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Data presensi berhasil disimpan.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $kelasNama, $periodeSiswa)
    {
        $kelasNama = $kelasNama;
        $periodeSiswa = $periodeSiswa;

        // Ambil siswa dengan kelas dan periode yang sesuai
        $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelasNama, $periodeSiswa) {
            $query->where('namaKelas', $kelasNama)
                ->where('idPeriode', $periodeSiswa);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();

        $kehadiran = ModelsAbsensi::select('idSiswa')->whereDay('tanggal', $request->input('tanggal'))
            ->selectRaw('DAY(tanggal) as tanggal')
            ->selectRaw('tanggal as tgl')
            ->selectRaw("MAX(CASE WHEN presensi = 'hadir' THEN 'H' WHEN presensi = 'izin' THEN 'I' WHEN presensi = 'sakit' THEN 'S' ELSE 'A' END) as presensi")
            // Filter berdasarkan tanggal yang diberikan
            ->whereMonth('tanggal', $request->input('bulan'))
            ->groupBy('idSiswa', 'tanggal')
            ->get()
            ->map(function ($item) {
                return $item;
            });

        return response()->json(['siswa' => $siswaWithKelas, 'absen' => $kehadiran]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            Carbon::setLocale('id');

            $validator = Validator::make($request->all(), [
                'tanggal' => 'required'
            ], [
                'tanggal.required' => 'Tanggal tidak boleh kosong!'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {

                $idSiswa = $request->input('idSiswa');
                $idKelas = $request->input('idKelas');
                $idPeriode = $request->input('idPeriode');
                $idPengajar = $request->input('idPengajaran');
                $tanggal = Carbon::parse($request->tanggal);

                // Perbarui data absensi untuk tanggal yang diberikan
                foreach ($idSiswa as $data) {
                    $presensi = $request->input('presensi_' . $data);
                    $absensi = ModelsAbsensi::where('idSiswa', $data)
                        ->where('idKelas', $idKelas)
                        ->where('idPeriode', $idPeriode)
                        ->where('tanggal', $tanggal->translatedFormat('Y-m-d'))
                        ->first();

                    if ($absensi) {
                        // Jika absensi untuk tanggal tersebut sudah ada, perbarui
                        $absensi->update([
                            'presensi' => $presensi,
                            // Tambahkan kolom lain yang ingin diperbarui
                        ]);
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Data presensi berhasil diperbarui.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error updating data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rekapitulasi($name, $bulan)
    {
        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->first();
        $kelasNama = $name;
        $periodeSiswa = $periode->idPeriode;

        // Ambil siswa dengan kelas dan periode yang sesuai
        $siswaWithKelas = Siswa::whereHas('kelas', function ($query) use ($kelasNama, $periodeSiswa) {
            $query->where('namaKelas', $kelasNama)
                ->where('idPeriode', $periodeSiswa);
        })
            ->orderBy('namaSiswa', 'asc')
            ->get();


        $pegawai = Auth::user()->pegawai->idPegawai;

        $kelas = Kelas::where('idPegawai', $pegawai)->where('idPeriode', $periode->idPeriode)->get();

        $data = Pengajaran::where('idPegawai', $pegawai)->where('idPeriode', $periode->idPeriode)->whereHas('kelas', function ($query) use ($name) {
            $query->where('namaKelas', $name);
        })
            // ->select('idKelas')
            ->distinct()
            ->get();


        $idP = $data[0]->idPengajaran;

        $kehadiran = ModelsAbsensi::select('idSiswa')
            ->selectRaw('DAY(tanggal) as tanggal')
            ->selectRaw('tanggal as bulan')
            ->selectRaw('MONTH(tanggal) as noBulan')
            ->selectRaw("MAX(CASE WHEN presensi = 'hadir' THEN 'H' WHEN presensi = 'izin' THEN 'I' WHEN presensi = 'sakit' THEN 'S' ELSE 'A' END) as presensi")
            // ->whereMonth('tanggal', now()->month)
            ->where('idKelas', $data[0]->idKelas)
            ->where('idPeriode', $periode->idPeriode)
            ->whereRaw('MONTH(tanggal) = ?', $bulan)
            ->groupBy('idSiswa', 'tanggal')
            ->get()->map(function ($item) {
                $item->bulan = Carbon::parse($item->bulan)->translatedFormat('F');
                return $item;
            });

        $kepsek = Pegawai::select('namaPegawai', 'nip')->whereHas('jabatanPegawai', function ($query) {
            $query->where('jabatan', 'Kepala Sekolah');
        })->first();

        $wakel = Pegawai::select('namaPegawai', 'nip')->whereHas('kelas', function ($query) use ($data) {
            $query->where('idKelas', $data[0]->idKelas);
        })->first();


        return view('siakad.content.absen.rekap_absen', compact('periode', 'kelas', 'data', 'kehadiran', 'siswaWithKelas', 'kepsek', 'wakel'), [
            'judul' => 'Presensi Siswa',
            'sub_judul' => 'Kelas ' . $data[0]->kelas->namaKelas,
            'sub_sub_judul' => 'Rekapitulasi ' . $bulan,
            'text_singkat' => 'Mengelola rekapitulasi kehadiran siswa!',
            's_idKelas' => $data[0]->idKelas,
            'kelasName' => $name,
            'bulan' => $bulan
        ]);
    }
}
