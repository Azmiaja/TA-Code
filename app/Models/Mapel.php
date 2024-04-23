<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';
    protected $guarded = ['idMapel'];
    protected $primaryKey = 'idMapel';
    public $timestamps = false;

    public function pengajar()
    {
        return $this->hasMany(Pengajaran::class, 'idMapel');
    }
}
