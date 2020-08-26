//actualizar la barra de progreso
//$("#progres_"+this.id).css('width',ui.value+'%');
var procesoActual;

var procesoInicio;
var procesoFin;
var procesoParado;
/*Variable para solo dejar dar 1 paso a la vez*/
var stepGral = 1;

var ordenActual = 0;
var ordenMax;


function  cambiarProcesoForm(ordenAbierta,row){
  proyectoProcesos = [];
  stepGral = 1;
  $("#modalCambiarProceso").modal('show');
  $("#proyecto_producto_id").val(ordenAbierta.id);
  $("#nombre_proceso").text("");
  $("#progressPorcentajes").empty();

  getProyectoProcesos(ordenAbierta.proyecto_id,ordenAbierta.id);
}

/* Funcion para hacer submit en un Form utilizando ajax */
function submitFormCambiarProceso(){
  Pace.restart();
  $("#cambiarProcesoOverlay").show();
  /*Se deshabilita el boton guardar*/
  $("#btn_guardar").prop("disabled",true);
  var proceso_actual = $("#proceso_actual").val();
  var proceso_nuevo = $("#proceso_nuevo").val();

  /*Verificamos que no sea el mismo proceso y que se haya seleccionado un proceso nuevo*/
  if(proceso_actual == proceso_nuevo || proceso_nuevo == 0){
    console.log("No se mandara el form");
    $("#cambiarProcesoOverlay").hide();
    Pace.stop();
    return false;
  }
  console.log("Si se esta mandando el form!");

  var form = $("#formCambiarProceso");
  var url = form.attr('action');
  console.log(form);
  $.ajax({
    type: "POST",
    url: url,
    data: form.serialize(),
    success: function(ordenesAbiertas){
      console.log('Completado.');
      console.log(ordenesAbiertas);
      table.clear().draw();
      updateTable(ordenesAbiertas);
      /*Se habilita el boton guardar y el boton de siguiente*/
      $("#btn_guardar").prop("disabled",false);
      $("#cambiarProcesoOverlay").hide();
      $("#modalCambiarProceso").modal('hide');
      Pace.stop();
    },
    error: function (data) {
      console.log('Ha ocurrido un error.');
      console.log(data);
      toastr.error('Hubo un error al guardar proceso.');
      Pace.stop();
    },
  });
  //$('#modalPorcentajes').modal('hide');
}

/*Funcion para obtener los procesos del proyecto*/
function getProyectoProcesos(proyecto_id,ordenAbierta_id){
  $("#cambiarProcesoOverlay").show();
  var totalProgreso = 0;
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
    type: "POST", url: urlGetProcesos,
    data:{'proyecto_id':proyecto_id,'ordenAbierta_id':ordenAbierta_id},
    success: function(data){
      //actualizar tabla
      console.log("Avance");
      console.log(data);
      data.procesos.forEach( function(proceso, indice, array) {
        procesoAux = { "id": proceso.id, 
                        "proceso_id": proceso.proceso.id,
                        "proceso": proceso.proceso.nombre, 
                        "orden":proceso.orden,
                        "porcentaje":proceso.porcentaje,
                        "color":proceso.proceso.color,
                        "texto_color":proceso.proceso.texto_color,
                        "es_ultimo": proceso.proceso.es_ultimo,
                        "es_primero": proceso.proceso.es_primero,
        };
        if(proceso.proceso.id == data.lastProceso.id){
          procesoActual = procesoAux;
        }

        if(procesoAux.orden != 0){
          proyectoProcesos.push(procesoAux);
          $("#progressPorcentajes").append('<div id="progres_'+proceso.id+'" class="progress-bar" style="width:0%;" ></div>');
        }else{
          if(procesoAux.es_primero == 0 && proceso.es_ultimo == 0){
            procesoParado = procesoAux;
          }else{
            if(procesoAux.es_primero == 1){
              procesoInicio = procesoAux;
            }
            if(procesoAux.es_ultimo == 1){
              procesoFin = procesoAux;
            }
          }
        }
      });



      var ordenes = proyectoProcesos.map(function(obj) { return obj.orden; });
      ordenMax = Math.max.apply(null, ordenes);

      if(procesoActual.es_ultimo == 1){
        ordenActual = ordenMax+1;
      }else{
        ordenActual = procesoActual.orden;  
      }
      
      /* Mandando id al Form para hacerle submit */
      $("#proceso_actual").val(procesoActual.id);

      $("#btn_ant").prop("disabled",false);
      $("#btn_sig").prop("disabled",false);
      if(ordenActual == 0){
        $("#btn_ant").prop("disabled",true);
        if(procesoActual.es_primero == 0 && procesoActual.es_ultimo == 0){
          //esta parado
        }else{
          /*Si es primero se limpian todos los procesos*/
          if(procesoActual.es_primero == 1){
            proyectoProcesos.some( function(proceso, indice, array) {
              $('#progres_'+proceso.id).css({'width':'0%'});
              $('#progres_'+proceso.id).css({'color':proceso.texto_color});
              $('#progres_'+proceso.id).css({'background-color':proceso.color});
            });
          }
          /*Se es ultimo se pintan todos los procesos*/
          if(procesoActual.es_ultimo == 1){
            proyectoProcesos.some( function(proceso, indice, array) {
              $('#progres_'+proceso.id).css({'width':proceso.porcentaje+'%'});
              $('#progres_'+proceso.id).css({'color':proceso.texto_color});
              $('#progres_'+proceso.id).css({'background-color':proceso.color});
            });
          }
        }
        /*Si no es un orden = 0 pintas hasta el proceso actual*/
      }else{
        if(ordenActual > ordenMax){
          $("#btn_sig").prop("disabled",true);
        }

        proyectoProcesos.some( function(proceso, indice, array) {
          $('#progres_'+proceso.id).css({'width':proceso.porcentaje+'%'});
          $('#progres_'+proceso.id).css({'color':proceso.texto_color});
          $('#progres_'+proceso.id).css({'background-color':proceso.color});

          if(proceso.id == procesoActual.id){
            $('#progres_'+proceso.id).css({'width':(proceso.porcentaje/2)+'%'});
            return true;
          }
        });
      }
      
      $("#nombre_proceso").text(procesoActual.proceso);
      $("#cambiarProcesoOverlay").hide();
    },
    error: function (mensaje) {
      console.log('Ha ocurrido un error.');
      console.log(mensaje);
      toastr.error('Hubo un error al cargar proceso.');
      Pace.stop();
      $("#cambiarProcesoOverlay").hide();
    },
  });

}




