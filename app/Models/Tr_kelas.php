<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_kelas extends Model
{
    use HasFactory;

    protected $table = 'tr_kelas';
    protected $guarded = ['idtrKelas'];
    protected $primaryKey = 'idtrKelas';
    public $timestamps = false;

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'idKelas', 'idKelas');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'idSiswa');
    }
}
