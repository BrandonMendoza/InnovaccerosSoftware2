<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado_nomina extends Model
{
    protected $table = 'empleado_nomina';
    protected $hidden = ['pivot'];
    protected $fillable = [	
    						'id',
    						'lunes_status','lunes_fecha','lunes_hrs_extra',
    						'martes_status','martes_fecha','martes_hrs_extra',
    						'miercoles_status','miercoles_fecha','miercoles_hrs_extra',
    						'jueves_status','jueves_fecha','jueves_hrs_extra',
    						'viernes_status','viernes_fecha','viernes_hrs_extra',
    						'sabado_status','sabado_fecha','sabado_hrs_extra',
    						'domingo_status','domingo_fecha','domingo_hrs_extra',
    					];
    
    public function empleado(){
    	return $this->belongsTo('App\Empleado');
    }

    public function nomina(){
        return $thid->hasOne('App\Nomina');
    }

}
