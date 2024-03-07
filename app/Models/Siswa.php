<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model 
{
    use HasFactory;

    protected $table = 'siswa';
    protected $guarded = ['idSiswa'];
    protected $primaryKey = 'idSiswa';

    public $timestamps = false;

    public function tr_kelas()
    {
        return $this->hasMany(Tr_kelas::class, 'idSiswa', 'idSiswa');
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'idSiswa');
    }

}
