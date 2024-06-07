<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
            's_idKelas' => ''
        ]);
    }

    public function getDataUser()
    {
        // $auth = auth()->user()->pegawai ?? auth()->user()->siswa;
        // $auth = Pegawai::where('idPegawai', auth()->user()->pegawai->idPegawai)->with('jabatanPegawai')->first() ?? Siswa::where('idSiswa', auth()->user()->siswa->idSiswa)->first();
        $user = auth()->user();

        $data = null;

        if (Auth::user()->siswa) {
            $data = Siswa::where('idSiswa', $user->siswa->idSiswa)
            ->first();
        } else {
            $data = Pegawai::where('idPegawai', $user->pegawai->idPegawai)
                ->with('jabatanPegawai')
                ->first();
        }
        return response()->json($data);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        return $fail(__('Password saat ini tidak sesuai.'));
                    }
                }
            ],
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            ],
            'password_confirmation' => ['required', 'same:password']
        ], [
            'current_password.required' => 'Masukan password saat ini.',
            'password.required' => 'Masukan password baru.',
            'password.min' => 'Password baru minimal harus terdiri dari 8 karakter.',
            'password.regex' => 'Password baru harus mengandung setidaknya satu huruf besar, satu angka, dan satu karakter khusus.',
            'password_confirmation.required' => 'Masukan kembali password baru.',
            'password_confirmation.same' => 'Password baru dan Konfirmasi password tidak sama.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $update = $request->user()->fill([
                'password' => Hash::make($request->password)
            ])->save();

            if ($update) {
                return response()->json(['status' => 'success', 'msg' => 'Password berhasil diperbarui.']);
            }
        }
    }


    public function updateFotoProfil(Request $request, $id)
    {
        try {
            $pegawai = Pegawai::find($id);

            $validator = Validator::make($request->all(), [
                'gambar' => 'image|mimes:jpeg,jpg,png,svg|max:2048',
            ], [
                'gambar.image' => 'File yang anda pilih bukan gambar.',
                'gambar.mimes' => 'Format gambar hanya JPEG,JPG,PNG,SVG.',
                'gambar.max' => 'Ukuran file maksimal 2MB.'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 0, 'error' => $validator->errors()->first()]);
            } else {
                if ($request->hasFile('gambar')) {
                    $imgName = uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                    $gambarPath = $request->file('gambar')->storeAs('profil_pegawai', $imgName, 'public');

                    if ($pegawai->gambar) {
                        Storage::delete('public/' . $pegawai->gambar);
                    }
                }
                $pegawai->gambar = $gambarPath;
                $pegawai->save();

                return response()->json(['status' => 'success', 'msg' => 'Foto profil berhasil diperbarui.']);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }


    public function updateBiografi(Request $request, $id)
    {
        try {
            $user = User::where('idPegawai', $id);
            $bio = Pegawai::find($id);

            // Validasi data
            $validatedData =  Validator::make($request->all(), [
                'username' => 'required|max:25|unique:user,username,' . $id . ',idPegawai',
                'nip' => 'required|max:18',
                'namaPegawai' => 'required|string|max:45',
                'tempatLahir' => 'required|string|max:10',
                'tanggalLahir' => 'required',
                'jenisKelamin' => 'required|in:Laki-Laki,Perempuan',
                'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha',
                'noHp' => 'required|max:15',
                'alamat' => 'required|max:125',
            ], [
                'username.required' => 'Masukan username.',
                'username.max' => 'Username maksimal 25 karakter.',
                'username.unique' => 'Username sudah digunakan.',
                'nip.required' => 'Masukan NIP.',
                'nip.max' => 'NIP maksimal 18 karakter.',
                'namaPegawai.required' => 'Masukan nama lengkap Anda.',
                'namaPegawai.string' => 'Nama harus berupa string/huruf.',
                'namaPegawai.max' => 'Nama terlalu panjang, maksimal 45 karakter.',
                'tempatLahir.required' => 'Masukan tempat lahir Anda.',
                'tempatLahir.string' => 'Tempat lahir harus berupa string/huruf.',
                'tempatLahir.max' => 'Tempat lahir terlalu panjang, maksimal 10 karakter.',
                'tanggalLahir.required' => 'Masukan tanggal lahir Anda.',
                'jenisKelamin.required' => 'Masukan jenis kelamin Anda.',
                'agama.required' => 'Masukan agama Anda.',
                'noHp.required' => 'Masukan nomor telepon Anda.',
                'noHp.max' => 'Nomor telepon maksimal 15 karakter.',
                'alamat.required' => 'Masukan alamat domisili Anda.',
                'alamat.max' => 'Alamat terlalu panjang, maksimal 125 karakter.',
            ]);

            if ($validatedData->fails()) {
                return response()->json(['status' => 0, 'error' => $validatedData->errors()->toArray()]);
            } else {
                $user->update(['username' => $request->username]);

                $bio->update([
                    'nip' => $request->nip,
                    'namaPegawai' => $request->namaPegawai,
                    'tempatLahir' => $request->tempatLahir,
                    'tanggalLahir' => Carbon::createFromFormat('d/m/Y', $request->tanggalLahir)->format('Y-m-d'),
                    'jenisKelamin' => $request->jenisKelamin,
                    'agama' => $request->agama,
                    'noHp' => $request->noHp,
                    'alamat' => $request->alamat,
                ]);

                return response()->json(['status' => 'success', 'msg' => 'Profil berhasil diperbarui.']);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }
    }

    public function updateBiografiSiswa(Request $request, $id)
    {
        try {
            $bio = Siswa::find($id);

            $validatedData = Validator::make($request->all(), [
                'namaSiswa' => 'required|max:45',
                'panggilan' => 'required|max:45',
                'tempatLahir' => 'required|max:10',
                'tanggalLahir' => 'required',
                'jenisKelamin' => 'required|in:Laki-Laki,Perempuan',
                'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha',
                'alamat' => 'required|max:125',

                'namaAyah' => 'required|max:45',
                'namaIbu' => 'required|max:45',
                'pekerjaanAyah' => 'required|max:45',
                'pekerjaanIbu' => 'required|max:45',
                'noTlpAyah' => 'required|max:15',
                'noTlpIbu' => 'required|max:15',
                'alamatAyah' => 'required|max:125',
                'alamatIbu' => 'required|max:125',

                'namaWali' => 'nullable|max:45',
                'pekerjaanWali' => 'nullable|max:45',
                'noTlpWali' => 'nullable|max:15',
                'alamatWali' => 'nullable|max:125',
            ], [
                'namaSiswa.required' => 'Masukan nama lengkap.',
                'namaSiswa.max' => 'Nama lengkap maksimal 45 karakter.',
                'panggilan.required' => 'Masukan nama panggilan.',
                'panggilan.max' => 'Nama panggilan maksimal 45 karakter.',
                'tempatLahir.required' => 'Masukan tempat lahir.',
                'tempatLahir.max' => 'Tempat lahir maksimal 10 karakter.',
                'tanggalLahir.required' => 'Masukan tanggal lahir.',
                'jenisKelamin.required' => 'Masukan jenis kelamin.',
                'agama.required' => 'Masukan agama.',
                'alamat.required' => 'Masukan alamat domisili.',
                'alamat.max' => 'Alamat terlalu panjang, maksimal 125 karakter.',

                'namaAyah.required' => 'Masukan nama ayah.',
                'namaAyah.max' => 'Nama ayah maksimal 45 karakter.',
                'namaIbu.required' => 'Masukan nama ibu.',
                'namaIbu.max' => 'Nama ibu maksimal 45 karakter.',
                'pekerjaanAyah.required' => 'Masukan pekerjaan ayah.',
                'pekerjaanAyah.max' => 'Pekerjaan ayah maksimal 45 karakter.',
                'pekerjaanIbu.required' => 'Masukan pekerjaan ibu.',
                'pekerjaanIbu.max' => 'Pekerjaan ibu maksimal 45 karakter.',
                'noTlpAyah.required' => 'Masukan nomor telepon ayah.',
                'noTlpAyah.max' => 'Nomor telepon ayah maksimal 15 karakter.',
                'noTlpIbu.required' => 'Masukan nomor telepon ibu.',
                'noTlpIbu.max' => 'Nomor telepon ibu maksimal 15 karakter.',
                'alamatAyah.required' => 'Masukan alamat domisili ayah.',
                'alamatAyah.max' => 'Alamat ayah terlalu panjang, maksimal 125 karakter.',
                'alamatIbu.required' => 'Masukan alamat domisili ibu.',
                'alamatIbu.max' => 'Alamat ibu terlalu panjang, maksimal 125 karakter.',

                'namaWali.max' => 'Nama wali maksimal 45 karakter.',
                'pekerjaanWali.required' => 'Masukan pekerjaan wali.',
                'noTlpWali.max' => 'Nomor telepon wali maksimal 15 karakter.',
                'alamatWali.max' => 'Alamat wali terlalu panjang, maksimal 125 karakter.',
            ]);

            if ($validatedData->fails()) {
                return response()->json(['status' => 0, 'error' => $validatedData->errors()->toArray()]);
            } else {
                $tanggalLahir = Carbon::createFromFormat('d/m/Y', $request->tanggalLahir)->format('Y-m-d');
                $requestData = $request->all();
                $requestData['tanggalLahir'] = $tanggalLahir;

                $bio->update($requestData);

                return response()->json(['status' => 'success', 'msg' => 'Profil berhasil diperbarui.']);
            }
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());
        }


        // return back()->with('siswa_success', 'Biografi siswa berhasil diubah.');
    }
}
