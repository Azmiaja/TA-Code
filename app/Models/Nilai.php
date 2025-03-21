<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';
    protected $guarded = ['idNilai'];
    protected $primaryKey = 'idNilai';
    public $timestamps = false;

    // protected $fillable = ['idSiswa', 'idPeriode', 'idPengajaran', 'idKategoriNilai', 'nilai'];

    public function periode()
    {
        return $this->hasMany(Periode::class, 'idPeriode');
    }

    public function pengajaran()
    {
        return $this->hasMany(Pengajaran::class, 'idPengajaran');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'idSiswa');
    }
    public function sumatif_lm()
    {
        return $this->hasMany(LM_sumatif::class, 'idLM');
    }
    public function sumatif_tp()
    {
        return $this->hasMany(TP_sumatif::class, 'idTP');
    }
}
