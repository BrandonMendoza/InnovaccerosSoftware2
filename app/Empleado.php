<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
	protected $table = 'empleados'; 
	use SoftDeletes;
    protected $hidden = ['pivot'];

    protected $fillable = ['id','foto','rate','clave', 'nombre','apellido1','apellido2','fecha_nac','edad','fecha_entrada','tiempo_trabajando','telefono1','telefono2','direccion','email','roles','subRoles','salario_semanal','num_imss','identificacion','acta_nacimiento','comprobante_domicilio','rfc','curp','carta_no_antecedentes'];

    public function coments()
    {
        return $this->hasMany('App\Comentarios');
    }

    public function nominas(){
    	return $this->belongsToMany('App\Nomina')->withPivot( 'id',
                                                                                'hrs_extra',
                                                                                'retardos',
                                                                                'faltas',
                                                                                'lunes_status','lunes_fecha','lunes_hrs_extra',
                                                                                'martes_status','martes_fecha','martes_hrs_extra',
                                                                                'miercoles_status','miercoles_fecha','miercoles_hrs_extra',
                                                                                'jueves_status','jueves_fecha','jueves_hrs_extra',
                                                                                'viernes_status','viernes_fecha','viernes_hrs_extra',
                                                                                'sabado_status','sabado_fecha','sabado_hrs_extra',
                                                                                'domingo_status','domingo_fecha','domingo_hrs_extra'
                                                                            );
    }

    public function empleados_nomina(){
        return $this->hasMany('App\Empleado_nomina');
    }

    public function deudas()
    {
        return $this->hasMany('App\Deuda');
    }
}