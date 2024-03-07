<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ProfilUserController extends Controller
{
    public function index()
    {
        $auth = auth()->user();
        return view('siakad/content/profil_user/index', [
            'judul' => 'Profil Pengguna',
            'sub_judul' => 'Profil',
            'text_singkat' => 'Mengelola data informasi profil Anda!',
            'auths' => $auth,
        ]);
    }
    public function edit()
    {
        $auth = auth()->user();
        return view('siakad/content/profil_user/edit-profil', [
            'judul' => 'Profil Pengguna',
            'sub_judul' => 'Profil',
            'sub_sub_judul' => 'Edit Profil',
            'text_singkat' => 'Mengelola data informasi profil Anda!',
            'auths' => $auth,
        ]);
    }
    public function chPassword()
    {
        $profilPegawai = auth()->user()->pegawai;

        return view('siakad/content/profil_user/ch-password', [
            'judul' => 'Profil Pengguna',
            'sub_judul' => 'Profil',
            'sub_sub_judul' => 'Change Password',
            'text_singkat' => 'Ubah password untuk meningkatkan keamanan akun Anda!',
            'auth' => $profilPegawai,
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'password_confirmation' => ['required', 'same:password']
        ]);

        if (Hash::check($request->current_password, auth()->user()->password)) {
            $request->user()->fill([
                'password' => Hash::make($request->password)
            ])->save();
            return back()->with('success', 'Password berhasil diubah.');
            
        } else {
            throw ValidationException::withMessages([
                'current_password' => 'The current password does not match.',
            ]);
        }
    }


    public function updateUsername(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'username' => 'required|string|max:25'
        ]);

        $user->update($validatedData);

        return back()->with('user_success', 'Username berhasil diubah.');
    }

    public function updateBiografi(Request $request, $id)
    {
        // try {
        // dd($request->all());
        $bio = Pegawai::find($id);

        $validatedData = $request->validate([
            'nip' => 'required|max:18',
            'namaPegawai' => 'required|string|max:45',
            'tempatLahir' => 'required|string|max:10',
            'tanggalLahir' => 'required|date',
            'jenisKelamin' => 'required|in:Laki-Laki,Perempuan',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha',
            'noHp' => 'required|max:15',
            'alamat' => 'required|string|max:125',
            'gambar' => 'image|mimes:jpeg,jpg,png,svg',
        ]);

        if ($request->file('gambar')) {
            // $img = $request->file('gambar');
            $imgName = uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
            $validatedData['gambar'] = $request->file('gambar')->storeAs('profil_pegawai', $imgName, 'public');

            if ($bio->gambar) {
                Storage::delete('public/' . $bio->gambar);
            }
        }
        // dd($validatedData);

        $bio->update($validatedData);

        return back()->with('success', 'Biografi berhasil diubah.');
        // } catch (\Exception $e) {
        //     Log::error('Error storing data: ' . $e->getMessage());

        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Error storing data.',
        //     ], 422);
        // }
    }

    public function updateBiografiSiswa(Request $request, $id)
    {
        $bio = Siswa::find($id);

        $validatedData = $request->validate([
            'namaSiswa' => 'required|string|max:45',
            'panggilan' => 'required|string|max:45',
            'tempatLahir' => 'required|string|max:10',
            'tanggalLahir' => 'required|date',
            'jenisKelamin' => 'required|in:Laki-Laki,Perempuan',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha',
            'alamat' => 'required|string|max:125',
        ]);

        $bio->update($validatedData);

        return back()->with('siswa_success', 'Biografi siswa berhasil diubah.');
    }

    public function updateBiografiOrtu(Request $request, $id)
    {
        $bio = Siswa::find($id);

        $validatedData = $request->validate([
            'namaAyah' => 'nullable|string|max:45',
            'namaIbu' => 'nullable|string|max:45',
            'pekerjaanAyah' => 'nullable|string|max:45',
            'pekerjaanIbu' => 'nullable|string|max:45',
            'noTlpAyah' => 'nullable|string|max:15',
            'noTlpIbu' => 'nullable|string|max:15',
            'alamatAyah' => 'nullable|string|max:125',
            'alamatIbu' => 'nullable|string|max:125',
        ]);

        $bio->update($validatedData);

        return back()->with('ortu_success', 'Data Orang tua murid berhasil diubah.');
    }

    public function updateBiografiWali(Request $request, $id)
    {
        $bio = Siswa::find($id);

        $validatedData = $request->validate([
            'namaWali' => 'nullable|string|max:45',
            'pekerjaanWali' => 'nullable|string|max:45',
            'noTlpWali' => 'nullable|string|max:15',
            'alamatWali' => 'nullable|string|max:125',
        ]);

        $bio->update($validatedData);

        return back()->with('wali_success', 'Data wali murid berhasil diubah.');
    }
}
