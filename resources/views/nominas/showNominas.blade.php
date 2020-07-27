@extends('layouts.app')
@section('content')



  <section class="jumbotron text-center">
    <div class="container">
      <h1 class="jumbotron-heading">Nominas</h1>
      <p class="lead text-muted"></p>
    </div>
  </section>
  
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
      <li class="breadcrumb-item">Nominas</li>
    </ol>
  </nav>

 @if(Session::has('message')) <div class="alert alert-info"> {{Session::get('message')}} </div> @endif
    <!--  FILTROS DE BUSQUEDA -->
  
  <div class="row">
    <div class="col float-right" >
      <a href="/nomina/crear" class="btn btn-outline-success float-right">
        <span class="ion-plus-round mr-2"></span>Nueva Nomina
      </a>
    </div>
  </div>  



  <div class="row mt-4">
    <div class="col-md-12">


      
            
       
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <th>#</th>
            <th class="text-center">Semana</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Empleados</th>
            <th class="text-center">Editar</th>
          </thead>

          <tbody>
            @foreach($nominas as $id => $nomina)
              <tr>
                <td class="text-center">{{$nomina->id}}</td>
                <td class="text-center">{{$nomina->semana}}</td>
                <td class="text-center">{{ 'Martes-'.$nomina->created_at }}</td>
                <td class="text-center">{{$nomina->empleados->count()}}</td>
                <td class="text-center">
                  <a href="{{ url('/nomina/'.$nomina->id.'/perfil') }}"><span style="height: 100%; width: 100%;" class="btn btn-info ion-edit"></span></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div> 


    
    
  </div>
@endsection

@section('scripts')
@endsection