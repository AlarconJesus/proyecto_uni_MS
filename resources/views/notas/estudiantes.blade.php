@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Estudiantes - {{$seccion->nombre}}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h3 class="text-center">Dashboard Content</h3> -->

                        <table id="tabla" class="table table-light table-striped table-bordered shadow-lg mt" style="width: 100%;">
                            <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">Nombre</th>
                                <th style="color:#fff;">Trayecto</th>
                                <th style="color:#fff;">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($estudiantes as $estudiante)
                                @if($estudiante->secciones[0]->id == $seccion->id)
                                <tr>
                                    <td style="display: none;">{{ $estudiante->id }}</td>
                                    <td>{{ $estudiante->nombre_completo }}</td>
                                    <td>{{ $estudiante->trayecto }}</td>
                                    <td>
                                        <a href="" class="btn btn-info">Ver/imprimir notas</a>
                                        <button type="button" class="btn btn-primary btnConfig" id="{{$estudiante->id}}" onclick="showModal(`{{$seccion->id}}`)">Configurar notas</button>
                                    </td>
                                </tr>
                                @endif
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
                <h5 class="modal-title" id="exampleModalLongTitle">Notas</h5>
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
                <button type="button" class="btn btn-primary" onclick="getMateriasNotasSelected();">Guardar</button>
            </div>
        </div>
    </div>
</div>
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>
<script>
    let currentSectionId;
    let currentEstudianteId;

    const estudiantes = Object.values(document.getElementsByClassName('btnConfig'));
    estudiantes.forEach(estudiante => {
        estudiante.addEventListener('mousedown', event => {
            event.preventDefault();
            currentEstudianteId = event.path[0].id;
        });
    });

    function showModal(seccion) {
        $('#list_materias').empty();

        if (!seccion) {
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
                title: 'No existe parametro de seccion'
            })
            return false;
        }
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token" ]').attr('content')
                },
                method: "GET",
                url: "/notas/getMaterias",
                data: {
                    seccion: seccion,
                }
            }).done(function(res) {
                $('#sectionID').val(seccion)


                if (res.materias.length > 0) {
                    res.materias.forEach(element => {

                        let check = "";
                        check = `<div class="form-check"  id="${element.id}">
                        <label class="form-check-label" id="materia-${element.id}" for="exampleCheck1">${element.nombre}</label>
                        <input type="number" class="notas">
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
    function getMateriasNotasSelected() {
        let arraySelected = [];

        let notas = document.getElementsByClassName('notas');

        let materias = document.getElementById('list_materias').children;
        for (let i = 0; i < materias.length; i++) {
            // Comprobando los inputs
            let id = materias[i].id;
            let nota = notas[i].value;
            if (nota === '') {
                arraySelected.push([id, 'N/A']);
            } else {
                arraySelected.push([id, nota]);
            }
        }

        if (arraySelected.length > 0) {
            setMateriasSection(arraySelected);

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
    function setMateriasSection(materia_nota) {
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token" ]').attr('content')
                },
                method: "POST",
                url: "/notas/setNotas",
                data: {
                    estudiante: currentEstudianteId,
                    materias_notas: materia_nota
                }
            }).done(function(res) {
                console.log(res.calificacion);
                if (res.calificacion) {
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
<script>
    $(document).ready(function() {
        $('#tabla').DataTable();
    });
</script>
@endsection
@endsection
