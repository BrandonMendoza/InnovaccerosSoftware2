@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar Cotización</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            	<li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
		    	<li class="breadcrumb-item"><a href="{{URL('/trabajos/show')}}">Proyectos</a></li>
		    	<li class="breadcrumb-item"><a href="{{url('/cotizaciones/'.$save->id.'/cotizacionesProyecto')}}">Cotizaciones por Proyecto</a></li>
		      	<li class="breadcrumb-item">Editar Cotización</li>
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
	
<form id="formCreate" method="POST" onchange="guardarFormulario()" action="{{url('/cotizaciones/'.$cotizacionGeneral->id.'/actualizarCotizacion')}}" enctype="multipart/form-data">
	{{csrf_field()}}

	<!-- Valores escondidos en el Form -->
	<!-- Id del proyecto cotizado--> 	
	<input type="text" value="{{ $save->id }}" name="id_proyecto" hidden>
	<!-- materiales--> 	
	<label for="" id="subtotal_material_label" hidden>$ {{ $cotizacionGeneral->subtotal_materiales }}</label>
	<input type="text" name="subtotal_material" id="subtotal_material" value="{{ $cotizacionGeneral->subtotal_materiales }}"hidden>

	<label for="" id="ganancia_material_label" hidden>$ {{ $cotizacionGeneral->ganancia_materiales }}</label>
	<input type="text" name="ganancia_material" id="ganancia_material" value="{{ $cotizacionGeneral->ganancia_materiales }}" hidden>

	<label for="" id="total_material_label" hidden>$ {{ $cotizacionGeneral->total_materiales }}</label>
	<input type="text" name="total_material" id="total_material" value="{{ $cotizacionGeneral->total_materiales }}" hidden>
						
	<input type="text" id="counter" name="counter_material" hidden value="0">

	<!-- mano de obra--> 	
	<label for="" id="mano_obra_subtotal_label" hidden>$ {{ $cotizacionGeneral->subtotal_mano_obra }}</label>
	<input type="text" name="mano_obra_subtotal" id="mano_obra_subtotal" value="{{ $cotizacionGeneral->subtotal_mano_obra }}" hidden>
	<label for="" id="mano_obra_total_label" hidden>$ {{ $cotizacionGeneral->total_mano_obra }}</label>
	<input type="text" name="mano_obra_total" id="mano_obra_total" value="{{ $cotizacionGeneral->total_mano_obra }}" hidden>


	<!-- gastos varios--> 	
	<label for="" id="gastos_total_label" hidden>$ {{ $cotizacionGeneral->total_gastos_varios }}</label>
	<input type="text" name="gastos_total" id="gastos_total" value="{{ $cotizacionGeneral->total_gastos_varios }}" hidden>

	<!-- insumos--> 	
	<label id="subtotal_insumos_general_label" hidden>$ {{ $cotizacionGeneral->subtotal_insumos }}</label>
	<input type="text" name="subtotal_insumos_general" id="subtotal_insumos_general"  value="{{ $cotizacionGeneral->subtotal_insumos }}" hidden>

	<label id="ganancia_insumos_general_label" hidden>$ {{ $cotizacionGeneral->ganancia_insumos }}</label>
	<input type="text" name="ganancia_insumos_general" id="ganancia_insumos_general"  value="{{ $cotizacionGeneral->ganancia_insumos }}" hidden>

	<label id="total_insumos_general_label" hidden>${{ $cotizacionGeneral->total_insumos }}</label>
	<input type="text" name="total_insumos_general" id="total_insumos_general" value="{{ $cotizacionGeneral->total_insumos }}" hidden>
	<input type="text" id="counterInsumos" name="counter_insumos" hidden>
	<!-- /.Valores escondidos en el Form -->
	<!-- encabezaado de totales--> 	
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				
		  		<div class="card-footer">
		    		<div class="row">
		      			<div class="col-sm col-6">
					        <div class="description-block border-right">
					          	<h5 class="description-header" id="subtotal_general_label">${{ $cotizacionGeneral->subtotal_general }}</h5>
					          	<input type="text" hidden="true" name="subtotal_general" id="subtotal_general" value="{{ $cotizacionGeneral->subtotal_general }}">
					          	<span class="description-text">SUBTOTAL</span>
					        </div>
			        	<!-- /.description-block -->
			      		</div>
					      <!-- /.col -->
					    <div class="col-sm col-6">
					        <div class="description-block border-right">
					          	<h5 class="description-header" id="ganancia_general_label">$ {{ $cotizacionGeneral->ganancia_general }}</h5>
								<input type="text" name="ganancia_general" id="ganancia_general" value="{{ $cotizacionGeneral->ganancia_general }}" hidden>
					          	<span class="description-text">GANANCIA</span>
					        </div>
					        <!-- /.description-block -->
					    </div>
					      <!-- /.col -->
					    <div class="col-sm col-6">
					        <div class="description-block border-right">
					          	<h5 class="description-header" id="total_general_label">$ {{ $cotizacionGeneral->total_general }}</h5>
								<input type="text" hidden="true" name="total_general" id="total_general" value="{{ $cotizacionGeneral->total_general }}">
					          	<span class="description-text">TOTAL GENERAL</span>
					        </div>
					        <!-- /.description-block -->
					    </div>
					      <!-- /.col -->
					    <div class="col-sm col-6">
					        <div class="description-block border-right">                      
					          	<h5 class="description-header" id="iva_label"></h5>
							  	<input type="text" id="iva" name="iva" hidden>
					          	<span class="description-text">IVA</span>
					        </div>
					        <!-- /.description-block -->
					    </div>
					    <div class="col-sm col-6">
					        <div class="description-block">
					          	<h5 class="description-header" id="total_iva_label"></h5>
							  	<input type="text" id="total_iva" name="total_iva" hidden>
					          	<span class="description-text">TOTAL IVA</span>
					        </div>
					        <!-- /.description-block -->
					    </div>
					</div>
					    <!-- /.row -->
				</div>



			  <!-- TOTAL MATERIAL MANO OBRA INSUMOS Y GASTOS VARIOS-->
				<div class="card-footer border-top">
				    <div class="row">
				      	<div class="col-sm-3 col-6">
				        	<div class="description-block border-right">
				          		<h5 class="description-header" id="total_material_vista_general">$000.00</h5>
				          		<span class="description-text">MATERIAL</span>
				        	</div>
				        	<!-- /.description-block -->
				      	</div>
				      	<!-- /.col -->
				      	<div class="col-sm-3 col-6">
				        	<div class="description-block border-right">
				          		<h5 class="description-header" id="total_mano_obra_vista_general">$ 000.00</h5>
				          		<span class="description-text">MANO DE OBRA</span>
				        	</div>
				        	<!-- /.description-block -->
				      	</div>
				      	<!-- /.col -->
				      	<div class="col-sm-3 col-6">
				        	<div class="description-block border-right">
				          		<h5 class="description-header" id="total_gastos_varios_vista_general">$ 000.00</h5>
								<input type="text" hidden="true" name="gastos_varios_general" id="gastos_varios_general" value="{{ $cotizacionGeneral->total_gastos_varios }}">
				          		<span class="description-text">GASTOS VARIOS</span>
				        	</div>
				        	<!-- /.description-block -->
				      	</div>
					    <!-- /.col -->
					    <div class="col-sm-3 col-6">
					    	<div class="description-block">                      
					        	<h5 class="description-header" id="total_insumos_vista_general"></h5>
					          	<span class="description-text">INSUMOS</span>
					        </div>
					        <!-- /.description-block -->
					    </div>
					</div>
					<!-- /.row -->
				</div>
			</div>
			<!-- /.card -->
		</div>
		<!-- /.col -->
	</div>
	<!-- ./encabezaado de totales--> 

	<div class="row">
        <div class="col-12">
            <div class="card card-secondary">
              	<div class="card-header border-0">
                	<h3 class="card-title">Materiales</h3>
                	<div class="card-tools">
                  		<button type="button" class="btn btn-tool" id="addRow" title="Agregar">
				  			<i class="fas fa-plus-square"></i>
				  		</button>
				  		<button type="button" class="btn btn-tool" id="removeRow" title="Eliminar"> 
				  			<i class="fas fa-trash-alt"></i>
				  		</button>
				  		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Abrir/cerrar">
                  			<i class="fas fa-minus"></i>
              			</button>
                	</div>
              	</div>

              	<div class="card-body  table-responsive p-0">
                <!-- CONTENIDO 1 -->
	                <table id="tabla" class="table table-hover" >
		    			<thead>
		    				<tr>
								<th style="width: 30%;">Material</th>
								<th style="width: 1%;">Cantidad</th>
								<th style="width: 5%;">Costo Unitario</th>
								<th style="width: 5%;">Subtotal Costo</th>
								<th style="width: 1%;">Ganancia</th>
								<th style="width: 5%;">Total</th>
		    				</tr>
		    			</thead>
		    			<tbody>
						
										
		    			</tbody>
		    		</table>
	            </div>
        	</div>
            <!-- /.card -->
         	
	        <!-- /.card -->
		</div>
          <!-- /.col-md-6 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-secondary">
              	<div class="card-header border-0">
               		<h3 class="card-title">Insumos</h3>
                	<div class="card-tools">
                  		<button type="button" class="btn btn-tool" id="addRowInsumos" title="Agregar">
				  			<i class="fas fa-plus-square"></i>
				  		</button>
				  		<button type="button" class="btn btn-tool" id="removeRowInsumos" title="Eliminar"> 
				  			<i class="fas fa-trash-alt"></i>
				  		</button>
				  		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Abrir/cerrar">
                  			<i class="fas fa-minus"></i>
              			</button>
                	</div>
              	</div>
              	<div class="card-body table-responsive p-0">
              		<table class="table table-hover" id="tablaInsumos">
    					<thead>
    						<tr>
								<th style="width: 40%;">Nombre</th>
								<th style="width: 5%;">Costo</th>
								<th style="width: 5%;">Sub Total</th>
								<th style="width: 1%;">Ganancia</th>
								<th style="width: 5%;">Total</th>
	    					</tr>
	    				</thead>
    					<tbody>
						
					
    					</tbody>
    				</table>
               
              	</div>
            </div>
            <!-- /.card -->
		</div>
          <!-- /.col-md-6 -->
    </div>

    <div class="row">
    	<div class="col-lg-6">
            <div class="card card-secondary">
              	<div class="card-header border-0">
                  	<h3 class="card-title">Gastos Varios</h3>
                  	<div class="card-tools"> 
                  		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Abrir/cerrar">
	              			<i class="fas fa-minus"></i>
	          			</button>
                  	</div>
              	</div>
              	<div class="card-body table-responsive p-0">
                	<table id="tableGastosVarios" class="table table-hover">
    					<thead>
    						<tr>
								<th></th>
								<th style="width: 1%;">Ganancia</th>
								<th style="width: 20%;">Total</th>
	    					</tr>
    					</thead>
						<tbody>
							<tr>
								<td>
									<label for="">Gastos Administrativos</label>
								</td>
								<td>
									<input class="form-control form-control-sm" type="number" onkeypress="return isNumberKey(event)" onchange="calcularGastosVarios();" step="1" value="{{ $gastosVarios->gastos_admin_ganancia }}" name="gastos_admin_ganancia" id="gastos_admin_ganancia" min="0">
								</td>
								<td>
									<label id="gastos_admin_total_label">$ {{ $gastosVarios->gastos_admin_total }}</label>
									<input type="text" hidden="true" name="gastos_admin_total"  id="gastos_admin_total" value="{{ $gastosVarios->gastos_admin_total }}">
								</td>
							</tr>
							<tr>
								<td>
									<label for="">Desgaste de Herramienta</label>
								</td>
								<td>
									<input class="form-control form-control-sm" type="number" onkeypress="return isNumberKeyDecimal(event)" onchange="calcularGastosVarios();" step="1" value="{{ $gastosVarios->desgaste_herramienta_ganancia }}" name="herramienta_ganancia" id="herramienta_ganancia" min="0">
								</td>
								<td>
									<label id="herramienta_total_label">$ {{ $gastosVarios->desgaste_herramienta_total }}</label>
									<input type="text" hidden="true" name="herramienta_total" id="herramienta_total" value="{{ $gastosVarios->desgaste_herramienta_total }}">
								</td>
							</tr>
							<tr>
								<td>
									<label for="">Mantenimiento a Vehiculos</label>
								</td>
								<td>
									<input class="form-control form-control-sm" type="number" onkeypress="return isNumberKeyDecimal(event)" onchange="calcularGastosVarios();" step="1" value="{{ $gastosVarios->mantenimiento_ganancia }}" name="mantenimiento_ganancia" id="mantenimiento_ganancia" min="0">
								</td>
								<td>
									<label id="mantenimiento_total_label">$ {{ $gastosVarios->mantenimiento_total }}</label>
									<input type="text" name="mantenimiento_total" hidden="true" id="mantenimiento_total" value="{{ $gastosVarios->mantenimiento_total }}">
								</td>
							</tr>
							<tr>
								<td>
									<label for="">Gastos de Seguridad</label>
								</td>
								<td>
									<input class="form-control  form-control-sm" onkeypress="return isNumberKeyDecimal(event)" onchange="calcularGastosVarios();" type="number" step="1" value="{{ $gastosVarios->seguridad_ganancia }}" id="seguridad_ganancia" name="seguridad_ganancia" min="0">
								</td>
								<td>
									<label id="seguridad_total_label">$ {{ $gastosVarios->seguridad_total }}</label>  
									<input type="text" name="seguridad_total" hidden="true" value="{{ $gastosVarios->seguridad_total }}" id="seguridad_total">
								</td>
							</tr>
	    				</tbody>
	    			</table>
	            </div>
	        </div>
            <!-- /.card -->
        </div>
        <div class="col-lg-6">
            <div class="card card-secondary">
	          	<div class="card-header border-0">
	            	<h3 class="card-title">Mano de obra</h3>
		            <div class="card-tools">
		              	<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Abrir/cerrar">
                  			<i class="fas fa-minus"></i>
              			</button>
		            </div>
	         	</div>
	            <div class="card-body table-responsive p-0">
	              	<table id="tabalManoObra" class="table table-hover">
		    			<thead>
							<tr>
								<th style="width: 10%;"></th>
								<th style="width: 5%;">Cantidad</th>
								<th style="width: 10%;">Hrs</th>
								<th style="width: 15%;">Costo p/ Hr</th>
								<th style="width: 15%;">Sub Total</th>
								<th style="width: 10%;">Total</th>
							</tr>
		    			</thead>
						<tbody>
							<tr>
								<td>
									<label for="">Operador</label>
								</td>
								<td>
									<input class="form-control  form-control-sm" onkeypress="return isNumberKey(event)" type="number" step="1" value="{{ $manoObra->operador_cantidad }}" id="operador_cantidad" name="operador_cantidad" onchange="calcularSubtotalMOOP();" min="0">
								</td>
								<td>
									<input class="form-control form-control-sm" onkeypress="return isNumberKey(event)" type="number" step="" value="{{ $manoObra->operador_hrs }}" id="operador_hrs" name="operador_hrs" onchange="calcularSubtotalMOOP();" min="0">
								</td>
								<td>
									<input value="{{ $manoObra->operador_costo_hr }}" class="form-control" type="text" id="operador_costo_hr" name="operador_costo_hr" onkeypress="return isNumberKey(event)" onchange="calcularSubtotalMOOP();" step="1" min="0">
								</td>
								<td>
									<label id="operador_subtotal_label">$ {{ $manoObra->operador_subtotal }}</label><input type="text" value="{{ $manoObra->operador_subtotal }}" hidden="true" id="operador_subtotal" name="operador_subtotal">
								</td>
								<td>
									<label id="operador_total_label">$ {{ $manoObra->operador_total }}</label><input type="text" hidden="true" id="operador_total" name="operador_total" value="{{ $manoObra->operador_total }}">
								</td>
							</tr>
							<tr>
								<td>
									<label>Tecnico</label>
								</td>
								<td>
									<input class="form-control  form-control-sm" type="number" onkeypress="return isNumberKey(event)" onchange="calcularSubtotalMOTE();" step="1" value="{{ $manoObra->tecnico_cantidad }}" id="tecnico_cantidad" name="tecnico_cantidad" min="0">
								</td>
								<td>
									<input class="form-control  form-control-sm" onkeypress="return isNumberKey(event)" type="number" onchange="calcularSubtotalMOTE();" step="1" value="{{ $manoObra->tecnico_hrs }}" id="tecnico_hrs" name="tecnico_hrs" min="0">
								</td>
								<td>
									<input class="form-control" type="text" id="tecnico_costo_hr" value="{{ $manoObra->tecnico_costo_hr }}" name="tecnico_costo_hr" onkeypress="return isNumberKey(event)" onchange="calcularSubtotalMOTE();" step="1" min="0">
								</td>
								<td>
									<label id="tecnico_subtotal_label">$ {{ $manoObra->tecnico_subtotal }}</label><input type="text" hidden="true" id="tecnico_subtotal" value="{{ $manoObra->tecnico_subtotal }}" name="tecnico_subtotal">
								</td>
								<td>
									<label id="tecnico_total_label">$ {{ $manoObra->tecnico_total }}</label><input type="text" id="tecnico_total" name="tecnico_total" value="{{ $manoObra->tecnico_total }}" hidden="true">
								</td>
							</tr>
						</tbody>
		    		</table>
	        	</div>
	        </div>
        </div>
          <!-- /.col-md-6 -->
    </div>

    <div class="row">
        <div class="col-12">
			<a class="ion-close-round btn btn-flat btn-danger" href="{{url('/cotizaciones/'.$save->id.'/cotizacionesProyecto')}}">
          		<i class="fas fa-window-close mr-2"></i>Cancelar
        	</a>

		    <button type="submit" value="create" class="btn btn-flat btn-success float-right">
          		<i class="fas fa-check-square mr-2"></i>Guardar
        	</button>
        </div>
    </div>
