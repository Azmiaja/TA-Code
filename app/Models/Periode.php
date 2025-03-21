<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periode';
    protected $guarded = ['idPeriode'];
    protected $primaryKey = 'idPeriode';
    public $timestamps = false;

    // Define the relationship with the Kelas model
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'idPeriode');
    }
    // protected $fillable = ['semester', 'tanggalMulai', 'tanggalSelesai'];

    // Define the relationship with the Pegawai model
    public function pegawai()
    {
        return $this->kelas->belongsTo(Pegawai::class, 'idPegawai');
    }

    
    public function pengajar()
    {
        return $this->hasMany(Pengajaran::class, 'idPengajaran');
    }
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'idJadwal');
    }
    public function kegiatan()
    {
        return $this->hasMany(KegEkstra::class, 'idPeriode');
    }
    public function naik_kelas()
    {
        return $this->hasMany(KetNaikTidak::class, 'idNK');
    }
}
