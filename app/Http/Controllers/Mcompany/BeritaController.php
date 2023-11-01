<?php

namespace App\Http\Controllers\Mcompany;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        return view('mcompany.berita', [
            'title' => 'Manajemen Company',
            'title2' => 'Berita Sekolah',
            
        ]);
    }
}
