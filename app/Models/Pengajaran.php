<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajaran extends Model
{
    use HasFactory;

    protected $table = 'pengajaran';
    protected $guarded = ['idPengajaran'];
    protected $primaryKey = 'idPengajaran';
    public $timestamps = false;

    public function periode()
    {
        return $this->hasOne(Periode::class, 'idPeriode', 'idPeriode');
    }
    public function guru()
    {
        return $this->hasOne(Pegawai::class, 'idPegawai', 'idPegawai');
    }

    public function mapel()
    {
        return $this->hasOne(Mapel::class, 'idMapel', 'idMapel');
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'idKelas', 'idKelas');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'idPengajaran');
    }
}
