<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos'; 

    protected $fillable = ['id','cliente_id','numero_parte_cliente','numero_parte','descripcion','peso_kg','peso_lbs','deleted_at','created_at','updated_at'];

    public function Materiales(){
	    return $this->belongsToMany('App\Material', 'Productos_materiales','producto_id', 'material_id')->withPivot('cantidad')->withTimestamps();
	}

	public function Accesorios(){
	    return $this->belongsToMany('App\Accesorio', 'Productos_accesorios','producto_id', 'accesorio_id')->withPivot('cantidad')->withTimestamps();
	}

	public function Documentos(){
	    return $this->belongsToMany('App\Documento', 'Producto_documento','producto_id', 'documento_id')->withTimestamps();
	}

	public function Cliente()
    {
        return $this->hasOne('App\Cliente','id','cliente_id');
    }

    public function Proyectos(){
	    return $this->belongsToMany('App\Proyecto', 'proyecto_producto','producto_id', 'proyecto_id')->withPivot('id','cantidad','numero_parte_cliente','work_order','item','cantidad','heat_number','notas','hrs_labor','pintura_id','proceso_id')->using('App\ProyectoProducto')->withTimestamps();
	}
	
	public function getProgreso(){
		/*
			1.obtener todos los procesos del proyecto en el que esta el producto
			2.obtener porcentaje por cada proceso del ProyectoProducto
			3.sumar el porcentaje de cada proceso 'Terminado'
				ej. si inicio = 0%, fin = 0%, materiales = 0%, 
					habilitado = 26%, soldadura = 62%, pintura 12%

					si tenemos completado habilitado y soldadura llevamos 88% del progreso del producto
			4. enviamos el total del progreso return progreso;
		*/
		$totalProgreso = 0;
    	foreach ($this->Productos as $id => $producto) {
    		$totalProgreso += (float)$producto->getHrsLabor();
    	}
    	return number_format((float)$totalProgreso, 2, '.', '');

		/*
			Necesitamos:
				1.Hacer configuracion de procesos por cada proyecto y tambien una general
				2.Crear una tabla ProyectoProceso. En esta se guardaran todos los procesos que le configuramos al proyecto. Se podria reconfigurar?
				3.Crear una tabla PoryectoProductoProceso. Esta tendra relacion con ProyectoProceso. En esta se guardara el proceso en el que va un producto en especifico.
					Creo que este ultimo no es necesario si guardamos los porcesos en la tabla ProyectoProducto

					Ej. proyectoProducto->Proceso->getProcesoActual()

					Creo que necesitamos inicio y fin por cada proceso

		*/
	}

	public function getHrsLabor(){
		$cadencia = 20;
		return number_format((float)$this->peso_lbs/$cadencia, 2, '.', '');
	}
}
