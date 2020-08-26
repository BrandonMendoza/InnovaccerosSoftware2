

/*Funciones para calcular libras y kgs*/
function calcularKgsToLbs(){
  var kgs = $("#peso_kg").val();
  if(kgs == "")
    kgs = 0
  $("#peso_kg").val(parseFloat(kgs).toFixed(2));
  var lbs = kgs*2.2046
  $("#peso_lbs").val(lbs.toFixed(2));
  
}

function calcularLbsToKgs(){
  var lbs = $("#peso_lbs").val();
  if(lbs == "")
    lbs = 0
  $("#peso_lbs").val(parseFloat(lbs).toFixed(2));
  var kgs = lbs/2.2046
  $("#peso_kg").val(kgs.toFixed(2));
}
/* Eliminar fila en tablas
  Funciones para habilitar opcion en el select2
*/
function eliminarProd(id){
  $("#producto_select>option[value='"+id+"']").prop('disabled', !$("#producto_select>option[value='"+id+"']").prop('disabled'));
}
function eliminarAcc(id){
  $("#accsesorio_select>option[value='"+id+"']").prop('disabled', !$("#accsesorio_select>option[value='"+id+"']").prop('disabled'));
}
/*Funcion para cargar Form cuando presionamos editar en la tabla principal*/
function cargarTablasForm(url){    
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
    type: "POST",
    url: url,
    data: {'id':idSeleccionado},
    success: function(proyecto){
      //Limpiar tablas
      tablaProductos.clear().draw();
      //actualizar tablas
      updateTableForm(proyecto.productos);
      //se limpia el form
      $("#tablaOverlay").hide();
      $("#modalAgregar").modal();
      Pace.stop();
    },
    error: function (mensaje) {
      console.log('Ha ocurrido un error.');
      console.log(mensaje);
      toastr.error('Hubo un error al cargar el producto.');
      Pace.stop();
      $("#tablaOverlay").hide();
    },
  });
}

function updateTableForm(productos) {
  console.log("PRODUCTOS");
  console.log(productos);
  productos.forEach( function(producto, indice, array) {
    $("#producto_select>option[value='"+producto.id+"']").prop('disabled', !$("#producto_select>option[value='"+id+"']").prop('disabled'));
    //Add materiales
    tablaProductos.row.add([
      ''+producto.id,
      ''+producto.numero_parte,
      '<input type="text" name="prod_cant[]" value="'+producto.proyecto_producto.cantidad+'" hidden>'+producto.proyecto_producto.cantidad
      +'<input type="text" name="prod_id[]" value="'+producto.id+'" hidden>',
      '<input type="text" name="prod_item[]" value="'+producto.proyecto_producto.item+'" hidden>'+producto.proyecto_producto.item,
      '<input type="text" name="prod_work_order[]" value="'+producto.proyecto_producto.work_order+'" hidden>'+producto.proyecto_producto.work_order,
      '<input type="text" name="prod_heat_number[]" value="'+producto.proyecto_producto.heat_number+'" hidden>'+producto.proyecto_producto.heat_number,
      '<button type="button" class="btn btn-flat btn-danger btn-sm remover" onclick="eliminarProd('+producto.id+');"><i class="fas fa-trash-alt"></i></button>'
    ]).draw( false );
  });
}


