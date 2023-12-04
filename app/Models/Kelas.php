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
        return $this->belongsTo(Pegawai::class, 'idPegawai');
    }
    public function pengajaran()
    {
        return $this->hasMany(Pengajaran::class, 'idKelas');
    }

    // public function pengajaran()
    // {
    //     return $this->hasOne(Pengajaran::class, 'idPengajaran');
    // }
}
