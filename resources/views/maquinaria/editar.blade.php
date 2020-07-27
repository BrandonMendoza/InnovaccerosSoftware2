@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar Maquinaria y Vehículos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
		      <li class="breadcrumb-item"><a href="{{URL('/maquinaria/show')}}">Maquinarias y vehiculos</a></li>
		      <li class="breadcrumb-item">Editar Maquinaria y Vehículos</li>
            </ol>
          </div>
        </div>
      </div>
@stop

@section('content')
	
	<form id="formCreate" method="POST" action="{{isset($maquinaria) ? URL('maquinaria/'.$maquinaria->id.'/actualizar') : '' }}" enctype="multipart/form-data" name="agregarMaquinaria">
      {{csrf_field()}}
      <div class="row">
        <div class="col-md-6">
          	<div class="card card-info">
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
	                	<label for="">Clave </label>
	                	<label id="clave" type="text">{{ isset($maquinaria) ? $maquinaria->clave : '' }}</label>
	              	</div>
	              	<div class="form-group">
		              	<div class="row">
			                <div class="col-sm-6">
			                	<div class="form-group">
				    			    <label for="">Categoría </label>
									<select class="form-control custom-select" id="categorias" name="categorias"  onchange="populate(this.id,'tipos')">
								    	@if($maquinaria->categoria=='VEHICULO')
								    		<option value="VEHICULO" selected="true">Vehiculo</option>
								    		<option value="MAQUINARIA">Maquinaria</option>
								    	@elseif($maquinaria->categoria=='MAQUINARIA')
				                      		<option value="MAQUINARIA" selected="true">Maquinaria</option>
				                      		<option value="VEHICULO">Vehiculo</option>
				                      	@endif
								    </select>
					            </div>
			                </div>
			                <div class="col-sm-6">
			                  	<div class="form-group">
				                	<label for="">Tipo</label>
				                	
				                	<select class="form-control custom-select" id="tipos" name="tipos">
								        <option value="0" disabled="true" selected="true">-Select-</option>
								        @if($maquinaria->categoria=='VEHICULO')
								    		<option value="{{$maquinaria->tipo}}" selected="true">{{$maquinaria->tipo}}</option>
								    		<option value="AUTOMOVIL">AUTOMOVIL</option>
								    		<option value="PICKUP">Pickup</option>
								    		<option value="MONTACARGAS">Montacargas</option>
								    		<option value="GRUA MECANICA">Grua mecanica</option>
								    		<option value="Grua normal">Grua normal</option>
								    		<option value="TROQUE">Troque</option>
								    	@elseif($maquinaria->categoria=='MAQUINARIA')
				                      		<option value="{{$maquinaria->tipo}}" selected="true">{{$maquinaria->tipo}}</option>
				                      		<option value="PLASMA">Plasma</option>
				                      		<option value="SOLDAR">Soldar</option>
				                      		<option value="ARCOAIR">Arcoair</option>
				                      	@endif
								    </select>
				            	</div>
			                </div>
			            </div>
		            </div>
	              	
	              	<div class="form-group">
		              	<div class="row">
			                <div class="col-sm-6">
			                	<div class="form-group">
				            		<label>Marca</label>
				            		<input id="marca" name="marca" class="form-control" type="text" value="{{ $maquinaria->marca }}">
				            	</div>
			                </div>
			                <div class="col-sm-6">
			                  	<div class="form-group">
				            		<label>Modelo</label>
				            		<input id="modelo" name="modelo" class="form-control" type="text" value="{{ $maquinaria->modelo }}">
				            	</div>
			                </div>
			            </div>
		            </div>

	            	<div class="form-group">
	            		<label>Color</label>
	            		<select class="form-control custom-select" id="color" name="color">
					        <option value="{{$maquinaria->color}}" selected="true">{{$maquinaria->color}}</option>
					        <option value="ROJO">Rojo</option>
	                      	<option value="VERDE">Verde</option>
	                      	<option value="GRIS">Gris</option>
	                      	<option value="BLANCO">Blanco</option>
	                      	<option value="AZUL">Azul</option>
	                      	<option value="VERDE">Verde</option>
					    </select>
	            	</div>

	            	<div class="form-group">
		              	<div class="row">
			                <div class="col-sm-6">
			                	<div class="form-group">
				            		<label>Fecha del Ultimo servicio</label>
				            		<input id="ultimoServicio" name="ultimoServicio" value="{{ $maquinaria->ultimo_serv }}"/>
				            	</div>
			                </div>
			                <div class="col-sm-6">
			                  	<div class="form-group">
				            		<label>Alerta de servicio(días)</label>
				            		<input id="alerta" name="alerta" class="form-control" type="number" min=0 value="{{ $maquinaria->alerta }}">
				            	</div>
			                </div>
			            </div>
		            </div>
	            </div>
            <!-- /.card-body -->
	        </div>
	          <!-- /.card -->
	          
	    </div>
	    <div class="col-md-6">
	    	<div class="card card-secondary">
            	<div class="card-header">
              		<h3 class="card-title">Foto</h3>

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


      	</div>
	    <div class="row">
	        <div class="col-12">
				<a class="ion-close-round btn btn-flat btn-danger" href="{{route('maqshow')}}">
	          		<i class="fas fa-window-close mr-2"></i>Cancelar
	        	</a>
			    <button type="submit" value="create" class="btn btn-flat btn-success float-right" data-toggle="modal" data-target="#exampleModal">
	          		<i class="fas fa-check-square mr-2"></i>Guardar
	        	</button>
	        </div>
	    </div>
	</form>



	
