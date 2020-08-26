@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Procesos</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
         <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
          <li class="breadcrumb-item">Procesos</li>
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
            <button class="btn btn-flat btn-default" onclick="porcentajesModal();">
              Porcentajes
            </button>
            <button class="btn btn-flat btn-default" onclick="ordenarModal();">
              Ordenar
            </button>
            <button class="btn btn-flat btn-default" onclick="agregarForm();" data-toggle="modal" data-target="#modalAgregar">
              <i class="fas fa-plus mr-2"></i>
              Agregar
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
          <table id="tablaPrincipal" class="table table-hover text-nowrap projects">
            <thead>
              <tr>
                <th>Orden</th>
                <th>ID</th>
                <th>Nombre</th>
                <th>Simbolo</th>
                <th style="text-align: center;">Color</th>
                <th style="text-align: center;">Color del Texto</th>
                <th style="text-align: center;">Activo</th>
                <th data-orderable="false"></th>
              </tr>
            </thead>
            <tbody> 
              @foreach($procesos as $id => $proceso)
                <tr>
                  <td>{{ $proceso->orden }}</td>
                  <td>{{ $proceso->id }}</td>
                  <td>{{ $proceso->nombre }}</td>
                  <td>{{ $proceso->simbolo }}</td>
                  <td><i class="fas fa-square" style="background-color: black; color: {{ $proceso->color }};"></i></td>
                  <td><i class="fas fa-square" style="background-color: black; color: {{ $proceso->texto_color }};"></i>
                  </td>
                  <td>
                    @if($proceso->activo == 1)
                    <i class="fas fa-check text-success"></i>
                    @else
                      <i class="fas fa-times text-danger"></i>
                    @endif
                  </td>
                  <!-- Botones -->
                  <td style="text-align: right;">
                    @if($proceso->es_estatico == 0)
                    <div class="btn-group">
                      <button class="btn btn-flat btn-info" data-toggle="modal" data-target="#modalAgregar"
                              onclick="editarForm({{$proceso.','
                                                  .($loop->index+1) }});">
                        <i class="far fa-edit"></i>
                      </button>

                      <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" 
                              onclick="eliminarForm({{ $proceso->id }});">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>
                    @endif
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
          Estás seguro que deseas <b> Eliminar Proceso?</b>
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
   
  <!-- Modal Form-->  
  @include('procesos.form')

  <!-- Modal Ordenar-->  
  @include('procesos.ordenarModal')

  <!-- Modal Porcentajes-->  
  @include('procesos.porcentajesModal')



@stop

