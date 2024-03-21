<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $guarded = ['idJadwal'];
    protected $primaryKey = 'idJadwal';
    public $timestamps = false;

    public function pengajaran()
    {
        return $this->hasOne(Pengajaran::class, 'idPengajaran', 'idPengajaran');
    }
    
    public function periode()
    {
        return $this->hasOne(Periode::class, 'idPeriode', 'idPeriode');
    }
    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'idKelas', 'idKelas');
    }
}
