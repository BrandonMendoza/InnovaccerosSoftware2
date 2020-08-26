@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Productos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item">Productos</li>
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
        <div class="card-body table-responsive overlay-wrapper">
          <table id="tablaPrincipal" class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>#</th>
                <th>Núm. de Parte (Local)</th>
                <th>Cliente</th>
                <th>Núm. de Parte (Cliente) </th>
                <th>Peso (kg)</th>
                <th>Peso (lbs)</th>
                <th data-orderable="false"></th>
              </tr>
            </thead>
            <tbody> 
              @foreach($productos as $id => $producto)
                <tr>
                  <td>{{ ($loop->index+1) }}</td>
                  <td>{{ $producto->numero_parte }}</td>
                  <td>{{ $producto->cliente->nombre_cliente }}</td>
                  <td>{{ $producto->numero_parte_cliente }}</td>
                  <td>{{ $producto->peso_kg }}</td>
                  <td>{{ $producto->peso_lbs }}</td>
                  <!-- Botones -->
                  <td style="text-align: right;">
                    <div class="btn-group">
                      <button class="btn btn-flat btn-info"
                        onclick="documentosForm({{ $producto->id }});">
                        <i class="fas fa-file-upload"></i>
                      </button>
                      <button class="btn btn-flat btn-info" 
                        onclick="editarForm({{ $producto->id.',"'
                                              .$producto->numero_parte.'",'
                                              .$producto->cliente_id.',"'
                                              .$producto->numero_parte_cliente.'","'
                                              .$producto->descripcion.'","'
                                              .$producto->peso_kg.'","'
                                              .$producto->peso_lbs.'",'
                                              .($loop->index+1) }});">
                        <i class="far fa-edit"></i>
                      </button>

                      <button class="btn btn-flat btn-danger" data-toggle="modal" 
                        data-target="#modalEliminar" onclick="eliminarForm({{$producto->id}});">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div id="tablaOverlay" class="overlay">
            <i class="fas fa-3x fa-sync-alt fa-spin"></i> <br>
            <div class="text-bold pt-2">Cargando...</div>
          </div>
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
          Estás seguro que deseas <b> Eliminar Producto?</b>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-flat btn-outline-light" data-dismiss="modal">
          <i class="fas fa-window-close mr-2"></i>Cancelar
        </button>
          <button type="button" class="btn btn-flat btn-outline-light" onclick="eliminar();">
              <i class="fas fa-trash-alt mr-2" ></i>Eliminar 
          </button>
        </div>
      </div>
    </div>
  </div>
<!-- Modal Documentos-->  
  @include('productos.formDocumentos')
  <!-- Modal Principal-->  
  @include('productos.form')

  

@stop

