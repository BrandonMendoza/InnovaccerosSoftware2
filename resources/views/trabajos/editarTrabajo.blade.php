@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar Proyecto</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            	<li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
		      	<li class="breadcrumb-item"><a href="{{URL('/trabajos/show')}}">Proyectos</a></li>
		      	<li class="breadcrumb-item"><a href="{{url('/cotizaciones/'.$trabajo->id.'/cotizacionesProyecto')}}">{{ $trabajo->nombre_trabajo }}</a></li>
		      	<li class="breadcrumb-item">Editar Proyecto</li>
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

<form id="formCreate" method="POST" action="{{URL('/trabajo/'.$trabajo->id.'/actualizarTrabajo')}}" enctype="multipart/form-data" name="editarProyecto">
      {{csrf_field()}}
      <input type="text" name="fechaAlternativa" id="fechaAlternativa" hidden>
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
	                	<label for="nombre_trabajo">Nombre del Proyecto </label>
	                	<input type="text"  name="nombre_trabajo" id="nombre_trabajo" class="form-control" 
	                		value="{{ $trabajo->nombre_trabajo}}" >
	              	</div>
	              	<div class="form-group">
		                <label for="cliente">Cliente </label>
		                 <select class="form-control custom-select" id="cliente" name="id_cliente">
			                <option value="{{ $trabajo->cliente->id}}" selected="true">{{ $trabajo->cliente->nombre_cliente }}</option>
				          	@foreach($clientes as $cliente)
				            	<option value="{{ $cliente->id }}">{{$cliente->nombre_cliente }}</option>
				          	@endforeach
			          	</select>
		            </div>
		            <div class="row">
		            	<div class="col-sm-6">
		            		<label for="fecha_inicio">Inicio del Proyecto</label>
					        <input 	id="fecha_inicio" 
					        		name="fecha_inicio"
					        		value="{{  $trabajo->fecha_inicio}}">
		            	</div>
		            	<div class="col-sm-6">
		            		<label for="fecha_termino">Termino del Proyecto</label>
					        <input 	id="fecha_termino" 
					        		name="fecha_termino" 
					        		value="{{  $trabajo->fecha_inicio}}">
		            	</div>
		            </div>
	              	
	              	<div class="form-group" hidden>
	              		<label>Atencion a: </label>
					    <input type="text" class="form-control" name="atencion_a" id="atencion_a" >	
						<input type="text" class="form-control" name="telefono_atencion" id="telefono_atencion">	
	              	</div>
	            </div>
            <!-- /.card-body -->
	        </div>
	          <!-- /.card -->
	        <div class="card card-default">
            	<div class="card-header">
              		<h3 class="card-title">Descripción del Proyecto</h3>

              		<div class="card-tools">
                		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  		<i class="fas fa-minus"></i></button>
              		</div>
            	</div>
	            <div class="card-body">
	            	<div class="form-group">
						    <div class="col-12">
								<textarea 	class="form-control" 
											aria-label="With textarea" 
											placeholder="Descripcion"  
											name="descripcion_trabajo" 
											rows="10" 
											value="{{ old('descripcion') }}" disabled>{{$trabajo->descripcion_trabajo}}</textarea>
						    </div>
					</div>
	            </div>
            <!-- /.card-body -->
          	</div>
	    </div>
	    <div class="col-md-6">
	    	<div class="card card-default">
            	<div class="card-header">
              		<h3 class="card-title">Información para cotizaciones</h3>

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
			    			    <label for="dias_habiles">Tiempo de entrega(días) </label>
								<input 	type="number" 
										id="giro" 
										name="dias_habiles" 
										class="form-control no-spinners" 
										onkeypress="return isNumberKey(event)"
										value="{{ $trabajo->dias_habiles }}">
				            </div>
		                </div>
		                <div class="col-sm-6">
		                  	<div class="form-group">
			                	<label for="tiempo_pago">Tiempo de Pago(días)</label>
								<input 	type="number"
										id="tiempo_pago" 
										name="tiempo_pago" 
										class="form-control no-spinners" 
										value="{{ $trabajo->tiempo_pago }}"
										onkeypress="return isNumberKey(event)">
			            	</div>
		                </div>
		            </div>

	            	<div class="form-group">
	                	<label for="valides">Validez de las Cotizaciones</label>
	                	<textarea id="valides" name="valides" class="form-control" type="text" value="{{ $trabajo->valides }}">{{ $trabajo->valides }}</textarea>
	            	</div>
	            	<div class="form-group">
	                	<label for="orden_compra">Orden de Compra </label>
	                	<input type="text"  name="orden_compra" id="orden_compra" class="form-control" value="{{ $trabajo->orden_compra }}">
	              	</div>
	            </div>
            <!-- /.card-body -->
	        </div>
          <!-- /.card -->
        </div>
    </div>
	    <div class="row">
	        <div class="col-12">
				<a class="ion-close-round btn btn-flat btn-danger" href="{{route('trashow')}}">
	          		<i class="fas fa-window-close mr-2"></i>Cancelar
	        	</a>

	        	<button type="submit" value="create" class="btn btn-flat btn-success float-right mr-2">
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
		var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");


	    startTime();


	    $( "#formCreate" ).validate({
	    	//nombre cliente fecha_inicio fecha_termino
	    	//atencion_a telefono_atencion dias_habiles
	    	//tiempo_pago valides orden_compra
		  	rules: {
		    	nombre_trabajo: {
		      		required: true
		    	},
		    	id_cliente: {
		      		required: true, min: 1
		    	},
		    	fecha_inicio: {
		      		required: true
		    	}
		  	},
		  	messages: {
			    nombre_trabajo: 'ingresa un nombre',
			    id_cliente: 'selecciona un cliente',
			    fecha_inicio: 'ingresa el inicio del proyecto',
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
	    
	    function getFormattedDate(date) {
	      var year = date.getFullYear();
	      var month = (1 + date.getMonth()).toString();
	      month = month.length > 1 ? month : '0' + month;
	      var day = date.getDate().toString();
	      day = day.length > 1 ? day : '0' + day;
	      return month + '/' + day + '/' + year;
	    }

	    function startTime() {
	      var today = new Date();
	      var h = today.getHours();
	      var m = today.getMinutes();
	      var s = today.getSeconds();
	      m = checkTime(m);
	      s = checkTime(s);
	      //document.getElementById('txt').innerHTML =
	      //h + ":" + m + ":" + s;
	      //document.getElementById('inputTime').value =
	      //h + ":" + m + ":" + s;
	      
	      //$('#hora').val(h + ":" + m + ":" + s);
	      $('#fechaAlternativa').val(today.getDate() + " de " + meses[today.getMonth()] + " del " + today.getFullYear());

	      var t = setTimeout(startTime, 500);
	    }
	    function checkTime(i) {
	      if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
	        return i;
	    }


	var today;
   	today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#fecha_inicio').datepicker({
    	changeMonth: true,
      	changeYear: true,
        firstDay: 1,
		uiLibrary: 'bootstrap4'
    });
    $( function() {
    	$('#fecha_termino').datepicker({
    		changeMonth: true,
      		changeYear: true,
	        firstDay: 1,
			uiLibrary: 'bootstrap4'
	    });
	});

	function toUpper(str) {
		var lower = str.toLowerCase();
  		return lower.replace(/(^| )(\w)/g, function(x) {
    		return x.toUpperCase();
  		});
	 }


	function tipoSubmit(tipo){
		$("#tipoSubmit").val("salir");
	}

	$( "#guardarSalir" ).click(function() {
  		$('#guardarSalir').attr('name','tipoSubmit');
	});

	$( "#cotizar" ).click(function() {
  		$('#cotizar').attr('name','tipoSubmit');
	});

	$('#formCreate').submit(function() {
		var nombre = $('#nombre_trabajo').val();
		var descripcion = $('#descripcion_trabajo').val();
		
		
		$('#nombre_trabajo').val(toUpper(nombre));
 		$('#descripcion_trabajo').val(toUpper(descripcion));
 		
	});

	</script>


@endsection

