@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Accesorios</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item">Accesorios</li>
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
          <button class="btn btn-flat btn-default" onclick="agregarForm();" data-toggle="modal" data-target="#modalAgregarEditar">
            <i class="fas fa-plus mr-2"></i>
            Agregar
          </button>
        </div>

      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive">
        <table id="tablaPrincipal" class="table table-sm table-hover table-striped text-nowrap projects">
          <thead>
            <tr>
              <th>#</th>
              <th>Núm de Parte</th>
              <th>Descripción</th>
              <th>Acero</th>
              <th>Peso (kg)</th>
              <th data-orderable="false"></th>
            </tr>
          </thead>
          <tbody> 
            @foreach($accesorios as $id => $accesorio)
              <tr>
                <td>  
                  {{ $accesorio->id }}
                </td>
                <td>{{ $accesorio->numero_parte}}</td>
                <td>
                  {{ $accesorio->descripcion }}
                </td>
                <td>
                  {{ $accesorio->Acero->nombre }}
                </td>
                <td>{{ $accesorio->peso_kg}}</td>
                <td style="text-align: right;">
                  <div class="btn-group">
                    <button class="btn btn-flat btn-info" 
                      onclick="editarForm({{$accesorio->id.',"'
                                            .$accesorio->numero_parte.'","'
                                            .$accesorio->descripcion.'",'
                                            .$accesorio->acero_id.',"'
                                            .$accesorio->peso_kg.'",'
                                            .($loop->index+1) }});" 
                      data-toggle="modal" 
                      data-target="#modalAgregarEditar">
                      <i class="far fa-edit"></i>
                    </button>

                    <button class="btn btn-flat btn-danger" data-toggle="modal" 
                      data-target="#modalEliminar" onclick="eliminarForm({{$accesorio->id}});">
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
        Estás seguro que deseas <b> Eliminar este Accesorio?</b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-flat btn-outline-light" data-dismiss="modal">
        <i class="fas fa-window-close mr-2"></i>Cancelar
      </button>
        <button type="button" class="btn btn-flat btn-outline-light" onclick="eliminarAsignacion();">
            <i class="fas fa-trash-alt mr-2" ></i>Eliminar 
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->  
<form id="formAgregarEditar" method="POST" action="{{URL('/accesorios/insert/')}}" enctype="multipart/form-data">
  {{csrf_field()}}
