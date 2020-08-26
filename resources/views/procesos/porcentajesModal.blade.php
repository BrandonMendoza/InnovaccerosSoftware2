
<form id="formPorcentaje" method="POST" action="{{URL('/procesos/guardarPorcentaje')}}" enctype="multipart/form-data">
  {{csrf_field()}}


<div class="modal fade" id="modalPorcentajes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFormLabel">Procesos - Porcentajes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <div class="progress" id="progressPorcentajes">
            @foreach($procesos as $id => $proceso)
              <div id="{{'progres_'.$proceso->id}}" class="progress-bar" data-toggle="popover" data-trigger="hover" data-content="{{ $proceso->nombre }}" style="width: {{ $proceso->porcentaje  }}%; background-color: {{ $proceso->color  }}; color:{{ $proceso->texto_color }}">
              </div>
            @endforeach
          </div> 


          <br>
          
            <table id="tablaPorcentajes" class="table table-hover text-nowrap projects">
            <thead>
              <tr>
                <th width="15%">Proceso</th>
                <th>Porcentaje</th>
                <th >COLOR</th>
                <th>TEXTO COLOR</th>
              </tr>
            </thead>
            <tbody>
                
              
            </tbody>
          </table>
            
          
        </div>
        <div class="modal-footer align-center">
          <button type="button" class="btn btn-flat btn-danger mr-auto" data-dismiss="modal">
            <i class="fas fa-window-close mr-2"></i>Cancelar
          </button>

          <button type="button" class="btn btn-flat btn-success" onclick="submitFormPorcentaje();">
            <i class="fas fa-check-square mr-2"></i><span id="textAgregarForm">Guardar</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</form>