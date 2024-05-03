<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai_TP extends Model
{
    use HasFactory;

    protected $table = 'nilai_tp';
    protected $guarded = ['idNilaiTP'];
    protected $primaryKey = 'idNilaiTP';
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
    public function sumatif_tp()
    {
        return $this->hasMany(TP_sumatif::class, 'idTP');
    }
}
