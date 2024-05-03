<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TP_sumatif extends Model
{
    use HasFactory;
    protected $table = 'sumatif_tp';
    protected $guarded = ['idTP'];
    protected $primaryKey = 'idTP';
    public $timestamps = false;

    public function mapel()
    {
        return $this->hasMany(Mapel::class, 'idMapel');
    }
}
