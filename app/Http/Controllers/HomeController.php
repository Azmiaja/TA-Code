<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'title' => 'Home',
            'title2' => 'Home',
        ]);
    }
}
