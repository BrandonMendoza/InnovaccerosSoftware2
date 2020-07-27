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
</style>

  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
        <li class="breadcrumb-item">Crear Orden de Compra</li>
      </ol>
  </nav>


  <div class="row">
    <div class="col" >
        <a class="btn btn-outline-info" href="{{route('ordenCompraCrear')}}" style="text-decoration:none;">Crear Orden de Compra</a>
    </div>
  </div>
  
@endsection