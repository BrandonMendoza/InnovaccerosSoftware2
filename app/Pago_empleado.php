<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago_empleado extends Model
{
    protected $table = 'pagos_empleado'; 
    protected $hidden = ['pivot'];

    public function deuda(){
    	return $this->belongsTo('App\Deuda');
    }

    public function nomina(){
    	return $this->belongsTo('App\Empleado_nomina');
    }
}
