<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenjadwalanController extends Controller
{
    public function index()
    {
        return view('mkelas.penjadwalan', [
            'title' => 'Manajemen Kelas',
            'title2' => 'Penjadwalan',
        ]);
    }
}
