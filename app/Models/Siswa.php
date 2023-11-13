<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Siswa extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $table = 'siswa';
    protected $guarded = ['idSiswa'];
    protected $primaryKey = 'idSiswa';

    public $timestamps = false;
}
