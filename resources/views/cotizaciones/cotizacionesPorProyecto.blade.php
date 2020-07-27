@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cotizaciones por Proyecto</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{url('/trabajos/show')}}">Proyectos</a></li>
              <li class="breadcrumb-item">Cotizaciones por Proyecto</li>
            </ol>
          </div>
        </div>
      </div>
@stop

@section('content')
  <style>
    .pointer {cursor: pointer;}

    a:hover{
        color: blue;
    }
     /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}
.no-spinners {
  -moz-appearance:textfield;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}
  </style>

@if(Session::has('message')) <div class="alert alert-info"> {{Session::get('message')}} </div> @endif
<!-- Id del proyecto -->
<input type="text" value="{{ $idProyecto }}" hidden>
<div class="row">
    <div class="col-md-3">
      <!-- Profile Image -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
          </div>

          <h3 class="profile-username ">{{ $proyecto->nombre_trabajo  }}</h3>


          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>Cliente</b> <a class="float-right">
                <img alt="Avatar" class="img-size-50" src="{{ asset('uploads/Clientes/'.$proyecto->cliente->clave_cliente.'/'.$proyecto->cliente->foto_cliente) }}">
              
                {{ $proyecto->cliente->nombre_cliente }}
              </a>
            </li>
            <li class="list-group-item">
              <b>Fecha de entrega programada</b> <a class="float-right">543</a>
            </li>
            <li class="list-group-item">
              <b>Dias de retraso</b> <a class="float-right">1,322</a>
            </li>
            <li class="list-group-item">
              <b>Status</b> <a class="float-right"></a>
            </li>
            <li style="list-style: none">
              <div class="progress progress-sm">
                <div class="progress-bar bg-green" role="progressbar" aria-volumenow="57" aria-volumemin="0" aria-volumemax="100" style="width: 57%"></div>
              </div>
              <small>
                  {{$proyecto->proceso}}
              </small>
            </li>
          </ul>
          <a href="{{ url('/proyecto/'.$idProyecto.'/editar') }}" class="btn btn-primary btn-block">
            <i class="far fa-edit"></i><b>Editar información</b>
          </a>
          
          <a href="{{ url('/cotizaciones/'.$idProyecto.'/nuevaCotizacionPorTrabajo') }}" class="btn btn-default btn-block">
            <i class="fas fa-plus mr-2"></i><b>Nueva Cotizacion</b>
          </a>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

      <!-- About Me Box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Información</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <strong>Orden de compra</strong>
          <p class="text-muted"> @if($proyecto->orden_compra== "") - @else {{$proyecto->orden_compra}} @endif </p>
          <hr>

          <strong> Factura</strong>
          <p class="text-muted"> @if($proyecto->numero_factura== "") - @else {{$proyecto->numero_factura}} @endif </p>
          <hr>

          <strong> Tiempo de entrega(días)</strong>
          <p class="text-muted">@if($proyecto->dias_habiles== "") - @else {{ $proyecto->dias_habiles }} @endif </p>
          <hr>

          <strong> Tiempo de Pago(días)</strong>
          <p class="text-muted">@if($proyecto->tiempo_pago== "") - @else {{ $proyecto->tiempo_pago }} @endif </p>
          <hr>

          <strong> Validez</strong>
          <p class="text-muted">@if($proyecto->valides== "") - @else {{ $proyecto->valides }} @endif </p>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#proyectos" data-toggle="tab">Cotizaciones</a></li>
            <li class="nav-item"><a class="nav-link" href="#descripcion" data-toggle="tab">Descripción Gral.</a></li>
            <li class="nav-item"><a class="nav-link" href="#contactos" data-toggle="tab">Contactos</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="proyectos">
              <div class="card">
                <div class="card-body p-0">
                  <table id="tablaCotizacion" class="table table-striped projects">
                    <thead>
                      <th>U.M.</th>
                      <th>Cant.</th>
                      <th>Desc. individual</th>
                      <th>Subtotal</th>
                      <th>Ganancia</th>
                      <th>Total</th>
                      <th>Iva</th>
                      <th>Total + iva</th>
                      <th> 
                        <a  href=""
                          class="btn btn-flat btn-light "
                          data-toggle="modal" 
                          data-target="#ImprimirGruposModal"> 
                          <i class="fas fa-print"></i> Imprimir todo
                        </a>
                      </th>
                    </thead>
                      @if($cotizaciones->isEmpty())
                        <h5>Este proyecto aun no tiene cotizaciones</h3>
                      @else
                      <tbody>
                        @foreach($cotizaciones as $id => $cotizacion)
                          <tr>
                            <td class="text-center"
                              style="vertical-align: middle;"
                              id="{{'unidadMedidaColumn'.$cotizacion->id}}"
                              data-toggle="modal"
                              data-target="{{'#cantidadModal'.$cotizacion->id}}">
                              <a style="text-decoration:none;" class="btn btn-flat btn-default">
                                {{$cotizacion->unidad_medida->unidad_medida}}
                              </a>
                            </td>
                            <td class="text-center" 
                                style="vertical-align: middle;"
                                id="{{'cantidadColumn'.$cotizacion->id}}"
                                data-toggle="modal"
                                data-target="{{'#cantidadModal'.$cotizacion->id}}">
                                <div class="btn-group"> 
                                  <a style="text-decoration:none;" class="btn btn-flat btn-default">
                                    {{$cotizacion->cantidad}}
                                  </a>
                                </div>
                            </td>
                            <td class="text-center"
                              style="vertical-align: middle;" 
                              data-toggle="modal" 
                              data-target="{{'#descripcionModal'.$cotizacion->id }}">
                              <span class="badge {{ $cotizacion->descripcion_individual == "" ? 'badge-danger' : 'badge-primary' }}"
                                    id="{{ 'descripcionButton'.$cotizacion->id }}">
                                <i class="far fa-file-alt"></i>
                              </span>
                              
                            </td>
                            <td>{{ '$ '.number_format($cotizacion->subtotal_general) }}</td>
                            <td>{{ '$ '.number_format($cotizacion->ganancia_general) }}</td>
                            <td>{{ '$ '.number_format($cotizacion->total_general) }}</td>
                            <td>{{ '$ '.number_format($cotizacion->iva) }}</td>
                            <td>{{ '$ '.number_format($cotizacion->total_iva) }}</td>
                            <td>
                               <div class="btn-group">
                                <a  class="btn btn-flat btn-default" style="text-decoration:none;"
                                    data-toggle="modal" 
                                    data-target="{{'#imprimirModal'.$cotizacion->id }}"
                                    onclick="habilitarTipoCambio();">

                                    <i class="fas fa-print"></i>
                                </a>

                                <a  class="btn btn-flat btn-info" 
                                    href="{{ url('/cotizaciones/'.$cotizacion->id.'/editar') }}" 
                                    style="text-decoration:none;">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a  class="btn btn-flat btn-danger" 
                                    href="" 
                                    style="text-decoration:none;"
                                    data-toggle="modal" 
                                     data-target="{{'#eliminarModal'.$cotizacion->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                              </div>
                            </td>

                              
                          </tr>

                          <!-- PRE IMPRESION MODAL -->
                          <form id="formCreate" method="GET" 
                                      action="{{ url('/cotizaciones/'.$cotizacion->id.'/imprimirCotizacion') }}"
                                      enctype="multipart/form-data" > 
                            <div class="modal fade" id="{{ 'imprimirModal'.$cotizacion->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                              <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                  <div class="modal-body">
                                    <div class="modal-body">
                                      <div class="row">
                                        <div class="col">
                                          <input type="text" value="{{$proyecto->id}}" id="proyecto_id" hidden="true" >
                                          <label >Moneda: </label>
                                          <select class="form-control custom-select" 
                                                  id="moneda" 
                                                  name="moneda"
                                                  onchange="habilitarTipoCambio();">
                                            <option value="0" selected="true">Peso Mexicano</option>
                                            <option value="1" >Dolares</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div id="rowTipoCambio" class="row mt-3">
                                        <div class="col">
                                          <label> Tipo de cambio</label>
                                          <input  value="{{ $proyecto->tipo_cambio }}" 
                                                  onchange="guardarTipoCambio('proyecto_id')" 
                                                  onkeypress="return isNumberKeyDecimal(event)"
                                                  class="form-control" 
                                                  type="float" 
                                                  id="tipo_cambio" 
                                                  name="tipo_cambio">
                                        </div>
                                      </div>
                                    </div>
                                    
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-flat btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-flat btn-light">
                                      <i class="fas fa-print mr-2"></i>Imprimir
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>

                          <!-- Descripcion Modal #descripcionModal'.$trabajo->id -->
                          <div class="modal fade" id="{{ 'descripcionModal'.$cotizacion->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-body">
                                  <input type="text" value="{{$cotizacion->id}}" id="{{$cotizacion->id.'id_cotizacion'}}" hidden="true">
                                  <textarea class="form-control" onchange="guardarDescripcionCotizacion({{$cotizacion->id}})" aria-label="With textarea" placeholder="Descripción individual de Cotización"  name="descripcion_individual" id="{{$cotizacion->id.'descripcion_individual'}}" rows="10">{!! $cotizacion->descripcion_individual !!}</textarea>
                                  
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-flat btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <!-- Eliminar #descripcionModal'.$trabajo->id -->
                          <div class="modal fade" id="{{ 'eliminarModal'.$cotizacion->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-body">
                                  Estas seguro que deseas eliminar la Cotizacion?
                                  
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-flat btn-secondary" data-dismiss="modal">Cancelar</button>
                                  <a href="{{ url('/cotizaciones/'.$cotizacion->id.'/eliminar') }}" class="btn btn-flat btn-danger"><i class="fas fa-trash-alt"></i>Eliminar
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- CANTIDAD UNIDAD DE MEDIDA MODAL -->
                          <div class="modal fade" id="{{ 'cantidadModal'.$cotizacion->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-body">
                                  <input type="text" value="{{$cotizacion->id}}" id="{{$cotizacion->id.'id_cotizacion'}}" hidden="true">
                                  <label> Unidad de Medida</label>
                                  <select 
                                    class="form-control custom-select" 
                                    id="{{$cotizacion->id.'unidadMedida'}}" 
                                    name="unidad_medida"
                                    onchange="guardarUnidadMedidaCotizacion({{$cotizacion->id}})">

                                        <option value="{{$cotizacion->unidad_medida_id }}" selected="true">
                                          {{$cotizacion->unidad_medida->unidad_medida}}</option>
                                        @foreach($unidades_medida as $unidad_medida)
                                          <option value="{{ $unidad_medida->id }}"> 
                                            {{$unidad_medida->unidad_medida }}</option>
                                        @endforeach
                                  </select>

                                  <label> Cantidad</label>
                                    <input  value="{{ $cotizacion->cantidad }}" 
                                            onchange="guardarCantidadCotizacion({{$cotizacion->id}})" 
                                            onkeypress="return isNumberKey(event)"
                                            class="form-control no-spinners" 
                                            type="number"
                                            id="{{$cotizacion->id.'cantidad'}}">
                                  
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- Modal ENVIAR EMAIL-->
                          <div class="modal fade" id="{{ $loop->index.'sendEmailModal' }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Enviar Cotizacion</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  Enviar a: <input class="form-group" type="text" name="email">
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                  <a href="{{ url('/cotizaciones/'.$cotizacion->id.'/enviarCotizacion') }}" class="btn btn-xs btn-success">
                                    <span class="ion-close-round mr-2"></span>Enviar
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                    </tbody>
                    @endif
                  </table>
                </div>
                <!-- /.card-body -->
              </div>

             
            </div>

             <!-- /.tab-pane -->
            <div class="tab-pane" id="descripcion">
              <input type="text" value="{{$proyecto->id}}" id="proyecto_id" hidden="true">
              <textarea class="form-control" onchange="guardarDescripcion('proyecto_id')" aria-label="With textarea" placeholder="Descripcion del proyecto"  name="descripcion_trabajo" id="descripcion_trabajo" rows="10" >{!! $proyecto->descripcion_trabajo !!}
              </textarea>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="contactos">
              
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>  


    


    <!-- PRE IMPRESION GRUPOS MODAL -->
    <div class="modal fade" id="ImprimirGruposModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Imprimir en Grupos : {{ $proyecto->nombre_trabajo }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form id="formCreate2" 
                method="GET" 
                action="{{ url('/cotizaciones/imprimirGrupos') }}" >
                {{csrf_field()}}
            <div class="modal-body">
              <input type="text" value="{{$proyecto->id}}" name="proyecto_id" id="proyecto_id" hidden="true">
              <label >Moneda: </label>
              <select class="form-control custom-select" 
                    id="moneda" 
                    name="moneda">
                <option value="0" selected="true">Peso Mexicano</option>
                <option value="1" >Dolares</option>
              </select>

              <div class="mt-3">
                <label> Tipo de cambio</label>
                <input  value="{{ $proyecto->tipo_cambio }}" 
                    onchange="guardarTipoCambio('proyecto_id')" 
                    onkeypress="return isNumberKeyDecimal(event)"
                    class="form-control" 
                    type="float" 
                    id="tipo_cambio" 
                    name="tipo_cambio">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-light ion-printer">Imprimir</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    

