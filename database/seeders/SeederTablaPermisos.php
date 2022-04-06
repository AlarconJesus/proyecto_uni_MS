<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//agregamos el modelo de permisos de spatie
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            //Operaciones sobre tabla roles
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',

            //Operaciones sobre tabla usuarios (estudiantes)
            'ver-estudiantes',
            'crear-estudiante',
            'editar-estudiante',
            'borrar-estudiante',

            //Operaciones sobre tabla materias
            'ver-materia',
            'crear-materia',
            'editar-materia',
            'borrar-materia',

            //Operaciones sobre tabla sedes
            'ver-sede',
            'crear-sede',
            'editar-sede',
            'borrar-sede',

            //Operaciones sobre tabla carreras
            'ver-carrera',
            'crear-carrera',
            'editar-carrera',
            'borrar-carrera'
        ];

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}
