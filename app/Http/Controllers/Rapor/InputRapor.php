<?php

namespace App\Http\Controllers\Rapor;

use App\Http\Controllers\Controller;
use App\Models\CatatanGuru;
use App\Models\Ekstrakulikuler;
use App\Models\KegEkstra;
use App\Models\Kelas;
use App\Models\KetNaikTidak;
use App\Models\Pegawai;
use App\Models\Periode;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InputRapor extends Controller
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


        $sekolah = Sekolah::first() ?? null;

        $kepsek = Pegawai::select('namaPegawai', 'nip')->whereHas('jabatanPegawai', function ($query) {
            $query->where('jabatan', 'Kepala Sekolah');
        })->first();


        return view('siakad/content/rapor/input_rapor', compact('periodeAktif', 'periodeLewat', 'periode', 'kelas', 'kelas_nama', 'sekolah'), [
            'judul' => 'Rapor Siswa',
            'sub_judul' => 'Isi Rapor Siswa',
            'text_singkat' => 'Mengelola rapor semester siswa!',
            's_idKelas' => '',
            'kelasName' => '',
            'guru_kls' => Auth::user()->pegawai,
            'kepsek' => $kepsek
            // 'periode' => $periodeGuru
        ]);
    }

    public function getForm(Request $request)
    {
        $idPeriode = $request->idPeriode;
        $namaKelas = $request->namaKelas;
        $idSiswa = $request->idSiswa;

        $siswa = Siswa::where('idSiswa', $idSiswa)
            ->whereHas('kelas', function ($query) use ($idPeriode, $namaKelas) {
                $query->where('namaKelas', $namaKelas)
                    ->where('idPeriode', $idPeriode);
            })
            ->orderBy('namaSiswa', 'asc')
            ->first();

        $ekstra = Ekstrakulikuler::all();
        $kegiatan = KegEkstra::where('idPeriode', $idPeriode)
            ->where('idSiswa', $idSiswa)
            ->get();

        $ct_guru = CatatanGuru::where('idPeriode', $idPeriode)
            ->where('idSiswa', $idSiswa)
            ->first();

        $ketNaikTidak = KetNaikTidak::where('idPeriode', $idPeriode)
            ->where('idSiswa', $idSiswa)
            ->first();

        return response()->json([
            'siswa' => $siswa,
            'ekstra' => $ekstra,
            'kegiatan' => $kegiatan,
            'catatan' => $ct_guru,
            'keterangan' => $ketNaikTidak
        ]);
    }

    public function store(Request $request)
    {
        try {
            $rules = [];
            $idEks = $request->input('ideks');

            foreach ($idEks as $eks) {
                $rules['ekstra_' . $eks] = 'nullable|max:255';
                $rules['catatan'] = 'required|max:255'; // Sesuaikan dengan aturan validasi yang Anda perlukan
                $rules['naik_tidak_desk'] = 'required|max:255'; // Sesuaikan dengan aturan validasi yang Anda perlukan
                $rules['naik_tidak'] = 'required'; // Sesuaikan dengan aturan validasi yang Anda perlukan
            }
            $validator = Validator::make($request->all(), $rules, [
                'ekstra_*.max' => 'Deskripsi ekskul terlalu panjang, maksimal 255 karakter.',
                'catatan.max' => 'Catatan guru terlalu panjang, maksimal 255 karakter.',
                'catatan.required' => 'Catatan guru tidak boleh kosong.',
                'naik_tidak.required' => 'Keterangan kenaikan kelas tidak boleh kosong.',
                'naik_tidak_desk.max' => 'Deskripsi kenaikan kelas terlalu panjang, maksimal 45 karakter.',
                'naik_tidak_desk.required' => 'Deskripsi kenaikan kelas tidak boleh kosong.',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                $idSiswa = $request->input('idSiswa');
                $idPeriode = $request->input('idPeriode');
                $idKelas = $request->input('idKelas');
                $ekstrakulikuler = $request->input('ideks');
                $catatan = $request->input('catatan');
                $ket = $request->input('naik_tidak');
                $desk_ket = $request->input('naik_tidak_desk');

                $wajib = [];
                $pilihan = [];
                foreach ($ekstrakulikuler as $ekstra) {
                    $ekstraData = Ekstrakulikuler::find($ekstra); // Asumsi tabel ekstrakurikuler memiliki id dan kategori
                    if ($ekstraData->status == 'wajib') {
                        $wajib[] = $ekstra;
                    } else if ($ekstraData->status == 'pilihan') {
                        $pilihan[] = $ekstra;
                    }
                }

                // Cek jika lebih dari satu kategori wajib
                $check = KegEkstra::where('idSiswa', $idSiswa)
                    ->where('idPeriode', $idPeriode)
                    ->where('idKelas', $idKelas)
                    ->whereHas('ekstra', function ($query) {
                        $query->where('status', 'wajib');
                    })->first();

                if (!empty($check)) {
                    foreach ($wajib as $ekstra) {
                        $desk = $request->input('ekstra_' . $ekstra);
                        $predik = $request->input('predikat_' . $ekstra);
                        if (!empty($desk)) {
                            $eks = KegEkstra::find($check->idKegiatan);

                            $eks->update([
                                'idEks' => $ekstra,
                                'deskripsi' => $desk,
                                'predikat' => $predik
                            ]);
                        }
                    }
                } else {
                    foreach ($wajib as $ekstra) {
                        $desk = $request->input('ekstra_' . $ekstra);
                        $predik = $request->input('predikat_' . $ekstra);
                        if (!empty($desk)) {
                            $eks = KegEkstra::firstOrNew([
                                'idSiswa' => $idSiswa,
                                'idPeriode' => $idPeriode,
                                'idKelas' => $idKelas,
                                'idEks' => $ekstra
                            ]);

                            $eks->deskripsi = $desk;
                            $eks->predikat = $predik;
                            $eks->save();
                        }
                    }
                }

                foreach ($pilihan as $ekstra) {
                    $desk = $request->input('ekstra_' . $ekstra);
                    $predik = $request->input('predikat_' . $ekstra);
                    if (!empty($desk)) {
                        $eks = KegEkstra::firstOrNew([
                            'idSiswa' => $idSiswa,
                            'idPeriode' => $idPeriode,
                            'idKelas' => $idKelas,
                            'idEks' => $ekstra
                        ]);

                        $eks->deskripsi = $desk;
                        $eks->predikat = $predik;
                        $eks->save();
                    }
                }

                $ctt = CatatanGuru::firstOrNew([
                    'idSiswa' => $idSiswa,
                    'idPeriode' => $idPeriode,
                    'idKelas' => $idKelas,
                ]);

                $ctt->catatan_guru = $catatan;
                $ctt->save();

                $keterangan = KetNaikTidak::firstOrNew([
                    'idSiswa' => $idSiswa,
                    'idKelas' => $idKelas,
                    'idPeriode' => $idPeriode,
                ]);

                $keterangan->keterangan = $ket;
                $keterangan->deskripsi = $desk_ket;
                $keterangan->save();

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Data berhasil disimpan.',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }
}
