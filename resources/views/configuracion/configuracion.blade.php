@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <h1 class="m-0 text-dark">Configuracion de la Cuenta</h1>
@stop

@section('content')
	<nav aria-label="breadcrumb">
	    <ol class="breadcrumb">
	      <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
	      <li class="breadcrumb-item"><a href="{{ route('conshow') }}">Configuracion de la Cuenta</a></li>
	    </ol>
	 </nav>


<div class="row">
  <div class="col">
    
  </div>
  <div class="col">
    
  </div>


  <div class="col" >
    
    
  </div>
  
</div>



      
    

@if(Auth::user()->empleado)


<div class="row">
  <div class="col-md-4">
    
    <div class="col-md-4">
      <div class="card mb-4 box-shadow" style="width: 18rem;">
          <img class="card-img-top" src="{{ asset('uploads/DocEmpleados/'.Auth::user()->empleado->clave.'/'.Auth::user()->empleado->foto) }}" alt="Card image cap" style="width: 100%; height: 200px;">
          <div class="card-body">
            <h5 class="card-title">{{ Auth::user()->empleado->nombre.' '.Auth::user()->empleado->apellido1.' '.Auth::user()->empleado->apellido2}}</h5>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            
          </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Clave: </h4>
    </div>
    <div class="row">

      <h4 class="jumbotron-heading">{{ Auth::user()->empleado->clave }}</h4>
    </div>
    

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Fecha de Nacimiento: </h4>  
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{' '.Auth::user()->empleado->fecha_nac}}</h4>
    </div>

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Empleado desde: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ ' '.Auth::user()->empleado->fecha_entrada }} </h4>
    </div>

      
      
      

    
  </div>
  <div class="col-md-3">
     <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Telefono 1: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ Auth::user()->empleado->telefono1 }}</h4>
    </div>
    

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Telefono 2: </h4>  
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{' '.Auth::user()->empleado->telefono2}}</h4>
    </div>

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Direccion: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ ' '.Auth::user()->empleado->direccion }} </h4>
    </div>
  </div>

  <div class="col-md-2">
     <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Salario: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ Auth::user()->empleado->salario_semanal }}</h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Roles: </h4>  
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{' '.Auth::user()->empleado->roles}}</h4>
      <p class="text-muted">{{ Auth::user()->empleado->subRoles }}</p>
    </div>

    
  </div>
</div>

 


</div>
<br>
<div class="row">
  <div class="col">
    <h4 class="jumbotron-heading"></h4>
  </div>
</div>

@else
<div class="row">
  <div class="col-md-4">
    <div class="col-md-4">
      <div class="card mb-4 box-shadow" style="width: 18rem;">
          <img class="card-img-top" src="{{  asset('img/default-user.png') }}" alt="Card image cap" style="width: 100%; height: 200px;">
          <div class="card-body">
            <h5 class="card-title"> {{ Auth::user()->name }} </h5>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            
          </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Email: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">  {{ Auth::user()->email }}</h4>
    </div>
     

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Registrado desde: </h4>  
    </div>
    <div class="row">
      <h4 class="jumbotron-heading"> {{ Auth::user()->created_at }}</h4>
    </div>

    
  </div>
</div>
<div class="row">
 	<div class="row">
      <h4 class="jumbotron-heading">Si puedes leer esto es porque aun no vinculas tu cuenta, habla con el administrador del sistema para que la vincule. Vincular tu cuenta habilita algunas herramientas de el sistema que son necesarias.</h4>  
    </div>
 </div>



@endif





@stop
@section('scripts')
<script type="text/javascript">
	
	var selectedEmpleado;
	var loopEmpleados = parseInt({!! json_encode($empleados->count()) !!});

	
	function empleado($id){
		selectedEmpleado = $id;
		
      	for (var i = 0; i < loopEmpleados; i++) {
      		
      		if('emp'+i != $id){
      			$('#emp'+i).removeClass('border-success');
      		}
      	}
    }

    $('#vincular').click(function() {
    	$.ajaxSetup({
	        headers: {
	          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
      	});
	    '{{csrf_token()}}'



		var idSelectedEmpleado = $('#'+selectedEmpleado+'_seleccionado').val();
		var idUser = {!! json_encode(Auth::user()->id) !!}
	    $.ajax({
	    	type:'post',
	        url:'{!! URL::to('/configuracion/vincularUserEmpleado') !!}',
	        data:{'emp':idSelectedEmpleado,'user':idUser},
	        success:function() {
	        	location.reload();
	        },
	        error: function(xhr, status, error) {
			  var err = eval("(" + xhr.responseText + ")");
			  alert(err.Message);
			}

	    });        
	});

	$(document).ready(function () {
		
	    
	    $('.empleadoHover').click(function() {
	        $(this).addClass('border-success');
	    });

    });
</script>

@stop