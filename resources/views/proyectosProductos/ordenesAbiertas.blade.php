@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Ordenes Abiertas</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
         <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
          <li class="breadcrumb-item"><a href="{{route('proyshow')}}">Proyectos</a></li>
          <li class="breadcrumb-item">Ordenes Abiertas</li>
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
            <a href="{{route('procesoshow')}}" class="btn btn-flat btn-default">
              Procesos
            </a>
            <button class="btn btn-flat btn-default" onclick="agregarForm();" data-toggle="modal" data-target="#modalAgregar">
              <i class="fas fa-plus mr-2"></i>
              Agregar Producto
            </button>
            <button class="btn btn-flat btn-default">
              <i class="fas fa-plus mr-2"></i>
              Agregar Proyecto
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="overlay-wrapper">
  
          <table id="tablaPrincipal" class="table table-hover nowrap dt-responsive">
            <thead>
              <tr>
                <th hidden>COLOR</th> <!-- Color-->
                <th hidden>TEXTO COLOR</th> <!-- Texto_color-->
                <th style="width: 1%"> # </th>
                <th>Proceso</th>
                <th>Cliente</th>
                <th hidden>Núm. de Parte (Local)  </th>
                <th>Núm. de Parte (Cliente)</th>
                <th>Cant</th>
                <th>Orden de Trabajo</th>
                <th>Item</th>
                <th>Orden de Compra</th>
                <th>Fecha de Entrega</th>
                <th>Plan de Corte</th>
                <th>Peso Lbs</th>
                <th>Pintura</th>
                
                <th data-orderable="false">Notas</th>
                <th data-orderable="false"></th>
              </tr>
            </thead>
            <tbody> 
              @foreach($OrdenesAbiertas as  $ordenAbierta)

                  <tr>
                    <td hidden>{{ $ordenAbierta->Proceso->color }}</td>
                    <td hidden>{{ $ordenAbierta->Proceso->texto_color }}</td>
                    <td>{{ $ordenAbierta->id }}</td>
                    <td>
                      <i class="fas fa-exchange-alt mr-2"></i> 
                      {{ $ordenAbierta->Proceso->nombre }}
                    </td>
                    <td>{{ $ordenAbierta->proyecto->Cliente->nombre_cliente }}</td>
                    <td>{{ $ordenAbierta->proyecto->titulo }}</td>
                    <td>{{ $ordenAbierta->producto->numero_parte_cliente }}</td>
                    <td>{{ $ordenAbierta->cantidad }}</td>
                    <td>{{ $ordenAbierta->work_order }}</td>
                    <td>{{ $ordenAbierta->item }}</td>
                    <td>{{ $ordenAbierta->proyecto->orden_compra }}</td>
                    <td> {{ \Carbon\Carbon::parse($ordenAbierta->proyecto->fecha_entrega)->format('Y-m-d')}} </td>
                    <td>{{ $ordenAbierta->proyecto->plan_corte }}</td>
                    <td>{{ $ordenAbierta->proyecto->peso_lbs }}</td>
                    <td>
                      {{ $ordenAbierta->pintura_id }}
                    </td>
                    
                    <td>{{ $ordenAbierta->notas }}</td>
                    <!-- Botones -->
                    <td style="text-align: right;" class="p-1">
                      <div class="btn-group ">
                        <button   class="btn btn-flat btn-warning" title="cambiar proceso"
                                  onclick="cambiarProcesoForm({{$ordenAbierta.','
                                                            .($loop->index+1) }});">
                          <i class="fas fa-exchange-alt"></i>  
                        </button>
                        
                        <button class="btn btn-flat btn-info" data-toggle="modal" data-target="#modalAgregar"
                          onclick="editarForm({{$ordenAbierta.','.($loop->index+1)}});">
                          <i class="far fa-edit"></i>
                        </button>
                        <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" 
                                onclick="eliminarForm({{$ordenAbierta->id}});">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                


              @endforeach
            </tbody>
          </table>
          <!-- TABLA -->
           <div id="tablaOverlay" class="overlay">
              <i class="fas fa-3x fa-sync-alt fa-spin"></i> <br>
              <div class="text-bold pt-2">Cargando...</div>
            </div>
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
          Estás seguro que deseas <b> Eliminar Proyecto?</b>
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

  <!-- Modal -->  
  @include('proyectosProductos.OrdenesAbiertasForm')

  <!-- Modal -->  
  @include('proyectosProductos.cambiarProceso')

@stop

