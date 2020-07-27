@extends('layouts.app')

@section('content')
<style>
.no-spinners {
  -moz-appearance:textfield;
}

.no-spinners::-webkit-outer-spin-button,
.no-spinners::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.tablink {
  background-color: #555;
  float: left;
  color:white;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
  width: 25%;
}

.totales {
  background-color: #555;
  float: left;
  color:white;
  border: none;
  outline: none;
  padding: 14px 16px;
  font-size: 17px;
  width: 25%;
}

.filaTotales{
  background-color: #555;
    color:white;
    border: none;
    outline: none;
    padding: 14px 16px;
}

.totales2 {
  background-color: #555;
  float: left;
  color:white;
  border: none;
  outline: none;
  padding: 14px 16px;
  font-size: 17px;
}

.totales3 {
  background-color: #4CAF50;
  float: left;
  color:white;
  border: none;
  outline: none;
  padding: 14px 16px;
  font-size: 17px;
}

.tablink:hover {
  background-color: #777;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  
  display: none;
  padding: 100px 20px;
  height: 100%;

}

.active {
  background-color: #4CAF50;
  color: white;
}
</style>

  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
        <li class="breadcrumb-item">Crear Orden de Compra</li>
      </ol>
  </nav>
  <link href="{{asset('/css/select2.min.css')}}" rel="stylesheet" />
  

  <form id="formCreate" method="POST" action="{{URL('/ordenCompra/insertar')}}" enctype="multipart/form-data">
    
    {{csrf_field()}}


    <input type="text" name="fechaAlternativa" id="fechaAlternativa" hidden>
    <div class="form-group">
      <div class="form-row">
        <div class="col-4">
          <label >Proveedor </label>
            <select class="form-control custom-select" id="proveedor" name="proveedor_id">
              <option value="0" selected="true">-Proveedor-</option>
              @foreach($proveedores as $proveedor)
                  <option value="{{ $proveedor->id }}"> 
                  {{$proveedor->nombre}}</option>
              @endforeach
            </select>

            @if($errors->any())
              @foreach($errors->get('proveedor_id') as $error)
              <div class="badge badge-pill badge-danger">{{ $error }}</div>
              @endforeach
            @endif
          </div>


          <div class="col-3">
            <label>Contacto: </label>
            <div class="row mb-2">
              <div class="col">
                <input name="contacto" class="form-control" type="text" placeholder="Nombre Contacto">
              </div>
            </div>
          </div>

          <div class="col-4">
            <label>Solicitante: </label>
            <div class="row mb-2">
              <div class="col-8">
                <label for="">{{ Auth::user()->name }}</label>
                <input value="{{ Auth::user()->name }}" name="solicitante" class="form-control" type="text" placeholder="Nombre Contacto" hidden>
              </div>
            </div>
          </div>
        </div>
    </div>

     <div class="form-group">
      <div class="form-row">
        
      </div>
    </div>

    

        

    <div class="form-group">
       <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#modalCancelar">
              Cancelar
          </button>

        <a  class="btn btn-outline-success" data-toggle="modal" data-target="#modalTerminar">
              Guardar y Salir
          </a>

          <a  class="btn btn-outline-success" data-toggle="modal" data-target="#modalCotizar">
              Guardar y Cotizar
          </a>
      </div>

          <label  for=""  
                  id="total_material_vista_general">$ 000.00
          </label>


      <div class="row mb-3" >
        <div class="col-10">
            <button type="button" class="btn btn-outline-success" id="addRowMaterial"><span class="ion-plus mr-1"></span>Agregar Material</button>
            <button type="button" class="btn btn-outline-success" id="addRowInsumo"><span class="ion-plus mr-1"></span>Agregar Insumo</button>
            <button type="button" class="btn btn-outline-success" id="addRowMaquinaria"><span class="ion-plus mr-1"></span>Agregar Maquinaria</button>
            <button type="button" class="btn btn-outline-success" id="addRowServicio"><span class="ion-plus mr-1"></span>Agregar Servicio</button>
            <button type="button" class="btn btn-outline-danger" id="removeRow"><span class="ion-trash-a mr-1"></span></button>

            <input type="text" id="counter" name="counter_material" hidden value="0">
        </div>
      </div>
        

        <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tabla" >
              <thead>
                <tr>
                <th style="width: 5%; ">Tipo</th>
                <th style="width: 25%;">Material</th>
                <th style="width: 5%;">Cantidad</th>
                <th style="width: 15%;">Precio Unitario + IVA</th>
                <th style="width: 10%;">Total</th>
                </tr>
              </thead>

              <tbody>
                  
              </tbody>
            </table>
          </div>
        </div>




   


    
      
    <!-- Modal TERMINAR-->
      <div class="modal fade" id="modalCancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Cancelar</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Estas seguro que Deseas Salir sin Guardar?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <a href="{{route('trashow')}}" class="btn btn-outline-danger">Salir sin Guardar</a>
            </div>
          </div>
        </div>
      </div>
    </div>


      <!-- Modal TERMINAR-->
      <div class="modal fade" id="modalTerminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Guardar y Salir</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Agregar Proyecto sin cotizar?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button  type="submit" class="btn btn-outline-success" value="salir" id="guardarSalir">Guardar y Salir</button>
            </div>
          </div>
        </div>
      </div>
    </div>


     <!-- Modal COTIZAR-->
      <div class="modal fade" id="modalCotizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Cotizar</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Iniciar Cotizacion?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button  type="submit" class="btn btn-outline-success"  value="cotizar" id="cotizar">Iniciar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    

  </form>
