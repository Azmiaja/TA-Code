<?php

namespace App\Http\Controllers\Mkeuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('mkeuangan.laporan', [
            'title' => 'Manajemen Keuangan',
            'title2' => 'Laporan',
            
        ]);
    }
}
