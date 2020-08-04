@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Asignación de Material a Cliente</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item">Asignación de Material a Cliente</li>
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
          <button class="btn btn-flat btn-default" onclick="asignarForm();" data-toggle="modal" data-target="#modalAsignar">
            <i class="fas fa-plus mr-2"></i>
            Asignar
          </button>
        </div>

      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="tablaPrincipal" class="table table-hover dt-responsive nowrap">
          <thead>
            <tr>
              <th>#</th>
              <th>Cliente</th>
              <th>Núm. de Parte(Cliente)</th>
              <th>Material</th>
              <th data-orderable="false">Almacen</th>
              <th data-orderable="false">Locación</th>
              <th data-orderable="false"></th>
            </tr>
          </thead>
          <tbody> 
            @foreach($materialesClientes as $id => $materialCliente)
              <tr>
                <td>  
                  {{ $loop->index+1 }}
                </td>
                <td>{{ $materialCliente->Cliente->nombre_cliente}}</td>
                <td>
                  {{ $materialCliente->numero_parte }}
                </td>
                <td>
                  {{ $materialCliente->getNombreMaterialAccesorio()}}
                </td>
                <td>{{ $materialCliente->almacen}}</td>
                <td>{{ $materialCliente->locacion_almacen}}</td>
                <td style="text-align: right;">
                  <div class="btn-group">
                    <button class="btn btn-flat btn-info" 
                      onclick="editarForm({{$materialCliente->id.','
                                            .$materialCliente->Cliente->id.','
                                            .$materialCliente->getId().',"'
                                            .$materialCliente->numero_parte.'","'
                                            .$materialCliente->almacen.'","'
                                            .$materialCliente->locacion_almacen.'",'
                                            .$materialCliente->catalogo.','
                                            .($loop->index+1) }});" 
                      data-toggle="modal" 
                      data-target="#modalAsignar">
                      <i class="far fa-edit"></i>
                    </button>

                    <button class="btn btn-flat btn-danger" data-toggle="modal" 
                      data-target="#modalEliminar" onclick="eliminarForm({{$materialCliente->id}});">
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
        Estás seguro que deseas <b> Eliminar esta Asignación?</b>
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
<form id="formMaterialesClientes" method="POST" action="{{URL('/materialesClientes/insert/')}}" enctype="multipart/form-data">
  {{csrf_field()}}
<div class="modal fade" id="modalAsignar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="exampleModalLabel">Asignar Material a Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
          <!-- CUERPO DE MODAL ASIGNAR-->
          <input type="text" name="id" id="id" value="0" hidden>
          <div class="form-group">
            <label for="catalogo">Categoria</label>
            <select class="form-control custom-select" id="catalogo" name="catalogo" onchange="getMaterialesAccesorios();">
              <option value="1"> Material </option>
              <option value="2"> Accesorio </option>
            </select>
          </div>
          <div class="form-group">
            <label for="numero_parte">Número de Parte</label>
            <input  type="text" class="form-control" id="numero_parte" name="numero_parte" value="">
          </div>
          <div class="form-group">
            <label for="material_id">Material</label>
            <select class="form-control custom-select select2Form" id="material_id" name="material_id">
              @foreach($materiales as $id => $material)
                <option value="{{ $material->id }}" >
                  {{ $material->getNombreMaterial() }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select class="form-control custom-select select2Form" id="cliente_id" name="cliente_id">
              <option value=""></option>
              @foreach($clientes as $id => $cliente)
                <option value="{{ $cliente->id }}" >
                  {{ $cliente->nombre_cliente}}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="almacen">Almacen</label>
            <input  type="text" class="form-control" id="almacen" name="almacen" value="">
          </div>
          <div class="form-group">
            <label for="locacion_almacen">Locación</label>
            <input  type="text" class="form-control" id="locacion_almacen" name="locacion_almacen" value="">
          </div>
        </div>

      <div class="modal-footer align-center">
        <button type="button" class="btn btn-flat btn-danger mr-auto" data-dismiss="modal">
        <i class="fas fa-window-close mr-2"></i>Cancelar
        </button>
        <button class="btn btn-flat btn-success">
          <i class="fas fa-check-square mr-2"></i><span id="textAsignarForm">Asignar</span>
        </button>
      </div>
    </div>
  </div>
</div>
</form> 

@stop

@section('scripts')
<style type="text/css">
#loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  margin-left:200px;
  margin-top:30px;
} 
 
