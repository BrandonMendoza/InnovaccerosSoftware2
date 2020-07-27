@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Almacen</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
	      		<li class="breadcrumb-item">Almacen</li>
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
          	<a href="{{route('artshow')}}" class="links">
	            <div class="info-box" >
	              <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-warehouse"></i></span>
	              <div class="info-box-content">
	                <span class="info-box-text">Articulos</span>
	                <span class="info-box-number">
	                  <small>Agrega, edita o elimina Articulos</small>
	                </span>
	              </div>
	              <!-- /.info-box-content -->
	            </div>
            </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
          	<a href="{{ route('entradasshow') }}" class="links">
          	
	            <div class="info-box mb-3">
	              <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-sign-in-alt"></i></span>

	              <div class="info-box-content">
	                <span class="info-box-text">Entradas de Almacen</span>
	                <span class="info-box-number"><small>Registra la entrada de tus articulos</small></span>
	              </div>
	              <!-- /.info-box-content -->
	            </div>
	            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
          	<a href="{{route('salidasshow')}}" class="links">
	            <div class="info-box mb-3">
	              <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-sign-out-alt"></i></span>

	              <div class="info-box-content">
	                <span class="info-box-text">Salidas de Almacen</span>
	                <span class="info-box-number"><small>Registra la salida de tus articulos</small></span>
	              </div>
	              <!-- /.info-box-content -->
	            </div>
	            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
          	<a href="{{ route('histshow') }}" class="links">
	            <div class="info-box mb-3">
	              <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-history"></i></span>

	              <div class="info-box-content">
	                <span class="info-box-text">Historial de Movimientos</span>
	                <span class="info-box-number"><small>Revisa las entradas y salidas de los articulos de almacen</small></span>
	              </div>
	              <!-- /.info-box-content -->
	            </div>
	            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
          	<a href="{{ route('matshow') }}" class="links"> 
	            <div class="info-box mb-3">
	              <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-sign-in-alt"></i></span>

	              <div class="info-box-content">
	                <span class="info-box-text">Materiales</span>
	                <span class="info-box-number"><small>Agrega, edita y elimina materiales</small></span>
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