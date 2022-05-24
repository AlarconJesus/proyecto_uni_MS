@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Mi cuenta</h3>
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

                        <form action="{{ route('micuenta.update',$usuario) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        <input type="text" name="name" disabled class="form-control" value="{{ $usuario->name }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" disabled class="form-control" value="{{$usuario->email}}">
                                        </div>
                                    </div>
                                    <br>
                                    <a class="btn btn-warning" href="{{ route('micuenta.edit',$usuario->id) }}">Editar</a>
                                    <!-- <button type="submit" class="btn btn-primary">Editar</button> -->
                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
