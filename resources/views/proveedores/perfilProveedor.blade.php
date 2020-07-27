@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{URL('/proveedores/show')}}">Proveedores</a></li>
        <li class="breadcrumb-item">Perfil {{$proveedor->nombre}}</li>
      </ol>
    </nav>
<div class="row">
  <div class="col">
    <h3 class="jumbotron-heading">Perfil Proveedor</h3>  
  </div>
  <div class="col">
    
  </div>


  <div class="col" >
    <div class="row">
      <div class="col-md-5">
        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal">
          <span class="ion-close-round mr-2"></span>
          Eliminar
        </button>

      </div>

      <div class="col-md-4">
        <a href="{{URL('proveedor/'.$proveedor->id.'/editar')}}" class="btn btn-xs btn-outline-info"><span class="ion-edit mr-2"></span>Editar informacion</a>  
      </div>
    </div>
    
  </div>
  
</div>

      
    


<div class="row">
  <div class="col-md-4">
    
    <div class="col-md-4">
      <div class="card mb-4 box-shadow" style="width: 18rem;">
          <img class="card-img-top" src="{{ asset('uploads/DocProveedores/'.$proveedor->foto) }}" alt="Card image cap" style="width: 100%; height: 200px;">
          <div class="card-body">
            <h5 class="card-title">{{ $proveedor->nombre}}</h5>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            
          </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Sucursal: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ $proveedor->sucursal }}</h4>
    </div>
    

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Telefono: </h4>  
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{' '.$proveedor->telefono}}</h4>
    </div>

   
      
      

    
  </div>
  <div class="col-md-3">
     <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Email: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ $proveedor->email }}</h4>
    </div>
    

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Notas: </h4>  
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{$proveedor->notas}}</h4>
    </div>

    
    
  </div>
</div>


    


<div class="col-sm-4">
	<!-- Modal ELIMINAR-->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Eliminar proveedor</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        Estas seguro que deseas eliminar este Proveedor?
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	        <a href="{{URL('proveedor/'.$proveedor->id.'/eliminar')}}" class="btn btn-xs btn-danger"><span class="ion-close-round mr-2"></span>Eliminar proveedor</a>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<hr>


@endsection

@section('scripts')
<script type="text/javascript">

  



</script>


@endsection