@section('scripts')

  <script>  
    var table;
    var tablaMateriales;
    var tablaAccesorios;
    var tablaDocumentos;
    var idSeleccionado;
    var toastrMensaje = 'Agregado correctamente.';
    var pagina = "Producto";
    var spanishDataTable = '{{ asset('vendor/datatableSpanish.js') }}';
    var urlEliminarDocumento = '{!! URL::to('/productos/deleteProductoDocumento') !!}';
    var urlDescargarDocumento = '{!! URL::to('/productos/descargarProductoDocumento') !!}'
    var urlGral = '{!! URL::to('/') !!}';

    function eliminarForm(id){
      idSeleccionado = id;
      toastrMensaje = 'Eliminado correctamente.';
    } 

    function eliminar(){
      var url = '{!! URL::to('/productos/delete') !!}';
      eliminarFromTableAjax(idSeleccionado,url);
    }

    function editarForm(id,numero_parte,cliente_id,numero_parte_cliente,descripcion,peso_kg,peso_lbs,row){
      $("#tablaOverlay").show();
      $("#id").val(id);
      $("#numero_parte_cliente").val(numero_parte_cliente);
      $("#numero_parte").val(numero_parte);
      $("#descripcion").val(descripcion);
      $("#peso_kg").val(peso_kg);
      $("#peso_lbs").val(peso_lbs);
      $("#cliente_id").val(cliente_id).change();
      $("#numero_parte_text").text(numero_parte);
      filaSeleccionada = row;
      idSeleccionado = id;
      toastrMensaje = 'Guardado correctamente.';
      //Habilitar las opciones de los selects2 del form
      $("#material_select>option").prop("disabled", false);
      $("#accesorio_select>option").prop("disabled", false);

      $("#textAgregarForm").text('Guardar');
      $("#modalFormLabel").text(pagina+" - Editar");
      var url = '{!! URL::to('/productos/cargarTablasForm') !!}';
      cargarTablasForm(url);

    }

    function documentosForm(id){
      $("#producto_id").val(id);
      $("#modalDocumentosFormLabel").text(pagina+" - Documentos");
      $("#doc").val("").change();
      $("#nombre_usuario").val("").change();
      idSeleccionado = id;
      toastrMensaje = 'Guardado correctamente.';
      var url = '{!! URL::to('/productos/cargarTablaDocumentosForm') !!}';
      cargarTablaDocumentosForm(url,id);
    }

    function agregarForm(){

      idSeleccionado = 0;
      toastrMensaje = 'Agregado correctamente.';
      tablaMateriales.clear().draw();
      tablaAccesorios.clear().draw();

      $("#numero_parte_text").text("");
      $("#cliente_id").val("").change();
      $("#material_select").val("").change();
      $("#accesorio_select").val("").change();
      //Habilitar las opciones de los selects2 del form
      $("#material_select>option").prop("disabled", false);
      $("#accesorio_select>option").prop("disabled", false);

      $('#formAgregar').trigger("reset");
      $("#textAgregarForm").text('Agregar');
      $("#modalFormLabel").text(pagina+" - Agregar");
    }

    function updateTable(productos){
      $("#tablaOverlay").show();
      var funcion;
      productos.forEach( function(producto, indice, array) {
        //validacion para evitar que haya 'null' en las celdas de la tabla principal
        Object.keys(producto).forEach(function(key,value) {
          if(producto[key] == null) producto[key] = "";
        });
        funcion = 'editarForm('+producto.id+',\''+producto.numero_parte+'\',\''+producto.cliente_id+'\',\''+producto.numero_parte_cliente+'\',\''+producto.descripcion+'\',\''+producto.peso_kg+'\',\''+producto.peso_lbs+'\','+indice+');';
        table.row.add([
                ''+producto.id,
                ''+producto.numero_parte,
                ''+producto.cliente.nombre_cliente,
                ''+producto.numero_parte_cliente,
                ''+producto.peso_kg,
                ''+producto.peso_lbs,
                '<div class="btn-group"><button class="btn btn-flat btn-info" onclick="'+funcion+'"><i class="far fa-edit"></i></button> <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" onclick="eliminarForm('+producto.id+');"><i class="fas fa-trash-alt"></i></button>'
          ]).draw( false );
      });
      $("#tablaOverlay").hide();
    }

    $("#formAgregar").validate({
      rules: {
        cliente_id: {required: true },
        numero_parte_cliente: {required: true },
        peso_lbs: {required: true},
        peso_kg: {required: true},
      },
      messages: { cliente_id: 'selecciona un cliente', numero_parte_cliente: 'ingresa un numero parte',peso_lbs: 'ingresa un peso',peso_kg: 'ingresa un peso'},
    });
    
    $(document).ready(function () { 

      Pace.restart();
        table = $('#tablaPrincipal').DataTable({
          "paging": true, "searching": true,"ordering": true,"info": true, "autoWidth": false, "responsive": true,
          "language": { "url" : '{{ asset('vendor/datatableSpanish.js') }}', },
          "order": [[ 0, "desc" ]],
          "createdRow": function ( row, data, index ) { 
            $('td', row).eq(6).addClass('text-right');
            $('td', row).eq(6).addClass('p-1');
          },
        });
        $("#tablaOverlay").hide();
        Pace.stop();
    });
  </script>
  <!--Style para el El Modal->Form -->
  <link rel="stylesheet" href="{{ asset('css/productos/Form.css') }}">
  <!--Scripts para el El Modal->Form -->
  <script src="{{ asset('js/productos/Form.js') }}"></script>
  <!--Scripts para el El Modal->Documentos Form -->
  <script src="{{ asset('js/productos/FormDocumentos.js') }}"></script>
  

@stop