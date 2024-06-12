<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{


    public function index()
    {
        $sekolah = Sekolah::select('namaSekolah', 'logo')->first();
        return view('login', [
            'title' => $sekolah->namaSekolah ?? 'SDN Lemahbang',
            'logo' => $sekolah->logo ? (file_exists(public_path('storage/' . $sekolah->logo))
                ? asset('storage/' . $sekolah->logo)
                : asset('assets/media/img/tut-wuri.png'))
                : asset('assets/media/img/tut-wuri.png'),
        ]);
    }


    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            // $request->validate([
            //     'username' => 'required',
            //     'password' => 'required'
            // ]);

            $credentials = $request->only('username', 'password');

            $guards = ['user', 'siswa'];

            foreach ($guards as $guard) {
                if ($this->attemptUserLogin($credentials, $guard)) {
                    // return redirect()->intended('/dashboard');
                    // Cek peran setelah berhasil login
                    $user = Auth::guard($guard)->user();

                    if ($user->hakAkses === 'Guru') {
                        return redirect()->route('gg.beranda.index');
                    } elseif ($guard === 'siswa') {
                        return redirect()->route('ss.beranda.index');
                    } else {
                        return redirect()->route('dashboard.index');
                    }
                } else {
                    // Cek apakah login gagal karena akun tidak aktif
                    if ($guard === 'siswa' && $this->isAccountInactive($credentials, $guard)) {
                        return back()->with('error', 'Akun Anda tidak aktif.');
                    } elseif ($guard === 'user' && $this->isAccountInactive($credentials, $guard)) {
                        return back()->with('error', 'Akun Anda tidak aktif.');
                    }
                }
            }

            return back()->with('error', 'Username atau password salah.');
        }
    }

    private function isAccountInactive($credentials, $guard)
    {
        return Auth::guard($guard)->validate($credentials);
    }

    private function attemptUserLogin($credentials, $guard)
    {
        if (Auth::guard($guard)->attempt($credentials)) {
            $user = Auth::guard($guard)->user();

            // Periksa status pengguna
            if ($guard === 'siswa' && $user->siswa->status !== 'Aktif') {
                Auth::guard($guard)->logout();
                return false;
            } elseif ($guard === 'user' && $user->pegawai->status !== 'Aktif') {
                Auth::guard($guard)->logout();
                return false;
            }

            return true;
        }

        // Jika login gagal, kembalikan false
        return false;
    }

    // private function attemptUserLogin($credentials, $guard)
    // {
    //     return Auth::guard($guard)->attempt($credentials);
    // }




    // fungsi regist
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = new User;
        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->save();

        // Anda bisa menambahkan logika tambahan, seperti autentikasi langsung setelah pendaftaran

        return redirect('/home')->with('success', 'Pendaftaran berhasil. Silakan login.');
    }

    //fungsi logout
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
