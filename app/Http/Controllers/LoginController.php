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


    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        $guards = ['user', 'siswa'];

        foreach ($guards as $guard) {
            if ($this->attemptUserLogin($credentials, $guard)) {
                return redirect()->intended('/dashboard');
            }
        }

        return back()->with('error', 'Username atau password salah.');
    }

    private function attemptUserLogin($credentials, $guard)
    {
        return Auth::guard($guard)->attempt($credentials);
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