function updateProgress(progreso){
  var total = 0;
  $("#progressPorcentajes").empty();
  $("#progressPorcentajes").append('');
  
}


function cambiarProceso(step){
  console.log("CAMBIAR PROCESO");
  //var ordenMax = proyectoProcesos;
  console.log(ordenActual);
  var ordenAux = ordenActual;
  ordenAux += step;
  stepGral += step;

  limpiarProgress();
  

  if(ordenAux > ordenMax){
    //terminado
    ordenActual = ordenMax;
    /* Se llena por completo la progresbar */
    proyectoProcesos.forEach( function(proceso, indice, array) {
      $('#progres_'+proceso.id).css({'width':proceso.porcentaje+'%'});
      $('#progres_'+proceso.id).css({'color':proceso.texto_color});
      $('#progres_'+proceso.id).css({'background-color':proceso.color});
    });
    /*Se actualiza el label de proceso actual y se desahbilita el boton siguiente*/
    $("#nombre_proceso").text(procesoFin.proceso);
    $("#btn_sig").prop('disabled', true);
    $("#proceso_nuevo").val(procesoFin.id);
  }else{
    /*Si aun no llegamos al ultimo proceso deshabilitamos el siguiente*/
    $("#btn_sig").prop('disabled', false);
  }

  /*Verificamos para no irnos a menos de cero en el orden de los procesos*/
  if(ordenAux <= 0){
    ordenActual = 0;
    $("#nombre_proceso").text(procesoInicio.proceso);
    $("#btn_ant").prop('disabled', true);
    $("#proceso_nuevo").val(procesoInicio.id);
  }else{
    $("#btn_ant").prop('disabled', false);
  }


  /*Si no es el inicio ni el fin seguimos jugando con los procesos != a cero*/
  if(ordenAux > 0 && ordenAux <= ordenMax){
    ordenActual = ordenAux;
    var resultado = proyectoProcesos.find( proceso => proceso.orden === ordenActual );
    /*Se manda el id del proceso seleccionado*/
    $("#proceso_nuevo").val(resultado.id);
    /*Se actualizan los progresbar de acuerdo a la seleccion*/
    proyectoProcesos.some( function(proceso, indice, array) {
      $('#progres_'+proceso.id).css({'width':proceso.porcentaje+'%'});
      $('#progres_'+proceso.id).css({'color':proceso.texto_color});
      $('#progres_'+proceso.id).css({'background-color':proceso.color});

      if(proceso.id == resultado.id){
        $('#progres_'+proceso.id).css({'width':(proceso.porcentaje/2)+'%'});
        $("#nombre_proceso").text(proceso.proceso);
        return true;
      }
    });
  }

  /*Codigo para solo permitir un step por Submit*/
  if(stepGral == 2){
    $("#btn_sig").prop("disabled",true);
    $("#btn_ant").prop("disabled",false);
  }
  if(stepGral == 0){
    $("#btn_sig").prop("disabled",false);
    $("#btn_ant").prop("disabled",true);
  }


}

function limpiarProgress(){
  proyectoProcesos.some( function(proceso, indice, array) {
    $('#progres_'+proceso.id).css({'width':'0%'});
    $('#progres_'+proceso.id).css({'color':proceso.proceso.texto_color});
    $('#progres_'+proceso.id).css({'background-color':proceso.proceso.color});
  });
}



