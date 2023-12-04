<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $guarded = ['idBerita'];
    protected $primaryKey = 'idBerita';
    public $timestamps = false;

    protected $fillable =[
        'judulBerita',
        'isiBerita',
        'waktuBerita',
        'sumberBerita',
        'gambar'
    ];
}
