<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absen';
    protected $guarded = ['idAbsen'];
    protected $primaryKey = 'idAbsen';
    public $timestamps = false;

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'idSiswa');
    }
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'idKelas');
    }
    public function pengajaran()
    {
        return $this->hasMany(Pengajaran::class, 'idPengajaran');
    }
}
