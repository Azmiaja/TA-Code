<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamKe extends Model
{
    use HasFactory;

    protected $table = 'jamke';
    protected $guarded = ['idjamKe'];
    protected $primaryKey = 'idjamKe';
    public $timestamps = false;

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'idJadwal');
    }
}
