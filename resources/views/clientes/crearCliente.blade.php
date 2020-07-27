@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Agregar Cliente</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
		      <li class="breadcrumb-item"><a href="{{URL('/clientes/show')}}">Clientes</a></li>
		      <li class="breadcrumb-item">Agregar Cliente</li>
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
<form id="formCreate" method="POST" action="{{URL('/cliente/insertar')}}" enctype="multipart/form-data" name="agregarCliente">
      {{csrf_field()}}
      <div class="row">
        <div class="col-md-6">
          	<div class="card card-default">
            	<div class="card-header">
              		<h3 class="card-title">General</h3>

              		<div class="card-tools">
                		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  			<i class="fas fa-minus"></i>
              			</button>
             		 </div>
            	</div>
	            <div class="card-body" style="display: block;">

	              	<div class="form-group">
	                	<label for="nombre_cliente">Nombre Comercial </label>
	                	<input type="text" id="nombre_cliente" class="form-control" name="nombre_cliente">
	              	</div>
	              	<div class="form-group">
	    			    <label for="giro">Giro </label>
						<input id="giro" name="giro" class="form-control" type="text">
		            </div>
	              	<div class="form-group">
	                	<label for="tel_oficinas">Telefono de Oficina</label>
	                	
	                	<div class="input-group">
	                		<input type="text"  id="tel_oficinas" name="tel_oficinas" class="form-control">
		                    <div class="input-group-prepend">
		                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
		                    </div>
	                  	</div>
	            	</div>
	            </div>
            <!-- /.card-body -->
	        </div>
	          <!-- /.card -->
	          <div class="card card-default">
            	<div class="card-header">
              		<h3 class="card-title">Logo(opcional)</h3>

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
						<img id="blah" class="img-fluid pad" src="" alt="Photo">
	              	</div>
	            </div>
            <!-- /.card-body -->
          	</div>
	    </div>
	    <div class="col-md-6">
	    	<div class="card card-default">
            	<div class="card-header">
              		<h3 class="card-title">Datos Fiscales</h3>

              		<div class="card-tools">
                		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  			<i class="fas fa-minus"></i>
              			</button>
             		 </div>
            	</div>
	            <div class="card-body" style="display: block;">

	            	<div class="form-group">
	    			    <label for="razon_social">Razón Social </label>
						<input id="razon_social" name="razon_social" class="form-control" type="text">
		            </div>
	              	<div class="form-group">
	                	<label for="rfc">RFC </label>
	                	<input type="text" id="rfc" class="form-control" name="rfc">
	              	</div>
	              	<div class="form-group">
	                	<label for="direccion">Dirección</label>
	                	<input type="text" id="direccion" class="form-control" name="direccion" class="form-control">
	            	</div>
	            	<div class="form-group">
	                	<label for="codigo_postal">Codigo Postal</label>
	                	<input type="text" id="codigo_postal" class="form-control" name="codigo_postal" class="form-control">
	            	</div>
	            </div>
            <!-- /.card-body -->
	        </div>
			
          <!-- /.card -->
        </div>


      </div>
      <div class="row">
        <div class="col-12">
			<a class="ion-close-round btn btn-flat btn-danger" href="{{route('clishow')}}">
          		<i class="fas fa-window-close mr-2"></i>Cancelar
        	</a>
		    <button type="submit" value="create" class="btn btn-flat btn-success float-right" data-toggle="modal" data-target="#exampleModal">
          		<i class="fas fa-check-square mr-2"></i>Agregar
        	</button>
        </div>
    </div>
</form>



	
@stop

@section('scripts')
<script>
	//
	$( "#formCreate" ).validate({
	  	rules: {
	    	nombre_cliente: {
	      		required: true
	    	},
	    	giro: {
	      		required: true
	    	},
	    	tel_oficinas: {
	      		required: true,
	      		number: true
	    	},
	    	razon_social: {
	      		required: true
	    	},
	    	rfc: {
	      		required: true
	    	},
	    	direccion: {
	      		required: true
	    	},
	    	codigo_postal: {
	      		required: true,
	      		number: true,
	      		maxlength: 6
	    	}
	  	},
	  	messages: {
		    nombre_cliente: 'ingresa nombre comercial',
		    giro: 'ingresa un giro',
		    tel_oficinas: 'ingresa un numero de telefono',
		    razon_social: 'ingresa la razon social',
		    rfc: 'ingresa un rfc',
		    direccion: 'ingresa una direccion',
		    codigo_postal: 'ingresa un codigo postal'
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
                    $('#blah').attr('src', e.target.result);
                        
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

@stop

