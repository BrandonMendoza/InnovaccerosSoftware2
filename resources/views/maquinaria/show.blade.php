@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Maquinaria y Vehículos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item">Maquinaria y Vehículos</li>
            </ol>
          </div>
        </div>
      </div>
@stop
@section('content')


@if(Session::has('message')) <div class="alert alert-info"> {{Session::get('message')}} </div> @endif


<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          
        </div>

        <div class="card-tools">
          <a href="/maquinaria/crear" class="btn btn-flat btn-default"><i class="fas fa-plus mr-2"></i>Agregar</a>
        </div>

      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive">
        <table id="tablaPrincipal" class="table table-hover text-nowrap table-striped projects">
          <thead>
            <tr>
              <th>#</th>
              <th data-orderable="false"></th>
              <th>Clave</th>
              <th>Categoría</th>
              <th>Marca-Modelo</th>
              <th>Color</th>
              <th>Tipo</th>
              <th>Días sin servicio</th>
              <th>Ultimo servicio</th>
              <th data-orderable="false"></th>
            </tr>
          </thead>
          <tbody> 
            @foreach($maquinarias as $maquinaria)
              <tr>
                <td>  
                  {{ $loop->index+1 }}
                </td>
                <td>
                  <ul class="list-inline">
                    <li class="list-inline-item">
                      <img alt="Avatar" class="table-avatar" data-lazysrc="{{ asset('uploads/maquinaria/'.$maquinaria->foto) }}">
                    </li>
                  </ul>
                </td>
                <td>{{ $maquinaria->clave }}</td>
                <td>{{ $maquinaria->categoria }}</td>
                <td>{{ $maquinaria->tipo }}</td>
                <td>{{ $maquinaria->marca.' '.$maquinaria->modelo}}</td>
                <td>{{ $maquinaria->color }}</td>
                <td>{{ $maquinaria->dias_sin_serv }}</td>
                <td>{{ $maquinaria->ultimo_serv }}</td>
                <td style="text-align: right;">
                  <div class="btn-group">
                    <a class="btn btn-flat btn-info" href="{{URL('maquinaria/'.$maquinaria->id.'/editar')}}" style="text-decoration:none;">
                       <i class="far fa-edit"></i>
                    </a>
                    <a class="btn btn-flat btn-danger" href="{{URL('maquinaria/'.$maquinaria->id.'/eliminar')}}" style="text-decoration:none;">
                      <i class="fas fa-trash-alt"></i>
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



@endsection


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

    function changePlaceholderBusqueda(){
      var bus = $('#busqueda').val();
      $('#parametro').attr('placeholder','Buscar por '+bus);
    }

    function differenciaDias(){
      var ultimoDiaDeServicio = {!! json_encode($maquinarias->toArray()) !!};
      var date2 = new Date("12/15/2010");
      var timeDiff = Math.abs(date2.getTime() - date1.getTime());
      var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
    }


    function populate(s1,s2){
      var cat = document.getElementById(s1);
      var tipos = document.getElementById(s2);
      tipos.innerHTML = "";
      if(cat.value == "MAQUINARIA"){
        var optionArray = ["0|-Selecciona tipo-","PLASMA|Plasma","SOLDAR|Soldar","ARCOAIR|Arcoair"];
      } else {
        if(cat.value == "VEHICULO"){
          var optionArray = ["0|-Selecciona tipo-","AUTOMOVIL|Automovil","PICKUP|Pickup","MONTACARGAS|Montacargas","ELEVADOR|Elevador","GRUA MECANICA|Grua mecanica","GRUA NORMAL | Grua normal","TROQUE|Troque"];
        }
      }
      for(var option in optionArray){
        var pair = optionArray[option].split("|");
        var newOption = document.createElement("option");
        newOption.value = pair[0];
        newOption.innerHTML = pair[1];
        tipos.options.add(newOption);
      }
    }

  </script>
@endsection