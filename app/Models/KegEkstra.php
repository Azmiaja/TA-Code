<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegEkstra extends Model
{
    use HasFactory;

    
    protected $table = 'kegiatan_ekstra';
    protected $guarded = ['idKegiatan'];
    protected $primaryKey = 'idKegiatan';
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
    public function ekstra()
    {
        return $this->hasOne(Ekstrakulikuler::class, 'idEks', 'idEks');
    }
}
