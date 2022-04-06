<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'codigo', 'id_sede'];

    public function sedes()
    {
        return $this->belongsTo(Sede::class, 'id_sede');
    }

    public $timestamps = false;
}
