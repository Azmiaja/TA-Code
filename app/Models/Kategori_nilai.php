<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_nilai extends Model
{
    use HasFactory;

    protected $table = 'kategori_nilai';
    protected $guarded = ['idKategoriNilai'];
    protected $primaryKey = 'idKategoriNilai';
    public $timestamps = false;

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'idKategoriNilai');
    }
}
