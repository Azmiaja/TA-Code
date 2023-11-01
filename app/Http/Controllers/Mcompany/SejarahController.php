<?php

namespace App\Http\Controllers\Mcompany;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SejarahController extends Controller
{
    public function index()
    {
        return view('mcompany.sejarah', [
            'title' => 'Manajemen Company',
            'title2' => 'Sejarah Sekolah',
            
        ]);
    }
}
