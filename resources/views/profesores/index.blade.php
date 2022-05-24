@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Profesores</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h3 class="text-center">Dashboard Content</h3> -->
                        <a class="btn btn-warning" style="margin-bottom: 10px;" href="{{ route('profesores.create') }}">Nuevo</a>

                        <table id="tabla" class="table table-light table-striped table-bordered shadow-lg mt" style="width: 100%;">
                            <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">Nombre Completo</th>
                                <th style="color:#fff;">Cedula</th>
                                <th style="color:#fff;">Direccion</th>
                                <th style="color:#fff;">Estudios</th>
                                <th style="color:#fff;">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($profesores as $profesor)
                                <tr>
                                    <td style="display: none;">{{ $profesor->id }}</td>
                                    <td>{{ $profesor->nombre_completo }}</td>
                                    <td>{{ $profesor->cedula }}</td>
                                    <td>{{ $profesor->direccion }}</td>
                                    <td>{{ $profesor->estudios }}</td>

                                    <td>
                                        <a class="btn btn-info" href="{{ route('profesores.edit',$profesor->id) }}">Editar</a>
                                        <button type="button" class="btn btn-primary btnConfig" id="{{$profesor->id}}" onclick="showModal(`{{$profesor->id}}`, `{{$profesor->trayecto}}`)">Configurar secciones</button>

                                        {!! Form::open(['method' => 'DELETE','route' => ['profesores.destroy', $profesor->id],'style'=>'display:inline']) !!}
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

<!-- Modal configuracion de secciones-->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Asignar secciones a docente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="profesorID" id="profesorId">
                <div id="list_secciones"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="getSeccionesSelected();">Guardar</button>
            </div>
        </div>
    </div>
</div>
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>
<script>
    let currentProfesorId;

    const profesores = Object.values(document.getElementsByClassName('btnConfig'));
    profesores.forEach(profesor => {
        profesor.addEventListener('mousedown', event => {
            event.preventDefault();
            currentProfesorId = event.path[0].id;
        });
    });

    function showModal(profesor) {

        $('#list_secciones').empty();

        // if (!trayecto) {
        //     const Toast = Swal.mixin({
        //         toast: true,
        //         position: 'top-end',
        //         showConfirmButton: false,
        //         timer: 3000,
        //         timerProgressBar: true,
        //         didOpen: (toast) => {
        //             toast.addEventListener('mouseenter', Swal.stopTimer)
        //             toast.addEventListener('mouseleave', Swal.resumeTimer)
        //         }
        //     })

        //     Toast.fire({
        //         icon: 'error',
        //         title: 'No existe parametro de trayecto'
        //     })
        //     return false;
        // }
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token" ]').attr('content')
                },
                method: "GET",
                url: "/profesores/getSecciones",
                data: {
                    // trayecto: trayecto,
                }
            }).done(function(res) {

                $('#profesorId').val(profesor)


                if (res.secciones.length > 0) {
                    res.secciones.forEach(element => {

                        let check = "";
                        check = `<div class="form-check">
                        <input type="checkbox" class="form-check-input" id="seccion-${element.id}" value="${element.id}">
                        <label class="form-check-label" for="exampleCheck1">${element.nombre}</label>
                        </div>`;

                        $('#list_secciones').append(check);

                    });
                    $('#exampleModalLong').modal("show");
                }
            })
            .fail(function(error) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: 'Ha ocurrido un error al consultar secciones'
                })
            });
    }

    //esta function es la que va a obtener los checkbox seleccionados y guardarlos en un array
    function getSeccionesSelected() {
        let arraySelected = [];

        let checkboxes = document.getElementById('list_secciones').children;
        for (let i = 0; i < checkboxes.length; i++) {
            // Comprobando los inputs
            if (checkboxes[i].children[0].checked) {
                let id = checkboxes[i].children[0].value;
                arraySelected.push(id);
            }
        }

        if (arraySelected.length > 0) {
            setSeccionesProfesor(arraySelected);
            // console.log('funciona hasta antes de guardar');
        } else {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: 'No has seleccionado ninguna sección.'
            })
        }
    }
    //funcion para realizar request de guardado de materias a la seccion
    function setSeccionesProfesor(secciones) {
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token" ]').attr('content')
                },
                method: "POST",
                url: "/profesores/setSecciones",
                data: {
                    // seccion: $('#seccionID').val(),
                    profesor: currentProfesorId,
                    secciones: secciones
                }
            }).done(function(res) {
                console.log(res.secciones);
                if (res.secciones.length > 0) {
                    $('#exampleModalLong').modal("hide");


                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: '¡Sección asignada correctamente!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
            .fail(function(error) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: 'Ha ocurrido un error al consultar secciones'
                })
            });

    }
</script>
<script>
    $(document).ready(function() {
        $('#tabla').DataTable();
    });
</script>
@endsection

@endsection
