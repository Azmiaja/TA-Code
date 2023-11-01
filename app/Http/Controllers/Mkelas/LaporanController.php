<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('mkelas.laporan', [
            'title' => 'Manajemen Kelas',
            'title2' => 'Laporan',
        ]);
    }
}
