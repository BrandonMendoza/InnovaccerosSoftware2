@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Proyectos</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
         <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
          <li class="breadcrumb-item">Proyectos</li>
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
            <a href="{!! URL('/proyectos/ordenesAbiertas') !!}" class="btn btn-flat btn-default">
              <i class="fas fa-plus mr-2"></i>
              Ordenes Abiertas
            </a>
            <button class="btn btn-flat btn-default"  data-toggle="modal" data-target="#modalProcesosEditar">
              <i class="fas fa-plus mr-2"></i>
              Procesos
            </button>
            <button class="btn btn-flat btn-default" onclick="agregarForm();" data-toggle="modal" data-target="#modalAgregar">
              <i class="fas fa-plus mr-2"></i>
              Agregar
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="tablaPrincipal" class="table table-hover nowrap dt-responsive">
            <thead>
              <tr>

                <th style="width: 1%"> # </th>
                <th>Núm. de Parte (Local)</th>
                <th>Cliente</th>
                <th>Núm. de Parte (Cliente)</th>
                <th>Orden de Compra</th>
                <th>Plan de Corte</th>
                <th style="width: 20%;">Progreso</th>
                <th>Fecha de Entrega</th>
                <th>Hrs Labor</th>
                <th>Productos</th>
                <th style="width: 5%;" data-orderable="false"></th>
              </tr>
            </thead>
            <tbody> 
              @foreach($proyectos as $id => $proyecto)
                <tr>
                  <td>{{ ($loop->index+1) }}</td>
                  <td>{{ $proyecto->numero_parte }}</td>
                  <td>{{ $proyecto->Cliente->nombre_cliente }}</td>
                  <td>{{ $proyecto->numero_parte_cliente }}</td>
                  <td>{{ $proyecto->orden_compra }}</td>
                  <td>{{ $proyecto->plan_corte }}</td>
                  <td>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-green" role="progressbar" aria-volumenow="57" aria-volumemin="0" aria-volumemax="100" style="width: {{ $proyecto->getProgreso()}}%"></div>
                    </div>
                    <small> {{ $proyecto->getProgreso()}}% Completado </small>
                  </td>
                  <td> {{ \Carbon\Carbon::parse($proyecto->fecha_entrega)->format('Y-m-d')}} </td>
                  <td>{{ $proyecto->getTotalHrsLabor().' Hrs'}}</td>
                  <td>{{ $proyecto->productos->count() }}</td>
                  
                  <!-- Botones -->
                  <td style="text-align: right;" class="p-1">
                    <div class="btn-group ">
                      
                      <button class="btn btn-flat btn-info" data-toggle="modal" data-target="#modalAgregar"
                        onclick="editarForm({{$proyecto.','.($loop->index+1) }});">
                        <i class="far fa-edit"></i>
                      </button>
                      <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" 
                              onclick="eliminarForm({{$proyecto->id}});">
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
  @include('proyectos.form')


@stop


