<?php

namespace App\Http\Controllers\Mcompany;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    public function index()
    {
        return view('mcompany.visimisi', [
            'title' => 'Manajemen Company',
            'title2' => 'Visi Misi Sekolah',
        ]);
    }
}
