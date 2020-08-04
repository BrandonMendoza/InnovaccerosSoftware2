@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Inventario de Materiales y Accesorios</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="{{URL('/home')}}">Inicio</a></li>
              <li class="breadcrumb-item">Inventario de Materiales y Accesorios</li>
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
          <button class="btn btn-flat btn-default" onclick="agregarForm();" data-toggle="modal" data-target="#modalForm">
            <i class="fas fa-plus mr-2"></i>
            Agregar
          </button>
        </div>

      </div>
      
      <div class="card-body">
        <div class="overlay-wrapper">
        <table id="tablaPrincipal" class="table table-hover dt-responsive nowrap projects ">
          <thead>
            <tr>
              <th>#</th>
              <th hidden>StatusColor</th>
              <th>Status</th>
              <th>Num de Parte</th>
              <th>Descripción</th>
              <th data-orderable="false">Cant</th>
              <th>Acero</th>
              <th>Tba</th>
              <th>Heat Number</th>
              <th>Cliente</th>
              <th>Proyecto(Cliente)</th>
              <th>Alm</th>
              <th>Loc</th>
              <th>Peso</th>
              <th>Item</th>
              <th>Orden de Trabajo</th>
              <th>Plan de corte</th>
              
              <th data-orderable="false"></th>
            </tr>
          </thead>
          <tbody > 
    
            @foreach($inventariosMateriales as $id => $inventarioMateriales)
              <tr>
                <td>{{ $inventarioMateriales->id }}</td>
                <td hidden>{{ $inventarioMateriales->Status->color }}</td>
                <td>
                  <div style="padding-bottom: 0;">{{ $inventarioMateriales->Status->nombre }}</div>
                  @if($inventarioMateriales->recibido_el != null)
                    <small>{{ \Carbon\Carbon::parse($inventarioMateriales->recibido_el)->format('Y-m-d')}}</small>
                  @endif
                </td>
                <td>{{ $inventarioMateriales->Material_cliente->numero_parte }}</td>
                <td>{{ $inventarioMateriales->Material_cliente->getNombreMaterialAccesorio() }}</td>
                <td style="text-align: center;">{{ $inventarioMateriales->cantidad }}</td>
                <td>{{ $inventarioMateriales->Material_cliente->getAcero() }}</td>
                <td>{{ $inventarioMateriales->tba }}</td>
                <td>{{ $inventarioMateriales->heat_number }}</td>
                <td>{{ $inventarioMateriales->Cliente->nombre_cliente }}</td>
                <td>{{ $inventarioMateriales->proyecto }}</td>
                <td>{{ $inventarioMateriales->Material_cliente->almacen }}</td>
                <td>{{ $inventarioMateriales->Material_cliente->locacion_almacen }}</td>
                <td>{{ $inventarioMateriales->getPesoMaterial() }}</td>
                <td>{{ $inventarioMateriales->item }}</td>
                <td>{{ $inventarioMateriales->work_order }}</td>
                <td>{{ $inventarioMateriales->plan_corte }}</td>
                
                <td style="text-align: right;">
                  <div class="btn-group">
                    <button class="btn btn-flat btn-info" 
                      onclick="editarForm({{$inventarioMateriales->id.','
                                            .$inventarioMateriales->Cliente->id.','
                                            .$inventarioMateriales->Material_cliente->id.','
                                            .$inventarioMateriales->status_id.',"'
                                            .$inventarioMateriales->proyecto.'","'
                                            .$inventarioMateriales->tba.'",'
                                            .$inventarioMateriales->cantidad.',"'
                                            .$inventarioMateriales->item.'","'
                                            .$inventarioMateriales->work_order.'","'
                                            .$inventarioMateriales->plan_corte.'","'
                                            .$inventarioMateriales->heat_number.'","'
                                            .$inventarioMateriales->recibido_el.'",'
                                            .$inventarioMateriales->Material_cliente->catalogo.','
                                            .($loop->index+1) }});">
                      <i class="far fa-edit"></i>
                    </button>

                    <button class="btn btn-flat btn-danger"  data-toggle="modal" 
                      data-target="#modalEliminar" onclick="eliminarForm({{$inventarioMateriales->id}});">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
          <div id="tablaOverlay" class="overlay">
            <i class="fas fa-3x fa-sync-alt fa-spin"></i> <br>
            <div class="text-bold pt-2">Cargando...</div>
          </div>
        </div>
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
        Estás seguro que deseas <b> Eliminar Material del inventario?</b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-flat btn-outline-light" data-dismiss="modal">
        <i class="fas fa-window-close mr-2"></i>Cancelar
      </button>
        <button type="button" class="btn btn-flat btn-outline-light" onclick="eliminarInventarioMaterial();">
            <i class="fas fa-trash-alt mr-2" ></i>Eliminar 
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->  
<form id="formInventariosMateriales" method="POST" action="{{URL('/inventariosMateriales/insert/')}}" enctype="multipart/form-data">
  {{csrf_field()}}
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="overlay-wrapper">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="modalTitleForm">Inventario de Materiales - Agregar</h5>
        <button type="button" onclick="cerrarModal();" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- CUERPO DE MODAL AGREGAR-->
        <input type="text" name="id" id="id" value="0" hidden>
        <input type="text" name="recibido_el" id="recibido_el" value="" hidden>
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="status_id">Status</label>
              <select class="form-control custom-select" id="status_id" name="status_id">
                @foreach($statusInventariosMateriales as $id => $statusInventarioMaterial)
                  <option value="{{ $statusInventarioMaterial->id}}" 
                        style="color: {{ $statusInventarioMaterial->color }}" >
                    {{ $statusInventarioMaterial->nombre }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="catalogo">Categoria</label>
              <select class="form-control custom-select" id="catalogo" name="catalogo" onchange="cargarMateriales();">
                <option value="1"> Material </option>
                <option value="2"> Accesorio </option>
              </select>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="cliente_id">Cliente</label>
              <select class="form-control custom-select select2Form" id="cliente_id" name="cliente_id" onchange="cargarMateriales();">
                <option value=""></option>
                @foreach($clientes as $id => $cliente)
                  <option value="{{ $cliente->id }}" >
                    {{ $cliente->nombre_cliente}}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="material_cliente_id">Material</label>
              <select class="form-control custom-select select2Form" id="material_cliente_id" name="material_cliente_id">
                <option value=""></option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="almacen">Cantidad</label>
              <input  type="number" min="0" class="justNumber no-spinners form-control" id="cantidad" name="cantidad" value="">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="tba">Tba</label>
              <input  type="text" class="form-control" id="tba" name="tba" value="">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="heat_number">Heat Number</label>
              <input  type="text" class="form-control" id="heat_number" name="heat_number" value="">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="almacen">Orden de Trabajo</label>
              <input  type="text" class="form-control" id="work_order" name="work_order" value="">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="locacion_almacen">Item</label>
              <input  type="text" class="form-control" id="item" name="item" value="">
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="almacen">Proyecto</label>
              <input  type="text" class="form-control" id="proyecto" name="proyecto" value="">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="locacion_almacen">Plan de Corte</label>
              <input  type="text" class="form-control" id="plan_corte" name="plan_corte" value="">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" onclick="cerrarModal();" class="btn btn-flat btn-danger mr-auto" data-dismiss="modal">
        <i class="fas fa-window-close mr-2"></i>Cancelar
        </button>
        <button class="btn btn-flat btn-success">
          <i class="fas fa-check-square mr-2"></i><span id="textFormInventariosMateriales">Asignar</span>
        </button>
      </div>
    </div>
     <div id="modalFormOverlay" class="overlay">
        <i class="fas fa-3x fa-sync-alt fa-spin"></i> <br>
        <div class="text-bold pt-2">Cargando...</div>
      </div>
    </div>
  </div>

</div>

</form> 

@stop

@section('scripts')

  <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2-bootstrap4.css') }}">
  <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>

  <script>  
    var table; //tabla principal de asignaciones
    var filaSeleccionada;
    var idSeleccionado;
    var materialClienteId = 0;
    var toastrMensaje = 'Asignado correctamente.';
    $("#modalFormOverlay").hide();
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    /* Funcino para dar acceso a los otros usuarios a modificar el registro*/
    function cerrarModal() {
      $("#modalFormOverlay").show();
      var id = $("#id").val();
      console.log("Id Modal");
      console.log(id);
      if(id != 0){
        editando(id,0,'{!! URL::to('/inventariosMateriales/editando/') !!}');
        $("#id").val(0);
      }
      $("#modalFormOverlay").hide();
    }

    window.onbeforeunload = function() {
      var id = $("#id").val();
      if(id != 0){
        editando(id,0,'{!! URL::to('/inventariosMateriales/editando/') !!}');
      }
    };


    /* Funcion para obtener el nombre dependiendo si es material o accesorio*/
    function getPesoMaterial(inventarioMaterial)
    {
      var pesoUnitario;
      var pesoTotal;
      if(inventarioMaterial.material_cliente.catalogo == 1){
        pesoUnitario = inventarioMaterial.material_cliente.material.peso_kg;
      }else{
        pesoUnitario = inventarioMaterial.material_cliente.accesorio.peso_kg;
      }
      pesoTotal =  parseFloat(pesoUnitario)*parseFloat(inventarioMaterial.cantidad);
      return pesoTotal;
    }

    function getAcero(materialCliente)
    {
      var nombreAcero;
      if(materialCliente.catalogo == 1){
          nombreAcero = materialCliente.material.acero.nombre;
      }else{
          nombreAcero = materialCliente.accesorio.acero.nombre;
      }
      return nombreAcero;
    }

    function getNombreMaterial(material){
      var nombre_material_medida = material.tipo_material.simbolo+'-'+material.medida_1+'x'+material.medida_2;
      //checar si hay medida 3
      if(material.medida_3 != null){
        nombre_material_medida += 'x'+material.medida_3;
      }
      //checar si hay medida4
      if(material.medida_4 != null){
        nombre_material_medida += 'x'+material.medida_4;
      }
      return nombre_material_medida;
    }
   

    function eliminarForm(id){
      idSeleccionado = id;
      toastrMensaje = 'Eliminado correctamente.';
    } 

    function eliminarInventarioMaterial(){
      Pace.restart(); 

      $("#tablaOverlay").show();
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      $.ajax({
            type: "POST",
            url: '{!! URL::to('/inventariosMateriales/delete') !!}',
            data: {'id':idSeleccionado}, // serializes the form's elements.
            success: function(inventariosMateriales){
              //Limpiar tabla
              table.clear().draw();
              //actualizar tabla
              updateTable(inventariosMateriales);
              //se envia notificacion
              toastr.success(toastrMensaje);
              //se limpia el form
              $("#tablaOverlay").hide();
            },
            error: function (mensaje) {
              console.log('Ha ocurrido un error.');
              console.log(mensaje);
              toastr.error('Hubo un error al eliminar.');
              Pace.stop();
              $("#tablaOverlay").hide();
            },
      });
      $('#modalEliminar').modal('hide');
    }

    function editarForm(id,cliente_id,material_cliente_id,status_id,proyecto,tba
                        ,cantidad,item,work_order,plan_corte,heat_number,recibido_el,catalogo,row){
      $("#tablaOverlay").show();
      $("#catalogo").val(catalogo).change();
      $("#material_cliente_id").val("").change();
      $("#cliente_id").val(cliente_id).change();
      $("#status_id").val(status_id).change();
      $("#proyecto").val(proyecto);
      $("#tba").val(tba);
      $("#cantidad").val(cantidad);
      $("#item").val(item);
      $("#work_order").val(work_order);
      $("#plan_corte").val(plan_corte);
      $("#heat_number").val(heat_number);
      $("#recibido_el").val(recibido_el);

      $(".select2Form#material_cliente_id").prop("disabled", true);

      materialClienteId = material_cliente_id;
      filaSeleccionada = row;
      idSeleccionado = id;

      toastrMensaje = 'Guardado correctamente.';
      $("#textFormInventariosMateriales").text('Guardar');
      $("#modalTitleForm").text("Inventario de Materiales - Editar");

      /*Validar que ese registro to este siendo editado por otro usuario*/
      var url = '{!! URL::to('/inventariosMateriales/editando/') !!}';
      if(editando(id,1,'{!! URL::to('/inventariosMateriales/editando/') !!}') != 1){
        console.log("Id Seleccionado");
        console.log(id);
        toastr.error('<button type="button" class="btn btn-sm btn-flat btn-outline-light" onclick="editando('+id+',0,\''+url+'\')">Forzar Edicion</button>','Editando por otro usuario.');
      }else{
        $("#id").val(id);
        $('#modalForm').modal({backdrop: 'static',keyboard: false});
      }
      $("#tablaOverlay").hide();

    }

    

    function agregarForm(){
      $('#formInventariosMateriales').trigger("reset");
      $("#textFormInventariosMateriales").text('Agregar');
      $(".select2Form#material_cliente_id").prop("disabled", true);
      $("#cliente_id").val("").change();
      $("#material_cliente_id").val("").change();
      idSeleccionado = 0;
      materialClienteId = 0;
      toastrMensaje = 'Agregado correctamente.';
      $("#modalTitleForm").text("Inventario de Materiales - Agregar");
    }


    function updateTable(inventariosMateriales){
      var nombre_material_medida;
      var pesoTotal;


      inventariosMateriales.forEach( function(inventarioMaterial, indice, array) {
        //validacion para evitar que haya 'null' en las celdas de la tabla principal
        Object.keys(inventarioMaterial).forEach(function(key,value) {
            if(key == 'proyecto' || key == 'tba' || key == 'item' || key == 'work_order' || key == 'plan_corte' || key == 'heat_number' || key == 'recibido_el'){
              if(inventarioMaterial[key] == null){ 
                inventarioMaterial[key] = "";
              }
            }
        });
        //aqui se genera la funcion con los parametros necesarios para la funcion edit en la tabla
        var funcion = 'editarForm('+inventarioMaterial.id+','+inventarioMaterial.cliente_id+','+inventarioMaterial.material_cliente.id+','+inventarioMaterial.status_id+',\''+inventarioMaterial.proyecto+'\',\''+inventarioMaterial.tba+'\','+inventarioMaterial.cantidad+',\''+inventarioMaterial.item+'\',\''+inventarioMaterial.work_order+'\',\''+inventarioMaterial.plan_corte+'\',\''+inventarioMaterial.heat_number+'\',\''+inventarioMaterial.recibido_el+'\','+inventarioMaterial.material_cliente.catalogo+','+indice+');';

        //obtener nombre completo del material
        nombre_material_medida = getNombreMaterialAccesorio(inventarioMaterial.material_cliente);
        //obtener peso total del material
        pesoTotal = getPesoMaterial(inventarioMaterial);

        //obtener nombre de acero
        var nombreAcero = getAcero(inventarioMaterial.material_cliente);
        //Se formatea la fecha
        var recibido_el;
        if(inventarioMaterial.recibido_el != "" && inventarioMaterial.recibido_el != null){
           
          var mydate = new Date(inventarioMaterial.recibido_el);
          var fecha = mydate.toISOString().split('T')[0];

          recibido_el = fecha
        }else{
          recibido_el = "";
        }
       
        //se agrega la fila a la tabla
        table.row.add([
                inventarioMaterial.id,
                ''+inventarioMaterial.status.color,
                '<div>'+inventarioMaterial.status.nombre+'</div><small>'+
                recibido_el+'</small>',
                ''+inventarioMaterial.material_cliente.numero_parte,
                ''+nombre_material_medida,
                ''+inventarioMaterial.cantidad,
                ''+nombreAcero,
                ''+inventarioMaterial.tba,
                ''+inventarioMaterial.heat_number,
                ''+inventarioMaterial.cliente.nombre_cliente,
                ''+inventarioMaterial.proyecto,
                ''+inventarioMaterial.material_cliente.almacen,
                ''+inventarioMaterial.material_cliente.locacion_almacen,
                ''+pesoTotal,
                ''+inventarioMaterial.item,
                ''+inventarioMaterial.work_order,
                ''+inventarioMaterial.plan_corte,
                '<div class="btn-group"><button class="btn btn-flat btn-info" onclick="'+funcion+'"><i class="far fa-edit"></i></button> <button class="btn btn-flat btn-danger" data-toggle="modal" data-target="#modalEliminar" onclick="eliminarForm('+inventarioMaterial.id+');"><i class="fas fa-trash-alt"></i></button>'
          ]).draw( false );
      });
    }

    function cargarMateriales(){
      var cliente_id = $("#cliente_id").val();
      var catalogo = $("#catalogo").val();
      var nombre_material_medida;
      Pace.restart();
      $("#modalFormOverlay").show();
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      if(cliente_id != 0 ){
        $.ajax({
              type: "POST",
              url: '{!! URL::to('/materialesClientes/getMaterialesClientesByCatalogoCliente') !!}',
              data: {'cliente_id':cliente_id,'catalogo':catalogo},
              success: function(materialesClientes){
                actualizarSelectMaterialPorCliente(materialesClientes,cliente_id);
                $("#material_cliente_id").val(materialClienteId).change();
                //$(".select2Form#material_cliente_id").prop("disabled", false);
                $("#modalFormOverlay").hide();
                Pace.stop();
              },
              error: function (data) {
                console.log('Ha ocurrido un error.');
                console.log(data);
                toastr.error('Hubo un error obteniendo materiales.');
                $("#modalFormOverlay").hide();
                Pace.stop();
                $("#tablaPrincipal_processing").hide();
              },
        });
      }else{
        $("#modalFormOverlay").hide();
        Pace.stop();
      }
    }

    function actualizarSelectMaterialPorCliente(materialesClientes,cliente_id){
      //limpiamos el select
      $('.select2Form#material_cliente_id').empty();
      if(materialesClientes.length == 0){
        //deshabilitamos el select y seleccionamos el dato vacio
        $(".select2Form#material_cliente_id").prop("disabled", true);
        //$("#material_cliente_id").val("").change();
        //si esta vacio no mandamos el mensaje
        if(cliente_id != null && cliente_id != ""){
          $(".select2Form#material_cliente_id").prop("disabled", false);
          toastr.error('Cliente sin materiales asignados.');
        }
      }else{
        materialesClientes.forEach( function(materialCliente, indice, array) { 
          //obtenemos nombre completo del material
          nombre_material_medida = getNombreMaterialAccesorio(materialCliente);
          //agregamos el option en el select
          var optionMaterial = new Option(nombre_material_medida, materialCliente.id, true, true);
          $('.select2Form#material_cliente_id').append(optionMaterial);
        });
        //habilitamos select material y seleccionamos dato vacio
        $(".select2Form#material_cliente_id").prop("disabled", false);
        $("#material_cliente_id").val(0).change();
      }
    }

    /* Funcion para obtener el nombre dependiendo si es material o accesorio*/
    function getNombreMaterialAccesorio(materialCliente)
    {
      var nombre;
      if(materialCliente.catalogo == 1){
        nombre = getNombreMaterial(materialCliente.material);
      }else{
        nombre = materialCliente.accesorio.descripcion;
      }
      return nombre;
    }
    

    $(document).ready(function () { 

      $( "#formInventariosMateriales" ).validate({
        rules: {
          status_id: {
              required: true
          },
          cliente_id: {
              required: true
          },
          material_cliente_id: {
              required: true
          },
          cantidad: {
              required: true
          }
        },
        messages: {
          status_id: 'selecciona un status',
          cliente_id: 'selecciona un cliente',
          material_cliente_id: 'selecciona un material',
          cantidad: 'ingresa una cantidad en numero',
        },
          errorElement: 'span',
        errorPlacement: function (error, element) {
              error.addClass('invalid-feedback');
              element.closest('.form-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
          },
          submitHandler: function (form) {
              // form validates so do the ajax
              $("#modalFormOverlay").show();
              Pace.restart();
              var form = $(form);
              var url = form.attr('action');
              $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(inventariosMateriales){
                      //si el request es enviado correctamente se agrega la fila
                      //Limpiar tabla
                      table.clear().draw();
                      //actualizar tabla
                      console.log("INVENTARIO DE MATERIALES");
                      console.log(inventariosMateriales);
                      updateTable(inventariosMateriales);
                      //se envia notificacion
                      toastr.success(toastrMensaje);
                      //se limpia el form
                      $('#formMaterialesClientes').trigger("reset");
                      Pace.stop();
                      $("#modalFormOverlay").hide();

                    },
                    error: function (data) {
                      console.log('Ha ocurrido un error.');
                      console.log(data);
                      toastr.error('Hubo un error en la asignación.');
                      Pace.stop();
                      $("#modalFormOverlay").hide();
                    },
              });
              $('#modalForm').modal('hide');
          }
      });


      $('.select2Form').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        allowClear: true,
        placeholder: {
          id: "",
          text:"",
          selected:'selected'
        },
      });

      table = $('#tablaPrincipal').DataTable({
                "columnDefs": [
                    {
                        "targets": [ 1 ],
                        "visible": false,
                        "searchable": false
                    },
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ],
                "processing": true,
                "order": [[ 0, "desc" ]],
                 "createdRow": function ( row, data, index ) {
                    //columna de botones
                    $('td', row).eq(16).addClass('text-right');
                    //Columna de status
                    $('td', row).eq(1).css('text-align','center');
                    $('td', row).eq(1).css('background-color',data[1]);
                    $('td', row).eq(1).css('font-weight','bold');
                    //columna Num parte
                    //$('td', row).eq(2).css('background-color',data[1]);
                    $('td', row).eq(2).css('font-weight','bold');
                    //columna cantidad
                    //$('td', row).eq(3).css('background-color',data[1]);
                    $('td', row).eq(3).css('font-weight','bold');
                    //columna cantidad
                    $('td', row).eq(4).css('text-align','center');
                    //$('td', row).eq(4).css('background-color',data[1]);
                    $('td', row).eq(4).css('font-weight','bold');
                },
                "paging": true,
                "searching": true,
                "ordering": true,
                "serverSide": false,
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
          Pace.stop();
          $("#tablaOverlay").hide();
      });


      
  </script>


@stop