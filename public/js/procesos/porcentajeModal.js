


/* Funcion para hacer submit en un Form utilizando ajax */
function submitFormPorcentaje(){
  Pace.restart();
  var sliders = $(".slider");
  var total = 0;
  sliders.each(function(){
    var t = $(this),
    value = t.slider("option", "value");
    total += value;

    if(t.slider("option", "value") != t.slider("option", "max")){
      t.slider().css( "background-color", "#d9534f" );
    }else{
      t.slider().removeProp("background-color");
    }
  });

  if(total != 100){
    toastr.error('no completaste el proceso al 100%.');
    return false;
  }



  var form = $("#formPorcentaje");
  var url = form.attr('action');
  console.log(form);
  $.ajax({
    type: "POST",
    url: url,
    data: form.serialize(),
    success: function(procesos){
      //si el request es enviado correctamente se agrega la fila
      //Limpiar tabla
      console.log('Completado.');
      console.log(procesos);
      //actualizar tabla
      updateProcesosOrder(procesos)
      //se envia notificacion
      //toastr.success(toastrMensaje);
      Pace.stop();
    },
    error: function (data) {
      console.log('Ha ocurrido un error.');
      console.log(data);
      toastr.error('Hubo un error en la asignación.');
      Pace.stop();
    },
  });
  $('#modalPorcentajes').modal('hide');
}




/*Funcion para cargar la tabla cada vez que abres el modal*/
function cargarTablaPorcentajes(url){    
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
        type: "POST",
        url: url,
        success: function(procesos){
          //Limpiar tabla
          tablaPorcentajes.clear().draw();
          //actualizar tabla
          updateTablePorcentajes(procesos);
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


function updateTablePorcentajes(procesos){
  var total = 0;
  $("#progressPorcentajes").empty();
  procesos.forEach( function(proceso, indice, array) {

    total += proceso.porcentaje;

    $("#progressPorcentajes").append('<div id="progres_'+proceso.id+'" class="progress-bar" data-toggle="popover" data-trigger="hover" data-content="'+proceso.nombre+'" style="width: '+proceso.porcentaje+'%; background-color:  '+proceso.color+'; color:'+proceso.color_texto+'" ></div>');
    tablaPorcentajes.row.add([
      ''+proceso.nombre,
      '<div id="'+proceso.id+'" class="slider">'+proceso.porcentaje+'</div>\
      <span class="value">'+proceso.porcentaje+'</span>%\
      <input type="text" name="idProceso[]" value="'+proceso.id+'" hidden>\
      <input type="text" id="porcentaje_'+proceso.id+'"  name="porcentaje[]" value="'+proceso.porcentaje+'" hidden>',
      ''+proceso.color,
      ''+proceso.texto_color,
    ]).draw( false );

    var value = parseInt($(this).text(), 10),
        availableTotal = 100;
    var max = proceso.porcentaje;

    
    $("#"+proceso.id).empty().slider({
        value: proceso.porcentaje,
        min: 0,
        max: max,
        range: "max",
        step: 1,
        animate: 100,
        slide: function(event, ui) {
          var sliders = $(".slider");
          // Update display to current value
          $(this).siblings().text(ui.value);

          // Get current total
          var total = 0;
          //actualizar la barra de progreso
          $("#progres_"+this.id).css('width',ui.value+'%');
          //actualizar input escondido
          $("#porcentaje_"+this.id).val(ui.value);

          sliders.not(this).each(function() {
            total += $(this).slider("option", "value");
          });
          
          // Need to do this because apparently jQ UI
          // does not update value until this event completes
          total += ui.value;
          

          var max = availableTotal - total;
          sliders.not(this).each(function() {
              var t = $(this),
                  value = t.slider("option", "value");
              t.slider("option", "max", max + value) 
                  .siblings().text(value + '/' + (max + value));
              t.slider('value', value);
          });
        }
    });
  });
  
}

 //$("#storlekslider").slider("value", $(this).val());