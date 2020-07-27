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
	      <li class="breadcrumb-item"><a href="{{URL('/trabajos/show')}}">Proyectos</a></li>
	      <li class="breadcrumb-item">Crear Proyecto</li>
	    </ol>
	</nav>
	

	<form id="formCreate" method="POST" action="{{URL('/empleado/insertarDeuda')}}" enctype="multipart/form-data">
		
		{{csrf_field()}}
		<input type="number" name="empleado_id" value="{{ $empleado_id }}" hidden>

		<div class="form-group">
			<div class="form-row">
				<div class="col-5">
					<label >Monto: </label>
				    <input name="monto" class="form-control no-spinners" type="number" onkeypress="return isNumberKey(event)" placeholder="Monto en pesos" value="{{ old('dias_habiles') }}">
				    @if($errors->any())
					    @foreach($errors->get('monto') as $error)
							<div class="badge badge-pill badge-danger">{{ $error }}</div>
					    @endforeach
					 @endif
			    </div>
		    </div>
		</div>
		<div class="form-group">
			<div class="form-row">
			    <div class="col-12	">
					<label >Tipo: </label>
					<select class="form-control custom-select" name="tipo">
			          	<option value="0" selected="true">-Selecciona Tipo-</option>
			          	<option value="Prestamo">Prestamo</option>
			          	<option value="Daños a equipo">Daños a equipo</option>
			          	<option value="Caja de herramienta">Caja de herramienta</option>
			          	<option value="Otro" >Otro</option>
			      	</select>

			      	 @if($errors->any())
					    @foreach($errors->get('tipo') as $error)
							<div class="badge badge-pill badge-danger">{{ $error }}</div>
					    @endforeach
					 @endif
			    </div>
		    </div>
		</div>

		<div class="form-group">
			<div class="form-row">
			    <div class="col-12	">
					<label >Plazo: </label>
					<select class="form-control custom-select" name="plazo">
			          	<option value="0" selected="true">-Selecciona plazo-</option>
			          	<option value="Contado">1 solo pago</option>
			          	<option value="2 pagos">2 pagos</option>
			          	<option value="3 pagos">3 pagos</option>
			          	<option value="4 pagos">4 pagos</option>
			          	<option value="Mas de 4 pagos">Mas de 4 pagos</option>
			      	</select>

			      	 @if($errors->any())
					    @foreach($errors->get('plazo') as $error)
							<div class="badge badge-pill badge-danger">{{ $error }}</div>
					    @endforeach
					 @endif
			    </div>
		    </div>
		</div>

		

      	

		<div class="form-group">
			 <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#modalCancelar">
          		Cancelar
        	</button>

		    <a  class="btn btn-outline-success" data-toggle="modal" data-target="#modalGuardar">
          		Guardar
        	</a>

	    </div>
			
		<!-- Modal TERMINAR-->
			<div class="modal fade" id="modalCancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Cancelar</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	Estas seguro que Deseas Salir sin Guardar?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			        <a href="{{URL('empleado/'.$empleado_id.'/perfil')}}" class="btn btn-outline-danger">Salir sin Guardar</a>
			      </div>
			    </div>
			  </div>
			</div>
		</div>

		<!-- Modal TERMINAR-->
			<div class="modal fade" id="modalGuardar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Deuda</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	Guardar deuda?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			        <button  type="submit" class="btn btn-outline-success" id="guardarSalir">Guardar</button>
			      </div>
			    </div>
			  </div>
			</div>
		</div>



	</form>
@endsection

@section('scripts')
	

	</script>


@endsection

