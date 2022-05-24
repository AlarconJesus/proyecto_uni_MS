@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">
@endsection

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
                        <a class="btn btn-warning" style="margin-bottom: 10px;" href="{{ route('secciones.create') }}">Nuevo</a>

                        <table id="tabla" class="table table-light table-striped table-bordered shadow-lg mt" style="width: 100%;">
                            <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">Nombre</th>
                                <th style="color:#fff;">Codigo</th>
                                <th style="color:#fff;">Trayecto</th>
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
                                    <td>{{ $seccion->trayecto }}</td>

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
                                        <button type="button" class="btn btn-primary btnConfig" id="{{$seccion->id}}" onclick="showModal(`{{$seccion->id}}`, `{{$seccion->trayecto}}`)">Configurar materias</button>

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

<!-- Modal configuracion de materias-->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Configuración de materias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="sectionID" id="sectionID">
                <div id="list_materias"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="getMateriasSelected();">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentSectionId;

    const sections = Object.values(document.getElementsByClassName('btnConfig'));
    sections.forEach(section => {
        section.addEventListener('mousedown', event => {
            event.preventDefault();
            currentSectionId = event.path[0].id;
        });
    });

    function showModal(seccion, trayecto) {

        $('#list_materias').empty();

        if (!trayecto) {
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
                title: 'No existe parametro de trayecto'
            })
            return false;
        }
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token" ]').attr('content')
                },
                method: "GET",
                url: "/secciones/getMaterias",
                data: {
                    trayecto: trayecto,
                }
            }).done(function(res) {

                $('#sectionID').val(seccion)


                if (res.materias.length > 0) {
                    res.materias.forEach(element => {

                        let check = "";
                        check = `<div class="form-check">
                        <input type="checkbox" class="form-check-input" id="materia-${element.id}" value="${element.id}">
                        <label class="form-check-label" for="exampleCheck1">${element.nombre}</label>
                        </div>`;

                        $('#list_materias').append(check);

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
                    title: 'Ha ocurrido un error al consultar materias'
                })
            });
    }

    //esta function es la que va a obtener los checkbox seleccionados y guardarlos en un array
    function getMateriasSelected() {
        let arraySelected = [];

        let listaMaterias = document.getElementById('list_materias');

        let checkboxes = document.getElementById('list_materias').children;
        for (let i = 0; i < checkboxes.length; i++) {
            // Comprobando los inputs
            if (checkboxes[i].children[0].checked) {
                let id = checkboxes[i].children[0].value;
                arraySelected.push(id);
            }
        }

        if (arraySelected.length > 0) {
            setMateriasSection(arraySelected);
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
                title: 'No has seleccionado ninguna materia.'
            })
        }
    }
    //funcion para realizar request de guardado de materias a la seccion
    function setMateriasSection(materias) {
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token" ]').attr('content')
                },
                method: "POST",
                url: "/secciones/setMaterias",
                data: {
                    // seccion: $('#seccionID').val(),
                    seccion: currentSectionId,
                    materias: materias
                }
            }).done(function(res) {
                console.log(res.materias);
                if (res.materias.length > 0) {
                    $('#exampleModalLong').modal("hide");


                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: '¡Materia asignada correctamente!',
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
                    title: 'Ha ocurrido un error al consultar materias'
                })
            });

    }
</script>
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
