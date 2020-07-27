@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Crear Cotización</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            	<li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
		    	<li class="breadcrumb-item"><a href="{{URL('/trabajos/show')}}">Proyectos</a></li>
		    	<li class="breadcrumb-item"><a href="{{url('/cotizaciones/'.$save->id.'/cotizacionesProyecto')}}">Cotizaciones por Proyectos</a></li>
		      	<li class="breadcrumb-item">Crear Cotización</li>
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

/* Set height of body and the document to 100% to enable "full page tabs" */
body, html {
  height: 100%;
  margin: 0;
  font-family: Arial;
}

/* Style tab links */
.tablink {
  background-color: #555;
  float: left;
  color:white;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
  width: 25%;
}

.totales {
  background-color: #555;
  float: left;
  color:white;
  border: none;
  outline: none;
  padding: 14px 16px;
  font-size: 17px;
  width: 25%;
}

.filaTotales{
	background-color: #555;
  	color:white;
  	border: none;
  	outline: none;
  	padding: 14px 16px;
}

.totales2 {
  background-color: #555;
  float: left;
  color:white;
  border: none;
  outline: none;
  padding: 14px 16px;
  font-size: 17px;
}

.totales3 {
  background-color: #4CAF50;
  float: left;
  color:white;
  border: none;
  outline: none;
  padding: 14px 16px;
  font-size: 17px;
}

.tablink:hover {
  background-color: #777;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  
  display: none;
  padding: 100px 20px;
  height: 100%;

}

.active {
  background-color: #4CAF50;
  color: white;
}

</style>






