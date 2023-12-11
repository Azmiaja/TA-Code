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
        return $this->belongsTo(Periode::class, 'idPeriode');
    }

    public function pengajaran()
    {
        return $this->belongsTo(Pengajaran::class, 'idPengajaran');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'idSiswa');
    }
}
