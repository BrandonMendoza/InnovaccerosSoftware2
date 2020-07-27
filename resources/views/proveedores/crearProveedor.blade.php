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
	      <li class="breadcrumb-item"><a href="{{URL('/proveedores/show')}}">Proveedores</a></li>
	      <li class="breadcrumb-item">Agregar Proveedor</li>
	    </ol>
	  </nav>

	  <h3 class="jumbotron-heading"></h3>

	  <div class="row">
	  	<div class="col-3">
	  		

	  	</div>
	  	<div class="col-6">
	  	
	  		

	  	

	<form id="formCreate" method="POST" action="{{route('insertarProveedor')}}" enctype="multipart/form-data">
		
		{{csrf_field()}}
		<h1>Proveedor</h1>
		
		
		<div class="form-group">
			<div class="form-row">
				
				<div class="col">
					
					<div class="row">
      					<h4>Foto</h4>
      				</div>
					<div class="row">
						

						<div class="col-10">	
							<div class="input-group mb-3">
								<div class="row">
									<div class="custom-file">
								    	<input type="file" class="custom-file-input form-control" name="foto" id="inputGroupFile02" onchange="readURL(this);">
								    	<label class="custom-file-label" for="inputGroupFile02"></label>
									</div>
								</div>
								<div class="row mt-2">
								  	<div style="width: 200px; height: 150px;" class="img-thumbnail form-control">
										<img id="blah" src="" alt="your image" hidden="true" style="width: 100%; height: 100%;"/>
									</div>
								</div>
							</div>
						</div>
					</div>
					@if($errors->any())
					    @foreach($errors->get('foto') as $error)
							<div class="badge badge-pill badge-danger">{{ $error }}</div>
					    @endforeach
					 @endif
			    
			   
				</div>

			    
		    </div>
		</div>

		<div class="form-group">
			<div class="form-row">
			    <div class="col-8">
					<div class="row">
						<div class="col-3">
							<label >Nombre</label>
						</div>
						<div class="col-9 pl-0">
						    <input id="nombre" name="nombre" class="form-control ml-0" type="text" placeholder="Nombre" value="{{ old('nombre') }}">
						    @if($errors->any())
							    @foreach($errors->get('nombre') as $error)
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
					<div class="row">
						<div class="col-3">
							<label >Sucursal</label>
						</div>
						<div class="col-9 pl-0">
						    <input id="sucursal" name="sucursal" class="form-control ml-0" type="text" placeholder="Sucursal" value="{{ old('sucursal') }}">
						    @if($errors->any())
							    @foreach($errors->get('sucursal') as $error)
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
					<div class="row">
						<div class="col-3">
							<label><p>Telefono </p></label>
						</div>
						<div class="col-9 pl-0">
						    <input id="telefono" name="telefono" class="form-control" type="text" placeholder="5555555" value="{{ old('telefono') }}">
						    @if($errors->any())
							    @foreach($errors->get('telefono') as $error)
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
					<div class="row">
						<div class="col-3">
							<label>Email </label>
						</div>
						<div class="col-9 pl-0">
						    <input id="email" name="email" class="form-control" type="text" placeholder="email@gmail.com" value="{{ old('email') }}">
						    @if($errors->any())
							@foreach($errors->get('email') as $error)
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
					<div class="row">
						<div class="col-3">
							 <label>Categoria:</label>
						</div>
						<div class="col-9 pl-0">
						    <select class="form-control custom-select" name="categoria">
						        <option value="0" disabled="true" selected="true">- Categoria -</option>
						        <option value="Pintura">Pintura</option>
				              	<option value="Metales">Metales</option>
				              	<option value="Insumos">Insumos</option>
				              	<option value="Tuberia">Tuberia</option>
				              	<option value="Mantenimiento">Mantenimiento</option>
				              	<option value="Maquinado">Maquinado</option>
				              	<option value="Renta de Elevadores">Renta de Elevadores</option>
				              	<option value="Renta de Maquinaria">Renta de Maquinaria</option>
				              	<option value="Otro">Otro</option>
						    </select>
						    @if($errors->any())
						    @foreach($errors->get('categoria') as $error)
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
				
				<div class="col">
					<div class="row ">
					    <div class="col-2">
						   
						</div>

						<div class="col-10 pl-0">
						   
						</div>
					</div>
					
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="form-row">
			    <div class="col-8">
					<label >notas : </label>
					<textarea class="form-control" aria-label="With textarea" placeholder="Notas"  name="notas" rows="7" value="{{ old('notas') }}"></textarea>
					@if($errors->any())
					    @foreach($errors->get('notas') as $error)
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
			        <h5 class="modal-title" id="exampleModalLabel">Agregar Proveedor</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	Estas seguro que Deseas Agregar esta Proveedor?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			        <button  type="submit" class="btn btn-outline-success" name="submitbtn" value="create" id="submitFinal"><span class="ion-checkmark-round">Agregar</span></button>
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
			        <h5 class="modal-title" id="exampleModalLabel">Cancelar</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	Estas seguro que Deseas Cancelar la Operacion?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
			        <a class="btn btn-outline-danger ion-close-round" href="{{URL('/proveedores/show')}}">Si, estoy seguro</a>
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
$('#inputGroupFile02').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        //getElementById('fileName').
    })

	function readURL(input) {
		$('#blah').attr("hidden",false);
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                        
                };

                reader.readAsDataURL(input.files[0]);
            }

        }
</script>


@endsection

