@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{URL('/almacen/show')}}">Almacen</a></li>
        <li class="breadcrumb-item"><a href="{{URL('/historialAlmacen/show')}}">Historial de Transacciones de Almacen</a></li>
        <li class="breadcrumb-item">Transaccion {{ 'numero '.$transaccion->id}}</li>
      </ol>
    </nav>

<div class="row">
  <div class="col-md-4">
    <h4 class="jumbotron-heading">Solicitada por:</h4>
    <div class="col-md-4">
      <a href="{{URL('empleado/'.$transaccion->empleado->id.'/perfil')}}" style="text-decoration:none;">
        <div class="card mb-4 box-shadow" style="width: 18rem;">
            <img class="card-img-top" src="{{ asset('uploads/DocEmpleados/'.$transaccion->empleado->clave.'/'.$transaccion->empleado->foto) }}" alt="Card image cap" style="width: 100%; height: 200px;">
            <div class="card-body">
              <h5 class="card-title">{{ $transaccion->empleado->nombre.' '.$transaccion->empleado->apellido1}}</h5>
            </div>
        </div>
      </a>
    </div>
  </div>

  <div class="col-md-4">
    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Hora: </h4>
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ $transaccion->hora }}</h4>
    </div>
    

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Fecha de Transaccion: </h4>  
    </div>
    <div class="row">
      <h4 class="jumbotron-heading">{{ $transaccion->fecha }}</h4>
    </div>

    <div class="row">
      <h4 class="jumbotron-heading font-weight-bold">Tipo de Transaccion: </h4>  
    </div>
    @if($transaccion->tipo=='Salida')
    <div class="row alert-danger">
    @else
    <div class="row alert-success">
    @endif
      <h4 class="jumbotron-heading">{{ $transaccion->tipo }}</h4>
    </div>
  </div>
  <div class="col-md-4">
    
    
  </div>
</div>

<h4 class="jumbotron-heading">Articulos retirados:</h4>
<div class="row">
@foreach($articulos as $id => $articulo)
    <div class="col-md-4">
        <div class="card mb-4 box-shadow" style="width: 18rem;">
          <img class="card-img-top" src="{{ asset('uploads/Almacen/Articulos/'.$articulo->articulo->foto) }}" alt="Card image cap" style="width: 100%; height: 200px;">
          <div class="card-body">
            <h5 class="card-title">{{ $articulo->articulo->tipo.' '.$articulo->articulo->descripcion}}</h5>

            @if($transaccion->tipo=='Salida')
                <p class="card-text alert-danger">Cantidad retirada: {{ ' '.$articulo->cantidad }}</p>
            @else
              <p class="card-text alert-success">Cantidad agregada: {{ ' '.$articulo->cantidad }}</p>
            @endif
            

          </div>
        </div>
    </div>
@endforeach
</div>

</div>

  
@endsection

@section('scripts')
<script type="text/javascript">
	

</script>


@endsection