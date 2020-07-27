@extends('adminlte::page')

@section('title', 'Inn Software')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Entradas de Almacen</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{URL('/')}}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{URL('/almacen/show')}}">Almacen</a></li>
              <li class="breadcrumb-item">Entradas de Almacen</li>
            </ol>
          </div>
        </div>
      </div>
@stop

@section('content')
    <style>
      .special-card {
/* create a custom class so you 
   do not run into specificity issues 
   against bootstraps styles
   which tends to work better than using !important 
   (future you will thank you later)*/

  background-color: rgba(245, 245, 245, 1);
  opacity: .4;
}
    </style>
  <tbody >

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
@if(session()->has('errorArticulo'))
    <div class="alert alert-danger">
        {{ session()->get('errorArticulo') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
         @foreach ($errors->all() as $error)
                {{ $error.' ' }}
          @endforeach
    </div>
@endif

@if(Auth::user()->empleado)



<form method="POST" id="entradaForm" enctype="multipart/form-data" action="{{ route('enviarArticulosSeleccionadosEntradas') }}" >
      {{csrf_field()}}

  <div class="form-group"> 
   <div class="form-row">
    <div class="col-2">
       <button type="button"  class="btn btn-outline-secondary" data-toggle="modal" data-target=".bd-example-modal-lg">Seleccionar Articulos</button>
    </div>

    <div class="col-2">
      <input type="text" value="Entrada" name="tipo" hidden="true">
      <button id="botonSubmit" type="submit" class="btn btn-outline-success" hidden="true">Listo</button>
    </div>
    

    <div class="col-7">
        <h2 id="txt" class="jumbotron-heading float-right"></h2>
        <input id="hora" name="hora" hidden="true">
        <input id="fecha" name="fecha" hidden="true">
        <input id="fecha2" name="fecha2" hidden="true">
    </div>
   </div>
  
  </div>
      
        
  <div class="row">
    @foreach($articulos as $articulo)
      <div class="col-md-4 sortable" id="{{ 'art'.$articulo->id }}" data-index="{{ $loop->index }}" hidden="true">
          <div class="card mb-4 box-shadow" style="width: 18rem;"  >
              <input type="text" value="{{ $articulo->id }}" id="{{ 'inputart'.$articulo->id }}" name="{{ 'articulo'.$loop->index }}" disabled hidden="true">
              <input type="text" value="{{ $articulo->id }}" name="indice" id="indice" disabled hidden="true">
              <img class="card-img-top" src="{{ asset('uploads/Almacen/Articulos/'.$articulo->foto) }}" alt="Card image cap" style="width: 100%; height: 200px;">
              <div class="card-body">
                <h5 class="card-title">Descripcion{{ ' '.$articulo->descripcion}}</h5>
                <p class="card-text">Tipo: {{ ' '.$articulo->tipo }}</p>
                <p class="card-text">Categoria: {{ ' '.$articulo->categoria }}</p>
                <p class="card-text">Existencia:{{ ' '.$articulo->existencia }}</p>
                <p class="card-text">Cantidad <div class="btn btn-outline-danger float-right" id="{{ $articulo->id }}" onclick="quitarTarjeta(this.id);">Cancelar</div> 
                  <input type="number" id="{{ 'cantart'.$articulo->id }}" name="{{ 'cantart'.$articulo->id }}" class="form-control form-control-sm col-3" type="text" value="1" min="1" disabled onkeydown="return false">
                </p>
              </div>
            </div>
                
      </div>

      @if($loop->last)
        
      @endif

      
    @endforeach
  </div>
</form>


    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Articulos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
              <div class="row">
                <div class="col-5">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" id="parametro" name="parametro" placeholder="Buscar por clave">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                    </div>
                  </div>
                </div>
              </div>
                <div class="card-deck">

                  @foreach($articulos as $articulo)
                    <div class="col-6" id="{{ 'selectArt'.$articulo->id }}">
                        <div class="card articuloHover" id="{{ $articulo->id }}" onclick="agregarArticulo(this.id);">
                      
                        <div class="row">
                          <div class="col-md-4">
                              <img src="{{ asset('uploads/Almacen/Articulos/'.$articulo->foto) }}" style="height: 100%; width: 100%;">
                          </div>
                          <div class="col-md-8 px-3">
                            <div class="card-block px-3">
                              <p class="card-text jumbotron-heading">{{ $articulo->tipo.' '.$articulo->descripcion}}</p>
                              <p class="card-text">Existencia:{{ ' '.$articulo->existencia }}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    @if($loop->last)
                        </div>
                    @endif
                    @if($loop->index % 2 == 0 and $loop->index == 1)
                        </div>
                      <div class="row">
                    @endif
                  @endforeach
                  
              
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <a href="#" data-dismiss="modal" class="btn btn-xs btn-danger">Listo</a>
          </div>
        </div>
      </div>
    </div>

    @else

    <div class="alert alert-danger">
        Necesitas Vincular tu cuenta a un Empleado para Agregar Articulos al Almacen
    </div>
@endif

  </tbody>

@stop


@section('scripts')
  <script type="text/javascript">
    $("[type='number']").keypress(function (evt) {
      evt.preventDefault();
    });
      
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");


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
        document.getElementById('txt').innerHTML =
        h + ":" + m + ":" + s;
        //document.getElementById('inputTime').value =
        //h + ":" + m + ":" + s;
        
        $('#hora').val(h + ":" + m + ":" + s);
        $('#fecha').val(diasSemana[today.getDay()] + ", " + today.getDate() + " de " + meses[today.getMonth()] + " de " + today.getFullYear());
        $('#fecha2').val(getFormattedDate(today));
        var t = setTimeout(startTime, 500);
      }
      function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
      }

    $(document).ready(function () {

      $('.articuloHover').click(function() {
        $(this).toggleClass('border-success');
      });
    });

    function agregarArticulo(id){

      $('#botonSubmit').removeAttr('hidden');
      if($("#art"+id).is(':hidden')){

        $('#art'+id).removeAttr('hidden');
        $('#inputart'+id).removeAttr('disabled');
        $('#cantart'+id).removeAttr('disabled');
        $('#art'+id+' > div > #indice').removeAttr('disabled');
        //alert($('#art'+id+' > div > #indice').attr('name'));

      }else{

        $('#art'+id).attr('hidden','true');
        $('#inputart'+id).attr('disabled','disabled');
        $('#cantart'+id).attr('disabled','disabled');
        $('#art'+id+' > div > #indice').attr('disabled','disabled');
        
      }
      $('.sortable').each(function(){
        var $this = $(this);
        $this.append($this.find('.score').get().sort(function(a, b) {
          return $(a).data('index') - $(b).data('index');
        }));
      });

    }

    function quitarTarjeta(id){
      $('#selectArt'+id+' > #'+id).trigger('click');
    }
    
    $('#salidasForm').submit(function() {
      $('#botonSubmit').attr('disabled','disabled');
    });
  </script>

@stop