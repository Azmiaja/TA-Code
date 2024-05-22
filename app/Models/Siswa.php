<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $guarded = ['idSiswa'];
    protected $primaryKey = 'idSiswa';

    public $timestamps = false;

    // public function tr_kelas()
    // {
    //     return $this->hasMany(Tr_kelas::class, 'idSiswa', 'idSiswa');
    // }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'idSiswa');
    }
    public function absen()
    {
        return $this->hasOne(Absensi::class, 'idAbsen', 'idAbsen');
    }
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'tr_kelas', 'idSiswa', 'idKelas');
    }
    public function kegiatan()
    {
        return $this->hasMany(KegEkstra::class, 'idSiswa');
    }
    public function naik_kelas()
    {
        return $this->hasMany(KetNaikTidak::class, 'idSiswa');
    }
    public function userSiswa()
    {
        return $this->hasOne(userSiswa::class, 'idSiswa');
    }
}
