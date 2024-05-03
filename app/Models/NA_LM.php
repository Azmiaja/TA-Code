<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NA_LM extends Model
{
    use HasFactory;

    protected $table = 'na_lm';
    protected $guarded = ['idNa_lm'];
    protected $primaryKey = 'idNa_lm';
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
}
