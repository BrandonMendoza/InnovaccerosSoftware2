<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{

    protected $table = 'nominas'; 
    protected $hidden = ['pivot'];
	protected $fillable = ['id','ano','mes','semana','total'];
	
    public function empleados(){
    	return $this->belongsToMany('App\Empleado')->withPivot('id','hrs_extra','retardos','faltas',
                                                                                    'lunes_status','lunes_fecha','lunes_hrs_extra',
                                                                                    'martes_status','martes_fecha','martes_hrs_extra',
                                                                                    'miercoles_status','miercoles_fecha','miercoles_hrs_extra',
                                                                                    'jueves_status','jueves_fecha','jueves_hrs_extra',
                                                                                    'viernes_status','viernes_fecha','viernes_hrs_extra',
                                                                                    'sabado_status','sabado_fecha','sabado_hrs_extra',
                                                                                    'domingo_status','domingo_fecha','domingo_hrs_extra');
    }

    public function empleado_nomina(){
    	return $this->belongsTo('App\Empleado_nomina')->with('id');
    }


}
