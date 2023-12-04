<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Di dalam HomeController
    public function indexHome()
    {
        return view('home', [
            'title' => 'Home',
            'title2' => 'Home',
        ]);
    }

    // for Dashboard
    public function indexDashboard()
    {
        $pegawai = Pegawai::all()->count();
        $siswa = Siswa::all()->count();
        $jumlahPegawaiAktif = Pegawai::where('status', 'Aktif')->count();
        return view('dashboard', compact('pegawai', 'siswa', 'jumlahPegawaiAktif'), [
            'title' => 'Dashboard',
            'title2' => 'Dashboard',
        ]);
    }
    

}
