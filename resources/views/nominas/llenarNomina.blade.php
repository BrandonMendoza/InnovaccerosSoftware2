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
      <li class="breadcrumb-item">Llenar nomina</li>
    </ol>
  </nav>

  
  
  
  <div id="myDIV" class="mt-4" style="text-align: center; height: auto;">
    <button id="flechaAnterior" class="float-left ion-arrow-left-c flecha" style="color: white;" onclick="panelAnterior()"></button>
    <button type="button" class="tablink" id="defaultOpen" data-toggle="modal" data-target="#empleadosModal">
      
        Brandon Mendoza Tovar
     
    </button>
     <button id="flechaSiguiente" class="float-right ion-arrow-right-c flecha" style="color: white;" onclick="panelSiguiente()"></button>
  </div>


  <!-- EMPLEADOS Modal -->
  <div class="modal fade" id="empleadosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Selecciona empleado</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" >
          @foreach($nomina->empleados->chunk(4) as $empleados)
            <div class="row mt-3">
              @foreach($empleados as $id => $empleado)
                <div class="col">
                  <div class="card empleadoHover align-middle" style="width: 150px; height: auto; text-align: center;" onclick="mostrarEmpleado({{$id}})">
                    <input type="text" id="" value="" hidden>
                    <img class="card-img-top" src="{{ asset('uploads/DocEmpleados/'.$empleado->clave.'/'.$empleado->foto) }}" style="height: 80px; width: 80%; margin: 0 auto;">
                    <p class="card-text text-center"  id="nombreCompletoSelect">{{ $empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2 }}</p>              
                  </div>
              </div>         
              @endforeach
            </div>
          @endforeach
        </div>
        <div class="modal-footer">
          <button id="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  

  <!-- EMPLEADO             -->
  <!-- EMPLEADO              -->
  <!-- EMPLEADO              -->

  
