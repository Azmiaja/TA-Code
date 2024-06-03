<?php

namespace App\Http\Controllers;

use App\Models\LM_sumatif;
use App\Models\Pengajaran;
use App\Models\Periode;
use App\Models\TP_sumatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KategoriNilaiController extends Controller
{
    public function index()
    {
        $pegawai = Auth::user()->pegawai->idPegawai;
        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->first();

        $idPer = $periode->idPeriode ?? null;

        $klsPengajaran = Pengajaran::where('idPegawai', $pegawai)
            ->where('idPeriode', $idPer)
            ->whereHas('kelas', function ($query) {
                $query->orderBy('namaKelas', 'asc');
            })
            // ->with('guru')
            ->select('idKelas', 'idPegawai')
            ->distinct()
            ->get();


        return view('siakad/content/penilaian/kategori/index', compact('klsPengajaran', 'periode'), [
            'judul' => 'Kategori Penilaian',
            'sub_judul' => 'Atur Penilaian Mapel',
            'text_singkat' => 'Mengelola lingkup materi dan tujuan pembelajaran!',
            's_idKelas' => '',
            'kelasName' => '',
            // 'periode' => $periodeGuru/\
        ]);
    }

    public function getMapelGuru(Request $request)
    {
        $kelas = $request->kelas;
        $pegawai = Auth::user()->pegawai->idPegawai;
        $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->first();
        $data = Pengajaran::where('idPegawai', $pegawai)
            ->where('idPeriode', $periode->idPeriode)
            ->whereHas('kelas', function ($query) use ($kelas) {
                $query->where('namaKelas', $kelas);
            })
            // ->select('idKelas')
            ->with('mapel')
            ->distinct()
            ->get();

        return response()->json(['mapel' => $data]);
    }

    public function getTP(Request $request)
    {
        $idMapel = $request->idMapel;
        $kelas = $request->kelas;
        $periode = $request->periode;

        $tp = TP_sumatif::where('idMapel', $idMapel)
            ->where('kelas', $kelas)
            ->where('periode', $periode)
            ->orderBy('kodeTP', 'asc')
            ->get();
        $tp = $tp->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            $item['kode'] = $item->kodeTP ?: '-';
            $item['tp'] = $item->deskripsi ?: '-';
            $item['idTP'] = $item->idTP ?: '-';

            return $item;
        });

        return  response()->json(['data' => $tp]);
    }

    public function getLM(Request $request)
    {
        $idMapel = $request->idMapel;
        $kelas = $request->kelas;
        $periode = $request->periode;

        $lm = LM_sumatif::where('idMapel', $idMapel)
            ->where('kelas', $kelas)
            ->where('periode', $periode)
            ->orderBy('kodeLM', 'asc')
            ->get();
        $lm = $lm->map(function ($item, $key) {
            $item['nomor'] = $key + 1;
            $item['lm'] = $item->deskripsi ?: '-';
            $item['idLM'] = $item->idLM ?: '-';
            $item['kode'] = $item->kodeLM ?: '-';

            return $item;
        });

        return  response()->json(['data' => $lm]);
    }

    public function storeLM(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required|max:100',
            'kode' => [
                'required',
                'max:4',
                'regex:/^LM[0-9]+$/',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = LM_sumatif::where('kodeLM', $value)
                        ->where('idMapel', $request->input('idMapel'))
                        ->where('periode', $request->input('periode'))
                        ->where('kelas', $request->input('kelas'))
                        ->exists();

                    if ($exists) {
                        $fail('Kode LM sudah ada!');
                    }
                }
            ],
        ], [
            'deskripsi.required' => 'Lingkup materi tidak boleh kosong!',
            'deskripsi.max' => 'Lingkup materi tidak boleh lebih dari 100 karakter!',
            'kode.required' => 'Kode LM tidak boleh kosong!',
            'kode.max' => 'Kode LM tidak boleh lebih dari 4 karakter!',
            'kode.regex' => 'Format kode LM tidak sesuai, ikuti contoh!',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        } else {
            $idMapel = $request->input('idMapel');
            $deskripsi = $request->input('deskripsi');
            $kelas = $request->input('kelas');
            $kode = $request->input('kode');
            $periode = $request->input('periode');

            LM_sumatif::create([
                'idMapel' => $idMapel,
                'kelas' => $kelas,
                'deskripsi' => $deskripsi,
                'kodeLM' => $kode,
                'periode' => $periode
            ]);

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil menyimpan data.',
            ]);
        }
    }

    public function deleteLM($id)
    {
        $LM = LM_sumatif::find($id);
        $LM->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil menghapus data.'
        ]);
    }

    public function storeTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kodeTP' => [
                'required',
                'max:4',
                'regex:/^TP[0-9]+$/',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = TP_sumatif::where('kodeTP', $value)
                        ->where('idMapel', $request->input('idMapel'))
                        ->where('periode', $request->input('periode'))
                        ->where('kelas', $request->input('kelas'))
                        ->exists();

                    if ($exists) {
                        $fail('Kode TP sudah ada!');
                    }
                }
            ],
            'deskripsi' => 'required|max:255'
        ], [
            'deskripsi.required' => 'Tujuan pembelajaran tidak boleh kosong!',
            'deskripsi.max' => 'Tujuan pembelajaran tidak boleh lebih dari 255 karakter!',
            'kodeTP.required' => 'Kode TP tidak boleh kosong!',
            'kodeTP.max' => 'Kode TP tidak boleh lebih dari 4 karakter!',
            'kodeTP.regex' => 'Format kode TP tidak sesuai, ikuti contoh!',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        } else {
            $idMapel = $request->input('idMapel');
            $deskripsi = $request->input('deskripsi');
            $kode = $request->input('kodeTP');
            $kelas = $request->input('kelas');
            $periode = $request->input('periode');

            TP_sumatif::create([
                'idMapel' => $idMapel,
                'deskripsi' => $deskripsi,
                'kodeTP' => $kode,
                'kelas' => $kelas,
                'periode' => $periode
            ]);

            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Berhasil menyimpan data.',
            ]);
        }
    }

    public function deleteTP($id)
    {
        $TP = TP_sumatif::find($id);
        $TP->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Dihapus!',
            'message' => 'Berhasil menghapus data.'
        ]);
    }

    public function getTPById($id)
    {
        $TP = TP_sumatif::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $TP
        ]);
    }

    public function updateTP(Request $request, $id)
    {
        $TP = TP_sumatif::find($id);
        if ($TP) {
            # code...
            $validator = Validator::make($request->all(), [
                'kodeTP' => 'required',
                'deskripsi' => 'required'
            ], [
                'deskripsi.required' => 'Tujuan pembelajaran tidak boleh kosong!',
                'kodeTP.required' => 'Kode TP tidak boleh kosong!',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                // $idMapel = $request->input('idMapel');
                $deskripsi = $request->input('deskripsi');
                $kode = $request->input('kodeTP');
                // $kelas = $request->input('kelas');

                $TP->update([
                    // 'idMapel' => $idMapel,
                    'deskripsi' => $deskripsi,
                    'kodeTP' => $kode,
                    // 'kelas' => $kelas
                ]);

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil menyimpan data.',
                ]);
            }
        }
    }

    public function getLMById($id)
    {
        $LM = LM_sumatif::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $LM
        ]);
    }

    public function updateLM(Request $request, $id)
    {
        $LM = LM_sumatif::find($id);
        if ($LM) {
            # code...
            $validator = Validator::make($request->all(), [
                'kode' => 'required',
                'deskripsi' => 'required'
            ], [
                'deskripsi.required' => 'Lingkup materi tidak boleh kosong!',
                'kode.required' => 'Kode LM tidak boleh kosong!',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            } else {
                // $idMapel = $request->input('idMapel');
                $deskripsi = $request->input('deskripsi');
                $kode = $request->input('kode');
                // $kelas = $request->input('kelas');

                $LM->update([
                    // 'idMapel' => $idMapel,
                    'deskripsi' => $deskripsi,
                    'kodeLM' => $kode,
                    // 'kelas' => $kelas
                ]);

                return response()->json([
                    'status' => 'success',
                    'title' => 'Sukses',
                    'message' => 'Berhasil menyimpan data.',
                ]);
            }
        }
    }
}
