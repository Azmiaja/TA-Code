<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BagiGuruController extends Controller
{
    public function index()
    {
        return view('mkelas.bagiguru', [
            'title' => 'Manajemen Kelas',
            'title2' => 'Pembagian Guru',
        ]);
    }
}
