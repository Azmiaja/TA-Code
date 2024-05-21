<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanGuru extends Model
{
    use HasFactory;

    protected $table = 'catatan_guru';
    protected $guarded = ['idCtGuru'];
    protected $primaryKey = 'idCtGuru';
    public $timestamps = false;

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'idSiswa');
    }
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'idKelas');
    }
    public function periode()
    {
        return $this->hasMany(Periode::class, 'idPeriode');
    }
}