@section('scripts')
  <link rel="stylesheet" href="{{ asset('vendor/gijgo/css/gijgo.min.css') }}">
  <script src="{{ asset('vendor/gijgo/js/gijgo.min.js') }}"></script>
  <script src="{{ asset('vendor/gijgo/js/messages/messages.es-es.min.js') }}"></script>

  <script src="{{ asset('js/proyectosProductos/cambiarProceso.js') }}"></script>

  <script>
    $("#tablaOverlay").show();
    var table;
    var idSeleccionado;
    var toastrMensaje = 'Agregado correctamente.';
    var pagina = "Orden abierta";
    var urlGetProcesos = '{{ URL::to('/proyectos/getProcesosFromProyecto') }}';

    var proyectoProcesos = [];

    $('#fecha_entrega').datepicker({ uiLibrary: 'bootstrap4',locale: 'es-es',dateFormat: 'yyyy-mm-dd', });
    $('#fecha_proceso').datepicker({ uiLibrary: 'bootstrap4',locale: 'es-es',dateFormat: 'yyyy-mm-dd', size: 'small' });


    function eliminarForm(id){
      idSeleccionado = id;
      toastrMensaje = 'Eliminado correctamente.';
    } 

    function eliminar(){
      var url = '{!! URL::to('/proyectos/delete') !!}';
      eliminarFromTableAjax(idSeleccionado,url); //General script
    }

    function updateTable(ordenesAbiertas){
      
      var funcion;
      var ordenAbiertaText;
      ordenesAbiertas.forEach( function(ordenAbierta, indice, array) {
        //validacion para evitar que haya 'null' en las celdas de la tabla principal
        Object.keys(ordenAbierta).forEach(function(key,value) {
          if( typeof ordenAbierta[key] === 'undefined' || ordenAbierta[key] === null ){ 
            ordenAbierta[key] = "";
          }
        });
        var fecha_entrega = new Date(ordenAbierta.proyecto.fecha_entrega).toISOString().split('T')[0];
        /* Conviertiendo objecto en algo leible*/
        ordenAbiertaText = String(JSON.stringify(ordenAbierta)).replace(/"/g,'&quot;');
        /*Agregando a la tabla JSON.stringify(*/
        table.row.add([
                ''+ordenAbierta.Proceso.color,
                ''+ordenAbierta.Proceso.texto_color,
                ''+ordenAbierta.id,
                '<i class="fas fa-exchange-alt mr-2"> </i>'+ordenAbierta.Proceso.nombre,
                ''+ordenAbierta.proyecto.cliente.nombre_cliente,
                ''+ordenAbierta.proyecto.titulo,
                ''+ordenAbierta.producto.numero_parte_cliente,
                ''+ordenAbierta.cantidad,
                ''+ordenAbierta.work_order,
                ''+ordenAbierta.item,
                ''+ordenAbierta.proyecto.orden_compra,
                ''+fecha_entrega,
                ''+ordenAbierta.proyecto.plan_corte,
                ''+ordenAbierta.proyecto.peso_lbs,
                ''+ordenAbierta.pintura_id,
                ''+ordenAbierta.notas,
                '<div class="btn-group"><button class="btn btn-flat btn-warning" title="cambiar proceso" onclick="cambiarProcesoForm('+ordenAbiertaText+','+indice+');"><i class="fas fa-exchange-alt"></i></button><button class="btn btn-flat btn-info" data-toggle="modal"  data-target="#modalAgregar" onclick="editarForm('+ordenAbiertaText+','+indice+');"><i class="far fa-edit"></i></button> <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" onclick="eliminarForm('+ordenAbierta.id+');"><i class="fas fa-trash-alt"></i></button>'
          ]).draw( false );
      });
      
    }

    /*Funcion que es llamada cuando presionamos editar en la tabla.
      Nos ayuda a asignar la informacion del form con la de la fila seleccionada*/

    function editarForm(ordenAbierta,row){
      
      filaSeleccionada = row;
      idSeleccionado = ordenAbierta.id;
      toastrMensaje = 'Guardado correctamente.';
      $("#id").val(ordenAbierta.id);
      $("#proyectoLabel").text(ordenAbierta.proyecto.numero_parte);
      $("#productoLabel").text(ordenAbierta.producto.numero_parte_cliente);
      
      $("#cantidad").val(ordenAbierta.cantidad);
      $("#work_order").val(ordenAbierta.work_order);
      $("#item").val(ordenAbierta.item);
      $("#heat_number").val(ordenAbierta.heat_number);
      
      $("#textAgregarForm").text('Guardar');
      $("#modalFormLabel").text(pagina+" - Editar");
    
    }

    function agregarForm(){
      idSeleccionado = 0;
      toastrMensaje = 'Agregado correctamente.';
      $('#formAgregar').trigger("reset");
      $("#cliente_id").val("").change();
      $("#cantidad").val("1");

      
      $("#textAgregarForm").text('Agregar');
      $("#modalFormLabel").text(pagina+" - Agregar");
    }
    /*Validaciones del form agregar*/
    $("#formAgregar").validate({
      rules: {  
        cantidad: {required:true},
        cliente_id: { required: true },
        fecha_entrega:{ required: true, date: true },
      },
      messages: { 
        fecha_entrega: { 
          required: "selecciona una fecha de entrega.",
          date: "formato de fecha incorrecto."
        }, 
        cliente_id: 'selecciona un cliente' ,
        cantidad: 'ingresa una cantidad',
      },

    });

    $(document).ready(function (){
      Pace.restart();
      /*Iniciar tabla*/
      table = $('#tablaPrincipal').DataTable({
        "order": [[ 0, "desc" ]],
        "paging": true, "searching": true, "ordering": true, "info": true, "autoWidth": false,
        "responsive": true,
        "columnDefs": [
        {
          "targets": [0], "visible": false, "searchable": false
        },
        {
          "targets": [1], "visible": false, "searchable": false
        },
        {
          "targets": [5], "visible": false, "searchable": false
        },
          { responsivePriority: 1, targets: 3 },
          { responsivePriority: 2, targets: -1 }
        ],
        "language": { "url" : '{{ asset('vendor/datatableSpanish.js') }}', },
        "createdRow": function ( row, data, index ) {
            //columna de botones
            /*Columna de Proceso*/
            $('td', row).eq(1).css('background-color',data[0]);
            $('td', row).eq(1).css('color',data[1]);
            
            $('td', row).eq(1).addClass('text-center');
            /* Acciones*/
            $('td', row).eq(13).addClass('p-1');

        },
        "initComplete": function( settings, json ) {
          $("#tablaOverlay").hide();
        }
      });
      
      Pace.stop();
    });


  </script>
@stop
