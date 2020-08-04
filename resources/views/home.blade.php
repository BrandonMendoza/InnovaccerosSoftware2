@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Inicio</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div>
@stop

@section('content')
<style type="text/css">
  .links{
    text-decoration:none; 
    color:black;
  }
</style>
  <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{route('trashow')}}" class="links">
              <div class="info-box" >
                <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-project-diagram"></i> </span>
                <div class="info-box-content">
                  <span class="info-box-text">Proyectos</span>
                  <span class="info-box-number">
                    <small>Crea y cotiza proyectos para tus clientes</small>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{route('almshow')}}" class="links">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-warehouse"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Almacen</span>
                  <span class="info-box-number"><small>Entradas de articulos, salidas de articulos, administración de articulos</small></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </a>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{route('maqshow')}}" class="links">
              <div class="info-box" >
                <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-truck-pickup"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Maquinaria y vehiculos</span>
                  <span class="info-box-number">
                    <small>Consulta tus vehiculos y maquinaria y revisa cuanto tiempo tienen sin mantenimiento</small>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{route('empshow')}}" class="links">
            
              <div class="info-box mb-3">
                <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-user-tie"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Empleados</span>
                  <span class="info-box-number"><small>Consulta trabajadores, edita sus datos, sueldos</small></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{route('clishow')}}" class="links">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Clientes</span>
                  <span class="info-box-number"><small>Agrega, elimina, y edita Clientes</small></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{route('proshow')}}" class="links"> 
              <div class="info-box mb-3">
                <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-truck-loading"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Proveedores</span>
                  <span class="info-box-number"><small>Agrega, edita y elimina proveedores</small></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3" hidden>
            <a href="{{route('nomshow')}}" class="links"> 
              <div class="info-box mb-3">
                <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-sign-in-alt"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Nomina</span>
                  <span class="info-box-number"><small>Agrega, edita y elimina proveedores</small></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3" hidden>
            <a href="{{route('ordshow')}}" class="links"> 
              <div class="info-box mb-3">
                <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-sign-in-alt"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Ordenes de compra</span>
                  <span class="info-box-number"><small></small></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
        </div>
        <div class="col-12 col-sm-6 col-md-3" >
            <a href="{{route('matshow')}}" class="links"> 
              <div class="info-box mb-3">
                <span class="info-box-icon bg-lightblue elevation-1"></span>

                <div class="info-box-content">
                  <span class="info-box-text">Materiales</span>
                  <span class="info-box-number"><small></small></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@stop
