@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Aceros</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item">Aceros</li>
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
          <div class="card-tools">
            <button class="btn btn-flat btn-default" onclick="agregarForm();" data-toggle="modal" data-target="#modalAgregar">
              <i class="fas fa-plus mr-2"></i>
              Agregar
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
          <table id="tablaPrincipal" class="table table-hover text-nowrap table-striped projects">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Simbolo</th>
                <th data-orderable="false"></th>
              </tr>
            </thead>
            <tbody> 
              @foreach($materialesAceros as $id => $materialAcero)
                <tr>
                  <td>{{ $materialAcero->id }}</td>
                  <td>{{ $materialAcero->nombre }}</td>
                  <td>{{ $materialAcero->simbolo }}</td>
                  <!-- Botones -->
                  <td style="text-align: right;">
                    <div class="btn-group">
                      <button class="btn btn-flat btn-info" 
                        onclick="editarForm({{$materialAcero->id.',"'
                                              .$materialAcero->nombre.'","'
                                              .$materialAcero->simbolo.'",'
                                              .($loop->index+1) }});" 
                        data-toggle="modal" 
                        data-target="#modalAgregar">
                        <i class="far fa-edit"></i>
                      </button>

                      <button class="btn btn-flat btn-danger" data-toggle="modal" 
                        data-target="#modalEliminar" onclick="eliminarForm({{$materialAcero->id}});">
                        <i class="fas fa-trash-alt"></i>
                      </button>
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

	<!-- Eliminar MODAL-->
  <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content bg-danger">
        <div class="modal-body">
          Estás seguro que deseas <b> Eliminar Acero?</b>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-flat btn-outline-light" data-dismiss="modal">
          <i class="fas fa-window-close mr-2"></i>Cancelar
        </button>
          <button type="button" class="btn btn-flat btn-outline-light" onclick="eliminarAcero();">
              <i class="fas fa-trash-alt mr-2" ></i>Eliminar 
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal -->  
  @include('materialesAceros.form')
  

@stop

@section('scripts')
  <script>  
    var table;
    var idSeleccionado;
    var toastrMensaje = 'Agregado correctamente.';


    function eliminarForm(id){
      idSeleccionado = id;
      toastrMensaje = 'Eliminado correctamente.';
    } 

    function eliminarAcero(){
      var url = '{!! URL::to('/materialesAceros/delete') !!}';
      eliminarFromTableAjax(idSeleccionado,url);
    }

    function updateTable(materialesAceros){
      materialesAceros.forEach( function(materialAcero, indice, array) {
        var funcion = 'editarForm('+materialAcero.id+',\''+materialAcero.nombre+'\',\''+materialAcero.simbolo+'\','+indice+');';
        table.row.add([
                ''+materialAcero.id,
                ''+materialAcero.nombre,
                ''+materialAcero.simbolo,
                '<div class="btn-group"><button class="btn btn-flat btn-info" data-toggle="modal"  data-target="#modalAgregar" onclick="'+funcion+'"><i class="far fa-edit"></i></button> <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" onclick="eliminarForm('+materialAcero.id+');"><i class="fas fa-trash-alt"></i></button>'
          ]).draw( false );
      });
    }

    function editarForm(id,nombre,simbolo,row){
      $("#id").val(id);
      $("#nombre").val(nombre);
      $("#simbolo").val(simbolo);
      filaSeleccionada = row;
      idSeleccionado = id;
      toastrMensaje = 'Guardado correctamente.';
      $("#textAgregarForm").text('Guardar');
      $("#modalFormLabel").text("Acero - Editar");
    }

    function agregarForm(){
      $('#formAgregar').trigger("reset");
      $("#textAgregarForm").text('Agregar');
      $("#modalFormLabel").text("Acero - Agregar");
      idSeleccionado = 0;
      toastrMensaje = 'Agregado correctamente.';
    }

    $("#formAgregar").validate({
      rules: {
        nombre: {required: true },
        simbolo: {required: true},
      },
      messages: { nombre: 'ingresa nombre',simbolo: 'ingresa un simbolo',},
    });
    
    $(document).ready(function () { 
      Pace.restart();
        table = $('#tablaPrincipal').DataTable({
          "paging": true, "searching": true,"ordering": true,"info": true, "autoWidth": false, "responsive": true,
          "language": { "url" : '{{ asset('vendor/datatableSpanish.js') }}', },
          "order": [[ 0, "desc" ]],
          "createdRow": function ( row, data, index ) { $('td', row).eq(3).addClass('text-right'); },
        });

        Pace.stop();
    });
  </script>


@stop