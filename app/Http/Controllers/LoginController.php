<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    public function index()
    {
        return view('login');
    }

    // fungsi login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->hakAkses == 'Guru' || auth()->user()->hakAkses == 'Admin') {
                return redirect()->intended('/home');
            } else {
            return redirect()->intended('/home');}
        }

        // return back()->with('loginError', 'Login Failed!');
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
        // ->onlyInput('email');
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
