@extends('layouts.app')
@section('content')
  
  <style>
    .no-spinners {
  -moz-appearance:textfield;
}

.no-spinners::-webkit-outer-spin-button,
.no-spinners::-webkit-inner-spin-button {
 -webkit-appearance: none;
 margin: 0;
}

/* Set height of body and the document to 100% to enable "full page tabs" */
body, html {
  height: 100%;
  margin: 0;
  font-family: Arial;
}

/* Style tab links */
.tablink {
  background-color: #555;
  float: left;
  color:white;
  border: none;
  cursor: pointer;
  outline: none;
  padding: 14px 16px;
  font-size: 17px;
  width: 80%;


}
.tablink:hover {
  background-color: #4CAF50;
}

.flecha:not([disabled]) {
  width: 10%;
  height: 100%
  color: white;
  vertical-align: middle;
  cursor: pointer;
  background-color: #555;
  padding: 14px 15px 15px 15px;
}

button:disabled,
button[disabled]{
  width: 10%;
  height: 100%;
  padding: 14px 15px 15px 15px;
  vertical-align: middle;
  background-color: #cccccc;
  color: #666666;
}


.flecha:hover:not([disabled]) {
  background-color: #4CAF50;
}


/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  
  display: none;
  padding: 100px 20px;
  height: 100%;
  width: 100%

}

.active {
  background-color: #4CAF50;
  color: white;
}

