<?php

namespace App\Http\Controllers\Muser;

use App\Exports\UserSiswaExport;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Siswa;
use App\Models\User;
use App\Models\userSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::all();
        $siswa = Siswa::all();
        // $siswa_kelas = $siswa->tr_kelas;

        return view('siakad.content.m_user.index', compact('pegawai', 'siswa',), [
            'judul' => 'Manajemen User',
            'sub_judul' => 'Data User',
            'text_singkat' => 'Mengelola data user!',
        ]);
    }

    // tampilkan data tabel user siswa
    public function getUsrSiswa()
    {
        try {
            $data = userSiswa::orderBy('idUserSiswa', 'desc')->get();
            $data = $data->map(function ($item, $key) {
                $item['nomor'] = $key + 1;
                $item['namaSiswa'] = $item->siswa->namaSiswa;
                $item['kelas'] = $item->siswa->kelas->pluck('namaKelas')->transform(function ($kelas) {
                    return 'Kelas ' . $kelas;
                })->toArray() ?: ['N/A'];
                $item['status'] = $item->siswa->status === 'Aktif' ? '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">' . $item->siswa->status . '</span>' : '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">' . $item->siswa->status . '</span>';
                return $item;
            });

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            Log::error('Error get data: ' . $e->getMessage());
        }
    }

    // untuk select2 data siswa
    public function getOptions()
    {
        // $query = $request->input('query');

        $data = Siswa::whereDoesntHave('usersiswa')->get();

        // dd($data);

        return response()->json($data);
    }

    // store data user siswa
    public function storeUsrSiswa(Request $request)
    {
        $selectedData = $request->input('selectedData');

        foreach ($selectedData as $data) {
            $siswa = Siswa::find($data);

            $username = $siswa->nis;

            $password = date('dmy', strtotime($siswa->tanggalLahir));

            $role = 'Siswa';

            userSiswa::create([
                'idSiswa' => $data,
                'username' => $username,
                'password' => bcrypt($password),
                'hakAkses' => $role,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menyimpan data.',
        ]);
    }

    // show edit data user siswa
    public function editUsrSiswa($id)
    {
        $siswa = userSiswa::with('siswa')->find($id);
        if (!$siswa) {
            // Handle jika berita tidak ditemukan
            return response()->json(['status' => 'error', 'message' => 'Data user tidak ditemukan.']);
        }
        $kelas =  $siswa->siswa->kelas->pluck('namaKelas')->transform(function ($kelas) {
            return 'Kelas ' . $kelas;
        })->toArray() ?: ['N/A'];

        return response()->json(['user' => $siswa, 'kelas' => $kelas]);
    }

    // update data user siswa
    public function updateUsrSiswa(Request $request, $id)
    {

        $user = userSiswa::find($id);

        $user->username = $request->input('username');


        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->update();

        return response()->json([
            'status' => 'Success',
            'message' => 'Berhasil mengubah data.'
        ]);
    }

    // delete data user siswa
    public function destroyUsrSiswa($id)
    {
        $user = userSiswa::find($id);
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengapus data.'
        ]);
    }


    // tampilkan user pegawai
    public function getUsrPegawai()
    {
        try {
            $data = User::where('hakAkses', '!=', 'Super Admin')
                ->orderBy('idUser', 'desc')
                ->get();
            $data = $data->map(function ($item, $key) {
                $item['nomor'] = $key + 1;
                $item['namaPegawai'] = $item->pegawai->namaPegawai;
                $item['status'] = $item->pegawai->status === 'Aktif' ? '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">' . $item->pegawai->status . '</span>' : '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">' . $item->pegawai->status . '</span>';
                return $item;
            });

            return response()->json(['data' => $data]);

            // return DataTables::of($data)->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // untuk select2 data pegawai
    public function getOptionsPegawai()
    {
        // $query = $request->input('query');

        // $data = Pegawai::orderBy('namaPegawai', 'asc')->get();
        $data = Pegawai::whereNotIn('idPegawai', function($query) {
            $query->select('idPegawai')
                  ->from('user')
                  ->where('hakAkses', 'Super Admin');
        })->orderBy("namaPegawai", "asc")->get();
        

        // dd($data);

        return response()->json($data);
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
            $selectedData = $request->input('selectedData');

            foreach ($selectedData as $data) {
                $pegawai = Pegawai::find($data);

                $username = $pegawai->nip;

                $password = date('dmy', strtotime($pegawai->tanggalLahir));

                $role = $request->input('role');

                User::create([
                    'idPegawai' => $data,
                    'username' => $username,
                    'password' => bcrypt($password),
                    'hakAkses' => $role,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    // show data edit user pegawai
    public function edit($id)
    {
        $user = User::with('pegawai')->find($id);
        if (!$user) {
            // Handle jika berita tidak ditemukan
            return response()->json(['status' => 'error', 'message' => 'Data user tidak ditemukan.']);
        }

        return response()->json(['user' => $user]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            $user->username = $request->input('username');
            $user->hakAkses = $request->input('hakAkses');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->update();

            return response()->json([
                'status' => 'Success',
                'message' => 'Berhasil mengubah data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
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
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengapus data.'
        ]);
    }

    // public function destroyUsrSiswa($id)
    // {
    //     try {
    //         // Temukan siswa berdasarkan ID
    //         $siswa = Siswa::find($id);

    //         if (!$siswa) {
    //             return response()->json(['status' => 'error', 'message' => 'Data siswa tidak ditemukan.']);
    //         }

    //         // Mengosongkan nilai kolom username, password, dan hakAkses
    //         $siswa->update([
    //             'username' => null,
    //             'password' => null,
    //             'hakAkses' => null,
    //         ]);

    //         return response()->json(['status' => 'success', 'message' => 'Berhasil mengapus data.']);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data. ' . $e->getMessage()]);
    //     }
    // }
}
