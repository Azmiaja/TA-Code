<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajaran extends Model
{
    use HasFactory;

    protected $table = 'pengajaran';
    protected $guarded = ['idPengajaran'];
    protected $primaryKey = 'idPengajaran';
    public $timestamps = false;
}
