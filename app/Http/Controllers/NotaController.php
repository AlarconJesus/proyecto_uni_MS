<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\PDF;
use App\Models\Seccion;
use App\Models\Estudiante;
use App\Models\Materia;
use App\Models\Estudiante_Materia_Nota;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $secciones = Seccion::All();
        return view('notas.index', compact('secciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notas.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getSeccionEstudiante(Request $request, $id)
    {
        $seccion = Seccion::where('id', '=', $id)->first();
        $estudiantes = Estudiante::with('secciones')->get()->where('secciones', '!=', '[]');

        return view('notas.estudiantes', compact('estudiantes', 'seccion', 'id'));
    }

    public function getSeccionMateria(Request $request)
    {
        $seccion = Seccion::where('id', '=', $request->seccion)->first();
        $materias = $seccion->materias;
        return response()->json(['materias' => $materias], 200);
    }

    public function setMateriaEstudianteNota(Request $request)
    {
        $estudiante = Estudiante::find($request->estudiante);


        // $materias = $request->materias;
        // $notas = $request->notas;
        // $seccion = Seccion::where('id', '=', $request->seccion)->first();
        $materias_notas = $request->materias_notas;
        $notaYaAsignada = [];

        for ($i = 0; $i < count($materias_notas); $i++) {
            return $materias_notas[$i][0];
            if ($estudiante->materias()->contains($materias_notas[$i][0])) {
            } else {
                $estudiante->materias()->attach([
                    $materias_notas[$i][0] => ['nota' => $materias_notas[$i][1]],
                ]);
            }
            // DB::table('estudiante_materia_nota')->insert(
            //     ['estudianteId' => $estudiante, 'materiaId' => $materias_notas[$i][0], 'nota' => $materias_notas[$i][1]],
            // );

        }

        // Aqui estoy retornando el arreglo de materias.
        return response()->json(['calificacion' => 'exitosa']);
    }

    public function imprimir()
    {

        $pdf = PDF::loadView('ejemplo', compact('today'));
        return $pdf->download('ejemplo.pdf');
    }
}
