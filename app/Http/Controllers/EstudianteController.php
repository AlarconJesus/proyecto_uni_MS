<?php

namespace App\Http\Controllers;

use App\Models\Seccion;
use Illuminate\Http\Request;
use App\Models\Estudiante;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estudiantes = Estudiante::All();
        return view('estudiantes.index', compact('estudiantes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $secciones = Seccion::All();
        return view(' estudiantes.crear', compact('secciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|same:confirm-password',
        //     'roles' => 'required'
        // ]);

        $input = $request->all();
        // $input['password'] = Hash::make($input['password']);

        $user = Estudiante::create($input);
        // $user->assignRole($request->input('roles'));

        return redirect()->route('estudiantes.index');
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
    public function edit(Estudiante $estudiante)
    {
        $secciones = Seccion::All();
        return view(' estudiantes.editar', compact('estudiante', 'secciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estudiante $estudiante)
    {
        // request()->validate([
        //     'titulo' => 'required',
        //     'contenido' => 'required',
        // ]);

        $estudiante->update($request->all());

        return redirect()->route('estudiantes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();

        return redirect()->route('estudiantes.index');
    }

    public function getSeccionEstudiante(Request $request)
    {
        $secciones = Seccion::where('trayecto', '=', $request->trayecto)->get();
        return response()->json(['secciones' => $secciones], 200);
    }

    public function setSeccionEstudiante(Request $request)
    {
        $secciones = $request->secciones;
        $estudiante = Estudiante::where('id', '=', $request->estudiante)->first();

        // $seccion->attachMaterias($materias);
        $estudiante->secciones()->sync($secciones);

        $secciones = Estudiante::with('secciones')->find($request->estudiante);
        // si son varias relaciones se envia un array

        // Aqui estoy retornando el arreglo de materias.
        return response()->json(['secciones' => $secciones->secciones]);
    }
}
