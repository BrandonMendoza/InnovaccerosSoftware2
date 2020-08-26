
  <div class="modal fade" id="modalDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDocumentosFormLabel">Proceso - Documentos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body h-100">
          <!-- Id del producto editando o agregando -->

          <div class="row">
            <!-- PDFS -->
            <div class="col">
              <form id="formDocumento" method="POST" action="{{URL('/producto/insertDocumento')}}" enctype="multipart/form-data">
              {{csrf_field()}}
                <input type="text" name="producto_id" id="producto_id" value="0" hidden>
                <div class="row">
                  <!-- Cantidad -->
                  <div class="col-7">
                    <div  class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="doc" id="doc">
                        <label id="doc_inputgroup" class="custom-file-label" for="doc"></label>
                      </div>
                    </div>
                  </div>
                  <!-- Nombre Button -->
                  <div class="col-1 align-self-center">
                    nombre:
                  </div>
                  <div class="col-2 align-self-end">
                    <input type="text" id="nombre_usuario" class="form-control" name="nombre_usuario">
                  </div>
                  <!-- Agregar Button -->
                  <div class="col-2 align-self-end">
                    <button type="submit" class="btn btn-flat btn-default" >Agregar</button>
                  </div>
                </div>
              </form>
              <!-- Tabla documentos -->
              <table id="tablaDocumentos" class="table table-hover table-bordered text-nowrap">
                <thead>
                  <tr>
                    <th></th>
                    <th>Nombre Documento</th>
                    <th>Nombre</th>
                    <th style="text-align: center;">Tipo</th>
                    <th style="text-align: right; width: 7%;" data-orderable="false"></th>
                  </tr>
                </thead>
                <tbody> 
                  <!-- Filas de la tabla-->
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="modal-footer align-center">
          <button type="button" class="btn btn-flat btn-danger mr-auto" data-dismiss="modal">
            <i class="fas fa-window-close mr-2"></i>Cerrar
          </button>
        </div>
      </div>
    </div>
  </div>
