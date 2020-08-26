
<!-- Modal -->  
<form id="formAgregar" method="POST" action="{{URL('/proyectos/ordenAbiertaInsert')}}" enctype="multipart/form-data">
  {{csrf_field()}}
  <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="modalFormLabel">Proyecto - Agregar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" name="id" id="id" value="0" hidden>
          <div class="labelsForm">
            <div class="form-group">
            Proyecto: <label id="proyectoLabel"></label>
            </div>  
            <div class="form-group">
              Producto: <label id="productoLabel"></label>
            </div>  
          </div>
          

          <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="text" id="cantidad" name="cantidad" min="1" class="form-control justNumber no-spinners" >
          </div>

          <div class="form-group">
            <label for="work_order">Orden de Trabajo</label>
            <input  type="text" id="work_order" name="work_order" class="form-control" >
          </div>

          <div class="form-group">
            <label for="item">Item</label>
            <input  type="text" id="item" name="item" class="form-control justNumber no-spinners" >
          </div>

          

          <div class="form-group">
            <label for="heat_number">Heat Number</label>
            <input  type="text" id="heat_number" name="heat_number" class="form-control" >
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