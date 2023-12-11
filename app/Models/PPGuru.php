<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPGuru extends Model
{
    use HasFactory;

    protected $table = 'ppGuru';
    protected $guarded = ['idppGuru'];
    protected $primaryKey = 'idppGuru';
    public $timestamps = false;

    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'idPegawai');
    }
}
