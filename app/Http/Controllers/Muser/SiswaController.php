<?php

namespace App\Http\Controllers\Muser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        return view('muser.siswa', [
            'title' => 'Manajemen User',
            'title2' => 'Siswa',
            
        ]);
    }
}
