<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante_Materia_Nota extends Model
{
    use HasFactory;
    protected $fillable = ['estudianteId', 'materiaId', 'nota'];
}