@stop
@section('scripts')
  <script>
    $(document).ready(function () { 
        var table = $('#tablaCotizaciones').DataTable({
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

    function habilitarTipoCambio(){
      
      var selectMoneda = document.getElementById('moneda');
      //si moneda es dolares
      if(selectMoneda.value == 1){ 
        //entonces mostramos Input tipo de cambio
        $("#tipo_cambio").val(20.00);
        $("#rowTipoCambio").show();
      }else{
        $("#rowTipoCambio").hide();
        //si no escondemos Input tipo de cambio
      }
    }

    function guardarUnidadMedidaCotizacion(id){

      idCotizacion = $('#'+id+'id_cotizacion').attr("value");
      unidadMedida = $('#'+id+'unidadMedida').val();
      // INSERT POR MEDIO DE AJA/
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      '{{csrf_token()}}'
      $.ajax({
        type:'post',
        url:'{!! URL::to('/cotizaciones/guardarUnidadMedidaCotizacion') !!}',
        data:{'unidadMedida':unidadMedida,'idCotizacion':idCotizacion},
        success:function() {
          var textoUnidadMedida = $('#'+id+'unidadMedida option:selected').text();
          $('#unidadMedidaColumn'+id).text(textoUnidadMedida);
        },
         error: function(ts) { alert(ts.responseText); }
      });
    }

    function guardarCantidadCotizacion(id){

      idCotizacion = $('#'+id+'id_cotizacion').attr("value");
      cantidad = $('#'+id+'cantidad').val();
      // INSERT POR MEDIO DE AJA/
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      //alert('#cantidadColumn'+id);
      //cantidadColumn72
      '{{csrf_token()}}'
      $.ajax({
        type:'post',
        url:'{!! URL::to('/cotizaciones/guardarCantidadCotizacion') !!}',
        data:{'cantidad':cantidad,'idCotizacion':idCotizacion},
        success:function() {
          $('#cantidadColumn'+id).text(cantidad);
        },
         error: function(ts) { alert(ts.responseText); }
      });
    }


    function guardarDescripcion(id){

       idTrabajo = $('#'+id).attr("value");
      descripcion_trabajo = $('#descripcion_trabajo').val();
      // INSERT POR MEDIO DE AJA
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      '{{csrf_token()}}'
      $.ajax({
        type:'post',
        url:'{!! URL::to('/cotizaciones/guardarDescripcion') !!}',
        data:{'descripcion_trabajo':descripcion_trabajo,'idTrabajo':idTrabajo},
        success:function() {
        },
         error: function(ts) { alert(ts.responseText); }
      });


     
    }

    function guardarDescripcionCotizacion(id){

      idCotizacion = $('#'+id+'id_cotizacion').attr("value");
      descripcion_individual = $('#'+id+'descripcion_individual').val();
      // INSERT POR MEDIO DE AJA/
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      '{{csrf_token()}}'
      $.ajax({
        type:'post',
        url:'{!! URL::to('/cotizaciones/guardarDescripcionIndividual') !!}',
        data:{'descripcion_individual':descripcion_individual,'idCotizacion':idCotizacion},
        success:function() {
        },
         error: function(ts) { alert(ts.responseText); }
      });
    }

    function guardarTipoCambio(id){

      idTrabajo = $('#'+id).attr("value");
      tipo_cambio = $('#tipo_cambio').val();
      //alert(tipo_cambio);
      

      // INSERT POR MEDIO DE AJA
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      '{{csrf_token()}}'
      $.ajax({
        type:'post',
        url:'{!! URL::to('/cotizaciones/guardarTipoCambio') !!}',
        data:{'tipo_cambio':tipo_cambio,'idTrabajo':idTrabajo},
        success:function() {
        },
         error: function(ts) { alert('Hubo un error en el dato ingresado');
          tipo_cambio = $('#tipo_cambio').val(0);
          //alert(ts.responseText); 
        }
      });
    }

    function isNumberKeyDecimal(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
          return false;
      return true;
    }


  </script>
  @stop