<div class="modal fade" id="modalAgregarEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Accesorio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
          <!-- CUERPO DE MODAL Agregar -->
          <input type="text" name="id" id="id" value="0" hidden>
          <div class="form-group">
            <label for="numero_parte">Número de Parte</label>
            <input  type="text" class="form-control" id="numero_parte" name="numero_parte" value="">
          </div>
          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input  type="text" class="form-control" id="descripcion" name="descripcion" value="">
          </div>
          <div class="form-group">
            <label for="acero_id">Acero</label>
            <select class="form-control custom-select" id="acero_id" name="acero_id">
              @foreach($materialesAceros as $id => $materialAcero)
                <option value="{{ $materialAcero->id }}" >
                  {{ $materialAcero->nombre.' ('.$materialAcero->simbolo.')' }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="peso_kg">Peso (kg)</label>
            <input  type="text" class="justNumber no-spinners form-control" id="peso_kg" name="peso_kg" value="">
          </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-flat btn-danger ml-auto" data-dismiss="modal">
        <i class="fas fa-window-close mr-2"></i>Cancelar
        </button>
        <button class="btn btn-flat btn-success">
          <i class="fas fa-check-square mr-2"></i><span id="textAgregarForm">Agregar</span>
        </button>
      </div>
    </div>
  </div>
</div>
</form> 

@stop

@section('scripts')
  <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2-bootstrap4.css') }}">

  <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>

  <script>  
    var table; //tabla principal de asignaciones
    var filaSeleccionada;
    var idSeleccionado;
    var toastrMensaje = 'Agregado correctamente.';
   
    /*
    $materialCliente->id.','
    .$materialCliente->Cliente->id.','
    .$materialCliente->Material->id.','
    .$materialCliente->numero_parte.','
    .$materialCliente->almacen.','
    .$materialCliente->locacion_almacen
    */

  function eliminarForm(id){
    idSeleccionado = id;
    toastrMensaje = 'Eliminado correctamente.';
  } 

  function eliminarAsignacion(){
    Pace.restart();

    $("#tablaPrincipal_processing").show();
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
          type: "POST",
          url: '{!! URL::to('/accesorios/delete') !!}',
          data: {'id':idSeleccionado}, // serializes the form's elements.
          success: function(accesorios){
            //Limpiar tabla
            table.clear().draw();
            //actualizar tabla
            updateTable(accesorios);
            //se envia notificacion
            toastr.success(toastrMensaje);
            //se limpia el form
            Pace.stop();
            $("#tablaPrincipal_processing").hide();
          },
          error: function (mensaje) {
            console.log('Ha ocurrido un error.');
            console.log(mensaje);
            toastr.error('Hubo un error al eliminar.');
            Pace.stop();
            $("#tablaPrincipal_processing").hide();
          },
    });
    $('#modalEliminar').modal('hide');
  }
  function editarForm(id,numero_parte,descripcion,acero_id,peso_kg,row){
    $("#id").val(id);
    $("#numero_parte").val(numero_parte)
    $("#descripcion").val(descripcion);
    $("#acero_id").val(acero_id).change();
    $("#peso_kg").val(peso_kg);

    filaSeleccionada = row;
    idSeleccionado = id;
    toastrMensaje = 'Guardado correctamente.';
    $("#textAgregarForm").text('Guardar');
  }

  function agregarForm(){
    $('#formAgregarEditar').trigger("reset");
    $("#textAgregarForm").text('Agregar');
    idSeleccionado = 0;
    toastrMensaje = 'Asignado correctamente.';
    
  }

  function updateTable(accesorios){
    //loop
    accesorios.forEach( function(accesorio, indice, array) {
      var funcion = 'editarForm('+accesorio.id+',\''+accesorio.numero_parte+'\',\''+accesorio.descripcion+'\','+accesorio.acero_id+',\''+accesorio.peso_kg+'\','+indice+');';

      table.row.add([
              accesorio.id,
              ''+accesorio.numero_parte,
              ''+accesorio.descripcion,
              ''+accesorio.acero.nombre,
              ''+accesorio.peso_kg,
              '<div class="btn-group"><button class="btn btn-flat btn-info" data-toggle="modal"  data-target="#modalAgregarEditar" onclick="'+funcion+'"><i class="far fa-edit"></i></button> <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" onclick="eliminarForm('+accesorio.id+');"><i class="fas fa-trash-alt"></i></button>'
        ]).draw( false );
    });
  }

  $(document).ready(function () { 
        // Funcion para insertar datos a la BD
         //Validaciones del modal
    /*    campos: numero_parte descripcion acero_id peso_kg*/
    $( "#formAgregarEditar" ).validate({
      rules: {
        numero_parte: {
            required: true
        },
        descripcion: {
            required: true
        },
        acero_id: {
            required: true
        },
        peso_kg: {
            required: true
        },
      },
      messages: {
        numero_parte: 'ingresa un número de parte',
        descripcion: 'ingresa una descripción',
        acero_id: 'selecciona un acero',
        peso_kg: 'ingresa un peso',
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
                  success: function(accesorios){
                    //si el request es enviado correctamente se agrega la fila
                    //Limpiar tabla
                    
                    table.clear().draw();
                    console.log('Completado.');
                    console.log(accesorios);
                    //actualizar tabla
                    updateTable(accesorios);
                    //se envia notificacion
                    toastr.success(toastrMensaje);
                    //se limpia el form
                    $('#formAgregarEditar').trigger("reset");
                    Pace.stop();
                    $("#tablaPrincipal_processing").hide();
                  },
                  error: function (data) {
                    console.log('Ha ocurrido un error.');
                    console.log(data);
                    toastr.error('Hubo un error en el accesorio.');
                    Pace.stop();
                    $("#tablaPrincipal_processing").hide();
                  },
            });
            $('#modalAgregarEditar').modal('hide');
        }
    });


    $('select').select2({
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
    });

    table = $('#tablaPrincipal').DataTable({
              "processing": true,
              "order": [[ 0, "desc" ]],
               "createdRow": function ( row, data, index ) {
                  $('td', row).eq(5).addClass('text-right');
              },
              "paging": true,
              "searching": true,
              "ordering": true,
              "serverSide": false,
              "info": true,
              "autoWidth": true,
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