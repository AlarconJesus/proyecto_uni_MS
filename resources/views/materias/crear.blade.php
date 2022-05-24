@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Materia</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        @if ($errors->any())
                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <strong>¡Revise los campos!</strong>
                            @foreach ($errors->all() as $error)
                            <span class="badge badge-danger">{{ $error }}</span>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <form action="{{ route('materias.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" name="nombre" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="trimestre">Trimestre</label>
                                            <input type="text" name="trimestre" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="trayecto">Trayecto</label>
                                            <input type="text" name="trayecto" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">

                                        @if(sizeof($carreras) == 0)
                                        <label for="id_carrera">Carrera</label>
                                        <h3>No hay PNFs registradas, crea una primero. </h3>
                                        <a href="/sedes" class="btn btn-warning">Ir a PNFs</a>

                                        @else
                                        <div class="form-group">
                                            <label for="id_carrera">PNF</label>
                                            @foreach($carreras as $carrera)
                                            <div class="form-check">
                                                <input type="radio" id="{{$carrera->id}}" name="id_carrera" value="{{$carrera->id}}">
                                                <label class="form-check-label" for="{{$carrera->id}}">
                                                    {{$carrera->nombre}}, {{$carrera->municipio}}, {{$carrera->estado}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