.flecha{
  border-style: none;
  background-color: none;

}

  </style>

  
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
      <li class="breadcrumb-item">Consultar Nomina</li>
    </ol>
  </nav>

  
  <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <th>#</th>
            <th class="text-center">Nombre empleado</th>
            <th class="text-center">Puesto</th>
            <th class="text-center">Salario semanal</th>
            <th class="text-center">Hrs Extra</th>
            <th class="text-center">Faltas</th>
            <th class="text-center">Retardos</th>
            <th class="text-center">Bono</th>
            <th class="text-center">Deudas</th>
            <th class="text-center">Descuentos</th>
            <th class="text-center">Total</th>
          </thead>

          <tbody>
            @foreach($nomina->empleados as $id => $empleado)
              <tr>
                <td class="text-center">{{$empleado->id}}</td>
                <td class="text-center">
                  {{$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}
                </td>
                <td class="text-center">{{ $empleado->roles }}</td>
                <td class="text-center">{{ $empleado->salario_semanal }}</td>
                <td class="btn-outline-dark text-center" 
                    id="{{'hrs_extra_tabla_'.$empleado->id}}"
                    style="cursor: pointer;"
                    onchange="calcularTotal({{ $empleado->id }})" 
                    data-toggle="modal" 
                    data-target="{{'#hrsExtraModal'.$empleado->id }}"
                  >{{ $empleado->pivot->hrs_extra }}
                </td>
                <td class="text-center btn-outline-dark"
                    style="cursor: pointer;"
                    id="{{'faltas_tabla_'.$empleado->id}}"
                    onchange="calcularTotal({{ $empleado->id }})" 
                    data-toggle="modal" 
                    data-target="{{'#faltasModal'.$empleado->id }}"
                  >{{ $empleado->pivot->faltas }}
                </td>
                <td class="text-center btn-outline-dark"
                    style="cursor: pointer;"
                    id="{{'retardos_tabla_'.$empleado->id}}"
                    onchange="calcularTotal({{ $empleado->id }})" 
                    data-toggle="modal" 
                    data-target="{{'#retardosModal'.$empleado->id }}"
                  >{{ $empleado->pivot->retardos }}
                </td>
                <td class="text-center">
                  <label id="{{ 'bono_empleado'.$empleado->id }}">
                    0
                  </label>
                </td>
                @if($empleado->deudas->isEmpty())
                  <td class="text-center text-success">Sin deudas</td>
                @else
                  <td class="text-center btn-outline-danger" 
                      style="cursor: pointer;"
                      data-toggle="modal" 
                      data-target="{{'#deudasModal'.$empleado->id }}"
                    >{{$empleado->deudas->sum('restante_pagar')}}
                  </td>
                @endif
                <td class="text-center"
                    onchange="calcularTotal({{ $empleado->  id }})" 
                  >DESCUENTOS

                </td>
                <td class="text-center">
                  <label id="{{'label_total_empleado_'.$empleado->empleado_id}}"></label>
                  <input type="number" id="{{ 'total_empleado_'.$empleado->empleado_id }}" hidden>
                </td>
              </tr>


              

              
              <!-- HRS EXTRA Modal -->
              <div class="modal fade" id="{{'hrsExtraModal'.$empleado->id}}" tabindex="-1" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" >
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">{{$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" >
                      <h4 class="jumbotron-heading">Hrs extra 
                        <input  type="number" 
                                id="{{'hrs_extra_empleado'.$empleado->pivot->empleado_id}}" 
                                class="form-control" 
                                value="{{ number_format($empleado->pivot->hrs_extra) }}" 
                                onkeypress="return isNumberKey(event)" 
                                onchange="insertarHrsExtra({{$empleado->pivot->empleado_id}},this.value)" 
                                min="0"> 
                      </h4>
                    </div>
                    <div class="modal-footer">
                      <button id="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
              </div>

                          <!-- RETARDOS Modal -->
              <div class="modal fade" id="{{'retardosModal'.$empleado->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" >
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">{{$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" >
                      <h4 class="jumbotron-heading">Retardos 
                      <input  type="number" 
                              id="{{'retardos_empleado'.$empleado->pivot->empleado_id}}" 
                              class="form-control" 
                              value="{{ number_format($empleado->pivot->retardos) }}" 
                              onkeypress="return isNumberKey(event)" 
                              onchange="insertarRetardos({{$empleado->pivot->empleado_id}},this.value)" 
                              min="0"> 
                      </h4>
                    </div>
                    <div class="modal-footer">
                      <button id="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
              </div>

                          

                          <!-- FALTAS EXTRA Modal -->
              <div class="modal fade" id="{{'faltasModal'.$empleado->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">{{$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" >
                      <h4 class="jumbotron-headin">Faltas 
                        <input  type="number" 
                                id="{{'faltas_empleado'.$empleado->pivot->empleado_id}}" 
                                class="form-control" 
                                value="{{ number_format($empleado->pivot->faltas) }}" 
                                onkeypress="return isNumberKey(event)" 
                                onchange="insertarFaltas({{$empleado->pivot->empleado_id}},this.value)" 
                                min="0"> 
                      </h4>
                    </div>
                    <div class="modal-footer">
                      <button id="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
              </div>




                  


            @endforeach
          </tbody>
        </table>
      </div>


      @foreach($nomina->empleados as $id => $empleado)
        <!-- DEUDAS Modal -->
        <div class="modal fade" id="{{'deudasModal'.$empleado->id}}" tabindex="-1" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg" >
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" > 
                <div class="row">
                  <div class="col">
                    <h4 class="jumbotron-heading">Deudas</h4>
                  </div>
                  <div class="col">
                    
                  </div>
                  <div class="col">
                    
                  </div>
                </div>
                
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                    <thead>
                      <th></th>
                      <th>Monto</th>
                      <th>Plazo</th>
                      <th>Tipo</th>
                      <th>Restante</th>
                      
                    </thead>
                    @if($empleado->deudas->isEmpty())
                      <h5>Este empleado no tiene deudas</h5>
                    @else
                    <tbody>
                      @foreach($empleado->deudas as $id => $deuda)
                        <tr>
                          <td>{{$deuda->id}}</td>
                          <td>{{$deuda->monto}}</td>
                          <td>{{$deuda->plazo}}</td>
                          <td>{{$deuda->tipo}}</td>
                          <td>{{$deuda->restante_pagar}}</td>
                          
                        </tr>
                      @endforeach
                    </tbody>
                    @endif
                  </table>

                  <div class="text-center">Restante Total:</div> <div class="text-danger font-weight-bold text-center"> {{ $empleado->deudas->sum('restante_pagar') }}</div>
                </div>
              </div>
              <div class="modal-footer">
                <button id="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

      @endforeach



      @foreach($nomina->empleados as $id => $empleado)
        <!-- DEUDAS Modal -->
        <div class="modal fade" id="{{'deudasModal'.$empleado->id}}" tabindex="-1" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg" >
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" > 
                <div class="row">
                  <div class="col">
                    <h4 class="jumbotron-heading">Deudas</h4>
                  </div>
                  <div class="col">
                    
                  </div>
                  <div class="col">
                    <button class="float-right btn btn-success mb-2" onclick="enviarDeudas()">Guardar Descuento</button>
                  </div>
                </div>
                
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                    <thead>
                      <th></th>
                      <th>Monto</th>
                      <th>Plazo</th>
                      <th>Tipo</th>
                      <th>Restante</th>
                      <th class="w-2">Descuento</th>
                    </thead>
                    @if($empleado->deudas->isEmpty())
                      <h5>Este empleado no tiene deudas</h5>
                    @else
                    <tbody>
                      @foreach($empleado->deudas as $id => $deuda)
                        <tr>
                          <td>{{$deuda->id}}</td>
                          <td>{{$deuda->monto}}</td>
                          <td>{{$deuda->plazo}}</td>
                          <td>{{$deuda->tipo}}</td>
                          <td>{{$deuda->restante_pagar}}</td>
                          <td>
                            <input  type="number" 
                                    id="{{'descuentoDeuda'.$deuda->id}}" 
                                    class="form-control no-spinners" 
                                    value="0" 
                                    onkeypress="return isNumberKey(event)" 
                                    min="0">


                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                    @endif
                  </table>

                  <div class="text-center">Restante Total:</div> <div class="text-danger font-weight-bold text-center"> {{ $empleado->deudas->sum('restante_pagar') }}</div>
                </div>
              </div>
              <div class="modal-footer">
                <button id="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

      @endforeach

  

  <!-- EMPLEADO         FIN     -->
  <!-- EMPLEADO         FIN     -->
  <!-- EMPLEADO         FIN     -->
  <!-- EMPLEADO         FIN     -->





@endsection

  




@section('scripts')

  <script>

    var nomina_id = {!! json_encode($nomina->id) !!};
    var empleados_counter = {!! $nomina->empleados->count() !!};

    function calcularTotal(id){
      var retardos = $('retardos_tabla_'+id).text();
      var faltas = $('faltas_tabla_'+id).text();
      var hrs_extra = $('hrs_extra_tabla_'+id).text();

      alert(retardos+'(RETARDOS) - '+faltas+'(FALTAS) - '+hrs_extra+' (HRS EXTRA)');

      //id="hrs_extra_tabla_'.$empleado->id}}"
      //id="faltas_tabla_'.$empleado->id}}"
      //id="retardos_tabla_'.$empleado->id}}"
      //if retardos y faltas = 0
        //entonces bono = 500

      //costo por dia = sueldo/6

      //if faltas>0
        //sueldo total = sueldo total - (faltas * sueldo por dia)


    }





    function enviarDeudas(monto,pago,restante,deuda_id,empleado_id){
      restante = restante  - pago;


      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      //alert(nomina_id+'(nomina_id) '+empleado_id+'(empleado_id) '+hrs_extra+'(hrs_extra)');
      '{{csrf_token()}}'
      $.ajax({
        type:'post',
        url:'{!! URL::to('/nomina/insertarHrsExtra') !!}',
        data:{'empleado_id':empleado_id,'pago':pago,'restante':restante,'nomina_id':nomina_id},
        success:function(){
          $('#hrs_extra_tabla_'+empleado_id).text(hrs_extra);
        },
         error: function(ts) { alert(ts.responseText) }
      });
    }





















    function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
    }


    function insertarHrsExtra(empleado_id,hrs_extra){
      // INSERT POR MEDIO DE AJAX
      if(hrs_extra==""){
        hrs_extra=0;
        $('#hrs_extra_empleado'+empleado_id).val(hrs_extra);
      }


      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      //alert(nomina_id+'(nomina_id) '+empleado_id+'(empleado_id) '+hrs_extra+'(hrs_extra)');
      '{{csrf_token()}}'
      $.ajax({
        type:'post',
        url:'{!! URL::to('/nomina/insertarHrsExtra') !!}',
        data:{'empleado_id':empleado_id,'hrs_extra':hrs_extra,'nomina_id':nomina_id},
        success:function(){
          $('#hrs_extra_tabla_'+empleado_id).text(hrs_extra);
        },
         error: function(ts) { alert(ts.responseText) }
      });
    }

    function insertarFaltas(empleado_id,faltas){
      if(faltas==""){
        faltas=0;
        $('#faltas_empleado'+empleado_id).val(faltas);
      }
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      //alert(nomina_id+'(nomina_id) '+empleado_id+'(empleado_id) '+hrs_extra+'(hrs_extra)');
      '{{csrf_token()}}'
      $.ajax({
        type:'post',
        url:'{!! URL::to('/nomina/insertarFaltas') !!}',
        data:{'empleado_id':empleado_id,'faltas':faltas,'nomina_id':nomina_id},
        success:function(){
          $('#faltas_tabla_'+empleado_id).text(faltas);
        },
         error: function(ts) { alert(ts.responseText) }
      });
    }

    function insertarRetardos(empleado_id,retardos){
      if(retardos==""){
        retardos=0;
        $('#retardos_empleado'+empleado_id).val(retardos);
      }


      // INSERT POR MEDIO DE AJAX
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      //alert(nomina_id+'(nomina_id) '+empleado_id+'(empleado_id) '+hrs_extra+'(hrs_extra)');
      '{{csrf_token()}}'
      $.ajax({
        type:'post',
        url:'{!! URL::to('/nomina/insertarRetardos') !!}',
        data:{'empleado_id':empleado_id,'retardos':retardos,'nomina_id':nomina_id},
        success:function(){
          $('#retardos_tabla_'+empleado_id).text(retardos);
        },
         error: function(ts) { alert(ts.responseText) }
      });
    }


  </script>
@endsection