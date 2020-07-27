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
              <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
              <li class="breadcrumb-item">Proyectos</li>
            </ol>
          </div>
        </div>
      </div>
@stop

@section('content')

@if(Session::has('message')) <div class="alert alert-info"> {{Session::get('message')}} </div> @endif

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            
          </div>

          <div class="card-tools">
            <a href="/trabajo/crear" class="btn btn-flat btn-default"><i class="fas fa-plus mr-2"></i>Agregar</a>
          </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
          <table id="tabla_proyectos" class="table table-hover table-striped">

          <thead>
            <tr>
              <th style="width: 1%">
                  #
              </th>
              <th style="width: 30%">
                  Nombre del proyecto
              </th>
              <th data-orderable="false">Descripcion</th>
              <th>Cliente</th>
              <th>P.O.</th>
              <th>Factura</th>
              <th class="text-center">Costeo</th>
              <th class="text-center">Pagado</th>
              <th data-orderable="false">Notas</th>
              <th data-orderable="false"></th>
            </tr>
            
          </thead>

          <tbody>

           
            @foreach($trabajos as $id => $trabajo)
              <tr>
                <td>  
                  {{ $trabajo->id }}
                </td>
                <td>
                  <a>
                    {{ $trabajo->nombre_trabajo }}
                  </a>
                  <br>
                  <small>
                    {{ $trabajo->fecha_alternativa }}
                  </small>
                </td>

                <td class="text-center "
                    style="vertical-align: middle;" 
                    data-toggle="modal" 
                    data-target="{{'#descripcionModal'.$trabajo->id }}">
                  
                  <span class="badge {{ $trabajo->descripcion_trabajo == "" ? 'badge-danger' : 'badge-primary' }}"
                        id="{{ 'descripcionButton'.$trabajo->id }}"  >
                    <i class="far fa-file-alt"></i>
                  </span>
                </td>

                <td>
                  {{ $trabajo->cliente->nombre_cliente }}
                </td>
                <!--  TD ORDEN DE COMPRA  -->
                <td>
                  {{ $trabajo->orden_compra }} 
                </td>

                  <!--TD NUMERO FACTURA -->
                  <td>
                    {{ $trabajo->numero_factura }}
                  </td>
                  <!--  TD PROCESO STATUS INICIO  -->
                  @if($trabajo->proceso == "Avanzado 20%")
                    <td class="text-center" 
                        data-toggle="modal" 
                        data-target="{{ '#proccesModal'.$trabajo->id }}"
                        style="vertical-align: middle;"
                      >
                      <span id="{{'procesoButton'.$trabajo->id}}" 
                            class="badge badge-warning">{{ $trabajo->proceso }} </span>
                    </td>
                  @endif
                  @if($trabajo->proceso == "Avanzado 50%")
                    <td 
                        class="text-center" 
                        data-toggle="modal" 
                        data-target="{{ '#proccesModal'.$trabajo->id }}"
                        style="vertical-align: middle;"
                      >
                      <span id="{{'procesoButton'.$trabajo->id}}" 
                            class="badge badge-warning">{{ $trabajo->proceso }} </span>
                    </td>
                  @endif
                  @if($trabajo->proceso == "Avanzado 70%")
                    <td 
                        class="text-center" 
                        data-toggle="modal" 
                        data-target="{{ '#proccesModal'.$trabajo->id }}"
                        style="vertical-align: middle;"
                      >
                      <span id="{{'procesoButton'.$trabajo->id}}" 
                            class="badge badge-warning">{{ $trabajo->proceso }}</span>

                    </td>
                  @endif
                  @if($trabajo->proceso == "Avanzado 90%")
                    <td  
                          class="text-center" 
                          data-toggle="modal" 
                          data-target="{{ '#proccesModal'.$trabajo->id }}"
                          style="vertical-align: middle;"
                      >
                      <span id="{{'procesoButton'.$trabajo->id}}" 
                            class="badge badge-warning">{{ $trabajo->proceso }}</span>
                    </td>
                  @endif
                  @if($trabajo->proceso == "Terminado")
                     <td  
                          class="text-center" 
                          data-toggle="modal" 
                          data-target="{{ '#proccesModal'.$trabajo->id }}"
                          style="vertical-align: middle;"
                        >
                        <span id="{{'procesoButton'.$trabajo->id}}" 
                              class="badge badge-success">{{ $trabajo->proceso }}</span>
                      </td>
                  @endif
                  @if($trabajo->proceso == "Cancelado")
                     <td  
                          class="text-center" 
                          data-toggle="modal" 
                          data-target="{{ '#proccesModal'.$trabajo->id }}"
                          style="vertical-align: middle;"
                      >
                      <span id="{{'procesoButton'.$trabajo->id}}" 
                            class="badge badge-danger">{{ $trabajo->proceso }}</span>
                    </td>
                  @endif

                  @if($trabajo->proceso == "Cotizando")
                     <td 
                          class="text-center" 
                          data-toggle="modal" 
                          data-target="{{ '#proccesModal'.$trabajo->id }}"
                          style="vertical-align: middle;"
                        >
                        <span id="{{'procesoButton'.$trabajo->id}}" 
                              class="badge badge-primary">{{ $trabajo->proceso }}</span>
                      </td>
                  @endif
                  @if($trabajo->proceso == "Sin enviar")
                     <td  
                          class="text-center" 
                          data-toggle="modal" 
                          data-target="{{ '#proccesModal'.$trabajo->id }}"
                          style="vertical-align: middle;"
                        >
                        <span id="{{'procesoButton'.$trabajo->id}}" 
                              class="badge badge-info">{{ $trabajo->proceso }}</span>

                      </td>
                  @endif
                  @if($trabajo->proceso == "Sin Comenzar")
                    <td  
                          class="text-center"
                          style="vertical-align: middle;"
                      >
                      <span 
                        id="{{'procesoButton'.$trabajo->id}}" >
                        {{ $trabajo->proceso }}
                      </span>
                      
                    </td>
                  @endif

                  <!--  TD PAGADO STATUS INICIO  -->
                  @if($trabajo->pagado_status== "Si")
                    <td  
                        class="text-center" 
                        data-toggle="modal" 
                        data-target="{{'#pagoStatusModal'.$trabajo->id }}"
                        style="vertical-align: middle;"
                      > 
                      <span class="badge badge-success"
                            id="{{ 'pagoStatusButton'.$trabajo->id }}">
                            {{ $trabajo->pagado_status }} </span>
                      
                    </td>
                  @else
                    <td class="text-center" 
                        data-toggle="modal" 
                        data-target="{{'#pagoStatusModal'.$trabajo->id }}"
                        style="vertical-align: middle;"
                      >
                      <span class="badge badge-danger"
                            id="{{ 'pagoStatusButton'.$trabajo->id }}">{{ $trabajo->pagado_status }}  </span>
                    </td>
                  @endif

                  <!-- TD NOTAS -->
                  <td class="text-center"
                  style="vertical-align: middle;"  data-toggle="modal" data-target="{{'#notasModal'.$trabajo->id }}">
                    <span id="{{ 'notasButton'.$trabajo->id }}" class="badge {{ $trabajo->notas_trabajo == "" ? '' : 'badge-primary' }}">
                      <i class="far fa-clipboard"></i>
                    </span>
                  </td>

                  <!-- TD VER COTIZACIONES -->
                  <td class="text-right">
                    <div class="btn-group">
                      <a class="btn btn-flat btn-info" href="{{ url('/proyecto/'.$trabajo->id.'/editar') }}" style="text-decoration:none;"><i class="far fa-edit"></i>

                      </a>
                      <a class="btn btn-flat btn-primary" href="{{url('/cotizaciones/'.$trabajo->id.'/cotizacionesProyecto')}}">
                          <i class="fas fa-folder">
                          </i>
                          Cotizaciones
                      </a>
                    </div>
                      
                  </td>
              </tr>

              <!-- Descripcion Modal #descripcionModal'.$trabajo->id -->
                <div class="modal fade" id="{{ 'descripcionModal'.$trabajo->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Descripcion de proyecto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <input type="text" value="{{$trabajo->id}}" id="{{$trabajo->id.'proyecto_id'}}" hidden="true">
                        <textarea class="form-control" onkeyup="guardarDescripcion({{$trabajo->id.'proyecto_id'}})" aria-label="          With textarea" placeholder="Descripcion del proyecto"  name="descripcion_trabajo" id="descripcion_trabajo" rows="10" disabled>{!! $trabajo->descripcion_trabajo !!}
                        </textarea>
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>


              <!-- NOTAS Modal -->
              <div class="modal fade" id="{{'notasModal'.$trabajo->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Notas : {{ $trabajo->nombre_trabajo}}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <textarea onkeyup="guardarNotas(this.id);" id="{{ 'notas'.$trabajo->id }}" class="form-control" aria-label="With textarea" placeholder="Notas"  name="{{ $trabajo->id }}" rows="10"">{{ $trabajo->notas_trabajo }}</textarea>
                      </div>
                      
                    </div>
                    
                  </div>
                </div>
              </div>
                      <!-- Proceso Modal -->
              <div class="modal fade" id="{{'proccesModal'.$trabajo->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Proceso</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <!--
                         <div id="'esperando'.$trabajo->id" style="color:black;" class="col btn-lg sinRadius btn btn-outline-light text-center" name=" $trabajo->id" onclick="selectProceso(this.id);" data-dismiss="modal">Esperando Aprobacion</div>
                       -->
                      </div>
                      <div class="row">
                        <!--
                        <div id="'Comenzado'.$trabajo->id" class="col btn-lg sinRadius btn btn-outline-info text-center" name=" $trabajo->id" onclick="selectProceso(this.id);" data-dismiss="modal">Comenzado</div>
                        <div id="'Parado'.$trabajo->id" class="col btn-lg sinRadius btn btn-outline-dark text-center" name="$trabajo->id" onclick="selectProceso(this.id);" data-dismiss="modal">Parado</div>
                      -->
                      </div>
                      
                      <div class="row">
                        <div id="{{'Avanzado20'.$trabajo->id}}" class="col btn-lg sinRadius btn btn-outline-warning text-center" name="{{ $trabajo->id}}" onclick="selectProceso(this.id);" data-dismiss="modal">Avanzado 20%</div>
                        <div id="{{'Avanzado50'.$trabajo->id}}" class="col btn-lg sinRadius btn btn-outline-warning text-center" name="{{ $trabajo->id}}" onclick="selectProceso(this.id);" data-dismiss="modal">Avanzado 50%</div>
                        <div id="{{'Avanzado70'.$trabajo->id}}" class="col btn-lg sinRadius btn btn-outline-warning text-center" name="{{ $trabajo->id}}" onclick="selectProceso(this.id);" data-dismiss="modal">Avanzado 70%</div>
                        <div id="{{'Avanzado90'.$trabajo->id}}" class="col btn-lg sinRadius btn btn-outline-warning text-center" name="{{ $trabajo->id}}" onclick="selectProceso(this.id);" data-dismiss="modal">Avanzado 90%</div>
                      </div>

                      <div class="row">
                        <div id="{{'Terminado'.$trabajo->id}}" class="col btn-lg sinRadius btn btn-outline-success text-center" name="{{ $trabajo->id}}" onclick="selectProceso(this.id);" data-dismiss="modal">Terminado</div>
                        <div id="{{'Sinenviar'.$trabajo->id}}" class="col btn-lg sinRadius btn btn-outline-info text-center" name="{{ $trabajo->id}}" onclick="selectProceso(this.id);" data-dismiss="modal">Sin enviar</div>
                        <div id="{{'Cancelado'.$trabajo->id}}" class="col btn-lg sinRadius btn btn-outline-danger text-center" name="{{ $trabajo->id}}" onclick="selectProceso(this.id);" data-dismiss="modal">Cancelado</div>
                      </div>
                      
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                  </div>
                </div>
              </div>



              <!-- STATUS DE PAGO Modal -->
              <div class="modal fade" id="{{'pagoStatusModal'.$trabajo->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Status de Pago</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div id="{{'Si'.$trabajo->id}}" class="col btn-lg sinRadius btn btn-outline-success text-center" name="{{ $trabajo->id}}" onclick="selectPagoStatus(this.id);" data-dismiss="modal">Si</div>
                        <div id="{{'No'.$trabajo->id}}" class="col btn-lg sinRadius btn btn-outline-danger text-center" name="{{ $trabajo->id}}" onclick="selectPagoStatus(this.id);" data-dismiss="modal">No</div>
                      </div>
                      
                    </div>
                    
                  </div>
                </div>
              </div>


            @endforeach
            
            
              

          </tbody>
        </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>