<form id="formCreate" method="POST" action="{{route('insertarCotizacion')}}" enctype="multipart/form-data">
	<input type="text" value="{{ $save->id }}" name="id_proyecto" hidden>
	
	<div class="row mb-4">
		<div class="col-3">Crear Cotizacion:  {{ $save->nombre_trabajo }}</div>
		<div class="col"></div>
		<div class="col"></div>


		<div class="row"></div>
		<div class="col">
			<button type="submit" class="btn btn-outline-success"><span class="ion-checkmark-round mr-1"></span>Guardar Cotizacion</button>
		</div>
		<div class="col">
			<a class="btn btn-outline-danger" href="{{url('/cotizaciones/'.$save->id.'/cotizacionesProyecto')}}"><span class="ion-close-round mr-1"></span>Cancelar Cotizacion</a>
		</div>
		<div class="col"> <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalProveedores">Ver proveedores</button> </div>
		
	</div>

	<div class="row filaTotales">
		<div class="col">
			Subtotal <br>
			<label for="" id="subtotal_general_label">$ 000.00</label>
			<input type="text" hidden="true" name="subtotal_general" id="subtotal_general" value="0">
		</div>
		<div class="col">
			Ganancia<br> 
			<label for="" id="ganancia_general_label">$ 000.00</label>
			<input type="text" name="ganancia_general" id="ganancia_general" hidden value="0">
		</div>
		<div class="col">
			Total<br> 
			<label for="" id="total_general_label">$000.00</label>
			<input type="text" hidden="true" name="total_general" id="total_general" value="0">	
		</div>
		<div class="col">
			IVA (16%)<br> 
			<label id="iva_label">$ 000.00</label>
			<input type="text" id="iva" name="iva" value="000" hidden>
		</div>
				
		<div class="col">
			Total + Iva<br> 
			<label id="total_iva_label"> $ 000.00</label>
			<input type="text" id="total_iva" name="total_iva" value="000" hidden>	
		</div>	
	</div>



	
	
	{{csrf_field()}}

	



	<div id="myDIV" class="mt-4">
		<button type="button" class="tablink active" onclick="openPage('Home', this)" id="defaultOpen">Material <br><label for="" id="total_material_vista_general">$ 000.00</label></button>
		<button type="button" class="tablink" onclick="openPage('News', this)">Mano de Obra <br> <label for="" id="total_mano_obra_vista_general">$000.00</label></button>
		<button type="button" class="tablink" onclick="openPage('Contact', this)">Gastos Varios <br> <label for="" id="total_gastos_varios_vista_general">$ 000.00</label>
						<input type="text" hidden="true" name="gastos_varios_general" id="gastos_varios_general" value="0"></button>
		<button type="button" class="tablink" onclick="openPage('About', this)">Insumos <br><label for="" id="total_insumos_vista_general">$000.00</label></button> 	
	</div>
	

	<!-- MATERIALES              -->
	<!-- MATERIALES              -->
	<!-- MATERIALES              -->
	<!-- MATERIALES              -->

	<div id="Home" class="tabcontent border">
	  <div class="col"></div>

		<div class="col-12">
		

			<div class="row mb-3" >
			        <div class="col-8">
			    		<div class="btn-group" role="group" aria-label="Basic example">
						  <button type="button" class="btn btn-outline-success" id="addRow"><span class="ion-plus mr-1"></span>Agregar Material</button>
						  <button type="button" class="btn btn-outline-danger" id="removeRow"><span class="ion-trash-a mr-1"></span></button>
						</div>	
			        </div>
			        <div hidden>
				        <div class="col float-right totales3">
							<div class="font-weight-bold">
								Subtotal 
							</div>
							<label for="" id="subtotal_material_label">$ 000.00</label>
							<input type="text" name="subtotal_material" id="subtotal_material" hidden value="0">
						</div>

			    		<div class="col float-right totales3">
							<div class="font-weight-bold">
								Ganancia
							</div>
							<label for="" id="ganancia_material_label">$ 000.00</label>
							<input type="text" name="ganancia_material" id="ganancia_material" hidden value="0">
						</div>

			    		<div class="col float-right totales3">
							<div class="font-weight-bold">
								Total
							</div>
							<label for="" id="total_material_label">$ 000.00</label>
							<input type="text" name="total_material" id="total_material" hidden value="0">
						</div>
						
				        <div>
				        	<input type="text" id="counter" name="counter_material" hidden value="0">
				        </div>
			        </div>


		    </div>

	  

		
		


		
	    	<div class="col-md-12">
				<div class="table-responsive">
	    			<table class="table table-hover table-bordered" id="tabla" >
	    				<thead>
	    					<tr>
								<th style="width: 15%;">Uso</th>
								<th style="width: 15%;">Material</th>
								<th style="width: 5%;">Cantidad</th>
								<th style="width: 15%;">Costo Unitario</th>
								<th style="width: 15%;">Subtotal Costo</th>
								<th style="width: 5%;">Ganancia</th>
								<th style="width: 15%;">Total</th>
	    					</tr>
	    				</thead>

	    				<tbody>
									
	    				</tbody>
	    			</table>
	    		</div>
	    	</div>

	    	<div class="row mt-3 float-right">

				
				
	    	</div>
    	</div>



    	<div class="col"></div>
	</div>

	<!-- MATERIALES         FIN     -->
	<!-- MATERIALES         FIN     -->
	<!-- MATERIALES         FIN     -->
	<!-- MATERIALES         FIN     -->



	<!-- MANO DE OBRA              -->
	<!-- MANO DE OBRA              -->
	<!-- MANO DE OBRA              -->
	<!-- MANO DE OBRA              -->

	<div id="News" class="tabcontent border">
	  	<div class="col"></div>
    	
    	<div class="col-md-12">
    		<div class="row" hidden>
	    		<div class="col"></div>
	    		<div class="col"></div>
	    		<div class="col"></div>
	    		<div class="col"></div>
	    		<div class="col float-right totales3">
					<div class="font-weight-bold">
						Subtotal
					</div>
					<label for="" id="mano_obra_subtotal_label">$ 000.00</label>
					<input type="text" name="mano_obra_subtotal" id="mano_obra_subtotal" value="0" hidden>
				</div>

							

	    		<div class="col float-right totales3">
					<div class="font-weight-bold">
						Total
					</div>
					<label for="" id="mano_obra_total_label">$ 000.00</label>
					<input type="text" name="mano_obra_total" id="mano_obra_total" hidden value="0">
				</div>
			</div>

    		<h3 class="jumbotron-heading"></h3>
			<div class="table-responsive">
    			<table class="table table-hover table-bordered">
    				<thead>
    					
    				</thead>

    				<tbody>
						<tr >
							<th style="width: 10%;"></th>
							<th style="width: 5%;">Cantidad</th>
							<th style="width: 10%;">Hrs</th>
							<th style="width: 15%;">Costo p/ Hr</th>
							<th style="width: 15%;">Sub Total</th>
							<th style="width: 10%;">Total</th>
    					</tr>
						<tr class=" form-control-sm">
							<td>
								<label for="">Operador</label>
							</td>
							<td>
								<input class="form-control  form-control-sm" type="number" onkeypress="return isNumberKey(event)" step="1" value="0" min="0" id="operador_cantidad" name="operador_cantidad" onchange="calcularSubtotalMOOP();">
							</td>
							<td>
								<input class="form-control  form-control-sm" type="number" onkeypress="return isNumberKey(event)" step="1" value="0" min="0" id="operador_hrs" name="operador_hrs" onchange="calcularSubtotalMOOP();">
							</td>
							<td>
								<!--<label for="">$ 180.00</label> -->
								<input class="form-control" type="text" value="180" id="operador_costo_hr" name="operador_costo_hr" onkeypress="return isNumberKey(event)" onchange="calcularSubtotalMOOP();" step="1" min="0">
							</td>
							<td>
								<label id="operador_subtotal_label">$ 000.00</label><input type="text" hidden="true" id="operador_subtotal" name="operador_subtotal" value="0">
							</td>
							
							<td>
								<label id="operador_total_label">$ 000.00</label><input type="text" hidden="true" id="operador_total" name="operador_total" value="0">
							</td>
						</tr>
						<tr class=" form-control-sm">
							<td>
								<label for="">Tecnico</label>
							</td>
							<td>
								<input class="form-control  form-control-sm" type="number" onkeypress="return isNumberKey(event)" onchange="calcularSubtotalMOTE();" step="1" min="0" value="0" id="tecnico_cantidad" name="tecnico_cantidad">
							</td>
							<td>
								<input class="form-control  form-control-sm" type="number" onkeypress="return isNumberKey(event)" onchange="calcularSubtotalMOTE();" step="1" min="0" value="0" id="tecnico_hrs" name="tecnico_hrs">
							</td>
							<td>
								 <!-- <label id="tecnico_costo_hr_label" for="">$ 200.00</label> -->
								<input class="form-control" type="text" id="tecnico_costo_hr" value="200" name="tecnico_costo_hr" onkeypress="return isNumberKey(event)" onchange="calcularSubtotalMOTE();" step="1" min="0">
							</td>
							<td>
								<label for="" id="tecnico_subtotal_label">$ 000.00</label>
								<input type="text" hidden="true" id="tecnico_subtotal" name="tecnico_subtotal" value="0">
							</td>
							
							<td>
								<label for="" id="tecnico_total_label">$ 000.00</label>
								<input type="text" id="tecnico_total" name="tecnico_total" hidden="true" value="0">
							</td>
						</tr>
						
						<style>
							.table-hover>tbody>.renglon:hover {
    							background-color: #ffffff; /* Assuming you want the hover color to be white */
							}
						</style>
    				</tbody>
    			</table>
    		</div>

			<div class="row float-right mt-3">

				
			
    		</div>

			
			
    	</div>
    	<div class="col"></div>
	</div>

	<!-- MANO DE OBRA         FIN     -->
	<!-- MANO DE OBRA         FIN     -->
	<!-- MANO DE OBRA         FIN     -->
	<!-- MANO DE OBRA         FIN     -->


	<!-- GASTOS VARIOS              -->
	<!-- GASTOS VARIOS              -->
	<!-- GASTOS VARIOS              -->
	<!-- GASTOS VARIOS              -->


	<div id="Contact" class="tabcontent border">
	  <div class="col"></div>
    	<div class="col-md-12">

    		
    		<div class="row" hidden>
    			<div class="col"></div>
    			<div class="col"></div>
    			<div class="col"></div>
    			<div class="col"></div>
    			<div class="col"></div>
    			<div class="col float-right totales3 mb-2">
					<div class="font-weight-bold">
						Total 	
					</div>
					<label for="" id="gastos_total_label">$ 000.00</label>
					<input type="text" name="gastos_total" id="gastos_total" hidden value="0">
				</div>
    		</div>

    		
    		
			<div class="table-responsive">
    			<table class="table table-hover table-bordered">
    				<thead>
    					
    				</thead>

    				<tbody>
						<tr >
							<th style="width: 15%;">Concepto</th>
							<th style="width: 5%;">Ganancia</th>
							<th style="width: 5%;">Total</th>
    					</tr>
						<tr class=" form-control-sm">
							<td>
								<label for="">Gastos Administrativos</label>
							</td>
							<td>
								<input 	class="form-control form-control-sm" 
										type="number" 
										onkeypress="return isNumberKey(event)" 
										onchange="calcularGastosVarios();" 
										step="1" 
										value="10" 
										name="gastos_admin_ganancia" 
										id="gastos_admin_ganancia">
							</td>
							<td>
								<label id="gastos_admin_total_label">$ 000.00</label>
								<input type="text" hidden="true" name="gastos_admin_total"  id="gastos_admin_total" value="0">
							</td>

						</tr>
						<tr class=" form-control-sm">
							<td>
								<label for="">Desgaste de Herramienta</label>
							</td>
							<td>
								<input 	class="form-control form-control-sm" 
										type="number" 
										onkeypress="return isNumberKeyDecimal(event)" 
										onchange="calcularGastosVarios();" 
										step="1" 
										value="10" 
										name="herramienta_ganancia" 
										id="herramienta_ganancia">
							</td>
							<td>
								<label id="herramienta_total_label">$ 000.00 </label>
								<input type="text" hidden="true" name="herramienta_total" id="herramienta_total" value="0">
							</td>
						</tr>
						<tr class=" form-control-sm">
							<td>
								<label for="">Mantenimiento a Vehiculos</label>
							</td>
							<td>
								<input 	class="form-control form-control-sm" 
										type="number" 
										onkeypress="return isNumberKeyDecimal(event)" 
										onchange="calcularGastosVarios();" 
										step="1" 
										value="10" 
										name="mantenimiento_ganancia" 
										id="mantenimiento_ganancia">
							</td>
							<td>
								<label id="mantenimiento_total_label">$ 000.00</label>
								<input type="text" name="mantenimiento_total" hidden="true" id="mantenimiento_total" value="0">
							</td>
						</tr>
						<tr class=" form-control-sm">
							<td>
								<label for="">Gastos de Seguridad</label>
							</td>
							<td>
								<input 	class="form-control form-control-sm" 
										onchange="calcularGastosVarios();" 
										onkeypress="return isNumberKeyDecimal(event)" 
										type="number" 
										step="1" 
										value="10" 
										id="seguridad_ganancia" 
										name="seguridad_ganancia">
							</td>
							<td>
								<label id="seguridad_total_label">$ 000.00</label>  
								<input type="text" name="seguridad_total" hidden="true" id="seguridad_total" value="0">
							</td>
						</tr>
						<style>
							.table-hover>tbody>.renglon:hover {
    							background-color: #ffffff; /* Assuming you want the hover color to be white */
							}
						</style>
    				</tbody>

    				
    			</table>
    		</div>

    		<div class="row float-right mt-3">

	    		
			
    		</div>

    		
    	</div>
    	<div class="col"></div>
	</div>

	<!-- GASTOS VARIOS         FIN     -->
	<!-- GASTOS VARIOS         FIN     -->
	<!-- GASTOS VARIOS         FIN     -->
	<!-- GASTOS VARIOS         FIN     -->


	<!-- INSUMOS              -->
	<!-- INSUMOS              -->
	<!-- INSUMOS              -->
	<!-- INSUMOS              -->

	<div id="About" class="tabcontent border">
	  <div class="col"></div>

    	<div class="col-md-12">

			<div class="row mb-3">
		        <div class="col-8">
		    		<div class="btn-group" role="group" aria-label="Basic example">
					  <button type="button" class="btn btn-outline-success" id="addRowInsumos"><span class="ion-plus mr-1"></span>Agregar Insumo</button>
					  <button type="button" class="btn btn-outline-danger" id="removeRowInsumos"><span class="ion-trash-a mr-1"></span></button>
					</div>	
		        </div>

		        
		        <div class="col">
		        	
		        	<div class="row float-right mt-3" hidden>

		    			<div class="col float-right totales3">
							<div class="font-weight-bold">
								Subtotal
							</div>
							<label for="" id="subtotal_insumos_general_label">$ 000.00</label>
							<input type="text" name="subtotal_insumos_general" id="subtotal_insumos_general" hidden value="0">
						</div>

		    			<div class="col float-right totales3">
							<div class="font-weight-bold">
								Ganancia
							</div>
							<label for="" id="ganancia_insumos_general_label">$ 000.00</label>
							<input type="text" name="ganancia_insumos_general" id="ganancia_insumos_general" hidden value="0">
						</div>

			    		<div class="col float-right totales3">
							<div class="row font-weight-bold">
								Total
							</div>
							<label for="" id="total_insumos_general_label">$ 000.00</label>
							<input type="text" name="total_insumos_general" id="total_insumos_general" hidden value="0">
						</div>
			
    				</div>
    				
		        	<input type="text" id="counterInsumos" name="counter_insumos" hidden value="0">
		        </div>

				
		        
		        	
	    	</div>


    		<h3 class="jumbotron-heading"></h3>
			<div class="table-responsive">
    			<table class="table table-hover table-bordered" id="tablaInsumos">
    				<thead >
    					<tr>
							<th style="width: 15%;">Nombre</th>
							<th style="width: 10%;">Costo</th>
							<th style="width: 15%;">Sub Total</th>
							<th style="width: 10%;">Ganancia</th>
							<th style="width: 5%;">Total</th>
    					</tr>
    				</thead>

    				<tbody>
    					<style>
							.table-hover>tbody>.renglon:hover {
    							background-color: #ffffff; /* Assuming you want the hover color to be white */
							}
						</style>
    				</tbody>
    			</table>
    		</div>
    		
    	</div>
    	<div class="col"></div>
	</div>


	<!-- INSUMOS         FIN     -->
	<!-- INSUMOS         FIN     -->
	<!-- INSUMOS         FIN     -->
	<!-- INSUMOS         FIN     -->

	<div class="modal fade bd-example-modal-lg" id="modalProveedores" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Proveedores</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
              <div class="row">
                <div class="col-5">
                  <div class="input-group mb-3">
                   
                  </div>
                </div>
              </div>
                <div class="card-deck deck-art">

                  @foreach($proveedores as $proveedor)
                    
                    <div class="col-6 carta-columna ">
                     
                        <div class="card">
                     
                        
                        <div class="row">
                          <div class="col-md-4">
                              <img src="{{ asset('uploads/DocProveedores/'.$proveedor->foto) }}" style="height: 100%; width: 100%;">
                          </div>
                          <div class="col col-md-8 px-3">
                            <div class="card-block px-3">
                              <p class="card-text jumbotron-heading"><span class="font-weight-bold">{{$proveedor->nombre}}</span><span class="text-muted">{{ ' - '.$proveedor->categoria }}</span></p>
                              <div class="card-text mt-0 pt-0">{{$proveedor->telefono}}</div>
                              <div class="card-text mt-0 pt-0 text-muted">{{$proveedor->sucursal}}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    @if($loop->last)
                        </div>
                    @endif
                    @if($loop->index % 2 == 0 and $loop->index == 1)
                        </div>
                      <div class="row">
                    @endif
                  
                  @endforeach
                  
              
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>



