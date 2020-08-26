@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Materiales</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item">Materiales</li>
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
            <a href="{{route('accesoriosshow')}}" class="btn btn-flat btn-default">
              Accesorios
            </a>
            <a href="{{route('invmaterialesshow')}}" class="btn btn-flat btn-default">
              Inventario de Materiales
            </a>
            <a href="{{route('matclientesshow')}}" class="btn btn-flat btn-default">
              Materiales de Clientes
            </a>
            <a href="{{route('mattiposshow')}}" class="btn btn-flat btn-default">
              Tipos de Materiales
            </a>
            <a href="{{route('matacerosshow')}}" class="btn btn-flat btn-default">
              Tipos de Aceros
            </a>
            <a href="/material/0/Form/" class="btn btn-flat btn-default"><i class="fas fa-plus mr-2"></i>
              Agregar
            </a>
          </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
          <table id="tablaPrincipal" class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>#</th>
                <th>Numero de parte</th>
                <th>Medidas</th>
                <th>Tipo</th>
                <th>Acero</th>
                
                <th>Peso(kg)</th>
                <th data-orderable="false"></th>
              </tr>
            </thead>
            <tbody> 
              @foreach($materiales as $id => $material)
                <tr>
                  <td>  
                    {{ $loop->index+1 }}
                  </td>
                  <td>
                    {{ $material->numero_parte }}
                  </td>
                  <td>
                    {{ $material->medida_1.'x'.$material->medida_2 }}{{ $material->medida_3 ? 'x'.$material->medida_3 : '' }}{{ $material->medida_4 ? 'x'.$material->medida_4 : '' }}
                  </td>
                  <td>{{ $material->Tipo_material->nombre }}</td>
                  <td>{{ $material->Acero->nombre }}</td>
                  
                  <td>{{ $material->peso_kg }}</td>
                  <td style="text-align: right;">
                    <div class="btn-group">
                      <a class="btn btn-flat btn-info" href="{{ '/material/'.$material->id.'/Form/' }}" style="text-decoration:none;"><i class="far fa-edit"></i>
                      </a>
                      <a class="btn btn-flat btn-danger" href="" style="text-decoration:none;"><i class="fas fa-trash-alt"></i>
                      </a>
                    </div>
                  </td>
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

@section('scripts')
  <script>  
    $(document).ready(function () { 
        var table = $('#tablaPrincipal').DataTable({
                  "paging": true,
                  //"lengthChange": false,
                  "searching": true,
                  "ordering": true,
                  "info": true,
                  "autoWidth": false,
                  "responsive": true,
                  "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                      "sFirst":    "Primero",
                      "sLast":     "Último",
                      "sNext":     "Siguiente",
                      "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                  }
              });
    });
  </script>


@stop