<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;
    protected $fillable = ['nombre_completo', 'cedula', 'direccion', 'estudios'];

    public function secciones()
    {
        return $this->belongsToMany(Seccion::class, 'profesor_seccion', 'profesorId', 'seccionId');
    }
}
