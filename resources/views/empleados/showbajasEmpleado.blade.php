@extends('layouts.app')
@section('content')



<section class="jumbotron text-center">
    <div class="container">
      <h1 class="jumbotron-heading">Empleados dados de Baja</h1>
      <p class="lead text-muted"></p>
    </div>
  </section>
  
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
      <li class="breadcrumb-item"><a href="{{route('empshow')}}">Empleados</a></li>
      <li class="breadcrumb-item">Empleados dados de Baja</li>
    </ol>
  </nav>
<div class="form-group">

</div>
<tbody>
  <div id="body">
    @if($empleados->isEmpty())
      <h5>No hay empleados dados de baja</h3>
    @endif
    <div class="row">
      @foreach($empleados as $empleado)
        <div class="col-md-4">
          <a href="{{URL('empleado/'.$empleado->id.'/perfilBaja')}}" style="text-decoration:none;">
            <div class="card mb-4 box-shadow" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('uploads/DocEmpleados/'.$empleado->clave.'/'.$empleado->foto) }}" alt="Card image cap" style="width: 100%; height: 200px;">
                <div class="card-body">
                  <h5 class="card-title">{{ $empleado->nombre.' '.$empleado->apellido1}}</h5>

                  
                </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</tbody>
@endsection