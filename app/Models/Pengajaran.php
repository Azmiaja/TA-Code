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
        return $this->belongsTo(Periode::class, 'idPeriode');
    }
    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'idPegawai');
    }
    
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'idMapel');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'idKelas');
    }
    

}
