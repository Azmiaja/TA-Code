<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $guarded = ['idSiswa'];
    protected $primaryKey = 'idSiswa';

    protected $fillable = ['nama']; // field yang bisa di isi
    public $timestamps = false;
}
