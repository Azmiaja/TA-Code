<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BagiSiswaController extends Controller
{
    public function index()
    {
        return view('mkelas.bagisiswa', [
            'title' => 'Manajemen Kelas',
            'title2' => 'Pembagian Siswa',
        ]);
    }
}
