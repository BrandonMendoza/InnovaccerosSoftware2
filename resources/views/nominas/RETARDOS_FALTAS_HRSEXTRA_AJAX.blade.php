<div class="col-md-2">
            <div class="row">
              <h4 class="jumbotron-heading">Hrs extra 
                <input  type="number" 
                        id="{{'hrs_extra_empleado'.$empleado->pivot->empleado_id}}" 
                        class="form-control" 
                        value="{{ number_format($empleado->pivot->hrs_extra) }}" 
                        onkeypress="return isNumberKey(event)" 
                        onchange="insertarHrsExtra({{$empleado->pivot->empleado_id}},this.value)" 
                        min="0"> 
              </h4>
            </div>
            <div class="row">
              <h4 class="jumbotron-heading">Retardos 
                <input  type="number" 
                        id="{{'retardos_empleado'.$empleado->pivot->empleado_id}}" 
                        class="form-control" 
                        value="{{ number_format($empleado->pivot->retardos) }}" 
                        onkeypress="return isNumberKey(event)" 
                        onchange="insertarRetardos({{$empleado->pivot->empleado_id}},this.value)" 
                        min="0"> 
              </h4>
            </div>
            <div class="row">
              <h4 class="jumbotron-headin">Faltas 
                <input  type="number" 
                        id="{{'faltas_empleado'.$empleado->pivot->empleado_id}}" 
                        class="form-control" 
                        value="{{ number_format($empleado->pivot->faltas) }}" 
                        onkeypress="return isNumberKey(event)" 
                        onchange="insertarFaltas({{$empleado->pivot->empleado_id}},this.value)" 
                        min="0"> 
              </h4>
            </div>  
          </div>