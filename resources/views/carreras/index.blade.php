@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">
@endsection

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
                        <!-- <h3 class="text-center">Dashboard Content</h3> -->
                        <a class="btn btn-warning" style="margin-bottom: 10px;" href="{{ route('carreras.create') }}">Nuevo</a>

                        <table id="tabla" class="table table-light table-striped table-bordered shadow-lg mt" style="width: 100%;">
                            <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">Nombre</th>
                                <th style="color:#fff;">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($carreras as $carrera)
                                <tr>
                                    <td style="display: none;">{{ $carrera->id }}</td>
                                    <td>{{ $carrera->nombre }}</td>

                                    <td>
                                        <a class="btn btn-info" href="{{ route('carreras.edit',$carrera->id) }}">Editar</a>

                                        {!! Form::open(['method' => 'DELETE','route' => ['carreras.destroy', $carrera->id],'style'=>'display:inline']) !!}
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

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabla').DataTable();
    });
</script>
@endsection

@endsection
