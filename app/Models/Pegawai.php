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
    public $timestamps = false;

    protected $fillable = [
        'nip', 'namaPegawai', 'jenisKelamin', 'tempatLahir', 'tanggalLahir', 'agama', 'alamat', 'jenisPegawai', 'noHp' , 'status'
        // Add other fields as needed
    ];


    // Define the relationship with the Kelas model
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'idPegawai');
    }

    public function pp_guru()
    {
        return $this->hasMany(PPGuru::class, 'idPegawai');
    }

    // Define the relationship with the Periode model
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'idPeriode');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
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
