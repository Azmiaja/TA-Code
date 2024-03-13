<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_kelas extends Model
{
    use HasFactory;

    protected $table = 'tr_kelas';
    protected $guarded = ['idtrKelas'];
    protected $primaryKey = 'idtrKelas';
    public $timestamps = false;

    protected $fillable = ['idSiswa', 'idKelas'];

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'idKelas',);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'idSiswa');
    }
}
