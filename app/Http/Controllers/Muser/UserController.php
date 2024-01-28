<?php

namespace App\Http\Controllers\Muser;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
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
        $pegawaiList = Pegawai::all();
        $siswaList = Siswa::all();
        return view('siakad.content.m_user.index', compact('pegawaiList', 'siswaList'), [
            'title' => 'Manajemen User',
            'title2' => 'Data User',
        ]);
    }

    // tampilkan user pegawai
    public function getUsrPegawai()
    {
        try {
            $data = User::orderBy('idUser', 'desc')->with('pegawai')->get();
            $data = $data->map(function ($item, $key) {
                $item['nomor'] = $key + 1;
                return $item;
            });

            return DataTables::of($data)
                ->addColumn('namaPegawai', function ($user) {
                    return optional($user->pegawai)->namaPegawai;
                })
                ->addColumn('status', function ($user) {
                    return optional($user->pegawai)->status;
                })
                ->make(true);

            // return DataTables::of($data)->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // tampilkan user siswa
    public function getUsrSiswa()
    {
        try {
            $data = Siswa::whereNotNull('username')->orderBy('idSiswa', 'desc')->get();
            $data = $data->map(function ($item, $key) {
                $item['nomor'] = $key + 1;
                return $item;
            });

            return DataTables::of($data)->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
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
    public function storeUsrSiswa(Request $request, $id)
    {
        try {
            $siswa = Siswa::find($id);

            if (!$siswa) {
                // Handle jika periode tidak ditemukan
                return response()->json(['status' =>  'error', 'message' => 'Data tidak ditemukan.']);
            }
            $validatedData = $request->validate([
                'username' => 'required',
                'password' => 'required',
                'hakAkses' => 'required',
                // 'idPegawai' => 'required',
            ]);

            // Enkripsi password menggunakan bcrypt
            $validatedData['password'] = bcrypt($validatedData['password']);

            $existingUser = Siswa::where('username', $validatedData['username'])->first();

            if ($existingUser) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa sudah terdaftar.',
                ]);
            } else {
                // Menambahkan idPegawai saat membuat user
                $siswa->update($validatedData);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menyimpan data.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data. Pesan kesalahan: ' . $e->getMessage(),
            ]);
        }
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'hakAkses' => 'required',
            'idPegawai' => 'required',
        ]);
        // Enkripsi password menggunakan bcrypt
        $validatedData['password'] = bcrypt($validatedData['password']);

        // $existingUser = User::where('idPegawai', $validatedData['idPegawai'])->first();

        // if ($existingUser) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Pegawai sudah terdaftar.',
        //     ]);
        // } else {
        //     // Menambahkan idPegawai saat membuat user
            
        // }
        $user = User::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data.',
                'user' => $user,
            ]);
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
    public function edit($id)
    {
        $user = User::with('pegawai')->find($id);
        if (!$user) {
            // Handle jika berita tidak ditemukan
            return response()->json(['status' => 'error', 'message' => 'Data user tidak ditemukan.']);
        }

        return response()->json(['user' => $user]);
    }
    public function editUsrSiswa($id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) {
            // Handle jika berita tidak ditemukan
            return response()->json(['status' => 'error', 'message' => 'Data user tidak ditemukan.']);
        }

        return response()->json(['user' => $siswa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Data user tidak ditemukan.']);
        }
        // Validasi input
        $validatedData = $request->validate([
            'username' => 'required',
            'hakAkses' => 'required',
            'password' => $request->filled('password') ? 'required' : '',
        ]);

        // Perbarui data user, termasuk penanganan password
        if ($request->filled('password')) {
            // Jika password diisi, maka update password
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            // Jika password tidak diisi, abaikan kolom 'password' saat pembaruan
            unset($validatedData['password']);
        }

        // Perbarui data user
        $user->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah data.'
        ]);
    }
    public function updateUsrSiswa(Request $request, $id)
    {
        $user = Siswa::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Data user tidak ditemukan.']);
        }
        // Validasi input
        $validatedData = $request->validate([
            'username' => 'required',
            'hakAkses' => 'required',
            'password' => $request->filled('password') ? 'required' : '',
        ]);

        // Perbarui data user, termasuk penanganan password
        if ($request->filled('password')) {
            // Jika password diisi, maka update password
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            // Jika password tidak diisi, abaikan kolom 'password' saat pembaruan
            unset($validatedData['password']);
        }

        // Perbarui data user
        $user->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah data.'
        ]);
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
    public function destroyUsrSiswa($id)
    {
        try {
            // Temukan siswa berdasarkan ID
            $siswa = Siswa::find($id);

            if (!$siswa) {
                return response()->json(['status' => 'error', 'message' => 'Data siswa tidak ditemukan.']);
            }

            // Mengosongkan nilai kolom username, password, dan hakAkses
            $siswa->update([
                'username' => null,
                'password' => null,
                'hakAkses' => null,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Berhasil mengapus data.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data. ' . $e->getMessage()]);
        }
    }
}
