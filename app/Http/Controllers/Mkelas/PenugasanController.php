<?php

namespace App\Http\Controllers\Mkelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenugasanController extends Controller
{
    public function index()
    {
        return view('mkelas.penugasan', [
            'title' => 'Manajemen Kelas',
            'title2' => 'Penugasan',
        ]);
    }
}
