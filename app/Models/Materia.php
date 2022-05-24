<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'trayecto', 'trimestre', 'id_carrera'];
    public function users()
    {
        return $this->belongsToMany(User::class, 'materia_user', 'materiaId', 'userId');
    }
    public function carreras()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera');
    }
    public function secciones()
    {
        return $this->belongsToMany(Seccion::class, 'materia_seccion', 'materiaId', 'seccionId');
    }
    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'estudiante_materia_nota', 'materiaId', 'estudianteId');
    }
}
