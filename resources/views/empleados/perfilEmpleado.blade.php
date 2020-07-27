
@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Perfil de Empleado</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{URL('/empleados/show')}}">Empleados</a></li>
              <li class="breadcrumb-item">Perfil {{$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}</li>
            </ol>
          </div>
        </div>
      </div>
@stop
@section('content')
<div class="row">
    <div class="col-md-3">
      <!-- Profile Image -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle" src="{{ asset('uploads/DocEmpleados/'.$empleado->clave.'/'.$empleado->foto) }}" alt="User profile picture">
          </div>

          <h3 class="profile-username text-center">
            {{ $empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2}}
          </h3>

          <p class="text-muted text-center">{{ $empleado->puesto }}</p>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <fieldset class="rating float-left">     
                <input type="radio" name="stars" id="4stars" value="4" >
                <label class="stars" for="4stars" id="4">4 stars</label>
                <input type="radio" name="stars" id="3stars" value="3" >
                <label class="stars" for="3stars" id="3">3 stars</label>
                <input type="radio" name="stars" id="2stars" value="2" >
                <label class="stars" for="2stars" id="2">2 stars</label>
                <input type="radio" name="stars" id="1stars" value="1" >
                <label class="stars" for="1stars" id="1">1 star</label>
                <input type="radio" name="stars" id="0stars" value="0" required>
                <label class="stars" for="0stars" id="0">0 star</label>
              </fieldset>
            </li>
            <li class="list-group-item">
              <b>Clave</b> <a class="float-right">{{ $empleado->clave }}</a>
            </li>
            <li class="list-group-item">
              <b>Empleado desde</b> <a class="float-right">{{$empleado->fecha_entrada }}</a>
            </li>
          </ul>
          <a class="btn btn-primary btn-block" href="{{URL('empleado/'.$empleado->id.'/editar')}}" >
            <b>Editar información</b>
          </a>
          <a class="btn btn-danger btn-block" href="" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-times-circle mr-2"></i><b>Dar de baja</b>
          </a>
          <a class="btn btn-default btn-block" href="" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-download mr-2"></i><b>Descargar Foto</b>
          </a>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

      <!-- About Me Box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Información</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <strong> <i class="fas fa-money-bill"></i>Salario semanal</strong>

          <p class="text-muted">
            {{ $empleado->salario_semanal }}
          </p>

          <hr>
          <strong><i class="fas fa-calendar-day"></i> Fecha de nacimiento</strong>
          <p class="text-muted">{{ $empleado->fecha_nac}}</p>

          <hr>
          <strong><i class="fas fa-phone"></i> Teléfono de casa</strong>
          <p class="text-muted">{{ $empleado->telefono1 }}</p>
          
          <hr>
          <strong><i class="fas fa-phone"></i> Celular</strong>
          <p class="text-muted">{{$empleado->telefono2}}</p>

          <hr>
          <strong><i class="fas fa-map-marker-alt mr-1"></i> Dirección</strong>
          <p class="text-muted">{{$empleado->direccion }}</p>
          <hr>
          <strong><i class="far fa-file-alt"></i> CURP</strong>
          <p class="text-muted">{{$empleado->curp}}</p>
          <hr>
          <strong><i class="far fa-file-alt"></i> Numero de IMSS</strong>
          <p class="text-muted">{{$empleado->num_imss }}</p>
          <hr>

          <strong><i class="far fa-file-alt"></i> RFC</strong>
          <p class="text-muted">{{$empleado->rfc }}</p>
          <hr>   

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item" hidden><a class="nav-link" href="#actividad" data-toggle="tab">Actividad</a></li>
            <li class="nav-item"><a class="nav-link active" href="#amonestaciones" data-toggle="tab">Amonestaciones</a></li>
            <li class="nav-item"><a class="nav-link" href="#deudas" data-toggle="tab">Deudas</a></li>
            <li class="nav-item"><a class="nav-link" href="#comentarios" data-toggle="tab">Comentarios</a></li>
            <li class="nav-item"><a class="nav-link" href="#documentos" data-toggle="tab">Documentos</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane" id="actividad" hidden>
              <div class="card">
                <div class="card-body p-0">
                 
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="active tab-pane" id="amonestaciones">
                <form class="float-right" action="{{'/empleado/'.$empleado->id.'/crearAmonestacion'}}">
                  <button type="submit" class="btn btn-info">Agregar Amonestacion</button>
                </form>
                @if($amonestaciones->isEmpty())
                  <h5>Este empleado aun no tiene Amonestaciones</h5>
                @else
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                      <thead>
                        <th>#</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Motivo</th>
                        <th class="text-center">Sancion</th>
                      </thead>

                      <tbody>
                         @foreach($amonestaciones as $amonestacion)
                          <tr>
                            <td class="text-center">{{$amonestacion->id}}</td>
                            <td class="text-center">{{ $amonestacion->created_at }}</td>
                            <td class="text-center">{{ $amonestacion->tipo }}</td>
                            <td class="text-center">{{ $amonestacion->motivo }}</td>
                            <td class="text-center">{{ $amonestacion->sancion }}</td>
                          </tr>                          
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif

                {{ $amonestaciones->links() }}
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="deudas">
              <form class="float-right" action="{{'/empleado/'.$empleado->id.'/crearDeuda'}}">
                <button type="submit" class="btn btn-info">Agregar Deuda</button>
              </form>
              <div hidden>
                {{ $deudas=$empleado->deudas  }}
              </div>
              @if($deudas->isEmpty())
                <h5>Este empleado aun no tiene Deudas</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                    <thead>
                      <th></th>
                      <th>Monto</th>
                      <th>Plazo</th>
                      <th>Tipo</th>
                      <th>Restante</th>
                      <th>Editar</th>
                    </thead>
                    @if($empleado->deudas->isEmpty())
                      <h5>Este empleado no tiene deudas</h5>
                    @else
                      <tbody>
                        @foreach($empleado->deudas as $id => $deuda)
                          <tr>
                            <td>{{$deuda->id}}</td>
                            <td>{{$deuda->monto}}</td>
                            <td>{{$deuda->plazo}}</td>
                            <td>{{$deuda->tipo}}</td>
                            <td>{{$deuda->restante_pagar}}</td>
                            <td><a href="{{ url('/empleado/deuda/'.$deuda->id.'/editar') }}"><span style="height: 100%; width: 100%;" class="btn btn-info ion-edit"></span></td>
                          </tr>
                        @endforeach
                      </tbody>
                    @endif
                  </table>
                  <div class="text-center">Restante Total:</div> 
                  <div class="text-danger font-weight-bold text-center"> {{ $empleado->deudas->sum('restante_pagar') }}</div>
                </div>
              @endif
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="comentarios">
              @if(Auth::user()->empleado)
                <button class="btn btn-info float-right" data-toggle="modal" data-target="#comentModal">Agregar Comentario</button>
              @endif

            @if($comentarios->isEmpty())
                  <h5>Este empleado aun no Tiene comentarios</h3>
            @endif
            @foreach($comentarios as $comentario)

              
              <div class="chatContainer">
                <img src="{{ asset('uploads/DocEmpleados/'.$comentario->user->empleado->clave.'/'.$comentario->user->empleado->foto) }}" alt="Avatar">
                <p>{{ $comentario->comentario }}</p>
                <span class="time-right">{{ $comentario->created_at }}</span>
              </div>

            @endforeach
            {{ $comentarios->links() }}


          <form action="{{URL('empleado/'.$empleado->id.'/comentar')}}" method="get">
            <div class="modal fade" id="comentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Comentario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Comentario: <br>
                    <textarea name="comentario" class="form-control" aria-label="With textarea" placeholder="Descripcion"  name="descripcion_trabajo" rows="10" value=""></textarea>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-xs btn-success"><span class="ion-close-round mr-2"></span>Enviar Comentario</button>
                  </div>
                </div>
              </div>
            </div>

          </form>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="documentos">
              
            <div class="card">
              @if($empleado->identificacion==null)
                <div class="card-header border-danger float-left" id="headingTwo">
              @else
                <div class="card-header border-success btn collapsed" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration:none;">
              @endif
            
                  <a class="float-left">Copia de INE</a>

              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body" id="cardINE">

                  <embed
                  src="{{ asset('uploads/DocEmpleados/'.$empleado->clave.'/'.$empleado->identificacion) }}"
                  style="width:100%; height:800px;"
                  frameborder="0"
              >
                </div>
              </div>
            </div>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div> 

<div class="col-sm-4">
	<!-- Modal ELIMINAR-->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Dar de baja Empleado</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        Se dara de baja al empleado {{ $empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2 }}
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-flat btn-secondary" data-dismiss="modal">Cancelar</button>
	        <a href="{{URL('empleado/'.$empleado->id.'/eliminar')}}" class="btn btn-flat btn-danger">
            <i class="fas fa-times-circle mr-2"></i>Aceptar
          </a>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<hr>





@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function() {
    var empleadoRate = {!! json_encode($empleado->rate) !!};
    $('#'+empleadoRate+'stars').trigger('click');
  });

  $('.stars').click(function(){

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      '{{csrf_token()}}'

      var empleado =  {!! json_encode($empleado->id) !!};
      
      var rate = $(this).attr('id');
      $.ajax({
        type:'post',
        url:'{!! URL::to('/insertarRate') !!}',
        data:{'id':empleado,'rate':rate},
        success:function() {

        },
         error: function(ts) { alert(ts.responseText) }

      });
  });



</script>


@endsection