@section('scripts')

  <link rel="stylesheet" href="{{ asset('vendor/gijgo/css/gijgo.min.css') }}">
  <script src="{{ asset('vendor/gijgo/js/gijgo.min.js') }}"></script>
  <script src="{{ asset('vendor/gijgo/js/messages/messages.es-es.min.js') }}"></script>

  
  


  <script>
    var table;
    var idSeleccionado;
    var toastrMensaje = 'Agregado correctamente.';
    var pagina = "Proyecto";
    var spanishDataTable = '{{ asset('vendor/datatableSpanish.js') }}';
    var tablaProductos;

    $('#fecha_entrega').datepicker({ uiLibrary: 'bootstrap4',locale: 'es-es',dateFormat: 'yyyy-mm-dd', });


    function eliminarForm(id){
      idSeleccionado = id;
      toastrMensaje = 'Eliminado correctamente.';
    } 

    function eliminar(){
      var url = '{!! URL::to('/proyectos/delete') !!}';
      eliminarFromTableAjax(idSeleccionado,url); //General script
    }
    
    function updateTable(proyectos){
      var funcion;
      proyectos.forEach( function(proyecto, indice, array) {
        //validacion para evitar que haya 'null' en las celdas de la tabla principal
        Object.keys(proyecto).forEach(function(key,value) {
          if( typeof proyecto[key] === 'undefined' || proyecto[key] === null ){ 
            proyecto[key] = "";
          }
        });
        var fecha_entrega = new Date(proyecto.fecha_entrega).toISOString().split('T')[0];
        /* Conviertiendo objecto en algo leible*/
        funcionText = String(JSON.stringify(proyecto)).replace(/"/g,'&quot;');

        /* Creando funcion para editar en la columna*/
        funcion = 'editarForm('+funcionText+','+indice+');';
        /*Agregando a la tabla*/
        table.row.add([
                ''+indice,
                ''+proyecto.numero_parte,
                ''+proyecto.cliente.nombre_cliente,
                ''+proyecto.numero_parte_cliente,
                ''+proyecto.orden_compra,
                ''+proyecto.plan_corte,
                '<div class="progress progress-sm"><div class="progress-bar bg-green" role="progressbar" aria-volumenow="57" aria-volumemin="0" aria-volumemax="100" style="width: '+proyecto.progreso+'%"></div></div><small> '+proyecto.progreso+' Complete </small>',
                ''+fecha_entrega,
                ''+proyecto.totalHrsLabor+' Hrs',
                '',
                '<div class="btn-group"><button class="btn btn-flat btn-info" data-toggle="modal"  data-target="#modalAgregar" onclick="'+funcion+'"><i class="far fa-edit"></i></button> <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" onclick="eliminarForm('+proyecto.id+');"><i class="fas fa-trash-alt"></i></button>'
          ]).draw( false );
      });
    }

    /*Funcion que es llamada cuando presionamos editar en la tabla.
      Nos ayuda a asignar la informacion del form con la de la fila seleccionada*/
    function editarForm(proyecto,row){
      filaSeleccionada = row;
      idSeleccionado = proyecto.id;
      toastrMensaje = 'Guardado correctamente.';
      $("#id").val(proyecto.id);
      
      $("#cliente_id").val(proyecto.cliente_id).change();
      $("#numero_parte_cliente").val(proyecto.numero_parte_cliente);
      $("#numero_parte").val(proyecto.numero_parte);
      $("#orden_compra").val(proyecto.orden_compra);
      $("#fecha_entrega").val(proyecto.fecha_entrega).change();
      $("#plan_corte").val(proyecto.plan_corte);

      /*Labels*/
      $(".labelsForm").show();
      $("#proyectoLabel").text(proyecto.numero_parte);

      $("#textAgregarForm").text('Guardar');
      $("#modalFormLabel").text(pagina+" - Editar");

      var url = '{!! URL::to('/proyectos/cargarTablasForm') !!}';
      cargarTablasForm(url);
    }

    function agregarForm(){
      idSeleccionado = 0;
      toastrMensaje = 'Agregado correctamente.';
      $('#formAgregar').trigger("reset");
      $("#cliente_id").val("").change();
      $("#numero_parte").val("");
      /*Labels*/
      $(".labelsForm").hide();
      
      $("#textAgregarForm").text('Agregar');
      $("#modalFormLabel").text(pagina+" - Agregar");
      //Habilitar todas las opciones de el select de productos
      $("#producto_select>option").prop("disabled", false);
      //Limpando a tabla
      tablaProductos.clear().draw();
    }

    /*Validaciones del form agregar*/
    $("#formAgregar").validate({
      rules: {  
        cliente_id: { required: true },
        numero_parte_cliente: { required: true },
        fecha_entrega:{ required: true, date: true },
      },
      messages: { 
        fecha_entrega: { 
          required: "selecciona una fecha de entrega.",
          date: "formato de fecha incorrecto."
        }, 
        numero_parte_cliente: "ingresa un número de parte.",
        cliente_id: 'selecciona un cliente' ,
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
          { responsivePriority: 1, targets: 3 },
          { responsivePriority: 2, targets: -1 }
        ],
        "language": { "url" : '{{ asset('vendor/datatableSpanish.js') }}', },
        "createdRow": function ( row, data, index ) {
            //columna de botones
            /*Columna de Proceso*/
            /* Acciones*/
            $('td', row).eq(6).addClass('pb-0');
            $('td', row).eq(10).addClass('p-1');
            $('td', row).eq(10).addClass('text-right');

        },
      });

      Pace.stop();
    });
  </script>

  <!--Style para el El Modal->Form -->
  <link rel="stylesheet" href="{{ asset('css/proyectos/Form.css') }}">
  <!--Scripts para el El Modal->Form -->
  <script src="{{ asset('js/proyectos/Form.js') }}"></script>
@stop
