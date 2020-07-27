<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
     protected $table = 'trabajos'; 

    protected $fillable = ['id','descripcion_trabajo','nombre_trabajo','cliente_id', 'fecha_inicio','fecha_termino','fecha_real_inicio','fecha_real_termino','status','atencion_a','proceso','telefono_atencion','cotizado','fecha_alternativa','dias_habiles','pagado_status','notas_trabajo','orden_compra','numero_factura','tiempo_pago','tipo_cambio','valides'];

    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }
}
