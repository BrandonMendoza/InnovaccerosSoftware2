@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Historial de Movimientos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              	<li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
		        <li class="breadcrumb-item"><a href="{{URL('/almacen/show')}}">Almacen</a></li>
		        <li class="breadcrumb-item">Historial de Movimientos de Almacen</li>
            </ol>
          </div>
        </div>
      </div>
@stop

@section('content')
    
  	<tbody >

		<form action="{{URL('historialAlmacenFiltro')}}">
		    <div class="form-group">
		      <div class="form-row">
		        
				<div class="col-4">
					<select class="form-control custom-select" name="empleado">
		              <option value="0" selected="true">-Todos los Empleados-</option>
		              @foreach($empleados as $empleado)
						<option value="{{ $empleado->id }}">{{ $empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2.' - '.$empleado->clave }}</option>
		              @endforeach	          
					</select>
		        </div>

		        <div class="col-2">
		          <select class="form-control custom-select" id="tiposFiltro" name="tipo">
		              <option value="0" selected="true">-Cualquier Tipo-</option>
		              <option value="Entrada">Entrada</option>
		              <option value="Salida">Salida</option>
		          </select>
		        </div>

		        <div class="col-2">
		           <button  type="submit" class="btn btn-light">Buscar</button>
		        </div>
		        <div class="form-group">
		          
		        </div>
		      </div>
		    </div>
		  </form>

		<div class="row">
    	<div class="col-md-12">
    		<div class="table-responsive">
    			<table class="table table-hover">
    				<thead>
    					<tr>
							<th></th>
							<th>Empleado</th>
							<th>Fecha</th>
							<th>Hora</th>
							<th ># Articulos</th>
							<th>Tipo</th>
							<th></th>
    					</tr>
    				</thead>

    				<tbody>
    					@foreach($transacciones as $id => $transaccion)
    					
							
								<tr>
									
										<td>{{ ($transacciones->firstItem() + $id) }}</td>
										<td id="{{ $loop->index }}" onmousemove="popover(this.id, 'http://localhost:9000/uploads/DocEmpleados/'+'{{$transaccion->clave.'/'.$transaccion->foto }}',
										'empleado/'+'{{$transaccion->empleado_id}}'+'/perfil');">
											{{ ' '.$transaccion->empleado_nombre.' '.$transaccion->empleado_apellido1.' '.$transaccion->empleado_apellido2}}</td>
										<td>{{ $transaccion->fecha }}</td>
										<td>{{ $transaccion->hora }}</td>
										<td class="text-center">{{ $transaccion->cantidad_articulos }}</td>
										@if($transaccion->tipo == "Salida")
											<td class="table-danger" >{{ $transaccion->tipo }}</td>
										@else
											<td class="table-success">{{ $transaccion->tipo }}</td>
										@endif
										<td>
											<a href="{{URL('/historialAlmacen/'.$transaccion->id.'/perfilTransaccion')}}" style="text-decoration: none;">
												<p class="text-muted">Ver mas</p>
											</a>
										</td>
								</tr>
								
							
    					@endforeach
    					{{ $transacciones->links() }}

    				</tbody>
    			</table>
    		</div>
    	</div>
    </div>

 	</tbody>

@stop


@section('scripts')
  <script type="text/javascript">
    
    function popover(id,image,empleado) {
    	//alert(image);
    	var perfilEmpleado = empleado;
    	
    	var popimage = image;
    	$('#'+id).popover({
    		
	    	placement: 'top',
	    	content: function () {
    			return '<img src="'+popimage+ '" style="width:100%; height:100%;"/> <p class="lead text-muted">Ver Historial de Almacen</p>    			<a href="'+perfilEmpleado+'" style="text-decoration:none;"><p class="lead text-muted"> Ver Perfil</p> </a>';
  			},
	    	html: true
	  	});
    }
  	
	
    
  </script>

@stop