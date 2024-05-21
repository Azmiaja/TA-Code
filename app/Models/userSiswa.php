<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class userSiswa extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    protected $table = 'usersiswa';
    protected $guarded = ['idUserSiswa']; 
    protected $primaryKey = 'idUserSiswa';
    // protected $fillable = ['username', 'password', 'hakAkses', 'idSiswa'];
    // protected $hidden = ['password', 'remember_token'];
    public $timestamps = false;

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'idSiswa', 'idSiswa');
    }
}