/*Agregar Material*/
function agregarProd(){
  var id = $("#producto_select option:selected").val();
  var nombre = $("#producto_select option:selected").text();
  var cantidad = $("#producto_cant").val();
  var item = $("#producto_item").val();
  var work_order = $("#producto_work_order").val();
  var heat_number = $("#producto_heat_number").val();
  var validacion = true;

  if(id == ""){
    toastr.error('no seleccionaste producto.');
    $("#select2-producto_select-container").addClass("invalid");
    validacion = false;
  }
  if(item == ""){
    toastr.error('no ingresaste item.');
    $("#producto_item").addClass("invalid");
    validacion = false;
  }
  if(work_order == ""){
    toastr.error('no ingresaste orden de trabajo.');
    $("#producto_work_order").addClass("invalid");
    validacion = false;
  }
  if(heat_number == ""){
    toastr.error('no ingresaste heat_number.');
    $("#producto_heat_number").addClass("invalid");
    validacion = false;
  }
  if(cantidad == ""){
    toastr.error('no ingresaste cantidad.');
    $("#producto_cant").addClass("invalid");
    validacion = false;
  }

  if (validacion == false) { return false; }

  $("#select2-producto_select-container").removeClass("invalid");
  $("#producto_cant").removeClass("invalid");
  $("#producto_heat_number").removeClass("invalid");
  $("#producto_work_order").removeClass("invalid");
  $("#producto_item").removeClass("invalid");
  
  tablaProductos.row.add([
    ''+id,
    ''+nombre,
    '<input type="text" name="prod_cant[]" value="'+cantidad+'" hidden>'+cantidad
    +'<input type="text" name="prod_id[]" value="'+id+'" hidden>',
    '<input type="text" name="prod_item[]" value="'+item+'" hidden>'+item,
    '<input type="text" name="prod_work_order[]" value="'+work_order+'" hidden>'+work_order,
    '<input type="text" name="prod_heat_number[]" value="'+heat_number+'" hidden>'+heat_number,
    '<button type="button" class="btn btn-flat btn-danger btn-sm remover" onclick="eliminarProd('+id+');"><i class="fas fa-trash-alt"></i></button>'
  ]).draw( false );

  //Deshabilitamos el seleccionado
  $("#producto_select>option[value='"+id+"']").prop('disabled', !$("#material_select>option[value='"+id+"']").prop('disabled'));

  $("#filas_producto_cant").val(tablaProductos.rows().count());
  $("#producto_cant").val(1);
  $("#producto_heat_number").val("");
  $("#producto_work_order").val("");
  $("#producto_item").val("");
  $("#producto_select").val("").change();
}

/*Agregar Accesorio*/
function agregarAcc(){
  var id = $("#accesorio_select option:selected").val();
  var descripcion = $("#accesorio_select option:selected").text();
  var cantidad = $("#accesorio_cant").val();
  var validacion = true;

  if(id == ""){
    toastr.error('no seleccionaste accesorio.');
    $("#select2-accesorio_select-container").addClass("invalid");
    validacion = false;
  }
  if(cantidad == ""){
    toastr.error('no seleccionaste cantidad.');
    $("#accesorio_cant").addClass("invalid");
    validacion = false;
  }
  if (validacion == false) { return false; }

  $("#select2-accesorio_select-container").removeClass("invalid");
  $("#accesorio_cant").removeClass("invalid");

  tablaAccesorios.row.add([
    ''+id,
    ''+descripcion,
    '<input type="text" name="acc_cant[]" value="'+cantidad+'" hidden>'+cantidad
    +'<input type="text" name="acc_id[]" value="'+id+'" hidden>',
    '<button type="button" class="btn btn-flat btn-danger btn-sm remover" onclick="eliminarAcc('+id+');"><i class="fas fa-trash-alt"></i></button>'
  ]).draw( false );
  $("#accesorio_select>option[value='"+id+"']").prop('disabled', !$("#material_select>option[value='"+id+"']").prop('disabled'));
  $("#filas_acc_cant").val(tablaAccesorios.rows().count());
  $("#accesorio_cant").val(1);
  $("#accesorio_select").val("").change();
}


$(document).ready(function () { 
  tablaProductos = $('#tablaProductos').DataTable({
    "paging": true,"bAutoWidth":false,"iDisplayLength": 3,"bLengthChange": false, "searching": false,"ordering": false,"info": false, "autoWidth": false, "responsive": true,
    "language": { "url" : spanishDataTable, },
    "columnDefs": [ { "targets": [0], "visible": false, "searchable": false }],
    //"order": [[ 0, "desc" ]],
    "createdRow": function ( row, data, index ) {
      /*
      //columna de botones
      $('td', row).eq(2).addClass('p-1');
      $('td', row).eq(2).addClass('text-center');
      
      //columna cantidad
      $('td', row).eq(1).addClass('p-1');
      $('td', row).eq(1).addClass('text-center');

      //columna descripcion
      $('td', row).eq(0).addClass('p-1');
      */
    },
    drawCallback: function() {
      var api = this.api();
      var rowCount = api.rows({page: 'current'}).count();
      
      for (var i = 0; i < api.page.len() - (rowCount === 0? 1 : rowCount); i++) {
        $('#tablaProductos tbody').append($("<tr ><td colspan=\"7\" class=\"p-1\">&nbsp;</td></tr>"));
      }
    }
  });


  // Eliminar de tablaMateriales
  $('#tablaProductos').on('click', '.remover', function () {
    tablaProductos.row($(this).parents('tr')).remove().draw();
  });


});