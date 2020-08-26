<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProyectoProceso extends Model
{
    protected $table = 'proyectos_procesos'; 

    protected $fillable = ['id','proyecto_id','proceso_id','created_id','updated_id','orden','porcentaje','es_ultimo','es_primero','es_estatico'];

    public function Proceso()
    {
        return $this->hasOne('App\Proceso','id','proceso_id');
    }

    public function Proyecto()
    {
        return $this->hasOne('App\Proyecto','id','proyecto_id');
    }

    
    /*
    public function ProyectosProcesosProductos(){
    	return $this->hasOne('App\ProyectoProcesoProducto','id','proyecto_id');	
    }*/
}
