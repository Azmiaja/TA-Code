<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai_rata_rata extends Model
{
    use HasFactory;

    protected $table = 'nilai_rata_rata';
    protected $guarded = ['idNilaiRataRata'];
    protected $primaryKey = 'idNilaiRataRata';
    public $timestamps = false;
}
