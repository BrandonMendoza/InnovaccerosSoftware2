<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
	protected $fillable = ['id','empleado_id','monto','tipo','plazo','pagado','restante_pagar'];
    public function empleado(){
    	return $this->belongsTo('App\Empleado');
    }

    public function pagos(){
    	return $this->hasMany('App\Pago_empleado');
    }
}