</form>

@stop

@section('scripts')
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script>
	var panel = 0;
	
	var totalMOOP = 0; //TOTAL MANO DE OBRE OPERADORES
	var subtotalMOOP = 0; //SUBTOTAL MANO DE OBRE OPERADORES
	

	var totalMOTE = 0; //TOTAL MANO DE TECNICOS
	var subtotalMOTE = 0; //SUBTOTAL MANO DE TECNICOS

	var subtotalMO_GENERAL = 0; // SUBTOTAL GENERAL MANO DE OBRA
	var totalMO_GENERAL = 0;

	var gananciaMA_GENERAL = 0; // GANANCIA GENERAL MATERIALES
	var subtotalMA_GENERAL = 0; // SUBTOTAL GENERAL MATERIALES
	var totalMA_GENERAL = 0; //TOTAL GENERAL MATERIALES

	var gananciaIN_GENERAL = 0; // GANANCIA GENERAL INSUMOS
	var subtotalIN_GENERAL = 0; // SUBTOTAL GENERAL INSUMOS
	var totalIN_GENERAL = 0; //TOTAL GENERAL INSUMOS


	var gastos_varios_general = 0; //GASTOS VARIOS GENERAL
	var ganancia_general = 0; // GANANCIA GENERAL DE COTIZACION
	var subtotal_general = 0; // SUBTOTAL GENERAL DE COTIZACION
	var subtotal_general_sin_gastos_varios = 0;
	var total_general = 0;    // TOTAL GENERAL DE COTIZACION

	//input:text.red
	calcularSubtotalMOTE();
	calcularSubtotalMOOP();
	calcularTotalIva();
	

	

	$(document).ready(function() {
    	var counter = 0;
    	var counterInsumos = 0;

    	/*$('.gananciaInput').on('keyup', function(e){
    		alert('hola');
		  var min=parseFloat($(this).attr('min'));
		  var curr=parseFloat($(this).val());
		  if (curr < min) { $(this).val(min); var changed=true; }
		  
		});
*/
    	var tablaInsumos = $('#tablaInsumos').DataTable({
    		"paging":   false,
        	"ordering": false,
        	"info":     false,
        	"searching": false
    	});

    	var table = $('#tabla').DataTable({
    		"paging":   false,
        	"ordering": false,
        	"info":     false,
        	"searching": false
    	});

    	

    	$('#addRow').on( 'click', function () {
	        table.row.add( [
	            '<textarea class="form-control" aria-label="With textarea" placeholder="Uso"  name="material_uso_'+counter+'"></textarea>',
	            '<textarea class="form-control" type="text" onchange="checkCostoNull(this.id,'+counter+')" id="material_nombre_'+counter+'" placeholder="Material" name="material_nombre_'+counter+'"></textarea>',
	            '<input class="form-control" type="number" placeholder="Cant" min="0" onkeypress="return isNumberKey(event)" name="material_cantidad_'+counter+'" id="material_cantidad_'+counter+'"  onchange="calcularTotalMaterial('+counter+');">',
	            '<input class="form-control no-spinners" type="number" step="any" onkeypress="return isNumberKeyDecimal(event)" placeholder="Costo Unitario" min="0" id="material_costounitario_'+counter+'" name="material_costounitario_'+counter+'" onchange="calcularTotalMaterial('+counter+');">',
	            '<label for="" id="material_subtotal_'+counter+'_label">$ 000.00</label><input class="form-control" value="0" type="text" name="material_subtotal_'+counter+'" id="material_subtotal_'+counter+'" hidden>',
	            '<input class="form-control gananciaInput" type="number" onkeypress="return isNumberKey(event)" min="0" max="99" step="1" value="10"  placeholder="Ganancia" id="material_ganancia_'+counter+'"  name="material_ganancia_'+counter+'" onchange="calcularTotalMaterial('+counter+');">',
	            '<label for="" name="material_total_'+counter+'_label" id="material_total_'+counter+'_label">$ 000.00</label><input class="form-control" type="text" value="0" name="material_total_'+counter+'" id="material_total_'+counter+'" hidden>'
	        ] ).draw( false );

	        
	        counter++;
	        $('#counter').val(counter);
	        
	    } );
		$('#tabla tbody').on( 'click', 'tr', function () {
	        if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	        }
	        else {
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
	    } );

	    $('#removeRow').click( function () {
	        table.row('.selected').remove().draw( false );

	        var counter = $('#counter').val();
	        var total_material;
	        var aux;
	        //alert('Counter '+counter);
	        totalMA_GENERAL = 0;
	        for (var i = 0; i < counter; i++) {
	        	total_material = $('#material_total_'+i).val();
	        	
	        	if (total_material != '' && typeof total_material !== 'undefined') {
	        		//alert('LOOP: '+i+', dato = '+total_material);
	    			totalMA_GENERAL += parseFloat(total_material);
				}
	        }

	        calcularTotalMaterial();
	        calcularGastosVarios();

	        //alert('Total general'+totalMA_GENERAL);
	        $('#total_material').val(totalMA_GENERAL);
	        $('#total_material_label').text('$ '+totalMA_GENERAL.toLocaleString());
		});



	    //TABLA INSUMOS
		$('#addRowInsumos').on( 'click', function () {
	        tablaInsumos.row.add( [
	        	'<input class="form-control" type="text" value="Nombre de Insumo" onchange="checkInsumos(this.id,'+counter+')" placeholder="insumo" id="insumo_nombre_'+counterInsumos+'" name="insumo_nombre_'+counterInsumos+'">',
				'<input type="number" placeholder="Costo" step="any" value="0" onkeypress="return isNumberKeyDecimal(event)"  class="form-control no-spinners form-control-sm" id="insumo_costo_'+counterInsumos+'" name="insumo_costo_'+counterInsumos+'" min="0" onchange="calcularInsumoTotal('+counterInsumos+');">',
				'<label for="" id="insumo_subtotal_'+counterInsumos+'_label">$ 000.00</label><input type="text" id="insumo_subtotal_'+counterInsumos+'" name="insumo_subtotal_'+counterInsumos+'" value="0" hidden="true">',
				'<input class="form-control  form-control-sm" min="0" onkeypress="return isNumberKey(event)" type="text" step="1" value="10" id="insumo_ganancia_'+counterInsumos+'" name="insumo_ganancia_'+counterInsumos+'" onchange="calcularInsumoTotal('+counterInsumos+');">',
				'<label for=""  id="insumo_total_'+counterInsumos+'_label">$ 000.00</label> <input type="text" hidden="true" id="insumo_total_'+counterInsumos+'" value="0" name="insumo_total_'+counterInsumos+'" >'
	        ] ).draw( false );

	        
	        counterInsumos++;
	        $('#counterInsumos').val(counterInsumos);
	        
	    } );
		$('#tablaInsumos tbody').on( 'click', 'tr', function () {
	        if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	        }
	        else {
	            tablaInsumos.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
	    } );

	    $('#removeRowInsumos').click( function () {
	        tablaInsumos.row('.selected').remove().draw( false );

	        var counterInsumos = $('#counterInsumos').val();
	        var aux;
	        var total_insumos;
	        //alert('Counter '+counter);
	        totalIN_GENERAL = 0;
	        for (var i = 0; i < counterInsumos; i++) {
	        	total_insumos = $('#insumo_total_'+i).val();
	        	//alert(total_insumos);
	        	if (total_insumos != '' && typeof total_insumos !== 'undefined') {
	        		//alert('LOOP: '+i+', dato = '+total_insumos);
	    			totalIN_GENERAL += parseFloat(total_insumos);
				}
	        }
	        //alert(totalIN_GENERAL);
	        $('#total_insumos_general').val(totalIN_GENERAL);
	        $('#total_insumos_general_label').text('$ '+totalIN_GENERAL.toLocaleString());

	        calcularInsumos();
	        calcularGastosVarios();
		});


		//document.getElementById("addRow").click(); 
		//document.getElementById("addRowInsumos").click(); 
	});


	function calcularTotalIva(){

		var iva = parseFloat(total_general) * .16;
		var total_iva = parseFloat(iva) + parseFloat(total_general);

		$('#iva').val(iva);
		$('#iva_label').text('$ '+iva.toLocaleString());

		$('#total_iva').val(total_iva);
		$('#total_iva_label').text('$ '+total_iva.toLocaleString());
	}

	
	function calcularSubtotalGeneral(){




		ganancia_general = parseFloat(gananciaMA_GENERAL) + parseFloat(gananciaIN_GENERAL);
		//alert(gananciaIN_GENERAL+' + '+gananciaMA_GENERAL+' + '+gananciaMO_GENERAL+' = '+ganancia_general);
		subtotal_general_sin_gastos_varios = parseFloat(subtotalIN_GENERAL) + parseFloat(subtotalMO_GENERAL) + parseFloat(subtotalMA_GENERAL);

		subtotal_general = parseFloat(subtotalIN_GENERAL) + parseFloat(subtotalMO_GENERAL) + parseFloat(subtotalMA_GENERAL);

		total_general = parseFloat(totalMO_GENERAL) + parseFloat(totalMA_GENERAL) + parseFloat(totalIN_GENERAL) + parseFloat(gastos_varios_general);

		$('#subtotal_general').val(subtotal_general);
		$('#subtotal_general_label').text('$ '+subtotal_general.toLocaleString());

		$('#ganancia_general').val(ganancia_general);
		$('#ganancia_general_label').text('$ '+ganancia_general.toLocaleString());

		$('#total_general').val(total_general);
		$('#total_general_label').text('$ '+total_general.toLocaleString());

		calcularTotalIva();
	}

	function calcularInsumoTotal(id){

		var costo = $('#insumo_costo_'+id).val();
		var porcent = $('#insumo_ganancia_'+id).val();
		var total_insumos;



		if(porcent==""){
			porcent=0;
			$('#insumo_ganancia_'+id).val(0);
		}

        if(costo==""){
        	costo = 0;
        	$('#insumo_costo_'+id).val(costo);
        }

		var preGanancia = "."+porcent;
		var ganancia = parseFloat(costo) * parseFloat(preGanancia);
		var total = parseFloat(costo) + parseFloat(ganancia);

		if(isNaN(total)){
			total = 0;
		}

		$('#insumo_subtotal_'+id).val(costo);
        $('#insumo_subtotal_'+id+'_label').text('$ '+costo.toLocaleString());

        $('#insumo_total_'+id).val(total);
        $('#insumo_total_'+id+'_label').text('$ '+total.toLocaleString());





        var counterInsumos = $('#counterInsumos').val();
        var aux;
        //alert('Counter '+counter);
        totalIN_GENERAL = 0;
        subtotalIN_GENERAL = 0;
        for (var i = 0; i < counterInsumos; i++) {
        	total_insumos = $('#insumo_total_'+i).val();
        	subtotal_insumos = $('#insumo_subtotal_'+i).val();

        	//alert(total_insumos);
        	if (total_insumos != '' && typeof total_insumos !== 'undefined') {
        		//alert('LOOP: '+i+', dato = '+total_insumos);
    			totalIN_GENERAL += parseFloat(total_insumos);
    			subtotalIN_GENERAL += parseFloat(subtotal_insumos);
			}
        }

        if(isNaN(subtotalIN_GENERAL)){
			subtotalIN_GENERAL = 0;
		}

		if(isNaN(totalIN_GENERAL)){
			totalIN_GENERAL = 0;
		}

        gananciaIN_GENERAL = totalIN_GENERAL - subtotalIN_GENERAL;

        $('#ganancia_insumos_general').val(gananciaIN_GENERAL);
        $('#ganancia_insumos_general_label').text('$ '+gananciaIN_GENERAL.toLocaleString());

        $('#subtotal_insumos_general').val(subtotalIN_GENERAL);
        $('#subtotal_insumos_general_label').text('$ '+subtotalIN_GENERAL.toLocaleString());
        //alert(totalIN_GENERAL);
        $('#total_insumos_general').val(totalIN_GENERAL);
        $('#total_insumos_general_label').text('$ '+totalIN_GENERAL.toLocaleString());
        $('#total_insumos_vista_general').text('$ '+totalIN_GENERAL.toLocaleString());
        

        calcularGastosVarios();
        calcularSubtotalGeneral();

	}

	function calcularInsumos(){
		 var counterInsumos = $('#counterInsumos').val();
        var aux;
        //alert('Counter '+counter);
        totalIN_GENERAL = 0;
        subtotalIN_GENERAL = 0;
        for (var i = 0; i < counterInsumos; i++) {
        	total_insumos = $('#insumo_total_'+i).val();
        	subtotal_insumos = $('#insumo_subtotal_'+i).val();

        	//alert(total_insumos);
        	if (total_insumos != '' && typeof total_insumos !== 'undefined') {
        		//alert('LOOP: '+i+', dato = '+total_insumos);
    			totalIN_GENERAL += parseFloat(total_insumos);
    			subtotalIN_GENERAL += parseFloat(subtotal_insumos);
			}
        }

        gananciaIN_GENERAL = totalIN_GENERAL - subtotalIN_GENERAL;

        $('#ganancia_insumos_general').val(gananciaIN_GENERAL);
        $('#ganancia_insumos_general_label').text('$ '+gananciaIN_GENERAL.toLocaleString());



        $('#subtotal_insumos_general').val(subtotalIN_GENERAL);
        $('#subtotal_insumos_general_label').text('$ '+subtotalIN_GENERAL.toLocaleString());
        //alert(totalIN_GENERAL);
        $('#total_insumos_general').val(totalIN_GENERAL);
        $('#total_insumos_general_label').text('$ '+totalIN_GENERAL.toLocaleString());
        $('#total_insumos_vista_general').text('$ '+totalIN_GENERAL.toLocaleString());
        

        calcularGastosVarios();
        calcularSubtotalGeneral();
	}


	function calcularTotalMaterial(id){
		/*
			CANTIDAD MATERIA ID = material_cantidad_NUM
			COSTO MATERIAL ID = material_costounitario_NUM
			SUBTOTAL MATERIAL ID = material_subtotal_NUM  -> LABEL
			GANANCIA MATERIAL ID = material_ganancia_NUM
			TOTAL MATERIAL ID = material_total_NUM       -> LABEL

        */
        var cantidad = $('#material_cantidad_'+id).val();
        var costo = $('#material_costounitario_'+id).val();
        var porcent = $('#material_ganancia_'+id).val();
        var subtotal;
        var total;
        var total_material;
        var nombre_material = $('#material_nombre_'+id).val();

        if(nombre_material==''){
        	nombre_material = 'Nombre de Material';
        	$('#material_nombre_'+id).val(nombre_material);
        }



        if(porcent == ''){
        	porcent = 0;
        	$('#material_ganancia_'+id).val(porcent);
        }

        var preGanancia = "."+porcent;

        if(costo == ''){
			costo = 0;
			$('#material_costounitario_'+id).val(costo);
		}
        
        subtotal = (cantidad * costo);

        var ganancia = subtotal * preGanancia;

        total = (subtotal + ganancia);

        if(isNaN(total)){
        	total = 0;
        }

        $('#material_subtotal_'+id).val(subtotal);
        $('#material_subtotal_'+id+'_label').text('$ '+subtotal.toLocaleString());

        $('#material_total_'+id).val(total);
        $('#material_total_'+id+'_label').text('$ '+total.toLocaleString());

        var counter = $('#counter').val();
        var aux;
        //alert('Counter '+counter);
        totalMA_GENERAL = 0;
        subtotalMA_GENERAL = 0;
        for (var i = 0; i < counter; i++) {
        	total_material = $('#material_total_'+i).val();
        	subtotal_material = $('#material_subtotal_'+i).val();
        	
        	if (total_material != '' && typeof total_material !== 'undefined') {
    			totalMA_GENERAL += parseFloat(total_material);
    			subtotalMA_GENERAL += parseFloat(subtotal_material);
			}
        }
        gananciaMA_GENERAL = totalMA_GENERAL - subtotalMA_GENERAL;
        
        $('#total_material').val(totalMA_GENERAL);
        $('#total_material_label').text('$ '+totalMA_GENERAL.toLocaleString());
        $('#total_material_vista_general').text('$ '+totalMA_GENERAL.toLocaleString());


        $('#subtotal_material').val(subtotalMA_GENERAL);
        $('#subtotal_material_label').text('$ '+subtotalMA_GENERAL.toLocaleString());

        $('#ganancia_material').val(gananciaMA_GENERAL);
        $('#ganancia_material_label').text('$ '+gananciaMA_GENERAL.toLocaleString());
        calcularSubtotalGeneral();
        calcularGastosVarios();
        calcularSubtotalGeneral();

	}

	function calcularGastosVarios(){
		calcularSubtotalGeneral();

		var gananciaAdmon = $('#gastos_admin_ganancia').val();
		var gananciaHerramienta = $('#herramienta_ganancia').val();
		var gananciaMantenimiento = $('#mantenimiento_ganancia').val();
		var gananciaSeguridad = $('#seguridad_ganancia').val();

		if(gananciaAdmon == ''){
			gananciaAdmon = 0;
			$('#gastos_admin_ganancia').val(gananciaAdmon);
		}
		if(gananciaHerramienta == ''){
			gananciaHerramienta = 0;
			$('#herramienta_ganancia').val(gananciaHerramienta);
		}
		if(gananciaMantenimiento == ''){
			gananciaMantenimiento = 0;
			$('#mantenimiento_ganancia').val(gananciaMantenimiento);
		}
		if(gananciaSeguridad == ''){
			gananciaSeguridad = 0;
			$('#seguridad_ganancia').val(gananciaSeguridad);
		}

		//CALCULANDO GASTOS VARIOS
		var totalAdmon = parseFloat("."+gananciaAdmon) * parseFloat(subtotal_general_sin_gastos_varios);
		var totalHerramienta = parseFloat("."+gananciaHerramienta) * parseFloat(subtotal_general_sin_gastos_varios);
		var totalMantenimiento = parseFloat("."+gananciaMantenimiento) * parseFloat(subtotal_general_sin_gastos_varios);
		var totalSeguridad = parseFloat("."+gananciaSeguridad) * parseFloat(subtotal_general_sin_gastos_varios);

		//alert('Total Admon '+totalAdmon+' Total Herramienta '+totalHerramienta+' Total mantenimiento'+totalMantenimiento+' Total Seguridad '+totalSeguridad+);
		//MOSTRANDO DATOS
		$('#gastos_admin_total').val(totalAdmon);
		$('#gastos_admin_total_label').text('$ '+totalAdmon.toLocaleString());

		$('#herramienta_total').val(totalHerramienta);
		$('#herramienta_total_label').text('$ '+totalHerramienta.toLocaleString());

		$('#mantenimiento_total').val(totalMantenimiento);
		$('#mantenimiento_total_label').text('$ '+totalMantenimiento.toLocaleString());

		$('#seguridad_total').val(totalSeguridad);
		$('#seguridad_total_label').text('$ '+totalSeguridad.toLocaleString());

		//ENVIANDO A TOP LOS GASTOS VARIOS
		gastos_varios_general = totalAdmon + totalHerramienta + totalMantenimiento + totalSeguridad;
		$('#gastos_varios_general').val(gastos_varios_general);
		$('#gastos_varios_general_label').text('$ '+gastos_varios_general.toLocaleString());
		$('#total_gastos_varios_vista_general').text('$ '+gastos_varios_general.toLocaleString());

		

		$('#gastos_total').val(gastos_varios_general);
		$('#gastos_total_label').text('$ '+gastos_varios_general.toLocaleString());
		calcularSubtotalGeneral();

	}

	function calcularSubtotalMOOP(){
		/////////////////// CALCULAR SUBTOTALTOTAL DE MANO DE OBRA OPERADOR
		var cantidad = $('#operador_cantidad').val();
		var hrs = $('#operador_hrs').val();
		var costo = $('#operador_costo_hr').val();

		if (costo == "") {
			costo = 0;
			$('#operador_costo_hr').val(costo);
		}

		var subtotalMO = (parseFloat(cantidad) * parseFloat(hrs)) * parseFloat(costo);
		subtotalMOOP = subtotalMO;

		$('#operador_subtotal').val(subtotalMO);
		$('#operador_subtotal_label').text('$ '+subtotalMO.toLocaleString());
		/////////////////// CALCULAR TOTAL GENERAL DE MANO DE OBRA OPERADOR
		var totalMO = parseFloat(subtotalMO);
		
		totalMOOP = totalMO;


		$('#operador_total').val(totalMO);
		$('#operador_total_label').text('$ '+totalMO.toLocaleString());
		//////////////////// CALCULAR TOTAL GENERAL DE LA MANO DE OBRA
		totalMO_GENERAL = parseFloat(totalMOOP) + parseFloat(totalMOTE);

		subtotalMO_GENERAL = parseFloat(subtotalMOOP) + parseFloat(subtotalMOTE);


		$('#mano_obra_total').val(totalMO_GENERAL);
		$('#mano_obra_total_label').text('$ '+totalMO_GENERAL.toLocaleString());
		$('#total_mano_obra_vista_general').text('$ '+totalMO_GENERAL.toLocaleString());

		$('#mano_obra_subtotal').val(subtotalMO_GENERAL);
		$('#mano_obra_subtotal_label').text('$ '+subtotalMO_GENERAL.toLocaleString());


		calcularSubtotalGeneral();
		calcularGastosVarios();
		calcularSubtotalGeneral();
	}




	function calcularSubtotalMOTE(){
		/////////////////// CALCULAR SUBTOTALTOTAL DE MANO DE OBRA TECNICO
		var cantidad = $('#tecnico_cantidad').val();
		var hrs = $('#tecnico_hrs').val();
		var costo = $('#tecnico_costo_hr').val();

		if (costo == "") {
			costo = 0;
			$('#tecnico_costo_hr').val(costo);
		}

		var subtotalMO = (parseFloat(cantidad) * parseFloat(hrs)) * parseFloat(costo);
		//alert('SubtotalMOTE : '+subtotalMO);
		subtotalMOTE = subtotalMO;

		$('#tecnico_subtotal').val(subtotalMO);
		$('#tecnico_subtotal_label').text('$ '+subtotalMO.toLocaleString());
		/////////////////// CALCULAR TOTAL GENERAL DE MANO DE OBRA TECNICO

		var totalMO = parseFloat(subtotalMO);
		//alert(ganancia+' + '+subtotalMO+' = '+totalMO);
		totalMOTE = totalMO;

		$('#tecnico_total').val(totalMO);
		$('#tecnico_total_label').text('$ '+totalMO.toLocaleString());


		//////////////////// CALCULAR TOTAL GENERAL DE LA MANO DE OBRA
		//alert('(funcion MOTE) TOTOAL MOOP '+ totalMOOP +' + TOTAL MOTE: '+ totalMOTE+' = TOTAL MO' +totalMO_GENERAL);
		totalMO_GENERAL = parseFloat(totalMOOP) + parseFloat(totalMOTE);

		subtotalMO_GENERAL = parseFloat(subtotalMOOP) + parseFloat(subtotalMOTE);
		
		
		$('#mano_obra_total').val(totalMO_GENERAL);
		$('#mano_obra_total_label').text('$ '+totalMO_GENERAL.toLocaleString());
		$('#total_mano_obra_vista_general').text('$ '+totalMO_GENERAL.toLocaleString());
		
		$('#mano_obra_subtotal').val(subtotalMO_GENERAL);
		$('#mano_obra_subtotal_label').text('$ '+subtotalMO_GENERAL.toLocaleString());


		

		calcularSubtotalGeneral();
		calcularGastosVarios();
		calcularSubtotalGeneral();
		
	}
	

	    


	function cambiarPanel(boton){
    	if(boton == "siguiente"){
    		panel++;
    	}else{
    		panel--;
    	}

    	/*
    		PANEL 0 MATERIALES
			PANEL 1 MANO DE OBRA
			PANEL 2 INSUMOS
			PANEL 3 GASTOS VARIOS
		*/
    	if(panel == 0){
    		$('#anterior').attr('disabled','disabled');

    		$('#panel_material').removeAttr('hidden');
    		$('#panel_insumos').attr('hidden','true');
    		$('#panel_mano_obra').attr('hidden','true');
    		$('#panel_gastos_varios').attr('hidden','true');

    		$('#tituloCosteo').text('Material');
    	}
    	if(panel == 1){
    		$('#anterior').removeAttr('disabled','disabled');

    		$('#panel_material').attr('hidden','true');
    		$('#panel_mano_obra').removeAttr('hidden');
    		$('#panel_insumos').attr('hidden','true');
    		$('#panel_gastos_varios').attr('hidden','true');

    		$('#tituloCosteo').text('Mano de Obra');
    	}
    	if(panel == 3){
    		$('#siguiente').attr('disabled','disabled');

    		$('#panel_material').attr('hidden','true');
    		$('#panel_mano_obra').attr('hidden','true');
    		$('#panel_insumos').removeAttr('hidden');
    		$('#panel_gastos_varios').attr('hidden','true');

    		$('#tituloCosteo').text("Insumos");
    	}
    	if(panel == 2){
    		$('#siguiente').removeAttr('disabled');

    		$('#panel_material').attr('hidden','true');
    		$('#panel_mano_obra').attr('hidden','true');
    		$('#panel_insumos').attr('hidden','true');
    		$('#panel_gastos_varios').removeAttr('hidden');	

    		//alert($('#tituloCosteo').val());
    		$('#tituloCosteo').text('Gastos Varios');
    		//alert($('#tituloCosteo').val());

    	}
	}


	jQuery("#myPhonefield").keypress(function(){
	    var value = jQuery(this).val();
	    value = value.replace(/[^0-9]+/g, '');
	    jQuery(this).val(value);
	});


	function isNumberKey(evt){
	    var charCode = (evt.which) ? evt.which : event.keyCode
	    if (charCode > 31 && (charCode < 48 || charCode > 57))
	        return false;
	    return true;
	}

	function isNumberKeyDecimal(evt){
	    var charCode = (evt.which) ? evt.which : event.keyCode
	    if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
	        return false;
	    return true;
	}

	function checkCostoNull(input,counter){
		var material_nombre =  $('#'+input).val();
		if(material_nombre==''){
        	material_nombre = 'Nombre de Material';
        	$('#'+input).val(material_nombre);
        }

		if($('#'+'material_cantidad_'+counter).val() == '')
			$('#'+'material_cantidad_'+counter).val('0');
		
		if ($('#'+'material_costounitario_'+counter).val() == '') 
			$('#'+'material_costounitario_'+counter).val('0');		
		calcularTotalMaterial();
	}


	function checkInsumos(input,counter){
		var insumo_nombre =  $('#'+input).val();
		if(insumo_nombre==''){
        	insumo_nombre = 'Nombre de Insumo';
        	$('#'+input).val(insumo_nombre);
        }

		if($('#insumo_costo_'+counter).val() == '')
			$('#insumo_costo_'+counter).val('0');
		
		if ($('#insumo_ganancia_'+counter).val() == '') 
			$('#insumo_ganancia_'+counter).val('0');
	}

	
	



	function openPage(pageName, elmnt) {
	    // Hide all elements with class="tabcontent" by default */
	    var i, tabcontent, tablinks;
	    tabcontent = document.getElementsByClassName("tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }

	    // Remove the background color of all tablinks/buttons
	    tablinks = document.getElementsByClassName("tablink");

	    // Show the specific tab content
	    document.getElementById(pageName).style.display = "block";


	    var btnContainer = document.getElementById("myDIV");

		// Get all buttons with class="btn" inside the container
		var btns = btnContainer.getElementsByClassName("tablink");

		// Loop through the buttons and add the active class to the current/clicked button
		for (var i = 0; i < btns.length; i++) {
		  btns[i].addEventListener("click", function() {
		    var current = document.getElementsByClassName("active");
		    current[0].className = current[0].className.replace(" active", "");
		    this.className += " active";
		  });
		}    
	}


	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click(); 
</script>
@stop