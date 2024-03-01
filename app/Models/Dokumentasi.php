<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi';
    protected $guarded = ['idDokumentasi'];
    protected $primaryKey = 'idDokumentasi';
    // protected $foreignKey = 'idUser';
    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

}
