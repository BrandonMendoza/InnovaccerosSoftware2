@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{URL('/empleados/show')}}">Empleados</a></li>
        <li class="breadcrumb-item">Perfil {{$empleado[0]->nombre.' '.$empleado[0]->apellido1.' '.$empleado[0]->apellido2}}</li>
      </ol>
    </nav>
<div class="row">
  <div class="col">
    <h3 class="jumbotron-heading">Perfil Empleado</h3>  
  </div>
  <div class="col">
    
  </div>


  <div class="col" >
    <div class="row">
      <div class="col-md-4">
        <a href="{{URL('empleado/'.$empleado[0]->id.'/alta')}}" class="btn btn-xs btn-outline-info"><span class="ion-edit mr-2"></span>Dar de Alta Empleado</a>  
      </div>
    </div>
    
  </div>
  
</div>

      
    


<div class="row">
  <div class="col-md-4">
    
    <div class="col-md-4">
      <div class="card mb-4 box-shadow" style="width: 18rem;">
          <img class="card-img-top" src="{{ asset('uploads/DocEmpleados/'.$empleado[0]->clave.'/'.$empleado[0]->foto) }}" alt="Card image cap" style="width: 100%; height: 200px;">
          <div class="card-body">
            <h5 class="card-title">{{ $empleado[0]->nombre.' '.$empleado[0]->apellido1.' '.$empleado[0]->apellido2}}</h5>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <fieldset class="rating float-left">     
              <input type="radio" name="stars" id="4stars" value="4" >
              <label class="stars" for="4stars" id="4">4 stars</label>
              <input type="radio" name="stars" id="3stars" value="3" >
              <label class="stars" for="3stars" id="3">3 stars</label>
              <input type="radio" name="stars" id="2stars" value="2" >
              <label class="stars" for="2stars" id="2">2 stars</label>
              <input type="radio" name="stars" id="1stars" value="1" >
              <label class="stars" for="1stars" id="1">1 star</label>
              <input type="radio" name="stars" id="0stars" value="0" required>
              <label class="stars" for="0stars" id="0">0 star</label>
            </fieldset>
          </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Clave: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ $empleado[0]->clave }}</h4>
    </div>
    

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Fecha de Nacimiento: </h4>  
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{' '.$empleado[0]->fecha_nac}}</h4>
    </div>

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Empleado desde: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ ' '.$empleado[0]->fecha_entrada }} </h4>
    </div>

      
      
      

    
  </div>
  <div class="col-md-3">
     <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Telefono 1: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ $empleado[0]->telefono1 }}</h4>
    </div>
    

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Telefono 2: </h4>  
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{' '.$empleado[0]->telefono2}}</h4>
    </div>

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Direccion: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ ' '.$empleado[0]->direccion }} </h4>
    </div>
  </div>

  <div class="col-md-2">
     <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Salario: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ $empleado[0]->salario_semanal }}</h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Roles: </h4>  
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{' '.$empleado[0]->roles}}</h4>
      <p class="text-muted">{{ $empleado[0]->subRoles }}</p>
    </div>

    
  </div>
</div>


    


<div class="col-sm-4">
	<!-- Modal ELIMINAR-->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Baja Empleado</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        Estas seguro que deseas eliminar a {{ $empleado[0]->nombre.' '.$empleado[0]->apellido1.' '.$empleado[0]->apellido2 }}
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	        <a href="{{URL('empleado/'.$empleado[0]->id.'/eliminar')}}" class="btn btn-xs btn-danger"><span class="ion-close-round mr-2"></span>Dar de Baja</a>
	      </div>
	    </div>
	  </div>
	</div>
</div>

  
<br>
<div class="row mb-4">
  <div class="col-2">
    <h4 class="jumbotron-heading">Comentarios</h4>
  </div>
  <div class="col">
    
  </div>
</div>

<div class="col-2"></div>
<div class="col-6">
  @if($comentarios->isEmpty())
        <h5>Este empleado aun no Tiene comentarios</h3>
  @endif
  @foreach($comentarios as $comentario)

    
    <div class="chatContainer">
      <img src="{{ asset('uploads/DocEmpleados/'.$comentario->user->empleado->clave.'/'.$comentario->user->empleado->foto) }}" alt="Avatar">
      <p>{{ $comentario->comentario }}</p>
      <span class="time-right">{{ $comentario->created_at }}</span>
    </div>

  @endforeach
  {{ $comentarios->links() }}
</div>
<div class="col-2"></div> 


@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function() {
    var empleadoRate = {!! json_encode($empleado[0]->rate) !!};
    $('#'+empleadoRate+'stars').trigger('click');
  });

  



</script>


@endsection