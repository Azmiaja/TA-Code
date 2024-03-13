<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';
    protected $guarded = ['idJabatan'];
    protected $primaryKey = 'idJabatan';
    public $timestamps = false;


    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'idJabatan');
    }
}
