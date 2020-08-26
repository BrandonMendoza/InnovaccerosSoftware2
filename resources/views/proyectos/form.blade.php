
<!-- Modal -->  
<form id="formAgregar" method="POST" action="{{URL('/proyectos/insert')}}" enctype="multipart/form-data">
  {{csrf_field()}}
  <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="modalFormLabel">Proyecto - Agregar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body h-100">
          <!-- Id del proyecto editando o agregando -->
          <input type="text" name="id" id="id" value="0" hidden>
          <!-- Numero de parte local-->
          <input type="text" name="numero_parte" id="numero_parte" value="" hidden>

          <div class="row">
            <div class="col-3">
              <div class="labelsForm">
                <div class="form-group">
                  Proyecto: <label id="proyectoLabel"></label>
                </div>
              </div>
          

              <div class="form-group">  
                <label for="cliente">Cliente </label>
                <select class="form-control custom-select select2Form" id="cliente_id" name="cliente_id">
                  <option value=""> </option>
                  @foreach($clientes as $id => $cliente)
                    <option value="{{ $cliente->id }}" >
                      {{ $cliente->nombre_cliente}}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="numero_parte_cliente">Número de Parte (Cliente)</label>
                <input type="text"  name="numero_parte_cliente" id="numero_parte_cliente" class="form-control" value="">
              </div>

              <div class="form-group">
                <label for="orden_compra">Orden de Compra (Cliente)</label>
                <input type="text"  name="orden_compra" id="orden_compra" class="form-control" value="">
              </div>

              <div class="form-group">
                <label for="plan_corte">Plan de Corte</label>
                <input  type="text" id="plan_corte" name="plan_corte" class="form-control" >
              </div>

              <div class="form-group">
                <label for="fecha_entrega">Fecha de Entrega</label>
                <input id="fecha_entrega" name="fecha_entrega" >
              </div>
            </div>

            <div class="col-9 border-left" >
              <!-- TABS -->
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#prod">Productos</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#serv">Servicios</a>
                </li>
              </ul> 

              <div class="tab-content">
                <!-- PRODUCTOS -->
                <div id="prod" class="tab-pane container active">
                  <div class="row h-100 pb-3 pt-3">
                    <div class="col">

                      <div class="row">
                        <!-- Accesorio -->
                        <div id="col_producto_select" class="col-4 align-self-end">
                          <select class="form-control custom-select select2Form" id="producto_select">
                            <option value=""> - seleccionar producto - </option>
                            @foreach($productos as $id => $producto)
                              <option value="{{ $producto->id }}" id="mat_{{ $producto->id }}">
                                {{ $producto->numero_parte}}
                              </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-1 align-self-end">
                          cantidad
                          <input type="number" id="producto_cant" class="form-control justNumber no-spinners" value="1" min="1" step="1">
                        </div>
                        <!-- Cantidad -->
                        <div class="col-1 align-self-end">
                          Item
                          <input type="number" id="producto_item" class="form-control justNumber no-spinners" min="1" step="1">
                        </div>
                        <!-- Cantidad -->
                        <div class="col-2 align-self-end">
                          Orden de Trabajo
                          <input type="text" id="producto_work_order" class="form-control">
                        </div>
                        
                        <!-- Cantidad -->
                        <div class="col-2 align-self-end">
                          Heat Number
                          <input type="text" id="producto_heat_number" class="form-control">
                        </div>
                        <!-- Agregar Button -->
                        <div class="col-2 align-self-end">
                          <button type="button" class="btn btn-flat btn-success" onclick="agregarProd();">
                          <i class="fas fa-plus mr-2"></i>Agregar</button>
                        </div>
                      </div>
                      <!-- Tabla Materiales -->
                      
                        <table id="tablaProductos" class="table table-hover table-bordered text-nowrap" >
                          <thead>
                            <tr>
                              <th hidden>#</th>
                              <th style="text-align: center; width: 53%;">Producto</th>
                              <th style="text-align: center; width: 10%;">Cant</th>
                              <th style="text-align: center; width: 10%;">Item</th>
                              <th style="text-align: center; width: 10%;">Orden de Trabajo</th>
                              <th style="text-align: center; width: 10%;">Heat Number</th>
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
                
                  <div id="serv" class="tab-pane container fade">
                    <div class="row h-100 pb-3 pt-3">
                      <div class="col">
                        <div class="row">
                          <!-- Accesorio -->
                          <div id="col_accesorio_select0" class="col-4 align-self-end">
                            <select class="form-control custom-select select2Form" id="accesorio_select0">
                              <option value=""> - seleccionar accesorio - </option>
                            </select>
                          </div>
                          <div class="col-1 align-self-end">
                            cantidad
                            <input type="number" id="accesorio_cant0" class="form-control justNumber no-spinners" value="1" min="1" step="1">
                          </div>
                          <!-- Cantidad -->
                          <div class="col-1 align-self-end">
                            Item
                            <input type="number" id="accesorio_cant0" class="form-control justNumber no-spinners" value="1" min="1" step="1">
                          </div>
                          <!-- Cantidad -->
                          <div class="col-2 align-self-end">
                            Orden de Trabajo
                            <input type="number" id="accesorio_cant0" class="form-control justNumber no-spinners" value="1" min="1" step="1">
                          </div>
                          
                          <!-- Cantidad -->
                          <div class="col-2 align-self-end">
                            Heat Number
                            <input type="number" id="accesorio_cant0" class="form-control justNumber no-spinners" value="1" min="1" step="1">
                          </div>
                          <!-- Agregar Button -->
                          <div class="col-2 align-self-end">
                            <button type="button" class="btn btn-flat btn-success" onclick="agregarAcc();">
                            <i class="fas fa-plus mr-2"></i>Agregar</button>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <!-- Tabla Accesorios -->
                          <table id="tablaAccesorios" class="table table-hover table-bordered text-nowrap">
                            <thead>
                              <tr>
                                <th hidden>#</th>
                                <th>Descripción</th>
                                <th style="text-align: center; width: 10%;">Cant</th>
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
                  </div>

            </div>
          </div>
        </div>

        <div class="modal-footer align-center">
          <button type="button" class="btn btn-flat btn-danger mr-auto" data-dismiss="modal">
            <i class="fas fa-window-close mr-2"></i>Cancelar
          </button>

          <button type="submit" class="btn btn-flat btn-success">
            <i class="fas fa-check-square mr-2"></i><span id="textAgregarForm">Agregar</span>
          </button>
        </div>

      </div>

        
      </div>
    </div>
  </div>
</form> 