@extends('layouts.app')
@section('content')

	
	<section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Materiales</h1>
        </div>
    </section>

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="#">Materiales</a></li>
      </ol>
    </nav>
    @if(Session::has('message')) <div class="alert alert-info"> {{Session::get('message')}} </div> @endif

    <div class="form-group">
		<a href="{{route('matCrear')}}" class="btn btn-outline-success"><span class="ion-plus-round mr-2"></span>Agregar Material</a>
	</div>

  <div class="row">
    <div class="col">
      @if($materiales->isEmpty())
                  <h5>No se encontraron resultados</h3>
      @else
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <th class="text-center">#</th>
              <th class="text-center">tipo</th>
              <th class="text-center">Descripcion</th>
              <th class="text-center">Medidas</th>
              <th class="text-center"></th>
            </thead>
            <tbody>
              
              @foreach($materiales as $id => $material)
                <tr>
                  <td class="text-center">
                    {{$material->id}}
                  </td>
                  <td class="text-center">
                    {{$material->tipo}}
                  </td>
                  <td>
                    {{$material->descripcion}}
                  </td>
                  <td class="text-center">
                    {{$material->medidas}}
                  </td>
                  <td>
                    <a href="{{ url('/material/'.$material->id.'/editar') }}"><span style="height: 100%; width: 100%;" class="btn btn-info ion-edit"></span></a>
                  </td>
                </tr>    
              @endforeach
              
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
	


@endsection