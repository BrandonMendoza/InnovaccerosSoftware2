<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gastos_varios extends Model
{
    protected $table = 'gastos_varios'; 

    protected $fillable = ['gastos_admin_ganancia','gastos_admin_total','desgaste_herramienta_ganancia','desgaste_herramienta_total','mantenimiento_ganancia','mantenimiento_total','seguridad_ganancia','seguridad_total'];
}
