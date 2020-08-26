var regExp = /[a-z]/i;
$('.justNumber').on('keydown keyup', function(e) {
	var value = String.fromCharCode(e.which) || e.key;
	// No letters
	if (regExp.test(value)) {
	  e.preventDefault();
	  return false;
	}
});

/* Color picker*/
/* Init*/
$('.color-picker').colorpicker({});
/* Init color del cuadrito*/
$('.color-picker .fa-square').css('color', $(".color-picker").val());
/* Funcion para cambiar color del cuadro*/
$('.color-picker').on('colorpickerChange', function(event) {
  $('.color-picker .fa-square').css('color', event.color.toString());
});


/*Funcion para devolver un icon si es activo o no*/
function getIconActivo(activo){
  if(activo == 1){
    return '<i class="fas fa-check text-success"></i>';
  }else{
    return '<i class="fas fa-times text-danger"></i>';
  }

}
/*funcion para activarDesactivar en Base de Datos
function activarDesactivar(url,id,activo){
  var response;
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({  async: false, type: "POST", url: url, data: {'id':id,'activo':activo},
        success: function(respuesta){ response = respuesta; },
        error: function (respuesta) { response = respuesta; },});
  return response;
}*/

/*Funcion para activar/desactivar activo en form*/
function toggleActivoCheckbox(activo){
  console.log("ACTIVO TOGGLE");
  console.log(activo);
  if(activo == 1){
    console.log("ACTIVO TOGGLE: 1");
    $("#activo").val(1);
    $("#activoCheckbox").prop('checked',true);
  }else{
    console.log("ACTIVO TOGGLE: 0");
    $("#activo").val(0);
    $("#activoCheckbox").prop('checked',false);
  }
}

/*Funcion que regresa un icon de acuerdo a una palabra*/
function getIconDocumento(palabra){
  console.log("PALABRA: ");
  console.log(palabra);
  var icon;
  switch(palabra) {
    case "pdf":
      icon = '<i class="far fa-file-pdf" alt="'+palabra+'"></i>';
      break;
    case "png":
    case "img":
    case "jpeg":
    case "jpg":
      icon = '<i class="far fa-file-image" alt="'+palabra+'"></i>';
      break;
    case "docx":
      icon = '<i class="far fa-file-word" alt="'+palabra+'"></i>';
      break;
    case "xlsx":
      icon = '<i class="far fa-file-excel" alt="'+palabra+'"></i>';
      break;
    case "rar":
    case "zip":
      icon = '<i class="far fa-file-archive" alt="'+palabra+'"></i>';
      break;
    default:
      icon = '<i class="far fa-file" alt="'+palabra+'"></i>';
  } 
  return icon;
}



/*Iniciar selects2*/
$('.select2Form').select2({
  theme: 'bootstrap4',
  width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
  placeholder: $(this).data('placeholder'),
  allowClear: Boolean($(this).data('allow-clear')),
});


function editando(id,editing,url){	
	var response;
  	$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  	$.ajax({	async: false, type: "POST", url: url, data: {'id':id,'editing':editing},
    			success: function(respuesta){ response = respuesta; },
    			error: function (respuesta) { response = respuesta; },});
  	return response;
}
/*Funcion para mandar a llamar una funcion de eliminar de cualquier catalogo
  Necesitamos id y el URL de la eliminacion
*/
function eliminarFromTableAjax(idSeleccionado,url){
  Pace.restart(); 
  $("#tablaOverlay").show();
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
        type: "POST",
        url: url,
        data: {'id':idSeleccionado},
        success: function(dataSource){
          //Limpiar tabla
          table.clear().draw();
          //actualizar tabla
          console.log(dataSource);
          updateTable(dataSource);
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
/*Validaciones jquery*/
jQuery.validator.setDefaults({
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
      submitAjaxForm(form);
    }
});

/* Funcion para hacer submit en un Form utilizando ajax */
function submitAjaxForm(form){
  Pace.restart();
  $("#tablaPrincipal_processing").show();
    var form = $(form);
    var url = form.attr('action');
    console.log(form);
    $.ajax({
      type: "POST",
      url: url,
      data: form.serialize(),
      success: function(dataSource){
        //si el request es enviado correctamente se agrega la fila
        //Limpiar tabla
        table.clear().draw();
        console.log('Completado.');
        console.log(dataSource);
        //actualizar tabla
        updateTable(dataSource);
        //se envia notificacion
        toastr.success(toastrMensaje);
        //se limpia el form
        $('#formAgregar').trigger("reset");
        Pace.stop();
        $("#tablaPrincipal_processing").hide();
      },
      error: function (data) {
        console.log('Ha ocurrido un error.');
        console.log(data);
        toastr.error('Hubo un error en la asignación.');
        Pace.stop();
        $("#tablaPrincipal_processing").hide();
      },
    });
    $('#modalAgregar').modal('hide');
}