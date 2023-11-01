<?php

namespace App\Http\Controllers\Mkeuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PemberitahuanController extends Controller
{
    public function index()
    {
        return view('mkeuangan.pemberitahuan', [
            'title' => 'Manajemen Keuangan',
            'title2' => 'Pemberiahuan',
            
        ]);
    }
}
