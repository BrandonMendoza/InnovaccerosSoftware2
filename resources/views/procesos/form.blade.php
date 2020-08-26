<form id="formAgregar" method="POST" action="{{URL('/proceso/insert')}}" enctype="multipart/form-data">
  {{csrf_field()}}
  <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="modalFormLabel">Proceso - Agregar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Id del proceso que se esta editando ("0" si es agregar) -->
          <input type="text" name="id" id="id" value="0" hidden>
          <!-- Activo -->
          <input type="text" name="activo" id="activo" value="1" hidden>

          <div id="rowActivo" class="row justify-content-end mr-3">
            <div class="custom-control custom-checkbox ">
              <input class="custom-control-input" type="checkbox" id="activoCheckbox">
              <label for="activoCheckbox" class="custom-control-label">Activo</label>
            </div>
          </div>
          
          <div class="form-group">
            <label for="nombre">Nombre del Proceso</label>
            <input type="text" id="nombre" class="form-control" name="nombre" 
                value="" >
          </div>
          <div class="form-group">
            <label for="simbolo">Simbolo </label>
            <input id="simbolo" name="simbolo" class="form-control" type="text" value="">
          </div>

          <div class="form-group">
            <div id="color-label">
              <label  for="color">Color </label>  
            </div>
            <div class="input-group color-picker colorpicker-element" data-colorpicker-id="2" onchange="onChangeColor();">
              <input id="color" name="color" type="text" class="form-control" value="#FFFFFF">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-square" style=""></i></span>
              </div>
            </div>
          </div>

          <div class="form-group">
              <label  for="texto_color">Color del Texto </label>  
              <select id="texto_color" name="texto_color" class="form-control" onchange="onChangeColor();">
                <option value="#000000">Negro</option>
                <option value="#FFFFFF">Blanco</option>
              </select>
          </div>
          
          <div class="row">
            <div class="col"></div>
            <div id="preview" class="col text-center">
              <b>EJEMPLO</b>
            </div>
            <div class="col"></div>
          </div>
        </div>

        <div class="modal-footer align-center">
          <button type="button" class="btn btn-flat btn-danger mr-auto" data-dismiss="modal">
          <i class="fas fa-window-close mr-2"></i>Cancelar
          </button>
          <button class="btn btn-flat btn-success">
            <i class="fas fa-check-square mr-2"></i><span id="textAgregarForm">Agregar</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</form> 