
/*Funcion para cargar la tabla cada vez que abres el modal*/
function cargarTablaOrdenModal(url){    
	$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  	$.ajax({
	    type: "POST",
	    url: url,
	    success: function(procesos){
	      //Limpiar tabla
	      tablaOrdenar.clear().draw();
	      //actualizar tabla
	      updateTableOrdenar(procesos);
	      //se limpia el form
	      $("#tablaOverlay").hide();
	      $("#modalOrdenar").modal();
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

function cargarTablaProcesos(url){    
	$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  	$.ajax({
	    type: "POST",
	    url: url,
	    success: function(procesos){
	      //Limpiar tabla
	      table.clear().draw();
	      //actualizar tabla
	      updateTable(procesos);
	      //se limpia el form
	      $("#tablaOverlay").hide();
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

  	
function updateTableOrdenar(procesos){
  procesos.forEach( function(proceso, indice, array) {
    /* Conviertiendo objecto en algo leible*/
    funcionText = String(JSON.stringify(proceso)).replace(/"/g,'&quot;');
    /* Creando funcion para editar en la columna
    */
    funcion = 'editarForm('+funcionText+','+indice+');';

    tablaOrdenar.row.add([
      ''+proceso.orden,
      ''+proceso.id,
      ''+proceso.nombre,
      ''+proceso.simbolo,
      proceso.porcentaje+'%',
      ''+proceso.color,
      ''+proceso.texto_color,
    ]).draw( false );
  });
}