</style>
  <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2-bootstrap4.css') }}">

  <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>

  <script>  
    var table; //tabla principal de asignaciones
    var filaSeleccionada;
    var idSeleccionado;
    var toastrMensaje = 'Asignado correctamente.';
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    function getIdMaterialAccesorio(materialCliente){
      var idMaterialAccesorio;
      if(materialCliente.catalogo == 1){
          idMaterialAccesorio = materialCliente.id;
      }else{
          idMaterialAccesorio = materialCliente.id;
      }
      return idMaterialAccesorio;
    }


  function getMaterialesAccesorios(){
    var catalogo = $("#catalogo").val();
    Pace.restart();
      $.ajax({
            type: "POST",
            url: '{!! URL::to('/materialesClientes/getMaterialesAccesoriosClientes') !!}',
            data: {'catalogo':catalogo},
            success: function(materialesAccesorios){
              actualizarSelectMaterialAccesorio(materialesAccesorios,catalogo);
              Pace.stop();
            },
            error: function (data) {
              console.log('Ha ocurrido un error.');
              console.log(data);
              toastr.error('Hubo un error obteniendo materiales.');
              Pace.stop();
              $("#tablaPrincipal_processing").hide();
            },
      });
  }

  function actualizarSelectMaterialAccesorio(materialesAccesorios,catalogo){
      //limpiamos el select
      $('#material_id').empty();
      if(materialesAccesorios.length == 0){
        //si esta vacio no mandamos el mensaje
        if(catalogo == 1){
          $("#material_id").prop("disabled", false);
          toastr.error('No hay accesorios disponibles.');
        }else{
          $("#material_id").prop("disabled", false);
          toastr.error('No hay materiales disponibles.');
        }
      }else{
        materialesAccesorios.forEach( function(materialAccesorio, indice, array) { 
          if(materialAccesorio.catalogo == 1){
            nombre_material_medida = getNombreMaterial(materialAccesorio);
            var optionMaterial = new Option(nombre_material_medida, materialAccesorio.id, true, true);
          }else{
            var optionMaterial = new Option(materialAccesorio.descripcion, materialAccesorio.id, true, true);
          }
          $('#material_id').append(optionMaterial);
        });
        //habilitamos select material y seleccionamos dato vacio
        $("#material_id").prop("disabled", false);
      }
    }

  function eliminarForm(id){
    idSeleccionado = id;
    toastrMensaje = 'Eliminado correctamente.';
  } 

  function eliminarAsignacion(){
    Pace.restart();

    $("#tablaPrincipal_processing").show();
    
    $.ajax({
          type: "POST",
          url: '{!! URL::to('/materialesClientes/delete') !!}',
          data: {'id':idSeleccionado}, // serializes the form's elements.
          success: function(materialesClientes){
            //Limpiar tabla
            table.clear().draw();
            //actualizar tabla
            updateTable(materialesClientes);
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

  function editarForm(id,cliente_id,material_id,numero_parte,almacen,locacion_almacen,catalogo,row){
    $("#id").val(id);
    $("#catalogo").val(catalogo).change();
    $("#cliente_id").val(cliente_id).change();
    $("#material_id").val(material_id).change();
    $("#numero_parte").val(numero_parte);
    $("#almacen").val(almacen);
    $("#locacion_almacen").val(locacion_almacen);
    filaSeleccionada = row;
    idSeleccionado = id;
    toastrMensaje = 'Guardado correctamente.';
    $("#textAsignarForm").text('Guardar');

  }

  function asignarForm(){
    $("#cliente_id").val("").change();
    $('#formMaterialesClientes').trigger("reset");
    $("#textAsignarForm").text('Asignar');
    idSeleccionado = 0;
    toastrMensaje = 'Asignado correctamente.';
    
  }

  function updateTable(materialesClientes){
    var nombre_material_accesorio;

    //foreach
    materialesClientes.forEach( function(materialCliente, indice, array) {
      var idMaterialAccesorio = getIdMaterialAccesorio(materialCliente);
      var funcion = 'editarForm('+materialCliente.id+','+materialCliente.cliente_id+','+idMaterialAccesorio+',\''+materialCliente.numero_parte+'\',\''+materialCliente.almacen+'\',\''+materialCliente.locacion_almacen+'\','+materialCliente.catalogo+','+indice+');';

      nombre_material_accesorio = getNombreMaterialAccesorio(materialCliente);

      table.row.add([
              (indice+1),
              ''+materialCliente.cliente.nombre_cliente,
              ''+materialCliente.numero_parte,
              ''+nombre_material_accesorio,
              ''+materialCliente.almacen,
              ''+materialCliente.locacion_almacen,
              '<div class="btn-group"><button class="btn btn-flat btn-info" data-toggle="modal"  data-target="#modalAsignar" onclick="'+funcion+'"><i class="far fa-edit"></i></button> <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" onclick="eliminarForm('+materialCliente.id+');"><i class="fas fa-trash-alt"></i></button>'
        ]).draw( false );
    });
    
  }
  /* Funcion para obtener el nombre dependiendo si es material o accesorio*/
  function getNombreMaterialAccesorio(materialCliente)
  {
    var nombre;
    console.log("Material Cliente: ");
    console.log(materialCliente);
    if(materialCliente.catalogo == 1){
      nombre = getNombreMaterial(materialCliente.material);
    }else{
      nombre = materialCliente.accesorio.descripcion;
    }
    console.log("Nombre: ");
    console.log(nombre);
    return nombre;
  }

  /*Funcion para obtener el nombre completo del material*/
  function getNombreMaterial(material){
    var nombre_material_medida = material.tipo_material.simbolo+'-'+material.medida_1+'x'+material.medida_2;
    //checar si hay medida 3
    if(material.medida_3 != null){
      nombre_material_medida += 'x'+material.medida_3;
    }
    //checar si hay medida4
    if(material.medida_4 != null){
      nombre_material_medida += 'x'+material.medida_4;
    }
    return nombre_material_medida;
  }


  $(document).ready(function () { 
        // Funcion para insertar datos a la BD
         //Validaciones del modal
    /*    campos: numero_parte material_id cliente_id almacen locacion_almacen*/
    $( "#formMaterialesClientes" ).validate({
      rules: {
        numero_parte: {
            required: true
        },
        material_id: {
            required: true
        },
        cliente_id: {
            required: true
        },
      },
      messages: {
        numero_parte: 'ingresa un número de parte',
        material_id: 'selecciona un material',
        cliente_id: 'selecciona un cliente',
        almacen: 'ingresa almacen',
        locacion_almacen: 'ingresa una locación',
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
                  success: function(materialesClientes){
                    //si el request es enviado correctamente se agrega la fila
                    //Limpiar tabla
                    
                    table.clear().draw();
                    console.log('Completado.');
                    console.log(materialesClientes);
                    //actualizar tabla
                    updateTable(materialesClientes);
                    //se envia notificacion
                    toastr.success(toastrMensaje);
                    //se limpia el form
                    $('#formMaterialesClientes').trigger("reset");
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
            $('#modalAsignar').modal('hide');
        }
    });


    $('.select2Form').select2({
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
    });

    table = $('#tablaPrincipal').DataTable({
              "processing": true,
              "order": [[ 0, "desc" ]],
               "createdRow": function ( row, data, index ) {
                  $('td', row).eq(6).addClass('text-right');
              },
              "paging": true,
              "searching": true,
              "ordering": true,
              "serverSide": false,
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