
<!-- Modal -->  
<form id="formCambiarProceso" method="POST" action="{{URL('/proyectos/cambiarProceso')}}" enctype="multipart/form-data">
  {{csrf_field()}}
  <div class="modal fade" id="modalCambiarProceso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="modalFormLabel"><i class="fas fa-exchange-alt mr-2"></i>   Cambiar Proceso</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="overlay-wrapper">
  
          <div class="modal-body">
            <input type="text" name="id" id="proyecto_producto_id" value="0" hidden>
            <input type="text" name="proceso_actual" id="proceso_actual" value="0" hidden>
            <input type="text" name="proceso_nuevo" id="proceso_nuevo" value="0" hidden>

            <div class="row">
              <div class="col-4 align-self-end" >
                <button onclick="cambiarProceso(-1)" type="button" id="btn_ant" class="btn btn-light btn-flat">
                  <i class="fas fa-backward mr-2"></i>Anterior
                </button>
              </div>
              <div class="col-4 text-center">
                <label id="nombre_proceso">MATERIALES</label>
              </div> 

              <div class="col-4 text-center align-self-end" hidden>
                  <input id="fecha_proceso" name="fecha_proceso">
              </div>
              <div class="col-4 text-right align-self-end">
                <button type="button" onclick="cambiarProceso(1)" id="btn_sig" class="btn btn-flat btn-default">
                  Siguiente<i class="fas fa-forward ml-2"></i>
                </button>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">

                 <div id="progressPorcentajes" class="progress progress-striped">
                </div>
              </div>
            </div>
          </div>
          <div id="cambiarProcesoOverlay" class="overlay">
            <i class="fas fa-3x fa-sync-alt fa-spin"></i> <br>
            <div class="text-bold pt-2">Cargando...</div>
          </div>
        </div>
        <div class="modal-footer align-center">
          <button type="button" class="btn btn-flat btn-danger mr-auto" data-dismiss="modal">
          <i class="fas fa-window-close mr-2"></i>Cancelar
          </button>
          <button type="button" id="btn_guardar" class="btn btn-flat btn-success" onclick="submitFormCambiarProceso();">
            <i class="fas fa-check-square mr-2"></i><span id="textAgregarForm">Guardar</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</form> 
