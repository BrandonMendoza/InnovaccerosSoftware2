<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProyectoProcesoProducto extends Pivot
{
    protected $table = 'proyecto_proceso_proyecto_producto'; 

    protected $fillable = ['id','proyecto_proceso_id','proyecto_producto_id','user_id','created_at','updated_at'];

    public function ProyectoProceso()
    {
        return $this->hasOne('App\ProyectoProceso','id','proyecto_proceso_id');
    }


    public function ProyectoProducto()
    {
        return $this->hasOne('App\ProyectoProducto','id','proyecto_producto_id');
    }

    public function getProceso(){
        return $this->ProyectoProceso()->Proceso();
    }

    public function User()
    {
        return $this->hasOne('App\User','id','user_id');
    }
}