@endsection

@section('scripts')
  
  <script src="{{asset('/js/select2.min.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
 
  <script>
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var counter = 0;
    var table = $('#tabla').DataTable({
      "paging":   false,
      "ordering": false,
      "info":     false,
      "searching": false
    });


      $('#addRowMaterial').on('click',function(){
        table.row.add([
          '<label for="" name="tipo_'+counter+'_label" id=tipo_'+counter+'_label">Material</label>','<select class="form-control js-example-basic-single" style="width:100%; height:100%; " name="material_nombre_'+counter+'" id="material_nombre_'+counter+'"><option value="0" selected="true">-Material-</option> @foreach($materiales as $material)<option value="{{ $material->id }}">{{$material->tipo.' '.$material->descripcion}}</option>@endforeach</select>','<input class="form-control" type="number" placeholder="Cant" min="0" value="0" onkeypress="return isNumberKey(event)" name="material_cantidad_'+counter+'" id="material_cantidad_'+counter+'"  onchange="calcularTotalMaterial('+counter+');">',
          '<input class="form-control no-spinners" type="number" step="any" onkeypress="return isNumberKeyDecimal(event)" placeholder="Costo Unitario" min="0" id="material_costounitario_'+counter+'" name="material_costounitario_'+counter+'" onchange="calcularTotalMaterial('+counter+');">',
          '<label for="" name="material_total_'+counter+'_label" id="material_total_'+counter+'_label">$ 000.00</label><input class="form-control" type="text" value="0" name="material_total_'+counter+'" id="material_total_'+counter+'" hidden>'
        ]).draw(false);
        
        $('.js-example-basic-single').select2({
          placeholder: 'Select an option'
        });      
        counter++;
        $('#counter').val(counter);
      });

       $('#addRowInsumo').on('click',function(){
        table.row.add([
          '<label for="" name="tipo_'+counter+'_label" id=tipo_'+counter+'_label">Insumo</label>','<select class="form-control js-example-basic-single" style="width:100%; height:100%; " name="material_nombre_'+counter+'" id="material_nombre_'+counter+'"><option value="0" selected="true">-Material-</option> @foreach($materiales as $material)<option value="{{ $material->id }}">{{$material->tipo.' '.$material->descripcion}}</option>@endforeach</select>','<input class="form-control" type="number" placeholder="Cant" min="0" value="0" onkeypress="return isNumberKey(event)" name="material_cantidad_'+counter+'" id="material_cantidad_'+counter+'"  onchange="calcularTotalMaterial('+counter+');">',
          '<input class="form-control no-spinners" type="number" step="any" onkeypress="return isNumberKeyDecimal(event)" placeholder="Costo Unitario" min="0" id="material_costounitario_'+counter+'" name="material_costounitario_'+counter+'" onchange="calcularTotalMaterial('+counter+');">',
          '<label for="" name="material_total_'+counter+'_label" id="material_total_'+counter+'_label">$ 000.00</label><input class="form-control" type="text" value="0" name="material_total_'+counter+'" id="material_total_'+counter+'" hidden>'
        ]).draw(false);
        
        $('.js-example-basic-single').select2({
          placeholder: 'Select an option'
        });      
        counter++;
        $('#counter').val(counter);
      });

      $('#tabla tbody').on('click','tr',function(){
        if($(this).hasClass('selected')){
          $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
      });

      $('#removeRow').click( function () {
        table.row('.selected').remove().draw( false );

        var counter = $('#counter').val();
        var total_material;
        var aux;
      });

        
        $('.js-example-basic-single').select2({
          placeholder: 'Select an option',
          allowClear: true
        });





      startTime();
      function getFormattedDate(date) {
        var year = date.getFullYear();
        var month = (1 + date.getMonth()).toString();
        month = month.length > 1 ? month : '0' + month;
        var day = date.getDate().toString();
        day = day.length > 1 ? day : '0' + day;
        return month + '/' + day + '/' + year;
      }      
      function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        //document.getElementById('txt').innerHTML =
        //h + ":" + m + ":" + s;
        //document.getElementById('inputTime').value =
        //h + ":" + m + ":" + s;
        
        //$('#hora').val(h + ":" + m + ":" + s);
        $('#fechaAlternativa').val(today.getDate() + " de " + meses[today.getMonth()] + " del " + today.getFullYear());

        var t = setTimeout(startTime, 500);
      }
      function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
          return i;
      }

  function calcularTotalMaterial(id){
    /*
      CANTIDAD MATERIA ID = material_cantidad_NUM
      COSTO MATERIAL ID = material_costounitario_NUM
      SUBTOTAL MATERIAL ID = material_subtotal_NUM  -> LABEL
      GANANCIA MATERIAL ID = material_ganancia_NUM
      TOTAL MATERIAL ID = material_total_NUM       -> LABEL

        */
        var cantidad = $('#material_cantidad_'+id).val();
        var costo = $('#material_costounitario_'+id).val();
        var subtotal;
        var total;
        var total_material;
        var nombre_material = $('#material_nombre_'+id).val();

        if(cantidad==''){
          cantidad = 0;
          $('#material_cantidad_'+id).val(cantidad);
        }

        if(nombre_material==''){
          nombre_material = 'Nombre de Material';
          $('#material_nombre_'+id).val(nombre_material);
        }

        if(costo == ''){
         costo = 0;
        $('#material_costounitario_'+id).val(costo);
        }
        
        subtotal = (cantidad * costo);
        total = subtotal;

        if(isNaN(total)){
          total = 0;
        }

        $('#material_subtotal_'+id).val(subtotal);
        $('#material_subtotal_'+id+'_label').text('$ '+subtotal.toLocaleString());

        $('#material_total_'+id).val(total);
        $('#material_total_'+id+'_label').text('$ '+total.toLocaleString());

        var counter = $('#counter').val();
        var aux;
        //alert('Counter '+counter);
        totalMA_GENERAL = 0;
        subtotalMA_GENERAL = 0;
        for (var i = 0; i < counter; i++) {
          total_material = $('#material_total_'+i).val();
          subtotal_material = $('#material_subtotal_'+i).val();
          
          if (total_material != '' && typeof total_material !== 'undefined') {
            totalMA_GENERAL += parseFloat(total_material);
            subtotalMA_GENERAL += parseFloat(subtotal_material);
          }
        }
        gananciaMA_GENERAL = totalMA_GENERAL - subtotalMA_GENERAL;
        
        $('#total_material').val(totalMA_GENERAL);
        $('#total_material_label').text('$ '+totalMA_GENERAL.toLocaleString());
        $('#total_material_vista_general').text('$ '+totalMA_GENERAL.toLocaleString());

  }

  function toUpper(str) {
    var lower = str.toLowerCase();
      return lower.replace(/(^| )(\w)/g, function(x) {
        return x.toUpperCase();
      });
   }


  function tipoSubmit(tipo){
    $("#tipoSubmit").val("salir");
  }

  $( "#guardarSalir" ).click(function() {
      $('#guardarSalir').attr('name','tipoSubmit');
  });

  $( "#cotizar" ).click(function() {
      $('#cotizar').attr('name','tipoSubmit');
  });

  $('#formCreate').submit(function() {
    var nombre = $('#nombre_trabajo').val();
    var descripcion = $('#descripcion_trabajo').val();
    
    
    $('#nombre_trabajo').val(toUpper(nombre));
    $('#descripcion_trabajo').val(toUpper(descripcion));
    
  });

  function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
  }

  function isNumberKeyDecimal(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
          return false;
      return true;
  }

  function openPage(pageName, elmnt) {
      // Hide all elements with class="tabcontent" by default */
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
      }

      // Remove the background color of all tablinks/buttons
      tablinks = document.getElementsByClassName("tablink");

      // Show the specific tab content
      document.getElementById(pageName).style.display = "block";


      var btnContainer = document.getElementById("myDIV");

    // Get all buttons with class="btn" inside the container
    var btns = btnContainer.getElementsByClassName("tablink");

    // Loop through the buttons and add the active class to the current/clicked button
    for (var i = 0; i < btns.length; i++) {
      btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
      });
    }    
  }
  document.getElementById("defaultOpen").click(); 

  </script>


@endsection

