<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;

    protected $table = 'pesan';
    protected $guarded = ['idPesan'];
    protected $primaryKey = 'idPesan';
    public $timestamps = false;
}