@stop

@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script>
	$( "#formCreate" ).validate({
	  	rules: {
	    	clave: {
	      		required: true
	    	},
	    	categorias: {
	      		required: true
	    	},
	    	tipos: {
	      		required: true
	    	},
	    	marca: {
	      		required: true
	    	},
	    	modelo: {
	      		required: true
	    	},
	    	color: {
	      		required: true
	    	},
	    	ultimoServicio: {
	      		required: true
	    	},
	    	alerta: {
	      		required: true,
	      		number: true
	    	}
	  	},
	  	messages: {
		    clave: 'ingresa una clave',
		    categorias: 'selecciona una categoría',
		    tipos: 'selecciona un tipo',
		    marca: 'ingresa una marca',
		    modelo: 'ingresa un modelo',
		    color: 'ingresa un color',
		    ultimoServicio: 'ingresa una cantidad de días',
		    alerta: 'ingresa una cantidad de días'
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

	function populate(s1,s2){
		var cat = document.getElementById(s1);
		var tipos = document.getElementById(s2);
		tipos.innerHTML = "";
		if(cat.value == "MAQUINARIA"){
			var optionArray = ["0|-Selecciona tipo-","PLASMA|Plasma","SOLDAR|Soldar","ARCOAIR|Arcoair"];
		} else {
			if(cat.value == "VEHICULO"){
				var optionArray = ["0|-Selecciona tipo-","AUTOMOVIL|Automovil","PICKUP|Pickup","MONTACARGAS|Montacargas","ELEVADOR|Elevador","GRUA MECANICA|Grua mecanica","GRUA NORMAL | Grua normal","TROQUE|Troque"];
			}
		}
		for(var option in optionArray){
			var pair = optionArray[option].split("|");
			var newOption = document.createElement("option");
			newOption.value = pair[0];
			newOption.innerHTML = pair[1];
			tipos.options.add(newOption);
		}
	}



	var today, datepicker;
   	today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#ultimoServicio').datepicker({

    	dateFormat: "dd-mm-yy",
        firstDay: 1,
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        monthNames: 
            ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthNamesShort: 
            ["Ene", "Feb", "Mar", "Abr", "May", "Jun",
            "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
		uiLibrary: 'bootstrap4',
		maxDate: today
    });
  //$.datepicker.setDefaults($.datepicker.regional['es']);
</script>
@stop