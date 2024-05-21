<?php

namespace App\Models;

use App\Http\Controllers\Rapor\KegiatanEkstra;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakulikuler extends Model
{
    use HasFactory;

    protected $table = 'ekstrakulikuler';
    protected $guarded = ['idEks'];
    protected $primaryKey = 'idEks';
    public $timestamps = false;

    public function kegiatan()
    {
        return $this->hasMany(KegEkstra::class, 'idEks');
    }
}
