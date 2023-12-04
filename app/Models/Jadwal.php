<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'Jadwal';
    protected $guarded = ['idJadwal'];
    protected $primaryKey = 'idJadwal';
    public $timestamps = false;

    public function pengajaran()
    {
        return $this->belongsTo(Pengajaran::class, 'idPengajaran');
    }
    
    public function guru()
    {
        return $this->pengajaran->belongsTo(Pegawai::class, 'idPegawai');
    }
    public function mapel()
    {
        return $this->pengajaran->belongsTo(Mapel::class, 'idMapel');
    }
    public function periode()
    {
        return $this->pengajaran->belongsTo(Periode::class, 'idPeriode');
    }
    public function kelas()
    {
        return $this->pengajaran->belongsTo(Kelas::class, 'idKelas');
    }
}