@foreach($nomina->empleados as $id => $empleado)
  <div id="{{$id}}" class="tabcontent border">
    <div class="col"></div>
      <div class="col-12">
        <div class="row">
          <div class="col-md-4">
            <div class="col-md-4">
              <div class="card mb-4 box-shadow" style="width: 18rem;">
                  <img class="card-img-top" src="{{ asset('uploads/DocEmpleados/'.$empleado->clave.'/'.$empleado->foto) }}" alt="Card image cap" style="width: 100%; height: 200px;">
                  <div class="card-body">
                    <h5 id="{{'nombre_empleado'.$id}}" class="card-title">{{ $empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}</h5>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    
                  </div>
              </div>
            </div>
          </div>
          
          <div class="col">
             <table class="table table-hover table-bordered">
              <thead>
                <th colspan="2">Viernes</th>
                <th colspan="2">Sabado</th>
                <th colspan="2">Domingo</th>
                <th colspan="2">Lunes</th>
                <th colspan="2">Martes</th>
                <th colspan="2">Miercoles</th>
                <th colspan="2">Jueves</th>
              </thead>
              <tbody>
                <tr>
                  <td colspan="2">{{$empleado->pivot->viernes_fecha}}</td>
                  <td colspan="2">{{$empleado->pivot->sabado_fecha}}</td>
                  <td colspan="2">{{$empleado->pivot->domingo_fecha}}</td>
                  <td colspan="2">{{$empleado->pivot->lunes_fecha}}</td>
                  <td colspan="2">{{$empleado->pivot->martes_fecha}}</td>
                  <td colspan="2">{{$empleado->pivot->miercoles_fecha}}</td>
                  <td colspan="2">{{$empleado->pivot->jueves_fecha}}</td>
                </tr>

                <tr>
                  <td>{{$empleado->pivot->viernes_status}}</td>
                  <td>{{$empleado->pivot->viernes_hrs_extra}}</td>
                  <td>{{$empleado->pivot->sabado_status}}</td>
                  <td>{{$empleado->pivot->sabado_hrs_extra}}</td>
                  <td>{{$empleado->pivot->domingo_status}}</td>
                  <td>{{$empleado->pivot->domingo_hrs_extra}}</td>
                  <td>{{$empleado->pivot->lunes_status}}</td>
                  <td>{{$empleado->pivot->lunes_hrs_extra}}</td>
                  <td>{{$empleado->pivot->martes_status}}</td>
                  <td>{{$empleado->pivot->martes_hrs_extra}}</td>
                  <td>{{$empleado->pivot->miercoles_status}}</td>
                  <td>{{$empleado->pivot->miercoles_hrs_extra}}</td>
                  <td>{{$empleado->pivot->jueves_status}}</td>
                  <td>{{$empleado->pivot->jueves_hrs_extra}}</td>
                </tr>
              </tbody>
            </table>

          </div>

        </div>

        <div class="row">
          
        </div>
      </div>


      <div class="col">
        <h3>Deudas</h3>
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                <th></th>
                <th>Monto</th>
                <th>Plazo</th>
                <th>Tipo</th>
                <th></th>
                <th></th>
              </thead>
              @if($empleado->deudas->isEmpty())
                <h5>Este empleado no tiene deudas</h5>
              @else
              <tbody>
                @foreach($empleado->deudas as $id => $deuda)
                  <tr>
                    <td>{{$id}}</td>
                    <td>{{$deuda->monto}}</td>
                    <td>{{$deuda->plazo}}</td>
                    <td>{{$deuda->tipo}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                @endforeach
              </tbody>
              @endif
            </table>
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
    var numero_panel = 0;
    var numero_empleados = {!! json_encode($nomina->empleados->count()) !!};
    var nomina_id = {!! json_encode($nomina->id) !!}


    $('#flechaAnterior').attr('disabled','disabled');


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
        },
         error: function(ts) { alert(ts.responseText) }
      });
    }



    $(function(){
      $('html').keydown(function(e){
        if(e.keyCode == 37) { // left
            if(numero_panel > 0)
              panelAnterior();
          }
          else if(e.keyCode == 39) { // right
            if(numero_panel < numero_empleados - 1)
              panelSiguiente();
          }
      });
    });



    function mostrarEmpleado($id){
      var nombre_empleado;
      numero_panel = $id;

      if(numero_panel == 0){
        $('#flechaAnterior').attr('disabled','disabled');
      }
      else{
        $('#flechaAnterior').removeAttr('disabled','disabled');
      }

      if(numero_panel == numero_empleados-1){
        $('#flechaSiguiente').attr('disabled','disabled');
      }
      else{
        $('#flechaSiguiente').removeAttr('disabled','disabled');
      }
      

      document.getElementById("closeModal").click(); 

      nombre_empleado = $('#nombre_empleado'+numero_panel).text();
      $('.tablink').text(nombre_empleado);
      openPage(numero_panel);

    }

    function panelAnterior(){
      var nombre_empleado;

      if(numero_panel == numero_empleados-1){
        $('#flechaSiguiente').removeAttr('disabled','disabled');
      }
      numero_panel--;
      if(numero_panel == 0){
        $('#flechaAnterior').attr('disabled','disabled');
      }
      else{
        $('#flechaAnterior').removeAttr('disabled','disabled');
      }


      nombre_empleado = $('#nombre_empleado'+numero_panel).text();
      $('.tablink').text(nombre_empleado);

      openPage(numero_panel);
    }

    function panelSiguiente(){
      if(numero_panel == 0){
        $('#flechaAnterior').removeAttr('disabled','disabled');
      }
      numero_panel++;
      if(numero_panel == numero_empleados-1){
        $('#flechaSiguiente').attr('disabled','disabled');
      }
      else{
        $('#flechaSiguiente').removeAttr('disabled','disabled');
      }

      nombre_empleado = $('#nombre_empleado'+numero_panel).text();
      $('.tablink').text(nombre_empleado);
      openPage(numero_panel);
    }

    function openPage(pageName) {

       // Hide all elements with class="tabcontent" by default */
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      // Show the specific tab content
      document.getElementById(pageName).style.display = "block";
      var btnContainer = document.getElementById("myDIV");
      // Get all buttons with class="btn" inside the container
      var btns = btnContainer.getElementsByClassName("tablink");
    }

    function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
    }

    document.getElementById("0").style.display = "block";

  </script>
@endsection