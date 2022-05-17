<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'trayecto', 'trimestre'];
    public function users()
    {
        return $this->belongsToMany(User::class, 'materia_user', 'materiaId', 'userId');
    }
    public function secciones()
    {
        return $this->belongsToMany(Seccion::class, 'materia_seccion', 'materiaId', 'seccionId');
    }
}
