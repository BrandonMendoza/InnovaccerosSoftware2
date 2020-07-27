@extends('layouts.app')

@section('content')

	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{URL('/almacen/show')}}">Almacen</a></li>
        <li class="breadcrumb-item"><a href="{{URL('/articulos/show')}}">Articulos de Almacen</a></li>
        <li class="breadcrumb-item">Crear Articulo</li>
      </ol>
    </nav>
    <h3 class="jumbotron-heading">Crear Articulo</h3>	

	<form id="formCreate" method="POST" action="{{URL('/material/actualizar')}}" enctype="multipart/form-data">
		<div class="row">
			<div class="col-3">
				
			</div>
			<div class="col-6">


				<input type="text" hidden name="clave" value="{{$material->clave}}">
				<input type="text" hidden name="id" value="{{$material->id}}">
				

		{{csrf_field()}}
		<div class="form-group">
			<div class="form-row">
				<div class="col">
					<div class="row">
						<div class="col-4">
							<label >Foto: </label>
						</div>
						<div class="col-10">
							<div class="input-group mb-3">
							  <div class="custom-file">
							    <input type="file" class="custom-file-input" name="foto" id="inputGroupFile02" onchange="readURL(this);">
							    <label class="custom-file-label" for="inputGroupFile02"></label>
							  </div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div style="width: 200px; height: 150px;" class="img-thumbnail">
									<img id="blah" src="" alt="your image" hidden="true" style="width: 100%; height: 100%;"/>
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
				<div class="col">
				    <div class="row mt-2">
				    	
						<div class="col-2">
							<label >Tipo: </label>
						</div>
						<div class="col-10">
							<select class="form-control custom-select" id="tipo" name="tipo">
						        <option value="{{$material->tipo}}" selected="true">{{$material->tipo}}</option>
						        <option value="Placa">Placa</option>
				              	<option value="Tubo">Tubo</option>
				              	<option value="Lamina">Lamina</option>
				              	<option value="Angulo">Tubular</option>
				              	<option value="Viga">Viga</option>
				              	<option value="Tubo">Tubo</option>
				              	<option value="Redondo">Redondo</option>
				              	<option value="Ptr">Ptr</option>
				              	<option value="Canal">Canal</option>
				              	<option value="Otro">Otro</option>
						    </select>
						</div>
						@if($errors->any())
							@foreach($errors->get('tipo') as $error)
								<div class="badge badge-pill badge-danger">{{ $error }}</div>
							@endforeach
						@endif
				    </div>
				    
					<div class="row mt-2">
						<div class="col-2">
						    <label>Descripcion: </label>
						</div>
						<div class="col-10">
							<input id="descripcion" name="descripcion" class="form-control" type="text" placeholder="Descripcion" value="{{$material->descripcion}}">
						</div>
					    @if($errors->any())
						    @foreach($errors->get('descripcion') as $error)
								<div class="badge badge-pill badge-danger">{{ $error }}</div>
						    @endforeach
						@endif
					</div>

					<div class="row mt-2">
						<div class="col-2">
						    <label>Medidas: </label>
						</div>
						<div class="col-10">
							<input id="medidas" name="medidas" class="form-control" type="text" placeholder="4x4X4" value="{{$material->medidas}}">
						</div>
					    @if($errors->any())
						    @foreach($errors->get('descripcion') as $error)
								<div class="badge badge-pill badge-danger">{{ $error }}</div>
						    @endforeach
						@endif
					</div>
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
			        <h5 class="modal-title" id="exampleModalLabel">Agregar Material</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	Estas seguro que Deseas Agregar este Material?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			        <button  type="submit" class="btn btn-outline-success" name="submitbtn" value="create" id="submitFinal"><span class="ion-checkmark-round">Agregar Material</span></button>
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
			        <h5 class="modal-title" id="exampleModalLabel">Agregar Material</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	Estas seguro que Deseas Cancelar la Operacion?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
			        <a class="btn btn-outline-danger ion-close-round" href="{{route('artshow')}}">Si, estoy seguro</a>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</form>
	
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script>
	function validarExistencia(){
		var existencia = $('#existencia').val();
		var existenciaMinima = $('#minimo').val();

		//alert(existencia+' '+existenciaMinima);

		if(existencia == ''){
			existencia = 0;
			$('#existencia').val(existencia);
		}

		if(existenciaMinima == ''){
			existenciaMinima = 0;
			$('#minimo').val(existenciaMinima);
		}
	}

	function toUpper(str) {
		var lower = str.toLowerCase();
  		return lower.replace(/(^| )(\w)/g, function(x) {
    		return x.toUpperCase();
  		});
	 }

	$('#formCreate').submit(function() {
		$marca = $('#marca').val();
		$descripcion = $('#descripcion').val();
		

		$('#marca').val(toUpper($marca));
 		$('#descripcion').val(toUpper($descripcion));
	});
 	
 	
	
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

	$('#inputGroupFile02').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        //getElementById('fileName').
    })
</script>


@endsection