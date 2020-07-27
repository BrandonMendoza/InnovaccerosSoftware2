@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <h1 class="m-0 text-dark">Perfil Articulo</h1>
@stop

@section('content')
<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{URL('/almacen/show')}}">Almacen</a></li>
        <li class="breadcrumb-item"><a href="{{route('artshow')}}">Articulos de Almacen</a></li>
        <li class="breadcrumb-item">Perfil de Articulo</li>
      </ol>
    </nav>

<section class="jumbotron text-center">
        <div class="container">
        	<img class="img-fluid rounded-circle" src="{{ asset('uploads/Almacen/Articulos/'.$articulo->foto) }}" style="width: 18rem; height: 200px;">
        	<h1 class="jumbotron-heading">{{ $articulo->categoria.' '.$articulo->tipo.' '.$articulo->descripcion}}</h1>
        </div>

</section>
  <div class="row ">
    <div class="col-sm-4">
      
	</div>

    <div class="col-sm-4">
		<div class="card" style="width: 18rem;">
		  <div class="card-header">
		    Informacion personal
		  </div>
		  <ul class="list-group list-group-flush">
		    <li class="list-group-item">Clave :{{' '.$articulo->clave}}</li>
        	<li class="list-group-item">Categoria:{{' '.$articulo->categoria}}</li>
		    <li class="list-group-item">Tipo:{{' '.$articulo->tipo}}</li>
		    <li class="list-group-item">Marca:{{' '.$articulo->marca}}</li>
		    <li class="list-group-item">Unidad de medida:{{' '.$articulo->unidad_medida}}</li>
		    <li class="list-group-item">Existencia:{{' '.$articulo->existencia}}</li>
		    <li class="list-group-item">Minimo:{{' '.$articulo->minimo}}</li>
		    
		    <li class="list-group-item">
		    	<a href="{{URL('articulo/'.$articulo->id.'/editar')}}" class="btn btn-xs btn-info">Editar informacion</a>
		    </li>
		  </ul>
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
		        Estas seguro que deseas eliminar a Este Articulo
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		        <a href="{{URL('articulo/'.$articulo->id.'/eliminar')}}" class="btn btn-xs btn-danger">Eliminar Articulo</a>
		      </div>
		    </div>
		  </div>
		</div>


    </div>
  </div>

</div>
@stop