
@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Perfil del Cliente</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{route('clishow')}}">Clientes</a></li>
              <li class="breadcrumb-item">Perfil del Cliente</li>
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
            <img class="profile-user-img img-fluid img-circle" src="{{ asset('uploads/Clientes/'.$cliente->clave_cliente.'/'.$cliente->foto_cliente) }}" alt="User profile picture">
          </div>

          <h3 class="profile-username text-center">{{ $cliente->nombre_cliente }}</h3>

          <p class="text-muted text-center">{{ $cliente->giro }}</p>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>Proyectos</b> <a class="float-right">1,322</a>
            </li>
            <li class="list-group-item">
              <b>Proyectos en proceso</b> <a class="float-right">543</a>
            </li>
          </ul>
          <a href="{{ URL('/cliente/'.$cliente->id.'/editarCliente') }}" class="btn btn-primary btn-block">
            <b>Editar información</b>
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
          <strong><i class="fas fa-book mr-1"></i> Razón social</strong>

          <p class="text-muted">
            {{ $cliente->razon_social}}
          </p>

          <hr>

          <strong><i class="fas fa-map-marker-alt mr-1"></i> Dirección</strong>

          <p class="text-muted">{{ $cliente->direccion }}</p>
          <p class="text-muted">CP {{ $cliente->codigo_postal }}</p>
          
          <hr>
          <strong><i class="far fa-file-alt mr-1"></i> RFC</strong>

          <p class="text-muted">{{ $cliente->rfc}}</p>
          <hr>
          <strong><i class="fas fa-phone"></i> Telefono</strong>
          <p class="text-muted">{{ $cliente->tel_oficinas}}</p>


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
            <li class="nav-item"><a class="nav-link active" href="#proyectos" data-toggle="tab">Proyectos</a></li>
            <li class="nav-item"><a class="nav-link" href="#contactos" data-toggle="tab">Contactos</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="proyectos">
              <div class="card">
                <div class="card-body p-0">
                  <table class="table table-striped projects">
                      <thead>

                          <tr>
                              <th style="width: 1%">
                                  #
                              </th>
                              <th style="width: 40%">
                                  Nombre del proyecto
                              </th>
                              <th>
                                  Progreso del proyecto
                              </th>
                              <th style="width: 8%" class="text-center">
                                  Status
                              </th>
                              <th style="width: 8%" class="text-center">
                                  Cotizado
                              </th>
                              <th style="width: 12%">
                              </th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($trabajos as $id => $trabajo)
                          <tr>
                              <td>
                                  {{ $loop->index }}
                              </td>
                              <td>
                                  <a>
                                      {{ $trabajo->nombre_trabajo }}
                                  </a>
                                  <br>
                                  <small>
                                      {{ $trabajo->fecha_alternativa }}
                                  </small>
                              </td>
                              <td>
                                  <div class="progress progress-sm">
                                      <div class="progress-bar bg-green" role="progressbar" aria-volumenow="57" aria-volumemin="0" aria-volumemax="100" style="width: 57%">
                                      </div>
                                  </div>
                                  <small>
                                      57% Completado
                                  </small>
                              </td>
                              <td class="project-state">

                                  <span class="badge badge-success">{{ $trabajo->status }}</span>

                              </td>
                              <td class="project-state">

                                  {{ $trabajo->cotizado }}

                              </td>
                              <td class=" text-right">
                                  <a class="btn btn-flat btn-primary btn-sm" href="{{url('/cotizaciones/'.$trabajo->id.'/cotizacionesProyecto')}}">
                                      <i class="fas fa-folder">
                                      </i>
                                      Cotizaciones
                                  </a>
                              </td>
                          </tr>
                        @endforeach
                      </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>

             
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="contactos">
              
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
@stop