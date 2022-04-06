@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Sedes</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h3 class="text-center">Dashboard Content</h3> -->
                        <a class="btn btn-warning" href="{{ route('sedes.create') }}">Nuevo</a>

                        <table class="table table-striped mt-2">
                            <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">Nombre</th>
                                <th style="color:#fff;">Municipio</th>
                                <th style="color:#fff;">Estado</th>
                                <th style="color:#fff;">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($sedes as $sede)
                                <tr>
                                    <td style="display: none;">{{ $sede->id }}</td>
                                    <td>{{ $sede->nombre }}</td>
                                    <td>{{ $sede->municipio }}</td>
                                    <td>{{ $sede->estado }}</td>

                                    <td>
                                        <a class="btn btn-info" href="{{ route('sedes.edit',$sede->id) }}">Editar</a>

                                        {!! Form::open(['method' => 'DELETE','route' => ['sedes.destroy', $sede->id],'style'=>'display:inline']) !!}
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
