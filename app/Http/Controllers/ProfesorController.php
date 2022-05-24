<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesor;
use App\Models\Seccion;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profesores = Profesor::All();
        return view('profesores.index', compact('profesores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('profesores.crear');
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

        $user = Profesor::create($input);
        // $user->assignRole($request->input('roles'));

        return redirect()->route('profesores.index');
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
    public function edit(Profesor $profesore)
    {
        return view('profesores.editar', compact('profesore'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profesor $profesore)
    {
        // request()->validate([
        //     'titulo' => 'required',
        //     'contenido' => 'required',
        // ]);

        $profesore->update($request->all());

        return redirect()->route('profesores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profesor $profesore)
    {
        $profesore->delete();

        return redirect()->route('profesores.index');
    }

    public function getSeccionProfesor(Request $request)
    {
        $secciones = Seccion::All();
        return response()->json(['secciones' => $secciones], 200);
    }

    public function setSeccionProfesor(Request $request)
    {
        $secciones = $request->secciones;
        $profesor = Profesor::where('id', '=', $request->profesor)->first();

        // $seccion->attachMaterias($materias);
        $profesor->secciones()->sync($secciones);

        $secciones = Profesor::with('secciones')->find($request->profesor);
        // si son varias relaciones se envia un array

        // Aqui estoy retornando el arreglo de materias.
        return response()->json(['secciones' => $secciones->secciones]);
    }
}
