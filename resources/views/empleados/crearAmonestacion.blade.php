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
	      <li class="breadcrumb-item"><a href="{{URL('/empleados/show')}}">Empleados</a></li>
	      <li class="breadcrumb-item">Crear Amonestacion</li>
	    </ol>
	  </nav>

	  <h3 class="jumbotron-heading"></h3>

	  <div class="row">
	  	<div class="col-3">
	  		

	  	</div>
	  	<div class="col-6">
	  	
	  		

	  	

	<form id="formCreate" method="POST" action="{{route('insertarAmonestacion')}}" enctype="multipart/form-data">
		
		{{csrf_field()}}
		<h1>Amonestacion laboral</h1>
		
		
		<div class="form-group">
			<div class="form-row">
				
				<div class="col">
					
					<div class="row">
						<div class="col-10">
							<label >Se dirige el siguiente documento a: </label>
							{{$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}

							<input type="text" name="empleado_id" value="{{ $empleado->id }}" hidden>
						
						</div>
					 </div>
			    
			   
				</div>

			    
		    </div>
		</div>

		<div class="form-group">
			<div class="form-row">
			    <div class="col-8">
					<label >Motivo de amonestacion: </label>
					<textarea class="form-control" aria-label="With textarea" placeholder="Motivo de amonestacion"  name="motivo" rows="10" value="{{ old('motivo') }}"></textarea>

					@if($errors->any())
					    @foreach($errors->get('motivo') as $error)
							<div class="badge badge-pill badge-danger">{{ $error }}</div>
					    @endforeach
					 @endif
			    </div>
		    </div>
		</div>


		<div class="form-group">
			<div class="form-row">
				
				<div class="col">
					<div class="row ">
					    <div class="col-2">
						    <label>Tipo de Falta:</label>
						</div>

						<div class="col-10 pl-0">
						   <select class="form-control custom-select" name="tipo">
						        <option value="0" disabled="true" selected="true">- Tipo -</option>
						        <option value="Puntualidad">Puntualidad</option>
				              	<option value="Seguridad">Seguridad</option>
				              	<option value="Desempeño">Desempeño</option>
				              	<option value="Insubordinacion (no acatar Instrucciones)">Insubordinacion (no acatar instrucciones)</option>
						    </select>
						    @if($errors->any())
						    @foreach($errors->get('tipo') as $error)
								<div class="badge badge-pill badge-danger">{{ $error }}</div>
								@endforeach
							@endif
						</div>
					</div>
					
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="form-row">
			    <div class="col-8">
					<label >Sancion a aplicarse : </label>
					<textarea class="form-control" aria-label="With textarea" placeholder="Sanción"  name="sancion" rows="10" value="{{ old('sancion') }}"></textarea>

					@if($errors->any())
					    @foreach($errors->get('sancion') as $error)
							<div class="badge badge-pill badge-danger">{{ $error }}</div>
					    @endforeach
					 @endif
			    </div>
		    </div>
		</div>



		
	    
		<div class="form-group">
			<button type="button" class="ion-close-round btn btn-outline-danger" data-toggle="modal" data-target="#cancelarModal">
          		Cancelar
        	</button>
		    <button type="button" class="btn btn-outline-success ion-checkmark-round" data-toggle="modal" data-target="#exampleModal">
          		Listo
        	</button>
	    </div>
	    <!-- Modal ELIMINAR-->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Agregar Amonestacion</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	Estas seguro que Deseas Agregar esta Amonestacion?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			        <button  type="submit" class="btn btn-outline-success" name="submitbtn" value="create" id="submitFinal"><span class="ion-checkmark-round">Amonestacion</span></button>
			      </div>
			    </div>
			  </div>
			</div>
		</div>

		<!-- Modal Cancelar-->
			<div class="modal fade" id="cancelarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Cancelar Amonestacion</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	Estas seguro que Deseas Cancelar la Operacion?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
			        <a class="btn btn-outline-danger ion-close-round" href="{{URL('/empleado/'.$empleado->id.'/perfil')}}">Si, estoy seguro</a>
			      </div>
			    </div>
			  </div>
			</div>
		</div>

	</form>


	</div>
	  	<div class="col-2">
	  		
		</div>
	</div>
	
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script>

</script>


@endsection

