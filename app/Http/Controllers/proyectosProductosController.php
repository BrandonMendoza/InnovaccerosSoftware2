<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProyectoProducto;
use App\ProyectoProceso;
use App\ProyectoProcesoProducto;
use App\Cliente;
use App\Proceso;
use Auth;

class proyectosProductosController extends Controller
{
    public function cambiarProceso(Request $request){
    	/*Se busca el PPP de el producto y el proceso*/
    	$proyectoProcesoProducto = ProyectoProcesoProducto::where([
    															['proyecto_proceso_id',$request->proceso_actual],
							                                    ['proyecto_producto_id',$request->id]
							                                ])	
    														->first();
    	/*Se actualiza su update_At*/
    	$proyectoProcesoProducto->touch(); 
    	/*Se preparan los datos del From para introducirse a la BD*/
    	$proyectoProcesoProducto = [
    							'proyecto_proceso_id' => $request->proceso_nuevo,
    							'proyecto_producto_id' => $request->id,
    							'user_id' => Auth::id(),
    						];
    	/*Se hace el insert*/
    	$save = ProyectoProcesoProducto::create($proyectoProcesoProducto);
    	/*Se regresan los datos para actualizar la tabla*/
    	 $ordenesAbiertas =  ProyectoProducto::loadOrdenesAbiertasWithAll();
        return response()->json($ordenesAbiertas);
    }

    public function ordenesAbiertas(){
        $data = [  
            'clientes' => Cliente::All(),
            'procesos' => Proceso::All(),
            'OrdenesAbiertas' => ProyectoProducto::loadOrdenesAbiertasWithAll()
        ];
        return view('proyectosProductos.ordenesAbiertas')->with($data);
    }
}
