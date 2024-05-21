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
        return $this->hasMany(Kelas::class, 'idPegawai');
    }

    public function jabatanPegawai()
    {
        return $this->hasOne(Jabatan::class, 'idJabatan', 'idJabatan');
    }

    // Define the relationship with the Periode model
    

    public function user()
    {
        return $this->hasMany(User::class, 'idPegawai');
    }

    public function pengajar()
    {
        return $this->hasMany(Pengajaran::class, 'idPegawai');
    }
}
