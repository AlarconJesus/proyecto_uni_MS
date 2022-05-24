<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $fillable = ['nombre_completo', 'cedula', 'direccion', 'id_seccion'];

    public function secciones()
    {
        return $this->belongsToMany(Seccion::class, 'estudiante_seccion', 'estudianteId', 'seccionId');
    }

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'estudiante_materia_nota', 'estudianteId', 'materiaId');
    }
}
