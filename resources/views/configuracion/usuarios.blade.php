@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <h1 class="m-0 text-dark">Usuario</h1>
@stop

@section('content')
	<nav aria-label="breadcrumb">
	    <ol class="breadcrumb">
	      <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
	      <li class="breadcrumb-item">Usuarios</li>
	    </ol>
	 </nav>


<div class="row">
  <h1 class="jumbotron-heading">Usuarios</h1>
</div>

 

 @if(Session::has('message')) <div class="alert alert-info"> {{Session::get('message')}} </div> @endif

<div class="row mb-4">
	<div class="col float-right" >
		<a href="/configuracion/usuario/crear" class="btn btn-outline-success float-right">
			<span class="ion-plus-round mr-2"></span>Nuevo Usuario
		</a>
	</div>
</div>

<div class="row">
	




	 @if($usuarios->isEmpty())
	    <h5>No se encontraron resultados</h3>
	 @else
	            
	            
	            
	    <div class="table-responsive">
	        <table class="table table-hover table-bordered">
	        	<thead>
		            <th>#</th>
		            <th class="text-center">Nombre</th>
		            <th class="text-center">correo</th>
		            <th class="text-center">Rol</th>
		            <th class="text-center">Empleado vinculado</th>
		            <th>Fecha de creacion</th>
		            <th>Ultima actualizacion</th>
		            <th>  </th>
		            <th></th>
	          	</thead>

	          	<tbody>
		            @foreach($usuarios as $id => $usuario)
		              <tr>
		                <td>{{ $usuario->id }}</td>
		                <td class="text-center"> {{ $usuario->name }}</td>
		                <td class="text-center"> {{ $usuario->email }}</td>
		                <td class="text-center">{{ $usuario->roles->rol }}</td>
		                <td class="text-center">
		                	@if($usuario->empleado_id)
								{{ $usuario->empleado->nombre.' '.$usuario->empleado->apellido1.' '.$usuario->empleado->apellido2 }}
							@else
								<a href="" data-target=".bd-example-modal-lg" data-toggle="modal" class="btn btn-success">Ninguno</a>
							@endif
		                </td>
		                <td class="text-center">{{ $usuario->created_at }}</td>
		                <td class="text-center">{{ $usuario->updated_at }}</td>
		                <td> <a href="{{'/configuracion/usuario/'.$usuario->id.'/getUsuario'}}"><span style="height: 100%; width: 100%;" class="btn btn-info ion-edit"></span> </td>
		            	<td><span style="height: 100%; width: 100%;" class="btn btn-danger ion-trash-a"  data-toggle="modal" data-target="{{ '#'.$loop->index.'exampleModal' }}"></span></td>
		              </tr>


		              <!-- Modal ELIMINAR-->
		                <div class="modal fade" id="{{ $loop->index.'exampleModal' }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		                  <div class="modal-dialog" role="document">
		                    <div class="modal-content">
		                      <div class="modal-header">
		                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Usuario</h5>
		                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                          <span aria-hidden="true">&times;</span>
		                        </button>
		                      </div>
		                      <div class="modal-body">
		                        Estas seguro que deseas eliminar el Usuario:  {{ $usuario->name }} ?
		                      </div>
		                      <div class="modal-footer">
		                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		                        <a href="{{'/configuracion/usuario/'.$usuario->id.'/eliminar'}}" class="btn btn-xs btn-danger"><span class="ion-close-round mr-2"></span>Eliminar</a>
		                      </div>
		                    </div>
		                  </div>
		                </div>

		                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

				      <div class="modal-dialog modal-lg">
				        <div class="modal-content">
				          <div class="modal-header">
				            <h5 class="modal-title" id="exampleModalLabel">Vincular cuenta</h5>
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
				                <div class="card-deck">

				                  @foreach($empleados as $seleccionarEmpleado)

				                  
									<div class="col-6 mt-4"  id="{{ 'selectArt'.$seleccionarEmpleado->id }}">
				                      <div class="card empleadoHover" style="width: 200px; height: 200px;" id="{{ 'emp'.$loop->index }}" onclick="empleado(this.id);">
				                      		<input type="text" id="{{ 'emp'.$loop->index.'_seleccionado' }}" value="{{ $seleccionarEmpleado->id }}" hidden>

				                            <img class="card-img-top" src="{{ asset('uploads/DocEmpleados/'.$seleccionarEmpleado->clave.'/'.$seleccionarEmpleado->foto) }}" style="height: 100%; width: 100%;">
				                          
				                          	<div class="card-body">
					                            <div class="card-block px-3">
					                              <p class="card-text jumbotron-heading text-center" id="nombreCompletoSelect">{{ $seleccionarEmpleado->nombre.' '.$seleccionarEmpleado->apellido1.' '.$seleccionarEmpleado->apellido2 }}</p>

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
				            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				            <a href="#" id="vincular" data-dismiss="modal" class="btn btn-xs btn-success">Vincular</a>
				          </div>
				        </div>
				      </div>
				    </div>

					@endforeach

				</tbody>
			</table>
		</div>
	@endif
	
</div>



@endsection

@section('scripts')

<script type="text/javascript">
	
	var selectedEmpleado;
	var loopEmpleados = parseInt({!! json_encode($empleados->count()) !!});

	
	function empleado($id){
		selectedEmpleado = $id;
		
      	for (var i = 0; i < loopEmpleados; i++) {
      		
      		if('emp'+i != $id){
      			$('#emp'+i).removeClass('border-success');
      		}
      	}
    }

    $('#vincular').click(function() {
    	$.ajaxSetup({
	        headers: {
	          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
      	});
	    '{{csrf_token()}}'



		var idSelectedEmpleado = $('#'+selectedEmpleado+'_seleccionado').val();
		var idUser = {!! json_encode(Auth::user()->id) !!}
	    $.ajax({
	    	type:'post',
	        url:'{!! URL::to('/configuracion/vincularUserEmpleado') !!}',
	        data:{'emp':idSelectedEmpleado,'user':idUser},
	        success:function() {
	        	location.reload();
	        },
	        error: function(xhr, status, error) {
			  var err = eval("(" + xhr.responseText + ")");
			  alert(err.Message);
			}

	    });        
	});

	$(document).ready(function () {
		
	    
	    $('.empleadoHover').click(function() {
	        $(this).addClass('border-success');
	    });

    });
</script>


@stop
