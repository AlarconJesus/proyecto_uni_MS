@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Materias</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Dashboard Content</h3>
                        @foreach ($materias as $materia)
                        <h2>{{$materia->nombre}}</h2>
                        @endforeach

                        <table class="table table-striped mt-2">
                            <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">Nombre</th>
                                <th style="color:#fff;">Trayecto</th>
                                <th style="color:#fff;">Trimestre</th>
                                <th style="color:#fff;">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($materias as $materia)
                                <tr>
                                    <td style="display: none;">{{ $materia->id }}</td>
                                    <td>{{ $materia->nombre }}</td>
                                    <td>{{ $materia->trayecto }}</td>
                                    <td>{{ $materia->trimestre }}</td>

                                    <td>
                                        <a class="btn btn-info" href="{{ route('materias.edit',$materia->id) }}">Editar</a>

                                        {!! Form::open(['method' => 'DELETE','route' => ['materias.destroy', $materia->id],'style'=>'display:inline']) !!}
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
