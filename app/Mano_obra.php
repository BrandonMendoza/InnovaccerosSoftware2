<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mano_obra extends Model
{
    protected $table = 'mano_obra'; 

    protected $fillable = ['id','id_cotizacion','operador_cantidad','operador_hrs','operador_costo_hr','operador_subtotal','operador_ganancia','operador_total','tecnico_cantidad','tecnico_hrs','tecnico_costo_hr','tecnico_subtotal','tecnico_ganancia','tecnico_total'];
}
