<form id="formAgregar" method="POST" action="{{URL('/producto/insert')}}" enctype="multipart/form-data">
  {{csrf_field()}}
  <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFormLabel">Proceso - Agregar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body h-100">
          <!-- Id del producto editando o agregando -->
          <input type="text" name="id" id="id" value="0" hidden>
          <!-- Numero de parte local del producto editando o agregando -->
          <input type="text" name="numero_parte" id="numero_parte" value="0" hidden>
          <!-- Cantidad de filas de la tabla Materiales -->
          <input type="text" name="filas_mat_cant" id="filas_mat_cant" value="0" hidden>
          <!-- Cantidad de filas de la tabla Accesorios -->
          <input type="text" name="filas_acc_cant" id="filas_acc_cant" value="0" hidden>

          <div class="row">
            <div class="col-3">
              <div class="form-group">
                <h4 id="numero_parte_text"></h4>
              </div>
              <div class="form-group">
                <label for="numero_parte">Cliente</label>
                <select class="form-control custom-select select2Form" id="cliente_id" name="cliente_id">
                  <option value=""> - seleccionar cliente - </option>
                  @foreach($clientes as $id => $cliente)
                    <option value="{{ $cliente->id }}" >
                      {{ $cliente->nombre_cliente}}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="numero_parte_cliente">Numero de Parte (Cliente)</label>
                <input type="text" class="form-control" id="numero_parte_cliente"  name="numero_parte_cliente" >
              </div>
              <div class="form-group">
                <label for="peso_kg">Peso (kg) </label>
                <input type="text" class="form-control justNumber" id="peso_kg"  name="peso_kg" onchange="calcularKgsToLbs();">
              </div>
              <div class="form-group">
                <label for="peso_lbs">Peso (lbs) </label>
                <input type="text" class="form-control justNumber" id="peso_lbs"  name="peso_lbs" onchange="calcularLbsToKgs();">
              </div>
            </div>

            <div class="col-9 border-left" >
              <!-- TABS -->

              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#mat">Materiales</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#acc">Accesorios</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#desc">Descripción</a>
                </li>
              </ul> 

              <div class="tab-content">
                <!-- MATERIALES Y ACCESORIOS -->
                <div id="mat" class="tab-pane container active">
                  <div class="row h-100 pb-3 pt-3">
                    <div class="col">

                      <div class="row">
                        <!-- Material -->
                        <div id="col_material_select" class="col-7">
                          <select class="form-control custom-select select2Form" id="material_select">
                            <option value=""> - seleccionar material - </option>
                            @foreach($materiales as $id => $material)
                              <option value="{{ $material->id }}" id="mat_{{ $material->id }}">
                                {{ $material->getNombreMaterial()}}
                              </option>
                            @endforeach
                          </select>
                        </div>
                        <!-- Cantidad -->
                        <div class="col-1 align-self-center">
                          cantidad:
                        </div>
                        <div class="col-2">
                          <input placeholder="cantidad" type="number" id="material_cant" class="form-control justNumber no-spinners" value="1" min="1" step="1">
                        </div>
                        <!-- Agregar button -->
                        <div class="col-2 align-self-end">
                          <button type="button" class="btn btn-flat btn-default" onclick="agregarMat();">Agregar</button>
                        </div>
                      </div>
                      <!-- Tabla Materiales -->
                      <table id="tablaMateriales" class="table table-hover table-bordered text-nowrap" >
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
                

                  <!-- DESCRIPCION -->
                <div id="acc" class="tab-pane container fade">
                  <div class="row h-100 pb-3 pt-3">
                    <div class="col">
                      <div class="row">
                        <!-- Accesorio -->
                        <div id="col_accesorio_select" class="col-7">
                          <select class="form-control custom-select select2Form" id="accesorio_select">
                            <option value=""> - seleccionar accesorio - </option>
                            @foreach($accesorios as $id => $accesorio)
                              <option value="{{ $accesorio->id }}" >
                                {{ $accesorio->descripcion}}
                              </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-1 align-self-center">
                          cantidad:
                        </div>
                        <!-- Cantidad -->
                        <div class="col-2">
                          <input type="number" id="accesorio_cant" class="form-control justNumber no-spinners" value="1" min="1" step="1">
                        </div>
                        <!-- Agregar Button -->
                        <div class="col-2 align-self-end">
                          <button type="button" class="btn btn-flat btn-default" onclick="agregarAcc();">Agregar</button>
                        </div>
                      </div>

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

                <!-- DESCRIPCION -->
                <div id="desc" class="tab-pane container fade">
                  <div class="p-3">
                    <textarea placeholder="..." class="form-control" name="descripcion" id="descripcion" rows="10"></textarea>
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
</form> 