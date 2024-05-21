<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KetNaikTidak extends Model
{
    use HasFactory;

    protected $table = 'naik_kelas';
    protected $guarded = ['idNK'];
    protected $primaryKey = 'idNK';
    public $timestamps = false;

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'idSiswa', 'idSiswa');
    }
    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'idKelas', 'idKelas');
    }
    public function periode()
    {
        return $this->hasOne(Periode::class, 'idPeriode', 'idPeriode');
    }
}
