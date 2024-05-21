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


    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'idUser', 'idUser');
    // }

    // public function getRouteKey()
    // {
    //     return 'slug';
    // }
}
