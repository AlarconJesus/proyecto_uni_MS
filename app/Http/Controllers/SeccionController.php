<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Sede;

class SeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $secciones = Seccion::All();
        return view('secciones.index', compact('secciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sedes = Sede::All();
        return view('secciones.crear', compact('sedes'));
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

        $user = Seccion::create($input);
        // $user->assignRole($request->input('roles'));

        return redirect()->route('secciones.index');
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
    public function edit(Seccion $seccione)
    {
        $sedes = Sede::All();
        return view('secciones.editar', compact('seccione', 'sedes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seccion $seccione)
    {
        // request()->validate([
        //     'titulo' => 'required',
        //     'contenido' => 'required',
        // ]);

        $seccione->update($request->all());

        return redirect()->route('secciones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seccion $seccione)
    {
        $seccione->delete();

        return redirect()->route('secciones.index');
    }

    public function getMateriaSeccion(Request $request)
    {
        $materias = Materia::where('trayecto', '=', $request->trayecto)->get();
        return response()->json(['materias' => $materias], 200);
    }

    public function setMateriaSeccion(Request $request)
    {
        $materias = $request->materias;
        $seccion = Seccion::where('id', '=', $request->seccion)->first();

        foreach ($materias as $materia) {
            $seccion->materias()->sync($materia);
        }
    }
}
