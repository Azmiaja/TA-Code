<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $guarded = ['idPegawai'];
    protected $primaryKey = 'idPegawai';
    protected $foreignKey = 'idJabatan';
    public $timestamps = false;


    // Define the relationship with the Kelas model
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'idPegawai', 'idPegawai');
    }

    public function jabatanPegawai()
    {
        return $this->hasOne(Jabatan::class, 'idJabatan', 'idJabatan');
    }

    // Define the relationship with the Periode model
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'idPeriode');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'idPegawai');
    }

    public function pengajar()
    {
        return $this->hasMany(Pengajaran::class, 'idPengajaran');
    }

    public function getPeriodeGuru($jenisPegawai, $idPeriode)
    {
        return $this->where('jenisPegawai', $jenisPegawai)
            ->whereHas('kelas', function ($query) use ($idPeriode) {
                $query->where('idPeriode', $idPeriode);
            })
            ->with(['kelas' => function ($query) use ($idPeriode) {
                $query->where('idPeriode', $idPeriode);
            }])
            ->get(['namaPegawai', 'nip', 'jenisKelamin', 'kelas.namaKelas']);
    }
}
