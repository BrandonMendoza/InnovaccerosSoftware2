var regExp = /[a-z]/i;
$('.justNumber').on('keydown keyup', function(e) {
	var value = String.fromCharCode(e.which) || e.key;

	// No letters
	if (regExp.test(value)) {
	  e.preventDefault();
	  return false;
	}
});


function editando(id,editing,url){	
	var response;
  	$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  	$.ajax({	async: false, type: "POST", url: url, data: {'id':id,'editing':editing},
    			success: function(respuesta){ response = respuesta; },
    			error: function (respuesta) { response = respuesta; },});
  	return response;
}