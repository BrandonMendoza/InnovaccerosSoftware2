

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
function eliminarMat(id){
  $("#material_select>option[value='"+id+"']").prop('disabled', !$("#material_select>option[value='"+id+"']").prop('disabled'));
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
    success: function(producto){
      //Limpiar tablas
      tablaMateriales.clear().draw();
      tablaAccesorios.clear().draw();
      //actualizar tablas
      updateTableForm(producto.materiales,producto.accesorios);
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

function updateTableForm(materiales,accesorios) {
  var descripcion;
  materiales.forEach( function(material, indice, array) {
    descripcion = getNombreMaterial(material);
    $("#material_select>option[value='"+material.id+"']").prop('disabled', !$("#material_select>option[value='"+id+"']").prop('disabled'));
    //Add materiales
    tablaMateriales.row.add([
      ''+material.id,
      ''+descripcion,
      '<input type="text" name="mat_cant[]" value="'+material.pivot.cantidad+'" hidden>'+material.pivot.cantidad
      +'<input type="text" name="mat_id[]" value="'+material.id+'" hidden>',
      '<button type="button" class="btn btn-flat btn-danger btn-sm remover"><i class="fas fa-trash-alt"></i></button>'
    ]).draw( false );
  });
  accesorios.forEach( function(accessorio, indice, array) {
    $("#accesorio_select>option[value='"+accessorio.id+"']").prop('disabled', !$("#material_select>option[value='"+id+"']").prop('disabled'));
    //Add accessorio
    tablaAccesorios.row.add([
      ''+accessorio.id,
      ''+accessorio.descripcion,
      '<input type="text" name="acc_cant[]" value="'+accessorio.pivot.cantidad+'" hidden>'+accessorio.pivot.cantidad
      +'<input type="text" name="acc_id[]" value="'+accessorio.id+'" hidden>',
      '<button type="button" class="btn btn-flat btn-danger btn-sm remover"><i class="fas fa-trash-alt"></i></button>'
    ]).draw( false );
  });
}


/*Agregar Material*/
function agregarMat(){
  var id = $("#material_select option:selected").val();
  var descripcion = $("#material_select option:selected").text();
  var cantidad = $("#material_cant").val();
  var validacion = true;

  if(id == ""){
    toastr.error('no seleccionaste material.');
    $("#select2-material_select-container").addClass("invalid");
    validacion = false;
  }

  if(cantidad == ""){
    toastr.error('no seleccionaste cantidad.');
    $("#material_cant").addClass("invalid");
    validacion = false;
  }
  if (validacion == false) { return false; }

  $("#select2-material_select-container").removeClass("invalid");
  $("#material_cant").removeClass("invalid");
  
  tablaMateriales.row.add([
    ''+id,
    ''+descripcion,
    '<input type="text" name="mat_cant[]" value="'+cantidad+'" hidden>'+cantidad
    +'<input type="text" name="mat_id[]" value="'+id+'" hidden>',
    '<button type="button" class="btn btn-flat btn-danger btn-sm remover" onclick="eliminarMat('+id+');"><i class="fas fa-trash-alt"></i></button>'
  ]).draw( false );

  //Deshabilitamos el seleccionado
  $("#material_select>option[value='"+id+"']").prop('disabled', !$("#material_select>option[value='"+id+"']").prop('disabled'));


  $("#filas_mat_cant").val(tablaMateriales.rows().count());
  $("#material_cant").val(1);
  $("#material_select").val("").change();
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

$(document).ready(function () { 
  tablaMateriales = $('#tablaMateriales').DataTable({
    "paging": true,"iDisplayLength": 3,"bLengthChange": false, "searching": false,"ordering": false,"info": false, "autoWidth": false, "responsive": true,
    "language": { "url" : spanishDataTable, },
    "columnDefs": [ { "targets": [0], "visible": false, "searchable": false }],
    //"order": [[ 0, "desc" ]],
    "createdRow": function ( row, data, index ) {
      //columna de botones
      $('td', row).eq(2).addClass('p-1');
      $('td', row).eq(2).addClass('text-center');
      
      //columna cantidad
      $('td', row).eq(1).addClass('p-1');
      $('td', row).eq(1).addClass('text-center');

      //columna descripcion
      $('td', row).eq(0).addClass('p-1');
    },
    drawCallback: function() {
      var api = this.api();
      var rowCount = api.rows({page: 'current'}).count();
      
      for (var i = 0; i < api.page.len() - (rowCount === 0? 1 : rowCount); i++) {
        $('#tablaMateriales tbody').append($("<tr ><td colspan=\"3\" class=\"p-1\">&nbsp;</td></tr>"));
      }
    }
  });

  tablaAccesorios = $('#tablaAccesorios').DataTable({
    "paging": true,"iDisplayLength": 3,"bLengthChange": false, "searching": false,"ordering": false,"info": false, "autoWidth": false, "responsive": true,
    "language": { "url" : spanishDataTable, },
    "columnDefs": [ { "width": "10%", "targets": 2 }, { "targets": [0], "visible": false, "searchable": false }],
    //"order": [[ 0, "desc" ]],
    "createdRow": function ( row, data, index ) {
      //columna de botones
      $('td', row).eq(2).addClass('p-1');
      $('td', row).eq(2).addClass('text-center');
      
      //columna cantidad
      $('td', row).eq(1).addClass('p-1');
      $('td', row).eq(1).addClass('text-center');

      //columna descripcion
      $('td', row).eq(0).addClass('p-1');
    },
    drawCallback: function() {
      var api = this.api();
      var rowCount = api.rows({page: 'current'}).count();
      
      for (var i = 0; i < api.page.len() - (rowCount === 0? 1 : rowCount); i++) {
        $('#tablaAccesorios tbody').append($("<tr ><td colspan=\"3\" class=\"p-1\">&nbsp;</td></tr>"));
      }
    }
  });

  // Eliminar de tablaMateriales
  $('#tablaMateriales').on('click', '.remover', function () {
    tablaMateriales.row($(this).parents('tr')).remove().draw();
  });
  // Eliminar de tablaAccesorios
  $('#tablaAccesorios').on('click', '.remover', function () {
    tablaAccesorios.row($(this).parents('tr')).remove().draw();
  });


});