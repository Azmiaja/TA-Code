<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    protected $table = 'user';
    protected $guarded = ['idUser']; 
    protected $primaryKey = 'idUser';
    // protected $fillable = ['username', 'password', 'hakAkses', 'idPegawai'];
    // protected $hidden = ['password', 'remember_token'];
    public $timestamps = false;

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'idPegawai', 'idPegawai');
    }
}
