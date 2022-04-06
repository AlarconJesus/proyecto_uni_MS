<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'municipio', 'estado'];

    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'id');
    }

    public $timestamps = false;
}
