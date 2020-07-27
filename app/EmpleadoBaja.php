<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleadoBaja extends Model
{
	public $table = "EmpleadosBaja";
    protected $fillable = ['id','foto','clave', 'nombre','apellido1','apellido2','fecha_nac','edad','fecha_entrada','tiempo_trabajando','telefono1','telefono2','direccion','email','roles','SubRoles','salario_semanal','num_imss','identificacion','acta_nacimiento','comprobante_domicilio','rfc','curp','carta_no_antecedentes'];
}
