@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Articulos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{URL('/almacen/show')}}">Almacen</a></li>
              <li class="breadcrumb-item">Articulos</li>
            </ol>
          </div>
        </div>
      </div>
@stop

@section('content')
  <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="card-title">
                  
                </div>

                <div class="card-tools">
                  <a href="{{route('artCrear')}}" class="btn btn-flat btn-default"><i class="fas fa-plus mr-2"></i>Agregar</a>
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10%">Numero de Parte</th>
                      <th style="width: 15%">Descripción</th>
                      <th>Marca</th>
                      <th>Categoria</th>
                      <th>Tipo</th>
                      <th>Unidad de Medida</th>
                      <th style="width: 5%">Existencia</th>
                      <th style="width: 8%">Ext. Minima</th>
                      <th style="width: 4%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @if($articulos->isEmpty())
                      <h5>No se encontraron resultados</h3>
                    @endif
                    @foreach($articulos as $articulo)
                        <tr>
                          <td>{{ $articulo->numero_parte }}</td>
                          <td>{{ $articulo->descripcion }}</td>
                          <td>{{ $articulo->marca}}</td>
                          <td>{{ $articulo->categoria }}</td>
                          <td>{{ $articulo->tipo }}</td>
                          <td>{{ $articulo->unidad_medida }}</td>
                          <td>{{ $articulo->existencia }}</td>
                          <td>{{ $articulo->minimo }}</td>
                          <td>
                            <div class="btn-group">
                              <a class="btn btn-flat btn-info" href="{{URL('articulo/'.$articulo->id.'/perfilArticulo')}}" style="text-decoration:none;"><i class="far fa-eye"></i></a>
                              <a class="btn btn-flat btn-danger" href="{{URL('articulo/'.$articulo->id.'/perfilArticulo')}}" style="text-decoration:none;"><i class="fas fa-trash-alt"></i></a>
                            </div>
                          </th>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

    


@stop