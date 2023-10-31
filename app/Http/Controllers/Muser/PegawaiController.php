<?php

namespace App\Http\Controllers\Muser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all(); // Gantilah dengan model dan nama tabel yang sesuai
        $jumlahGuru = Pegawai::where('jenisPegawai', 'Guru')->count();
        return view('muser.pegawai', compact('pegawai'), [
            'title' => 'Manajemen User',
            'title2' => 'Pegawai',
            'jumlahGuru' => $jumlahGuru,
            
        ]);
    }
}
