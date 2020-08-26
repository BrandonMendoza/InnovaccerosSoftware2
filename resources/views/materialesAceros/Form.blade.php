<form id="formAgregar" method="POST" action="{{URL('/materialesAceros/insert')}}" enctype="multipart/form-data">
  {{csrf_field()}}
  <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="modalFormLabel">Tipo de Material - Agregar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" name="id" id="id" value="0" hidden>
          <div class="form-group">
            <label for="nombre">Nombre del Acero</label>
            <input type="text" id="nombre" class="form-control" name="nombre" 
                value="" >
          </div>
          <div class="form-group">
            <label for="simbolo">Simbolo </label>
            <input id="simbolo" name="simbolo" class="form-control" type="text" value="">
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