<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    public function index()
    {
        return view('login');
    }

    // fungsi login
    // public function authenticate(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required',
    //         'password' => 'required|min:3|max:12',
    //     ]);

    //     $credentials = $request->only('username', 'password');

    //     if (Auth::guard('user')->attempt($credentials)) {
    //         $user = Auth::guard('user')->user();

    //         if ($user->hakAkses == 'Admin') {
    //             return redirect()->intended('/dashboard');
    //         } elseif ($user->hakAkses == 'Guru') {
    //             return redirect()->intended('/home');
    //         }
    //     } elseif (Auth::guard('siswa')->attempt($credentials)) {
    //         $siswa = Auth::guard('siswa')->user();

    //         if ($siswa->hakAkses == 'Siswa') {
    //             return redirect()->intended('/home');
    //         }
    //     } else {
    //         return redirect('/login')->with('error', 'Username atau Password salah!');
    //     }
    // }
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        if ($this->attemptUserLogin($credentials, 'user')) {
            return redirect()->intended($this->getRedirectionPath(Auth::guard('user')->user()->hakAkses));
        }

        if ($this->attemptUserLogin($credentials, 'siswa')) {
            return redirect()->intended($this->getRedirectionPath(Auth::guard('siswa')->user()->hakAkses));
        }

        return back()->with('error', 'Username atau password salah.');
    }

    private function attemptUserLogin($credentials, $guard)
    {
        return Auth::guard($guard)->attempt($credentials);
    }

    private function getRedirectionPath($hakAkses)
    {
        switch ($hakAkses) {
            case 'Super Admin':
                return route('dashboard.super_admin');
            case 'Admin':
                return route('dashboard.admin');
            case 'Guru':
                return route('dashboard.guru');
            case 'Siswa':
                return route('dashboard.siswa');
            // Tambahkan case lain jika perlu
            default:
                return '/dashboard'; // Sesuaikan dengan path default yang diinginkan
        }
        // if ($hakAkses === 'Admin') {
        //     return '/dashboard';
        // } elseif ($hakAkses === 'Guru' || $hakAkses === 'Siswa') {
        //     return '/home';
        // }
        // Add other roles and redirections if necessary
    }


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

        return redirect('/');
    }
}