@section('scripts')
  <!-- Row Order-->
  <script src="{{ asset('vendor/jquery/datatables/RowReorder/js/dataTables.rowReorder.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery/datatables/RowReorder/js/rowReorder.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('js/procesos/ordenarModal.js') }}"></script>

  
  

  <!-- Slider-->
  <link rel="stylesheet" href="{{ asset('vendor/jquery/jquery-ui/css/jquery-ui-slider.min.css') }}">
  <script src="{{ asset('vendor/jquery/jquery-ui/js/jquery-ui-slider.min.js') }}"></script>

  <script src="{{ asset('js/procesos/porcentajeModal.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('css/procesos/porcentajeModal.css') }}">

  <script>  
    var table;
    var tablaOrdenar;
    var tablaPorcentajes;
    var idSeleccionado;
    var filaSeleccionada;
    var toastrMensaje = 'Agregado correctamente.';
    var pagina = "Proceso";
    var urlActivarDesactivar = '{!! URL::to('/procesos/activarDesactivar') !!}';
    var urlCargarTablaProcesos = '{!! URL::to('/procesos/cargarTablaProcesos') !!}';
    var urlCargarTablaPorcentajes = '{!! URL::to('/procesos/cargarTablaPorcentajes') !!}';
    

    $("#activoCheckbox").click(function(){
      var activo;
      var check = $(this).prop('checked');
      console.log("si entro");
      if(check == true){
        $("#activo").val(1);
      }else{
        $("#activo").val(0);
      }
      activo = $("#activo").val();
      if(idSeleccionado != 0){
        //activarDesactivar(urlActivarDesactivar,idSeleccionado,activo);
      }
    });

    function porcentajesModal(){
      $("#modalPorcentajes").modal();
      toastrMensaje = 'cargado correctamente.';
      var url = '{!! URL::to('/procesos/cargarTablaPorcentajes') !!}';
      cargarTablaPorcentajes(url);
    }

    function ordenarModal(){
      toastrMensaje = 'cargado correctamente.';
      var url = '{!! URL::to('/procesos/cargarTablaPorcentajes') !!}';;
      cargarTablaOrdenModal(url);
    }


    function onChangeColor(){
      $("#preview").css("background-color",$("#color").val());
      $("#preview").css("color",$("#texto_color").val());
    }

    function eliminarForm(id){
      idSeleccionado = id;
      toastrMensaje = 'Eliminado correctamente.';
    } 

    function eliminarAcero(){
      var url = '{!! URL::to('/proceso/delete') !!}';
      eliminarFromTableAjax(idSeleccionado,url);
    }

    function updateTable(procesos){
      procesos.forEach( function(proceso, indice, array) {
        /* Conviertiendo objecto en algo leible*/
        funcionText = String(JSON.stringify(proceso)).replace(/"/g,'&quot;');
        /* Creando funcion para editar en la columna*/
        funcion = 'editarForm('+funcionText+','+indice+');';
        var botones = '<div class="btn-group"><button class="btn btn-flat btn-info" data-toggle="modal"  data-target="#modalAgregar" onclick="'+funcion+'"><i class="far fa-edit"></i></button> <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" onclick="eliminarForm('+proceso.id+');"><i class="fas fa-trash-alt"></i></button>'
        if(proceso.es_estatico == 1){
          botones = ''
        }

        table.row.add([
          ''+proceso.orden,
          ''+proceso.id,
          ''+proceso.nombre,
          ''+proceso.simbolo,
          '<i class="fas fa-square" style="background-color:black; color:'+proceso.color+';"></i>',
          '<i class="fas fa-square" style="background-color:black; color:'+proceso.texto_color+';"></i>',
          getIconActivo(proceso.activo),
          botones
        ]).draw( false );
      });
    }

    function editarForm(proceso,row){
      filaSeleccionada = row;
      idSeleccionado = 0;
      toastrMensaje = 'Guardado correctamente.';

      //activar/desactivar activo en form
      $("rowActivo").show();
      toggleActivoCheckbox(proceso.activo);

      $("#preview").css("background-color",proceso.color);
      $("#preview").css("color",proceso.texto_color);
      $("#id").val(proceso.id);
      $("#nombre").val(proceso.nombre);
      $("#simbolo").val(proceso.simbolo);
      $("#color").val(proceso.color);
      $("#texto_color").val(proceso.texto_color).change();

      $("#textAgregarForm").text('Guardar');
      $("#modalFormLabel").text(pagina+" - Editar");
      idSeleccionado = proceso.id;
    }

    function agregarForm(){
      idSeleccionado = 0;
      toastrMensaje = 'Agregado correctamente.';

      //activar/desactivar activo en form
      toggleActivoCheckbox(1);
      $("rowActivo").hide();

      $('#formAgregar').trigger("reset");
      $("#textAgregarForm").text('Agregar');
      $("#modalFormLabel").text(pagina+" - Agregar");
      onChangeColor();
    }

    $("#formAgregar").validate({
      rules: {
        nombre: {required: true },
        simbolo: {required: true },
        color: {required: true},
        texto_color: {required: true},
      },
      messages: { nombre: 'ingresa nombre',simbolo: 'ingresa un simbolo',color: 'selecciona un color',color: 'selecciona un color de texto'},
    });

    function updateProcesosOrder(procesos){
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      $.ajax({
         type: "POST",
         data: {procesos:procesos},
         url: '{{ asset('/procesos/order') }}',
         success: function(mensaje){
          //se envia notificacion
          toastr.success("ordenado correctamente.");
           console.log(mensaje);
           cargarTablaProcesos(urlCargarTablaProcesos);
         },
         error: function (mensaje) {
          console.log('Ha ocurrido un error.');
          console.log(mensaje);
          toastr.error('Hubo un error al cargar el producto.');
          Pace.stop();
          $("#tablaOverlay").hide();
        },
      });
    }
    
    $(document).ready(function () { 
      $('[data-toggle="popover"]').popover();   

      Pace.restart();
      table = $('#tablaPrincipal').DataTable({
        "paging": true, "searching": true,"ordering": true,"info": true, "autoWidth": false, 
        "responsive": true,
        "language": { "url" : '{{ asset('vendor/datatableSpanish.js') }}', },
        "order": [[ 0, "desc" ]],
        "columnDefs": [
          {"targets": [1], "visible": false, "searchable": false}
        ],

        "createdRow": function ( row, data, index ) { 
          $('td', row).eq(3).addClass('text-center'); 
          $('td', row).eq(4).addClass('text-center'); 
          $('td', row).eq(5).addClass('text-center');
          $('td', row).eq(6).addClass('text-right');
          $('td', row).eq(6).addClass('p-1'); 
        },
      });

      tablaPorcentajes = $('#tablaPorcentajes').DataTable({
        "paging": false, "searching": false,"ordering": false,"info": false, "autoWidth": false, 
        "responsive": true,
        "language": { "url" : '{{ asset('vendor/datatableSpanish.js') }}', },
        "columnDefs": [
          {"targets": [2], "visible": false, "searchable": false},
          {"targets": [3], "visible": false, "searchable": false}
        ],
        "createdRow": function ( row, data, index ) { 
          $('td', row).eq(0).css('background-color',data[2]);
          $('td', row).eq(0).css('color',data[3]);
          $('td', row).eq(1).addClass('text-center');
        },
      });

      tablaOrdenar = $('#tablaOrdenar').DataTable({
        "paging": false, "searching": false,"ordering": true,"info": false, "autoWidth": false, "responsive": true, rowReorder: true,
        "language": { "url" : '{{ asset('vendor/datatableSpanish.js') }}', },
        "columnDefs": [
          { orderable: true, className: 'reorder', targets: 0 },
          {"targets": [1,5,6], "visible": false, "searchable": false},
        ],
        "createdRow": function ( row, data, index ) { 
          $('td', row).eq(1).css('background-color',data[5]);
          $('td', row).eq(1).css('color',data[6]);
          $('td', row).eq(1).addClass('text-center');
        },
      });

      tablaOrdenar.on( 'row-reorder', function ( e, diff, edit ) {
        var result = 'Reorder started on row: '+edit.triggerRow.data()[1]+'<br>';
        var procesos = [];
        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
          var rowData = tablaOrdenar.row( diff[i].node ).data();
 
          result += rowData[1]+' actualizado a la posicion '+
                diff[i].newData+' (antes '+diff[i].oldData+')<br>';

          var obj = {'id':rowData[1],'orden':diff[i].newData};

          procesos.push(obj);
        }

        console.log(result);
        updateProcesosOrder(procesos);
      });
      Pace.stop();

    });
  </script>


@stop