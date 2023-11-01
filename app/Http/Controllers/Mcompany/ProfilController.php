<?php

namespace App\Http\Controllers\Mcompany;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        return view('mcompany.profil', [
            'title' => 'Manajemen Company',
            'title2' => 'Profil Sekolah',
            
        ]);
    }
}
