@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar Empleado</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
		      <li class="breadcrumb-item"><a href="{{URL('/empleados/show')}}">Empleados</a></li>
		      <li class="breadcrumb-item"><a href="{{URL('/empleado/'.$empleado->id.'/perfil')}}">Perfil Empleado</a></li>
		      <li class="breadcrumb-item">Editar Empleado</li>
            </ol>
          </div>
        </div>
      </div>
@stop
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

<form id="formCreate" method="POST" action="{{isset($empleado) ? URL('empleado/'.$empleado->id.'/actualizar') : '' }}" enctype="multipart/form-data">
      {{csrf_field()}}
      	<input type="text" value="{{ $empleado->id }}" hidden="true" name="id">
		<input type="text" value="{{ $empleado->clave }}" hidden="true" name="clave">
	      <div class="row">
	        <div class="col-md-6">
	          	<div class="card card-info">
	            	<div class="card-header">
	              		<h3 class="card-title">Información Personal</h3>

	              		<div class="card-tools">
	                		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                  			<i class="fas fa-minus"></i>
	              			</button>
	             		 </div>
	            	</div>
		            <div class="card-body" style="display: block;">

		              	<div class="form-group">
		                	<label for="nombre">Nombre </label>
		                	<input type="text" class="form-control" id="nombre" name="nombre" value="{{ $empleado->nombre }}">
		              	</div>

		              	<div class="form-group">
		              		<label>Apellidos </label>
			              	<div class="row">
				                <div class="col-sm-6">
				                	<div class="form-group">
										<input id="apellido1" name="apellido1" class="form-control" type="text" placeholder="Paterno"value="{{ $empleado->apellido1 }}">
					                </div>
				                </div>
				                <div class="col-sm-6">
				                  	<div class="form-group">
										<input id="apellido2" name="apellido2" class="form-control" type="text" placeholder="Materno"value="{{ $empleado->apellido2 }}">
								    </div>
				                </div>
				            </div>
			            </div>
			            <div class="form-group">
		              		
			              	<div class="row">
				                <div class="col-sm-6">
				                	<div class="form-group">
					                	<label for="nombre_cliente">Fecha de Nacimiento </label>
					                	<input type="date" class="form-control" id="fecha_nac" name="fecha_nac" value="{{ $empleado->fecha_nac }}"> 
					              	</div>
				                </div>
				                <div class="col-sm-6">
				                  	<div class="form-group">
					              		<label>Fecha de ingreso</label>
					              		<input type="date" class="form-control" id="fecha_entrada" name="fecha_entrada" value="{{ $empleado->fecha_entrada }}" >
					              	</div>
				                </div>
				            </div>
			            </div>
		            </div>
	            <!-- /.card-body -->
		        </div>
		          <!-- /.card -->

		        <div class="card card-info">
	            	<div class="card-header">
	              		<h3 class="card-title">Información Laboral</h3>

	              		<div class="card-tools">
	                		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                  		<i class="fas fa-minus"></i></button>
	              		</div>
	            	</div>
		            <div class="card-body">
		            	<div class="row">
			                <div class="col-sm-6">
			                	<div class="form-group">
					            	<label>Salario</label>
					            	<input type="number" id="salario" name="salario" class="form-control no-spinners" value="{{ $empleado->salario_semanal }}">
					            </div>	
			                </div>
			                <div class="col-sm-6">
			                  	<div class="form-group">
				              		<label>Puesto</label>
			              		<select class="custom-select" id="puesto" name="puesto" >
							        <option value="{{ $empleado->roles }}" selected="true">{{ $empleado->roles}}</option>
							        <option value="Soldador">Soldador</option>
					              	<option value="Ayudante">Ayudante</option>
					              	<option value="Cortador">Cortador</option>
					              	<option value="Armador">Armador</option>
					              	<option value="Oficina">Oficina</option>
							    </select>
				              	</div>
			                </div>
			            </div>
		            	<label hidden="true" id="tituloRoles">Roles</label>
						<fieldset hidden="true" id="rolesOficina">
							<select class="form-control custom-select" id="rol" name="rol" disabled>
						        <option value="0" disabled="true" selected="true">-Rol-</option>
					    	</select>
						</fieldset>

						<fieldset hidden="true" id="rolesSoldador">
							<div class="item">
							    <input type="checkbox" id="a" name="Tic">
							    <label for="a">Tic</label>

							    <input type="checkbox" id="a" name="maquina_de_rollo">
							    <label for="a">Maquina de Rollo</label>
							</div>

							<div class="item">
							    <input type="checkbox" id="c" name="maquina_de_varilla">
							    <label for="c">Maquina de Varilla</label>
							</div>
						</fieldset>
		            </div>
	            <!-- /.card-body -->
	          	</div>
		    </div>
		    <div class="col-md-6">
		    	<div class="card card-info">
	            	<div class="card-header">
	              		<h3 class="card-title">Contacto</h3>

	              		<div class="card-tools">
	                		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                  			<i class="fas fa-minus"></i>
	              			</button>
	             		 </div>
	            	</div>
		            <div class="card-body" style="display: block;">
		            	<div class="row">
			                <div class="col-sm-6">
			                	<div class="form-group">
				              		<label>Tel. de casa</label>
				              		
				              		<div class="input-group">
				                		<input type="text" class="form-control" id="telefono" name="telefono1" value="{{ $empleado->telefono1}}">	
					                    <div class="input-group-prepend">
					                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
					                    </div>
				                  	</div>
				              	</div>
			                </div>
			                <div class="col-sm-6">
			                  	<div class="form-group">
				              		<label>Celular</label>
				              		<div class="input-group">
				                		<input type="text" class="form-control" id="telefono2" name="telefono2" value="{{ $empleado->telefono2 }}">	
					                    <div class="input-group-prepend">
					                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
					                    </div>
				                  	</div>
				              	</div>
			                </div>
			            </div>
		              	
		              	
		              	<div class="form-group">
		              		<label>Email</label>
		              		<input type="text" class="form-control"  id="email" name="email" value="{{ $empleado->email }}">
		              	</div>
		              	<div class="form-group">
		              		<label>Dirección</label>
		              		<input type="text" class="form-control" id="direccion" name="direccion" value="{{ $empleado->direccion }}" >
		              	</div>
		            	
		            </div>
	            <!-- /.card-body -->
		        </div>

		        <div class="card card-secondary">
	            	<div class="card-header">
	              		<h3 class="card-title">Documentación</h3>

	              		<div class="card-tools">
	                		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                  			<i class="fas fa-minus"></i>
	              			</button>
	             		 </div>
	            	</div>
		            <div class="card-body" style="display: block;">
		              	
		              	<div class="form-group">
		              		<label>Num. IMSS</label>
		              		 <input type="number" class="form-control no-spinners" id="imss" name="imss" value="{{ $empleado->num_imss }}">
		              	</div>
		              	<div class="form-group">
		              		<label>RFC</label>
		              		 <input type="number" class="form-control no-spinners" id="rfc" name="rfc" value="{{ $empleado->rfc }}">
		              	</div>
		              	<div class="form-group">
		              		<label>Curp</label>
		              		<input type="text" class="form-control no-spinners" id="curp" name="curp" value="{{ $empleado->curp }}">
		              	</div>

		              	<div hidden class="form-group">
		              		<label>Copia de INE</label>
							<div class="input-group">
							  <div class="custom-file ">
							    <input type="file" class="custom-file-input" name="identificacion" id="identificacion">
							    <label class="custom-file-label pl-0" for="identificacion"></label>
							  </div>
							</div>
		              	</div>

		              	<div class="form-group" hidden>
		              		<label>Subir Documentos</label>
		              		<div>
					        	<input type="text" id="counter" name="counter_documentos" hidden value="0">
					        </div>
			      			<div class="table-responsive">
				    			<table class="table table-hover table-bordered" id="tabla" >
				    				<thead>
				    					<tr>
											<th style="width: 15%;">Nombre del Archivo</th>
											<th style="width: 15%;"><div class="btn-group" role="group" aria-label="Basic example">
											  <button type="button" class="btn btn-outline-success" id="addRow"><span class="ion-plus mr-1"></span></button>
											  <button type="button" class="btn btn-outline-danger" id="removeRow"><span class="ion-trash-a mr-1"></span></button>
											</div>	
											</th>
				    					</tr>
				    				</thead>

				    				<tbody>
												
				    				</tbody>
				    			</table>
				    		</div>
		              	</div>
		            </div>
	            <!-- /.card-body -->
		        </div>
		        <div class="card card-secondary">
	            	<div class="card-header">
	              		<h3 class="card-title">Foto (opcional)</h3>

	              		<div class="card-tools">
	                		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                  		<i class="fas fa-minus"></i></button>
	              		</div>
	            	</div>
		            <div class="card-body">
		            	<div class="form-group">
		                	<div class="input-group mb-3">
							  	<div class="custom-file">
							    	<input type="file" class="custom-file-input" name="foto" id="inputGroupFile02" onchange="readURL(this);">
							    	<label class="custom-file-label" for="inputGroupFile02"></label>
							  	</div>
							</div>
							<div style="width: 200px; height: 150px;" class="img-thumbnail">
								<img id="blah" src="{{ asset('uploads/DocEmpleados/'.$empleado->clave.'/'.$empleado->foto) }}" alt="your image" style="width: 100%; height: 100%;"/>
							</div>
		              	</div>
		            </div>
	            <!-- /.card-body -->
	          	</div>
				
	          <!-- /.card -->
	        </div>


	      </div>
	      <div class="row">
	        <div class="col-12">
				<a class="ion-close-round btn btn-flat btn-danger"  href="{{URL('/empleado/'.$empleado->id.'/perfil')}}">
	          		<i class="fas fa-window-close mr-2"></i>Cancelar
	        	</a>
			    <button type="submit" value="create" class="btn btn-flat btn-success float-right" data-toggle="modal" data-target="#exampleModal">
	          		<i class="fas fa-check-square mr-2"></i>Guardar
	        	</button>
	        </div>
	    </div>
	</form>
	
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script>
	$( "#formCreate" ).validate({
	  	rules: {
	    	nombre: {
	      		required: true
	    	},
	    	apellido1: {
	      		required: true
	    	},
	    	apellido2: {
	      		required: true
	    	},
	    	fecha_nac: {
	      		required: true
	    	},
	    	fecha_entrada: {
	      		required: true
	    	},
	    	salario: {
	      		required: true
	    	},
	    	puesto: {
	      		required: true
	    	},
	    	direccion: {
	      		required: true
	    	},
	    	imss: {
	    		number: true
			},
	  	},
	  	messages: {
		    nombre: 'ingresa nombre',
		    apellido1: 'ingresa apellido paterno',
		    apellido2: 'ingresa apellido materno',
		    fecha_nac: 'ingresa fecha de nacimiento',
		    fecha_entrada: 'ingresa fecha de entrada',
		    salario: 'ingresa un salario',
		    puesto: 'selecciona un puesto',
		    direccion: 'ingresa una direccion',
		    imss: 'ingresa solo numeros'
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

    $('#identificacion').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        //getElementById('fileName').
    })

    $('#imss').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        //getElementById('fileName').
    })

    $('#acta').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        //getElementById('fileName').
    })

    $('#comprobante').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        //getElementById('fileName').
    })

    $('#rfc').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        //getElementById('fileName').
    })

    $('#curp').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        //getElementById('fileName').
    })

    $('#antecedentes').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
        //getElementById('fileName').
    })

    let today = new Date().toISOString().substr(0, 10);
	document.querySelector("#fecha_entrada").value = today;
</script>


@endsection