@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Materiales</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
             <li class="breadcrumb-item"><a href="{{route('matshow')}}">Materiales</a></li>
              <li class="breadcrumb-item">Agregar Material</li>
            </ol>
          </div>
        </div>
      </div>
@stop
@section('content')


<form id="formCreate" method="POST" action="{{URL('/material/insert')}}" enctype="multipart/form-data">
	
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
	            	<input type="text" name="id" value="{{ old('id') ?? $material->id ?? 0}}" hidden>
	              	<div class="form-group">
	                	<label for="numero_parte">Numero de Parte</label>
	                	<input 	type="text" id="numero_parte" class="form-control" name="numero_parte" 
	                			value="{{ old('numero_parte') ?? $material->numero_parte ?? null }}">
	              	</div>
	              	<div class="row">
	              		<div class="col-6">
	              			<div class="form-group">
			    			    <label for="tipo_material_id">Tipo de Material </label>
								<select class="form-control custom-select" id="tipo_material_id" name="tipo_material_id">
									@isset($material)  @else <option value="" selected="true"></option> @endisset
									@foreach($materialesTipos as $id => $materialTipo)
										<option value="{{ $materialTipo->id }}" 
											{{ (isset($material)) ? 
													($material->Tipo_material->id == $materialTipo->id) ? 'selected' : '' : ''}}>
											{{ '('.$materialTipo->simbolo.') '.$materialTipo->nombre}}
										</option>
									@endforeach
							    </select>
				            </div>
	              		</div>
	              		<div class="col-6">
	              			<div class="form-group">
			    			    <label for="acero_id">Acero</label>
								<select class="form-control custom-select" id="acero_id" name="acero_id">
									@isset($material)  @else <option value="" selected="true"></option> @endisset
									@foreach($materialesAceros as $id => $materialAcero)
										<option value="{{ $materialAcero->id }}" 
											{{ (isset($material)) ? 
													($material->Acero->id == $materialAcero->id) ? 'selected' : '' : ''}}>
											{{ '('.$materialAcero->simbolo.') '.$materialAcero->nombre}}
										</option>
									@endforeach
							    </select>
				            </div>
	              		</div>
	              	</div>
	              	<div class="row">
	              		<div class="col">
	              			<div class="form-group">
		                		<label for="peso_kg">Peso(kg)</label>
		                		<input 	type="text" id="peso_kg" class="form-control" name="peso_kg" 
		                			value="{{ old('peso_kg') ?? $material->peso_kg ?? null }}">
				            </div>
	              		</div>
	              		<div class="col">
	              			<div class="form-group">
			                	<label>Medida</label>
			                	<div class="row">
			                		<div class="col-3">
			                			<input 	type="text" id="medida_1" class="form-control" name="medida_1" 
			                			value="{{ old('medida_1') ?? $material->medida_1 ?? null }}">
			                		</div>
			                		<div class="col-3">
			                			<input 	type="text" id="medida_2" class="form-control" name="medida_2" 
			                			value="{{ old('medida_2') ?? $material->medida_2 ?? null }}">
			                		</div>
			                		<div class="col-3">
			                			<input 	type="text" id="medida_3" class="form-control" name="medida_3" 
			                			value="{{ old('medida_3') ?? $material->medida_3 ?? null }}">
			                		</div>
			                		<div class="col-3">
			                			<input 	type="text" id="medida_4" class="form-control" name="medida_4" 
			                			value="{{ old('medida_4') ?? $material->medida_4 ?? null }}">
			                		</div>
			                	</div>
			              	</div>
	              		</div>
	              	</div>
	            </div>
	            
            <!-- /.card-body -->
	        </div>
	    </div>
    </div>
  	<div class="row mb-4">
      <div class="col-6">
        <a class="ion-close-round btn btn-flat btn-danger" href="{{route('matshow')}}">
              <i class="fas fa-window-close mr-2"></i>Cancelar
          </a>
          <button type="submit" class="btn btn-flat btn-success float-right" data-toggle="modal" data-target="#exampleModal">
              <i class="fas fa-check-square mr-2"></i> @if($pagina =='Editar') Guardar @else Agregar @endif
          </button>
          </div>
    </div>
</form>
		
	
@endsection

@section('scripts')
<script>
	$( "#formCreate" ).validate({
	    rules: {
	        numero_parte: {
	            required: true
	        },
	        tipo_material_id: {
	            required: true
	        },
	        acero_id: {
	            required: true
	        },
	        peso_kg: {
	            required: true
	        },
	        medida_1: {
	            required: true
	        },
	        medida_2: {
	            required: true
	        },
	    },
	    messages: {
	        numero_parte: 'ingresa un numero de parte',
	        tipo_material_id: 'selecciona un tipo de material',
	        acero_id: 'selecciona un acero',
	        peso_kg: 'ingresa un peso',
	        medida_1: 'ingresa una medida',
	        medida_2: 'ingresa medida',
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


@endsection