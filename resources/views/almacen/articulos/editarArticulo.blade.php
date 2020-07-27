@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar Articulo</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
	          	<li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
		        <li class="breadcrumb-item"><a href="{{URL('/almacen/show')}}">Almacen</a></li>
		        <li class="breadcrumb-item"><a href="{{route('artshow')}}">Articulos</a></li>
		        <li class="breadcrumb-item"><a href="{{URL('/articulo/'.$articulo->id.'/perfilArticulo')}}">Perfil de Articulo</a></li>
		        <li class="breadcrumb-item">Editar Articulo</li>
            </ol>
          </div>
        </div>
      </div>
@stop

@section('content')

<form id="formCreate" method="POST" action="{{URL('articulo/'.$articulo->id.'/actualizar')}}" enctype="multipart/form-data" name="modificarArticulo">
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
	                	<label for="numero_parte">Numero de parte </label>
	                	<input type="text" id="numero_parte" class="form-control" name="numero_parte" value="{{$articulo->numero_parte}}">
	              	</div>
	              	<div class="form-group">
	    			    <label for="descripcion">Descripcion: </label>
						<input id="descripcion" name="descripcion" class="form-control" type="text" value="{{$articulo->descripcion}}">
		            </div>
	              	<div class="form-group">
	                	<label for="marca">Marca</label>
	                	<input type="text" id="marca" class="form-control" name="marca" class="form-control" value="{{$articulo->marca}}">
	            	</div>
	            
					<div class="form-group">
		                <label for="categoria">Categoria </label>
		                <select class="form-control custom-select" id="categoria" name="categoria" onchange="populate(this.id,'tipos')">
					        <option selected="true" value="{{$articulo->categoria}}">{{$articulo->categoria}}</option>
					        <option value="Tanque">Tanque</option>
			              	<option value="Lentes">Lentes</option>
			              	<option value="Marcador">Marcador</option>
			              	<option value="Disco">Disco</option>
			              	<option value="Proteccion Facial">Proteccion Facial</option>
			              	<option value="Guantes">Guantes</option>
			              	<option value="Proteccion Corporal">Proteccion Corporal</option>
			              	<option value="Soldadura">Soldadura</option>
			              	<option value="Otros">Otros</option>
					    </select>
		            </div>

		            <div class="form-group">
	    			    <label for="tipos">Tipo </label>
						<select class="form-control custom-select" id="tipos" name="tipos">
					        <option selected="true" value="{{$articulo->tipo}}">{{$articulo->tipo}}</option>
					    </select>
		            </div>
		            

		            <div class="form-group"> <!-- Date input -->
					    <label>Unidad de Medida</label>
						<select class="form-control custom-select" id="unidad_medida" name="unidad_medida">
					        <option selected="true" value="{{$articulo->unidad_medida}}">{{$articulo->unidad_medida}}</option>
					        <option value="KILOS">Kilos</option>
			              	<option value="CAJA">Cajas</option>
			              	<option value="UNIDAD">Unidades</option>
			              	<option value="LITROS">Litros</option>
					    </select>
			      	</div>
			      	<div class="row">
		                <div class="col-sm-6">
		                	<div class="form-group">
								<label >Existencia </label>
								<input 	type="number"
									onchange="validarExistencia();" 
									min="0" 
									id="existencia" 
									name="existencia" 
									class="form-control"
									value="{{$articulo->existencia}}"
									placeholder="Existencia" >
			                </div>
		                </div>
		                <div class="col-sm-6">
		                  	<div class="form-group">
							    <label>Existencia minima: </label>
								<input 	type="number" 
										onchange="validarExistencia();" 
										id="minimo" 
										min="0" 
										name="minimo"
										value="{{$articulo->minimo}}"
										class="form-control"
										placeholder="Existencia minima" >
						    </div>
		                </div>
		            </div>
	            </div>
            <!-- /.card-body -->
	        </div>
	          <!-- /.card -->
	    </div>


      </div>
      <div class="row">
        <div class="col-6">
			<a class="ion-close-round btn btn-flat btn-danger" href="{{route('artshow')}}">
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
	    	numero_parte: {
	      		required: true
	    	},
	    	descripcion: {
	      		required: true
	    	},
	    	marca: {
	      		required: true
	    	},
	    	categoria: {
	      		required: true
	    	},
	    	tipos: {
	      		required: true
	    	},
	    	unidad_medida: {
	      		required: true
	    	},
	    	existencia: {
	      		required: true
	    	},
	    	minimo: {
	      		required: true
	    	}
	  	},
	  	messages: {
		    numero_parte: 'ingresa un numero de parte',
		    descripcion: 'ingresa una descripcion',
		    marca: 'ingresa una marca',
		    categoria: 'selecciona una categoria',
		    tipos: 'selecciona un tipo',
		    unidad_medida: 'selecciona unidad de medida',
		    existencia: 'ingresa la existencia',
		    minimo: 'ingresa el minimo de existencia'
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
 	
 	
	function populate(s1,s2){
		var cat = document.getElementById(s1);
		var tipos = document.getElementById(s2);

		tipos.innerHTML = "";
		if(cat.value == "TANQUE"){
			var optionArray = ["0|-Selecciona tipo-","GAS|Gas","OXIGENO|Oxigeno","OTRO|Otro"];
		} else {
			if(cat.value == "LENTES"){
				var optionArray = ["0|-Selecciona tipo-","NEGROS|Negros","BLANCOS|Blancos","OTRO|Otro"];
			}else {
				if(cat.value == "MARCADOR"){
					var optionArray = ["0|-Selecciona tipo-","GIS|Gis","PLUMON|Plumon","OTRO|Otro"];
				}else {
					if(cat.value == "DISCO"){
						var optionArray = ["0|-Selecciona tipo-","CORTE GRANDE|Corte Grande","CORTE CHICO|Corte Chico","DESBASTE GRANDE|Desbaste Grande","DESBASTE CHICO|Desbaste Chico","CARDA PLANA|Carda Plana","CARDA COPA|Carda Copa","MULTILIJA|Multilija","OTRO|Otro"];
					}else {
						if(cat.value == "PROTECCION FACIAL"){
							var optionArray = ["0|-Selecciona tipo-","CARETA DE SOLDADOR|Careta de Soldador","CARETA ANTIGAS|Careta Antigas","MASCARILLA|Mascarilla","OTRO|Otro"];
						}else {
							if(cat.value == "GUANTES"){
								var optionArray = ["0|-Selecciona tipo-","TELA VERDA|Tela Verde","DE SOLDADOR|De Soldador","OTRO|Otro"];
							}else {
								if(cat.value == "PROTECCION CORPORAL"){
									var optionArray = ["0|-Selecciona tipo-","TRAJE BLANCO|Traje Blanco","MANDIL|Mandil","OTRO|Otro"];
								}else {
									if(cat.value == "SOLDADURA"){
										var optionArray = ["0|-Selecciona tipo-","DE ROLLO|De Rollo","VARILLA|Varilla","OTRO|Otro"];
									}else {
										if(cat.value == "OTROS"){
											var optionArray = ["0|-Selecciona tipo-","MICAS|Micas","SILICON|Silicon","CINTA|Cinta","CONTAC|Contac","PEGAMENTO|Pegamento","TAPONES DE OIDOS|Tapones de Oidos","CARBONES|Carbones","NAVAJA|Navaja","FOCO|Foco","LIGA|Liga","BOQUILLA|Boquilla","OTRO|Otro"];
										}
									}
								}
							}
						}
					}
				}
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
</script>


@stop