</form>

 

@stop
@section('scripts')
<script>
	var panel = 0;
	
	var totalMOOP = {!! json_encode($manoObra->operador_total) !!}; //TOTAL MANO DE OBRE OPERADORES
	var subtotalMOOP = {!! json_encode($manoObra->operador_subtotal) !!};
	//alert('OPERADOR '+totalMOOP+' '+subtotalMOOP); //SUBTOTAL MANO DE OBRE OPERADORES
	var gananciaMOOP = parseFloat(totalMOOP) - parseFloat(subtotalMOOP); //SUBTOTAL MANO DE OBRE OPERADORES
	//alert('TOTAL MOOP; '+totalMOOP+', SUBTOTAL MOOP; '+subtotalMOOP+', ganancia MOOP; '+gananciaMOOP);

	var totalMOTE = {!! json_encode($manoObra->tecnico_total) !!}; //TOTAL MANO DE TECNICOS2i
	var subtotalMOTE = {!! json_encode($manoObra->tecnico_subtotal) !!}; //SUBTOTAL MANO DE TECNICOS
	//alert('TECNICO'+totalMOTE+' '+subtotalMOTE);
	var gananciaMOTE = parseFloat(totalMOTE) - parseFloat(subtotalMOTE); //SUBTOTAL MANO DE TECNICOS
	//alert('TOTAL MOTE; '+totalMOTE+', SUBTOTAL MOTE; '+subtotalMOTE+', ganancia MOTE; '+gananciaMOTE);

	
	var subtotalMO_GENERAL = {!! json_encode($cotizacionGeneral->subtotal_mano_obra) !!} ; // SUBTOTAL GENERAL MANO DE OBRA
	var totalMO_GENERAL = {!! json_encode($cotizacionGeneral->total_mano_obra) !!}; // TOTAL GENERAL MANO DE OBRA
	var gananciaMO_GENERAL = {!! json_encode($cotizacionGeneral->ganancia_mano_obra) !!}; // GANANCIA GENERAL MANO DE OBRA
	//alert('TOTAL MO_GENERAL; '+totalMO_GENERAL+', SUBTOTAL MO_GENERAL; '+subtotalMO_GENERAL+', ganancia MO_GENERAL; '+gananciaMO_GENERAL);

	
	var subtotalMA_GENERAL = {!! json_encode($cotizacionGeneral->subtotal_materiales) !!}; // SUBTOTAL GENERAL MATERIALES
	var totalMA_GENERAL = {!! json_encode($cotizacionGeneral->total_materiales) !!}; //TOTAL GENERAL MATERIALES
	var gananciaMA_GENERAL = {!! json_encode($cotizacionGeneral->ganancia_materiales) !!}; // GANANCIA GENERAL MATERIALES
	//alert('TOTAL MA_GENERAL; '+totalMA_GENERAL+', SUBTOTAL MA_GENERAL; '+subtotalMA_GENERAL+', ganancia MA_GENERAL; '+gananciaMA_GENERAL);


	
	var subtotalIN_GENERAL = {!! json_encode($cotizacionGeneral->subtotal_insumos) !!}; // SUBTOTAL GENERAL INSUMOS
	var totalIN_GENERAL = {!! json_encode($cotizacionGeneral->total_insumos) !!}; //TOTAL GENERAL INSUMOS
	var gananciaIN_GENERAL = {!! json_encode($cotizacionGeneral->ganancia_insumos) !!}; // GANANCIA GENERAL INSUMOS
	//alert('TOTAL IN_GENERAL; '+totalIN_GENERAL+', SUBTOTAL IN_GENERAL; '+subtotalIN_GENERAL+', ganancia IN_GENERAL; '+gananciaIN_GENERAL);


	var gastos_varios_general = {!! json_encode($cotizacionGeneral->total_gastos_varios) !!}; //GASTOS VARIOS GENERAL
	
	var subtotal_general = {!! json_encode($cotizacionGeneral->subtotal_general) !!}; // SUBTOTAL GENERAL DE COTIZACION
	var total_general = {!! json_encode($cotizacionGeneral->total_general) !!};    // TOTAL GENERAL DE COTIZACION
	var subtotal_general_sin_gastos_varios;
	var ganancia_general = {!! json_encode($cotizacionGeneral->ganancia_general) !!}; // GANANCIA GENERAL DE COTIZACION
	//alert(' Gastos varios general; '+gastos_varios_general+', Ganancia general; '+ganancia_general+', Subtotal_general; '+subtotal_general+', Total general'+total_general);


	$(document).ready(function() {
    	var counter =  0;
    	var counterInsumos =  0;

    	var tablaInsumos = $('#tablaInsumos').DataTable({
    		"paging":   false,
        	"ordering": false,
        	"info":     false,
        	"searching": false,
        	"select": true,
	        "autoWidth": false,
	        "responsive": true,
    	});

    	var table = $('#tabla').DataTable({
    		"paging":   false,
        	"ordering": false,
        	"info":     false,
        	"searching": false,
        	"select": true,
	        "autoWidth": false,
	        "responsive": true,
    	});

    	var tableManoObra = $('#tabalManoObra').DataTable({
                  "paging": false,
                  //"lengthChange": false,
                  "searching": false,
                  "ordering": false,
                  "info": false,
                  "autoWidth": false,
                  "responsive": true,
              });

    	var tableGastosVarios = $('#tableGastosVarios').DataTable({
                  "paging": false,
                  //"lengthChange": false,
                  "searching": false,
                  "ordering": false,
                  "info": false,
                  "autoWidth": false,
                  "responsive": true,
              });


    	//TABLAMATERIALES tabalManoObra

    	$('#addRow').on( 'click', function () {
	        table.row.add( [
	            '<textarea class="form-control" type="text" onkeypress="return dontAllowEnter(event)" onchange="checkCostoNull(this.id,'+counter+');" id="material_nombre_'+counter+'" placeholder="Material" name="material_nombre_'+counter+'">Nombre de Material</textarea>',
	            '<input class="form-control" type="number" value="0"  placeholder="Cant" step="any" onkeypress="return isNumberKey(event)" name="material_cantidad_'+counter+'" id="material_cantidad_'+counter+'"  onchange="calcularTotalMaterial('+counter+');" min="0">',
	            '<input class="form-control no-spinners" type="number" step="any" value="0" onkeypress="return isNumberKeyDecimal(event)" placeholder="Costo Unitario" id="material_costounitario_'+counter+'" name="material_costounitario_'+counter+'" onchange="calcularTotalMaterial('+counter+');" min="0">',
	            '<label for="" id="material_subtotal_'+counter+'_label">$ 000.00</label><input class="form-control" type="text" name="material_subtotal_'+counter+'" id="material_subtotal_'+counter+'" value="0" hidden required>',
	            '<input class="form-control" type="number"  step="1" value="10" placeholder="Ganancia" id="material_ganancia_'+counter+'"  name="material_ganancia_'+counter+'" onkeypress="return isNumberKey(event)" onchange="calcularTotalMaterial('+counter+');" min="0">',
	            '<label for="" name="material_total_'+counter+'_label" id="material_total_'+counter+'_label">$ 000.00</label><input class="form-control" type="text" value="0" name="material_total_'+counter+'" id="material_total_'+counter+'" hidden required>'
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
	        $('#total_material_label').text('$ '+parseFloat(totalMA_GENERAL).toLocaleString());
	        guardarFormulario();
		});
	    //TABLA INSUMOS
		$('#addRowInsumos').on( 'click', function () {
	        tablaInsumos.row.add( [
	        	'<input class="form-control" type="text" onchange="checkInsumos(this.id,'+counter+')" value="Nombre de Insumo" placeholder="insumo" id="insumo_nombre_'+counterInsumos+'" name="insumo_nombre_'+counterInsumos+'">',
				'<input type="number" placeholder="Costo" step="any" onkeypress="return isNumberKeyDecimal(event)" class="form-control no-spinners form-control-sm" id="insumo_costo_'+counterInsumos+'" name="insumo_costo_'+counterInsumos+'" value="0" onchange="calcularInsumoTotal('+counterInsumos+');" min="0">',
				'<label for="" id="insumo_subtotal_'+counterInsumos+'_label">$ 000.00</label><input type="text" id="insumo_subtotal_'+counterInsumos+'" name="insumo_subtotal_'+counterInsumos+'" hidden="true" value="0">',
				'<input class="form-control  form-control-sm" type="text" onkeypress="return isNumberKey(event)" step="1" value="10" id="insumo_ganancia_'+counterInsumos+'" name="insumo_ganancia_'+counterInsumos+'" onchange="calcularInsumoTotal('+counterInsumos+');" min="1">',
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
	        //alert('Counter '+counterInsumos);
	        totalIN_GENERAL = 0;
	        for (var i = 0; i < counterInsumos; i++) {
	        	total_insumos = $('#insumo_total_'+i).val();
	        	//alert(total_insumos);
	        	if (total_insumos != '' && typeof total_insumos !== 'undefined') {
	        		//alert('LOOP: '+i+', dato = '+total_insumos);
	    			totalIN_GENERAL += parseFloat(total_insumos);
				}
	        }
	        //alert('si llega');
	        //alert(totalIN_GENERAL);
	        calcularInsumos();
	        calcularGastosVarios();
	       
	        $('#total_insumos_general').val(totalIN_GENERAL);
	        $('#total_insumos_general_label').text('$ '+totalIN_GENERAL.toLocaleString());

	        guardarFormulario();
		});

		@foreach($materiales as $id => $material)
    		table.row.add( [
	            '<textarea class="form-control" id="material_nombre_'+counter+'" placeholder="Material" onkeypress="return dontAllowEnter(event)" onchange="checkCostoNull(this.id,'+counter+');" value="" name="material_nombre_'+counter+'">{{ $material->material_nombre }}</textarea>',
	            '<input class="form-control" type="number" placeholder="Cant" onkeypress="return isNumberKey(event)" value="{{ $material->cantidad }}" name="material_cantidad_'+counter+'" id="material_cantidad_'+counter+'"  onchange="calcularTotalMaterial('+counter+');">',
	            '<input class="form-control no-spinners" step="any" type="text" onkeypress="return isNumberKeyDecimal(event)" value="{{ $material->costo_unitario }}" placeholder="Costo Unitario" id="material_costounitario_'+counter+'" name="material_costounitario_'+counter+'" onchange="calcularTotalMaterial('+counter+');">',
	            '<label for="" id="material_subtotal_'+counter+'_label">$ {{ number_format($material->subtotal_costo,2) }}</label><input class="form-control" type="text" value="{{ $material->subtotal_costo }}" name="material_subtotal_'+counter+'" id="material_subtotal_'+counter+'" hidden required>',
	            '<input class="form-control" type="number"  step="1" onkeypress="return isNumberKey(event)" placeholder="Ganancia" value="{{ $material->ganancia }}" id="material_ganancia_'+counter+'"  name="material_ganancia_'+counter+'" onchange="calcularTotalMaterial('+counter+');">',
	            '<label for="" name="material_total_'+counter+'_label" id="material_total_'+counter+'_label">$ {{ number_format($material->total,2) }}</label><input class="form-control" type="text" value="{{ $material->total }}" name="material_total_'+counter+'" id="material_total_'+counter+'" hidden required>'
	        ] ).draw( false );
    		
	        counter++;
	        $('#counter').val(counter);
    	@endforeach()




    	@foreach($insumos as $id => $insumo)
    		 tablaInsumos.row.add( [
	        	'<input class="form-control" type="text" onchange="checkInsumos(this.id,'+counter+')" placeholder="insumo" value="{{ $insumo->concepto }}" id="insumo_nombre_'+counterInsumos+'" name="insumo_nombre_'+counterInsumos+'">',
				'<input type="number" step="any"  class="form-control no-spinners form-control-sm" onkeypress="return isNumberKeyDecimal(event)"  value="{{ $insumo->costo }}" id="insumo_costo_'+counterInsumos+'" name="insumo_costo_'+counterInsumos+'" onchange="calcularInsumoTotal('+counterInsumos+');">',
				'<label for="" id="insumo_sutotal_'+counterInsumos+'_label">$ {{ $insumo->subtotal }}</label><input type="text" id="insumo_subtotal_'+counterInsumos+'" name="insumo_subtotal_'+counterInsumos+'" hidden="true"  value="{{ $insumo->subtotal }}">',
				'<input class="form-control  form-control-sm" onkeypress="return isNumberKey(event)" value="{{ $insumo->ganancia }}" type="number" step="1"  id="insumo_ganancia_'+counterInsumos+'" name="insumo_ganancia_'+counterInsumos+'" onchange="calcularInsumoTotal('+counterInsumos+');">',
				'<label for=""  id="insumo_total_'+counterInsumos+'_label">$ {{ $insumo->total }}</label> <input type="text" id="insumo_total_'+counterInsumos+'" name="insumo_total_'+counterInsumos+'" value="{{ $insumo->total }}" hidden>'
	        ] ).draw( false );

	        
	        counterInsumos++;
	        $('#counterInsumos').val(counterInsumos);
    	@endforeach


    	calcularSubtotalMOTE();
		calcularSubtotalMOOP();
		calcularTotalIva();
	});

	function calcularTotalIva(){

		var iva = parseFloat(total_general) * .16;
		var total_iva = parseFloat(iva) + parseFloat(total_general);

		$('#iva').val(iva);
		$('#iva_label').text('$ '+iva.toLocaleString());

		$('#total_iva').val(total_iva);
		$('#total_iva_label').text('$ '+total_iva.toLocaleString());

		//ENVIO ASINCRONO DEL FORMULARIO PARA NO PERDER DATOS SI NO LE PRESIONAN EN GUARDAR
		/*$.post('{{url('/cotizaciones/'.$cotizacionGeneral->id.'/actualizarCotizacion')}}', 
				$('#formCreate').serialize());*/
	}

	function guardarFormulario(){
		$.post('{{url('/cotizaciones/'.$cotizacionGeneral->id.'/actualizarCotizacion')}}', 
				$('#formCreate').serialize());
	}

	
	function calcularSubtotalGeneral(){

		ganancia_general =parseFloat(gananciaMA_GENERAL) + parseFloat(gananciaIN_GENERAL);
		subtotal_general_sin_gastos_varios = parseFloat(subtotalIN_GENERAL) + parseFloat(subtotalMO_GENERAL) + parseFloat(subtotalMA_GENERAL);

		subtotal_general = parseFloat(subtotalIN_GENERAL)+parseFloat(subtotalMO_GENERAL)+  parseFloat(subtotalMA_GENERAL);
		//alert('Ganancia General; '+ganancia_general);
		//alert('subtotal general;'+subtotal_general+', subtotal MO '+subtotalMO_GENERAL+', subtotal MA; ' + subtotalMA_GENERAL+', subtotal IN;' + subtotalIN_GENERAL)

		$('#total_material_vista_general').text('$ '+parseFloat(totalMA_GENERAL).toLocaleString());
		total_general = parseFloat(totalMO_GENERAL) + parseFloat(totalMA_GENERAL) + parseFloat(totalIN_GENERAL) + parseFloat(gastos_varios_general);

		$('#subtotal_general').val(subtotal_general);
		$('#subtotal_general_label').text('$ '+subtotal_general.toLocaleString());

		$('#ganancia_general').val(ganancia_general);
		$('#ganancia_general_label').text('$ '+ganancia_general.toLocaleString());

		$('#total_general').val(total_general);
		$('#total_general_label').text('$ '+total_general.toLocaleString());
		$('#total_insumos_vista_general').text('$ '+totalIN_GENERAL.toLocaleString());

		calcularTotalIva();
	}

	function calcularInsumoTotal(id){
		var porcent = $('#insumo_ganancia_'+id).val();
		var costo = $('#insumo_costo_'+id).val();
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

        gananciaIN_GENERAL = parseFloat(totalIN_GENERAL) - parseFloat(subtotalIN_GENERAL);

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
        
        calcularGastosVarios();

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

        gananciaIN_GENERAL = parseFloat(totalIN_GENERAL) - parseFloat(subtotalIN_GENERAL);

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
        
        subtotal = (parseFloat(cantidad) * parseFloat(costo));
        if(isNaN(subtotal)){
        	subtotal = 0;
        }



        var ganancia = parseFloat(subtotal) * parseFloat(preGanancia);
        total = (parseFloat(subtotal) + parseFloat(ganancia));

        if(isNaN(total)){
			total = 0;
		}

        $('#material_subtotal_'+id).val(subtotal);
        $('#material_subtotal_'+id+'_label').text('$ '+parseFloat(subtotal).toLocaleString());

        $('#material_total_'+id).val(total);
        $('#material_total_'+id+'_label').text('$ '+parseFloat(total).toLocaleString());

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
        gananciaMA_GENERAL = parseFloat(totalMA_GENERAL) - parseFloat(subtotalMA_GENERAL);

        //alert('Ganancia Material general: '+gananciaMA_GENERAL);
        //alert('TOTAL Material general: '+gananciaMA_GENERAL);
        
        $('#total_material').val(totalMA_GENERAL);
        $('#total_material_label').text('$ '+totalMA_GENERAL.toLocaleString());
        $('#total_material_vista_general').text('$ '+parseFloat(totalMA_GENERAL).toLocaleString());

        $('#subtotal_material').val(subtotalMA_GENERAL);
        $('#subtotal_material_label').text('$ '+parseFloat(subtotalMA_GENERAL).toLocaleString());

        $('#ganancia_material').val(gananciaMA_GENERAL);
        $('#ganancia_material_label').text('$ '+gananciaMA_GENERAL.toLocaleString());
        calcularSubtotalGeneral();
        calcularGastosVarios();
        calcularSubtotalGeneral();

	}

	function calcularGastosVarios(){

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
		gastos_varios_general = parseFloat(totalAdmon) + parseFloat(totalHerramienta) + parseFloat(totalMantenimiento) + parseFloat(totalSeguridad);
		$('#gastos_varios_general').val(gastos_varios_general);
		$('#gastos_varios_general_label').text('$ '+gastos_varios_general.toLocaleString());

		$('#gastos_total').val(gastos_varios_general);
		$('#gastos_total_label').text('$ '+gastos_varios_general.toLocaleString());
		$('#total_gastos_varios_vista_general').text('$ '+gastos_varios_general.toLocaleString());
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


	function isNumberKey(evt){
	    var charCode = (evt.which) ? evt.which : event.keyCode
	    if (charCode > 31 && (charCode < 48 || charCode > 57)){
	    	$("#soloNumerosAlert").fadeTo(2000, 500).slideUp(500, function(){
			    $("#soloNumerosAlert").slideUp(500);
			});
	        return false;
	    }
	    return true;
	}
	

	function dontAllowEnter(event){
		//alert('si entra, evento: '+event.keyCode);
		if (event.keyCode == 13) {
			//$("#saltoLineaAlert").attr("hidden",false);
			$("#saltoLineaAlert").fadeTo(2000, 500).slideUp(500, function(){
			    $("#saltoLineaAlert").slideUp(500);
			});
			//$("#saltoLineaAlert").attr("hidden",true);
			return false;
		}
		return true;
	}

   		


	function isNumberKeyDecimal(evt){
	    var charCode = (evt.which) ? evt.which : event.keyCode
	    if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57))){
	    	$("#soloNumerosAlert").fadeTo(2000, 500).slideUp(500, function(){
			    $("#soloNumerosAlert").slideUp(500);
			});
	        return false;
	    }
	    return true;
	}


	function checkCostoNull(input,counter){

		//alert(input+'(input)'+counter+'(counter)');
		var material_nombre =  $('#'+input).val();
		if(material_nombre==''){
        	material_nombre = 'Nombre de Material';
        	$('#'+input).val(material_nombre);
        }

		if($('#'+'material_cantidad_'+counter).val() == '')
			$('#'+'material_cantidad_'+counter).val('0');
		
		if ($('#'+'material_costounitario_'+counter).val() == '') 
			$('#'+'material_costounitario_'+counter).val('0');		
		

	  		/*if($(this).val($(this).val().replace(/[\r\n\v]+/g, ''))){
	  			$("#buttonAlert").addClass('show') 
	  		}*/
		
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




	function guardarDatosAutomaticamente(){

	}



</script>
@stop