<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $periode = Periode::orderBy('idPeriode', 'desc')->get();
        return view('mkelas.penilaian', compact('periode'),[
            'title' => 'Manajemen Kelas',
            'title2' => 'Penilaian',
        ]);
    }
}
