var documento_idSeleccionado;

/*Funcion para cargar Form cuando presionamos editar en la tabla principal*/
function cargarTablaDocumentosForm(url,id){    
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
    type: "POST",
    url: url,
    data: {'id':idSeleccionado},
    success: function(producto){
      //Limpiar tabla
      tablaDocumentos.clear().draw();
      //actualizar tabla
      updateTableDocumentosForm(producto.documentos);
      //se limpia el form
      $("#tablaOverlay").hide();
      $("#modalDoc").modal();
      Pace.stop();
    },
    error: function (mensaje) {
      console.log('Ha ocurrido un error.');
      console.log(mensaje);
      toastr.error('Hubo un error al cargar documentos.');
      Pace.stop();
      $("#tablaOverlay").hide();
    },
  });
}

function eliminarDoc(id){
  documento_idSeleccionado = id;

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
    type: "POST",
    url: urlEliminarDocumento,
    data: {'documento_id':documento_idSeleccionado, 'producto_id':idSeleccionado},
    success: function(respuesta){
      toastr.success('Eliminado correctamente.');
      //se limpia el form
      $("#tablaOverlay").hide();
      Pace.stop();
    },
    error: function (mensaje) {
      console.log('Ha ocurrido un error.');
      console.log(mensaje);
      toastr.error('Hubo un error al eliminar documentos.');
      Pace.stop();
      $("#tablaOverlay").hide();
    },
  });

}

function updateTableDocumentosForm(documentos) {
  var descripcion;
  var icon;
  documentos.forEach( function(documento, indice, array) {
    icon = getIconDocumento(documento.tipo_documento);
    //Add materiales
    tablaDocumentos.row.add([
      tablaDocumentos.rows().count()+1,
      documento.nombre_real,
      documento.nombre_usuario,
      icon,
      '<a type="button" href="'+urlGral+'/productos/descargarProductoDocumento/'+documento.id+'" class="btn btn-flat btn-info btn-sm" onclick="descargar('+documento.id+');"><i class="fas fa-cloud-download-alt"></i></a><button type="button" class="btn btn-flat btn-danger btn-sm remover" onclick="eliminarDoc('+documento.id+');"><i class="fas fa-trash-alt"></i></button>'
    ]).draw( false );
  });
}


/*Funcion para agregar documento a la BD y almacenar el docuemnto*/
$("#formDocumento").submit(function(e) {
  var nombre_usuario = $("#nombre_usuario").val();
  var doc = $("#doc").val();
  var validacion = true;
  var icon;
  e.preventDefault();    
  if(nombre_usuario == ""){
    toastr.error('ingresa un nombre de documento.');
    $("#nombre_usuario").addClass("invalid");
    validacion = false;
  }

  if(doc == ""){
    toastr.error('ingresa un documento.');
    $("#doc_inputgroup").addClass("invalid");
    validacion = false;
  }

  
  if (validacion == false) {return}
  $("#nombre_usuario").removeClass("invalid");
  $("#doc_inputgroup").removeClass("invalid");

  var form = $("#formDocumento");
  var formData = new FormData($(form)[0]);
  var url = form.attr('action');
  $.ajax({
    type: "POST",
    url: url,
    data: formData,
    processData: false,
    contentType: false,
    success: function(documento){
    //si el request es enviado correctamente se agrega la fila
    //Limpiar tabla
    icon = getIconDocumento(documento.tipo_documento)

    tablaDocumentos.row.add([
      tablaDocumentos.rows().count()+1,
      documento.nombre_real,
      documento.nombre_usuario,
      icon,
      '<a type="button" target="_blank" href="'+urlGral+'/productos/descargarProductoDocumento/'+documento.id+'" class="btn btn-flat btn-info btn-sm" onclick="descargar('+documento.id+');"><i class="fas fa-cloud-download-alt"></i></a><button type="button" class="btn btn-flat btn-danger btn-sm remover" onclick="eliminarDoc('+documento.id+');"><i class="fas fa-trash-alt"></i></button>'
    ]).draw( false );
    
    //se envia notificacion
    toastr.success(toastrMensaje);
    //se limpia el form
    $('#formDocumento').trigger("reset");
    },
    error: function (data) {
      console.log('Ha ocurrido un error.');
      console.log(data);
      toastr.error('Hubo un error al agregar.');
    },
  });
  $("#doc").val("").change();
});


// Eliminar de tablaDocumentos
$('#tablaDocumentos').on('click', '.remover', function () {
  tablaDocumentos.row($(this).parents('tr')).remove().draw();
});


/*Funcion para leer la ruta de el archivo*/
$('#doc').on('change',function(){
  //get the file name
  var fileName = $(this).val();
  //replace the "Choose a file" label
  $(this).next('.custom-file-label').html(fileName);
  //getElementById('fileName').
});


tablaDocumentos = $('#tablaDocumentos').DataTable({
  "paging": true,"iDisplayLength": 3,"bLengthChange": false, "searching": false,"ordering": false,"info": false, "autoWidth": false, "responsive": true,
  "language": { "url" : spanishDataTable, },
  "columnDefs": [ { "width": "8%", "targets": 4 },{ "width": "8%", "targets": 3 }],
  //"order": [[ 0, "desc" ]],
  "createdRow": function ( row, data, index ) {
    //columna de botones
    $('td', row).addClass('p-1');
    $('td', row).eq(0).addClass('text-center');
    $('td', row).eq(3).addClass('text-center');
    $('td', row).eq(4).addClass('text-center');
  },
  drawCallback: function() {
    var api = this.api();
    var rowCount = api.rows({page: 'current'}).count();
    
    for (var i = 0; i < api.page.len() - (rowCount === 0? 1 : rowCount); i++) {
      $('#tablaDocumentos tbody').append($("<tr ><td colspan=\"5\" class=\"p-1\">&nbsp;</td></tr>"));
    }
  }
});

