@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Secciones</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-warning" href="{{ route('secciones.create') }}">Nuevo</a>

                        <table class="table table-striped mt-2">
                            <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">Nombre</th>
                                <th style="color:#fff;">Codigo</th>
                                <th style="color:#fff;">Sede</th>
                                <th style="color:#fff;">Municipio</th>
                                <th style="color:#fff;">Estado</th>
                                <th style="color:#fff;">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($secciones as $seccion)
                                <tr>
                                    <td style="display: none;">{{ $seccion->id }}</td>
                                    <td>{{ $seccion->nombre }}</td>
                                    <td>{{ $seccion->codigo }}</td>

                                    @if ($seccion->sedes)
                                    <td>{{ $seccion->sedes->nombre }}</td>
                                    <td>{{ $seccion->sedes->municipio }}</td>
                                    <td>{{ $seccion->sedes->estado }}</td>
                                    @else
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    @endif

                                    <td>
                                        <a class="btn btn-info" href="{{ route('secciones.edit',$seccion->id) }}">Editar</a>

                                        {!! Form::open(['method' => 'DELETE','route' => ['secciones.destroy', $seccion->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Centramos la paginacion a la derecha -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
