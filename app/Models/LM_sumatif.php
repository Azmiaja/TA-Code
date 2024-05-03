<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LM_sumatif extends Model
{
    use HasFactory;
    protected $table = 'sumatif_lm';
    protected $guarded = ['idLM'];
    protected $primaryKey = 'idLM';
    public $timestamps = false;

    public function mapel()
    {
        return $this->hasMany(Mapel::class, 'idMapel');
    }
}
