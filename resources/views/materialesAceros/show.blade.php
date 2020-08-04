@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Aceros</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item">Aceros</li>
            </ol>
          </div>
        </div>
      </div>
@stop
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <button class="btn btn-flat btn-default" onclick="agregarForm();" data-toggle="modal" data-target="#modalAgregar">
              <i class="fas fa-plus mr-2"></i>
              Agregar
            </button>
          </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
          <table id="tablaPrincipal" class="table table-hover text-nowrap table-striped projects">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Simbolo</th>
                <th data-orderable="false"></th>
              </tr>
            </thead>
            <tbody> 
              @foreach($materialesAceros as $id => $materialAcero)
                <tr>
                  <td>  
                    {{ $materialAcero->id }}
                  </td>
                  <td>
                    {{ $materialAcero->nombre }}
                  </td>
                  <td>{{ $materialAcero->simbolo }}</td>
                  <td style="text-align: right;">
                    <div class="btn-group">
                      <button class="btn btn-flat btn-info" 
                        onclick="editarForm({{$materialAcero->id.',"'
                                              .$materialAcero->nombre.'","'
                                              .$materialAcero->simbolo.'",'
                                              .($loop->index+1) }});" 
                        data-toggle="modal" 
                        data-target="#modalAgregar">
                        <i class="far fa-edit"></i>
                      </button>

                      <button class="btn btn-flat btn-danger" data-toggle="modal" 
                        data-target="#modalEliminar" onclick="eliminarForm({{$materialAcero->id}});">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>

	<!-- Eliminar MODAL-->
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content bg-danger">
      <div class="modal-body">
        Estás seguro que deseas <b> Eliminar Acero?</b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-flat btn-outline-light" data-dismiss="modal">
        <i class="fas fa-window-close mr-2"></i>Cancelar
      </button>
        <button type="button" class="btn btn-flat btn-outline-light" onclick="eliminarAcero();">
            <i class="fas fa-trash-alt mr-2" ></i>Eliminar 
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->  
<form id="formAgregar" method="POST" action="{{URL('/materialesAceros/insert')}}" enctype="multipart/form-data">
  {{csrf_field()}}
  <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="modalFormLabel">Tipo de Material - Agregar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" name="id" id="id" value="0" hidden>
          <div class="form-group">
            <label for="nombre">Nombre del Acero</label>
            <input type="text" id="nombre" class="form-control" name="nombre" 
                value="" >
          </div>
          <div class="form-group">
            <label for="simbolo">Simbolo </label>
            <input id="simbolo" name="simbolo" class="form-control" type="text" value="">
          </div>
        </div>

        <div class="modal-footer align-center">
          <button type="button" class="btn btn-flat btn-danger mr-auto" data-dismiss="modal">
          <i class="fas fa-window-close mr-2"></i>Cancelar
          </button>
          <button class="btn btn-flat btn-success">
            <i class="fas fa-check-square mr-2"></i><span id="textAsignarForm">Agregar</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</form> 

@stop

@section('scripts')
  <script>  
    var table;
    var idSeleccionado;
    var toastrMensaje = 'Agregado correctamente.';


    function eliminarForm(id){
      idSeleccionado = id;
      toastrMensaje = 'Eliminado correctamente.';
    } 

    function eliminarAcero(){
      Pace.restart(); 

      $("#tablaOverlay").show();
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      $.ajax({
            type: "POST",
            url: '{!! URL::to('/materialesAceros/delete') !!}',
            data: {'id':idSeleccionado}, // serializes the form's elements.
            success: function(materialesAceros){
              //Limpiar tabla
              table.clear().draw();
              //actualizar tabla
              updateTable(materialesAceros);
              //se envia notificacion
              toastr.success(toastrMensaje);
              //se limpia el form
              $("#tablaOverlay").hide();
            },
            error: function (mensaje) {
              console.log('Ha ocurrido un error.');
              console.log(mensaje);
              toastr.error('Hubo un error al eliminar.');
              Pace.stop();
              $("#tablaOverlay").hide();
            },
      });
      $('#modalEliminar').modal('hide');
    }

    function updateTable(materialesAceros){

      //foreach
      materialesAceros.forEach( function(materialAcero, indice, array) {

        var funcion = 'editarForm('+materialAcero.id+',\''+materialAcero.nombre+'\',\''+materialAcero.simbolo+'\','+indice+');';

        table.row.add([
                ''+materialAcero.id,
                ''+materialAcero.nombre,
                ''+materialAcero.simbolo,
                '<div class="btn-group"><button class="btn btn-flat btn-info" data-toggle="modal"  data-target="#modalAgregar" onclick="'+funcion+'"><i class="far fa-edit"></i></button> <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" onclick="eliminarForm('+materialAcero.id+');"><i class="fas fa-trash-alt"></i></button>'
          ]).draw( false );
      });
      
    }


    function editarForm(id,nombre,simbolo,row){
      $("#id").val(id);
      $("#nombre").val(nombre);
      $("#simbolo").val(simbolo);
      filaSeleccionada = row;
      idSeleccionado = id;
      toastrMensaje = 'Guardado correctamente.';
      $("#textAsignarForm").text('Guardar');
      $("#modalFormLabel").text("Acero - Editar");
    }

    function agregarForm(){
      $('#formAgregar').trigger("reset");
      $("#textAsignarForm").text('Agregar');
      $("#modalFormLabel").text("Acero - Agregar");
      idSeleccionado = 0;
      toastrMensaje = 'Agregado correctamente.';
    }

    $( "#formAgregar" ).validate({
      rules: {
        nombre: {
            required: true
        },
        simbolo: {
            required: true
        },
      },
      messages: {
        nombre: 'ingresa nombre',
        simbolo: 'ingresa un simbolo',
      },
        errorElement: 'span',
      errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            // form validates so do the ajax

            Pace.restart();
            $("#tablaPrincipal_processing").show();
            var form = $(form);
            var url = form.attr('action');
            console.log(form);
            $.ajax({
                  type: "POST",
                  url: url,
                  data: form.serialize(), // serializes the form's elements.
                  success: function(materialesAceros){
                    //si el request es enviado correctamente se agrega la fila
                    //Limpiar tabla
                    
                    table.clear().draw();
                    console.log('Completado.');
                    console.log(materialesAceros);
                    //actualizar tabla
                    updateTable(materialesAceros);
                    //se envia notificacion
                    toastr.success(toastrMensaje);
                    //se limpia el form
                    $('#formAgregar').trigger("reset");
                    Pace.stop();
                    $("#tablaPrincipal_processing").hide();
                  },
                  error: function (data) {
                    console.log('Ha ocurrido un error.');
                    console.log(data);
                    toastr.error('Hubo un error en la asignación.');
                    Pace.stop();
                    $("#tablaPrincipal_processing").hide();
                  },
            });
            $('#modalAgregar').modal('hide');
        }
    });



    $(document).ready(function () { 
      Pace.restart();
        table = $('#tablaPrincipal').DataTable({
                  "order": [[ 0, "desc" ]],
                  "createdRow": function ( row, data, index ) {
                      //columna de botones
                      $('td', row).eq(3).addClass('text-right');
                  },
                  "paging": true,
                  //"lengthChange": false,
                  "searching": true,
                  "ordering": true,
                  "info": true,
                  "autoWidth": false,
                  "responsive": true,
                  "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                      "sFirst":    "Primero",
                      "sLast":     "Último",
                      "sNext":     "Siguiente",
                      "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                  }
              });

        Pace.stop();
    });
  </script>


@stop