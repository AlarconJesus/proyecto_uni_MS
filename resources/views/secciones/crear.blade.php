@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Sección</h3>
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

                        <form action="{{ route('secciones.store') }}" method="POST">
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
                                            <label for="trimestre">Codigo</label>
                                            <input type="text" name="codigo" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="trayecto">Trayecto</label>
                                            <input type="text" name="trayecto" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">

                                        @if(sizeof($sedes) == 0)
                                        <label for="id_sede">Sede</label>
                                        <h3>No hay sedes registradas, crea una primero. </h3>
                                        <a href="/sedes" class="btn btn-warning">Ir a Sedes</a>

                                        @else
                                        <div class="form-group">
                                            <label for="id_sede">Sede</label>
                                            @foreach($sedes as $sede)
                                            <div class="form-check">
                                                <input type="radio" id="{{$sede->id}}" name="id_sede" value="{{$sede->id}}">
                                                <label class="form-check-label" for="{{$sede->id}}">
                                                    {{$sede->nombre}}, {{$sede->municipio}}, {{$sede->estado}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>

                                    @if(sizeof($sedes) != 0)
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    @endif
                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
