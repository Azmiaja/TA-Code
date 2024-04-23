<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $guarded = ['idKelas'];
    protected $primaryKey = 'idKelas';
    public $timestamps = false;

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'idPeriode');
    }

    public function guru()
    {
        return $this->hasOne(Pegawai::class, 'idPegawai', 'idPegawai');
    }
    public function absen()
    {
        return $this->hasOne(Absensi::class, 'idAbsen', 'idAbsen');
    }
    public function pengajaran()
    {
        return $this->hasMany(Pengajaran::class, 'idKelas');
    }
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'idKelas');
    }
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'tr_kelas', 'idKelas', 'idSiswa');
    }
    // public function tr_kelas()
    // {
    //     return $this->hasMany(Tr_kelas::class, 'idKelas', 'idKelas');
    // }

}
