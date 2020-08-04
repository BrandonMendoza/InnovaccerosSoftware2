@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ $pagina.' Acero' }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
           <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
           <li class="breadcrumb-item"><a href="{{route('matacerosshow')}}">Aceros</a></li>
            <li class="breadcrumb-item">{{ $pagina.' Acero' }} </li>
          </ol>
        </div>
      </div>
    </div>
@stop
@section('content')
<form id="formCreate" method="POST" action="{{URL('/materialesAceros/insert/')}}" enctype="multipart/form-data">
	
	
      {{csrf_field()}}
      <div class="row">
        <div class="col-md-6">
          	<div class="card card-primary">
            	<div class="card-header">
              		<h3 class="card-title">General</h3>

              		<div class="card-tools">
                		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  			<i class="fas fa-minus"></i>
              			</button>
             		 </div>
            	</div>
	            <div class="card-body" style="display: block;">

	            	  <input type="text" name="id" id="id" value="{{  old('id') ?? $acero->id ?? 0}}" hidden>
	              	<div class="form-group">
	                	<label for="nombre">Nombre del Acero</label>
	                	<input type="text" id="nombre" class="form-control" name="nombre" 
                        value="{{ old('nombre') ?? $acero->nombre ?? null }}" >
	              	</div>
	              	<div class="form-group">
  	    			    <label for="simbolo">Simbolo </label>
  						    <input id="simbolo" name="simbolo" class="form-control" type="text" value="{{ old('simbolo') ?? $acero->simbolo ?? null }}">
		            </div>
	            </div>
            <!-- /.card-body -->
	        </div>
	    </div>
    </div>
  	<div class="row">
    	<div class="col-6">
			<a class="ion-close-round btn btn-flat btn-danger" href="{{route('matacerosshow')}}">
      			<i class="fas fa-window-close mr-2"></i>Cancelar
    		</a>
	    	<button type="submit" class="btn btn-flat btn-success float-right" data-toggle="modal" data-target="#exampleModal">
      			<i class="fas fa-check-square mr-2"></i> @if($pagina ='Editar') Guardar @else Agregar @endif
    		</button>
        </div>
	</div>
</form>


	
@stop

@section('scripts')
<script>
  $( "#formCreate" ).validate({
      rules: {
        nombre: {
            required: true
        },
        simbolo: {
            required: true
        },
      },
      messages: {
        nombre: 'ingresa nombre',
        simbolo: 'ingresa un simbolo',
    },
      errorElement: 'span',
    errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
      }
  });
</script>
@stop