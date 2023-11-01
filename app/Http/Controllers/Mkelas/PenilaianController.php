<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        return view('mkelas.penilaian', [
            'title' => 'Manajemen Kelas',
            'title2' => 'Penilaian',
        ]);
    }
}
