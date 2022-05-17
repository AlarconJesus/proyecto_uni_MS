<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'codigo', 'trayecto', 'id_sede'];

    public function sedes()
    {
        return $this->belongsTo(Sede::class, 'id_sede');
    }

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'materia_seccion', 'seccionId', 'materiaId');
    }

    public $timestamps = false;
}