@stop


@section('scripts')
  <script>
  
    var pagoStatus;
    var idTrabajo;

    $(document).ready(function () {
      
        
        var table = $('#tabla_proyectos').DataTable({
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
    });


    function guardarNotas(id){

      idTrabajo = $('#'+id).attr("name");
      notas = $('#'+id).val();

      if(notas==""){
        notas="";
        $("#notasButton"+idTrabajo).removeClass();
        //$("#notasButton"+idTrabajo).addClass('btn-outline-danger text-center');
      }
      else{
        $("#notasButton"+idTrabajo).removeClass();
        $("#notasButton"+idTrabajo).addClass('badge-primary text-center');
      }

          
      // INSERT POR MEDIO DE AJAX
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      '{{csrf_token()}}'
      //alert('Proceso: '+proceso+', idTrabajo: '+idTrabajo);
      $.ajax({
        type:'post',
        url:'{!! URL::to('/trabajo/guardarNotas') !!}',
        data:{'notas':notas,'idTrabajo':idTrabajo},
        success:function() {
          
        },
         error: function(ts) { alert(ts.responseText) }
      });
    }

    function guardarNumeroFactura(id){

      idTrabajo = $('#'+id).attr("name");
      numero_factura = $('#'+id).val();
      if($('#'+id).val() == ""){
        $("#numeroFacturaButton"+idTrabajo).removeClass();
        $('#numeroFacturaButton'+idTrabajo).text("");
        //$("#numeroFacturaButton"+idTrabajo).addClass('btn-danger text-center');
      }else{
        $("#numeroFacturaButton"+idTrabajo).removeClass();
        $('#numeroFacturaButton'+idTrabajo).text(numero_factura);
        //$("#numeroFacturaButton"+idTrabajo).addClass('btn-success text-center');
      }



      // INSERT POR MEDIO DE AJAX
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      '{{csrf_token()}}'
      //alert('Proceso: '+proceso+', idTrabajo: '+idTrabajo);
      $.ajax({
        type:'post',
        url:'{!! URL::to('/trabajo/guardarNumeroFactura') !!}',
        data:{'numero_factura':numero_factura,'idTrabajo':idTrabajo},
        success:function() {
          
        },
         error: function(ts) { alert(ts.responseText) }
      });
    }

    function guardarOrdenCompra(id){

      idTrabajo = $('#'+id).attr("name");
      orden_compra = $('#'+id).val();

      if($('#'+id).val() == ""){
        $("#ordenCompraButton"+idTrabajo).removeClass();
        $('#ordenCompraButton'+idTrabajo).text("");
        //$("#ordenCompraButton"+idTrabajo).addClass('btn-danger text-center');
        
      }else{
        $("#ordenCompraButton"+idTrabajo).removeClass();
        $('#ordenCompraButton'+idTrabajo).text(orden_compra);
        //$("#ordenCompraButton"+idTrabajo).addClass('btn-success text-center');
      }



      // INSERT POR MEDIO DE AJAX
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      '{{csrf_token()}}'
      //alert('Proceso: '+proceso+', idTrabajo: '+idTrabajo);
      $.ajax({
        type:'post',
        url:'{!! URL::to('/trabajo/guardarOrdenCompra') !!}',
        data:{'orden_compra':orden_compra,'idTrabajo':idTrabajo},
        success:function() {
          
        },
         error: function(ts) { alert(ts.responseText) }
      });
    }

    function selectPagoStatus(id){

      idTrabajo = $('#'+id).attr("name");

      if($('#'+id).text() == "Si"){        
        $("#pagoStatusButton"+idTrabajo).removeClass('badge-danger');
        $('#pagoStatusButton'+idTrabajo).text('Si');
        $("#pagoStatusButton"+idTrabajo).addClass('badge-success');
        pagoStatus = 'Si';
        

      }else{
        if($('#'+id).text() == "No"){

          $("#pagoStatusButton"+idTrabajo).removeClass('badge-success');
          $('#pagoStatusButton'+idTrabajo).text('No');
          $("#pagoStatusButton"+idTrabajo).addClass('badge-danger');
          pagoStatus = 'No';
          idTrabajo = $('#'+id).attr("name");
        }
      }
    
      // INSERT POR MEDIO DE AJAX
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      '{{csrf_token()}}'
      //alert('Proceso: '+proceso+', idTrabajo: '+idTrabajo);
      $.ajax({
        type:'post',
        url:'{!! URL::to('/trabajo/insertarPagoStatus') !!}',
        data:{'pagoStatus':pagoStatus,'idTrabajo':idTrabajo},
        success:function() {
          
        },
         error: function(ts) { alert(ts.responseText) }
      });
    }


    function selectProceso(id){


      idTrabajo = $('#'+id).attr("name");
      if($('#'+id).text() == "Comenzado"){
        $("#procesoButton"+idTrabajo).removeClass();
        $('#procesoButton'+idTrabajo).text('Comenzado');
        $("#procesoButton"+idTrabajo).addClass('badge badge-info text-center');
        proceso = 'Comenzado';
      }else{
        if($('#'+id).text() == "Avanzado 20%"){

          $("#procesoButton"+idTrabajo).removeClass();
          $('#procesoButton'+idTrabajo).text('Avanzado 20%');
          $("#procesoButton"+idTrabajo).addClass(' badge badge-warning text-center');
          proceso = 'Avanzado 20%';
          idTrabajo = $('#'+id).attr("name");
        }else{
          if($('#'+id).text() == "Avanzado 50%"){
            $("#procesoButton"+idTrabajo).removeClass();
            $('#procesoButton'+idTrabajo).text('Avanzado 50%');
            $("#procesoButton"+idTrabajo).addClass('badge badge-warning text-center');
            proceso = 'Avanzado 50%';
            idTrabajo = $('#'+id).attr("name");
          }else{
            if($('#'+id).text() == "Avanzado 70%"){
              $("#procesoButton"+idTrabajo).removeClass();
              $('#procesoButton'+idTrabajo).text('Avanzado 70%');
              $("#procesoButton"+idTrabajo).addClass('badge badge-warning text-center');
              proceso = 'Avanzado 70%';
              idTrabajo = $('#'+id).attr("name");
            }else{
              if($('#'+id).text() == "Avanzado 90%"){
                $("#procesoButton"+idTrabajo).removeClass();
                $('#procesoButton'+idTrabajo).text('Avanzado 90%');
                $("#procesoButton"+idTrabajo).addClass('badge badge-warning text-center');
                proceso = 'Avanzado 90%';
                idTrabajo = $('#'+id).attr("name");
              }else{
                if($('#'+id).text() == "Terminado"){
                  $("#procesoButton"+idTrabajo).removeClass();
                  $('#procesoButton'+idTrabajo).text('Terminado');
                  $("#procesoButton"+idTrabajo).addClass('badge badge-success text-center');
                  proceso = 'Terminado';
                  idTrabajo = $('#'+id).attr("name");
                }else{
                  if($('#'+id).text() == "Cancelado"){
                    $("#procesoButton"+idTrabajo).removeClass();
                    $('#procesoButton'+idTrabajo).text('Cancelado');
                    $("#procesoButton"+idTrabajo).addClass('badge badge-danger text-center');
                    proceso = 'Cancelado';
                    idTrabajo = $('#'+id).attr("name");
                  }else{
                    if($('#'+id).text() == "Parado"){
                      $("#procesoButton"+idTrabajo).removeClass();
                      $('#procesoButton'+idTrabajo).text('Parado');
                      $("#procesoButton"+idTrabajo).addClass('badge badge-dark text-center');
                      proceso = 'Parado';
                      idTrabajo = $('#'+id).attr("name");
                    }else{
                      if($('#'+id).text() == "Esperando Aprobacion"){
                        $("#procesoButton"+idTrabajo).removeClass();
                        $('#procesoButton'+idTrabajo).text('Esperando Aprobacion');
                        $("#procesoButton"+idTrabajo).addClass('badge badge-light text-center');
                        proceso = 'Esperando Aprobacion';
                        idTrabajo = $('#'+id).attr("name");
                      }
                      else{
                        if($('#'+id).text() == "Sin enviar"){
                          $("#procesoButton"+idTrabajo).removeClass();
                          $('#procesoButton'+idTrabajo).text('Sin enviar');
                          $("#procesoButton"+idTrabajo).addClass('badge badge-info text-center');
                          proceso = 'Sin enviar';
                          idTrabajo = $('#'+id).attr("name");
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
      // INSERT POR MEDIO DE AJAX
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      '{{csrf_token()}}'
      //alert('Proceso: '+proceso+', idTrabajo: '+idTrabajo);
      $.ajax({
        type:'post',
        url:'{!! URL::to('/trabajo/insertarProceso') !!}',
        data:{'proceso':proceso,'idTrabajo':idTrabajo},
        success:function() {
          
        },
        error: function(ts) { alert("Ha ocurrido un error"); }
      });
    }



  </script>
@stop