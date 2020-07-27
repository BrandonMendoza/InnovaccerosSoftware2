<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use App\Articulo;
use App\Empleado;
use App\transaccion_tiene_articulo;
use App\registro_actividad;
use App\TransaccionAlmacen;

class salidasAlmacenController extends Controller
{

    public function createActivity($user,$catalogo,$descripcion){
        $actividad =  [
            'user_id' => $user,
            'catalogo' => $catalogo,
            'descripcion' => $descripcion,
        ];

        $save = registro_actividad::create($actividad);
    }

    public function show(){
     	$articulos['articulos'] = Articulo::all();
     	$empleados['empleados'] = Empleado::all();
     	$articulosSeleccionados['articulosSeleccionados'] = [];
        $this->createActivity(
            auth()->user()->id,
            'Salidas de Articulos',
            'Entro a Salida de Articulos de Almacen'
        );
		return view('almacen.entradasSalidas.salidas',$articulos)->with($empleados)->with($articulosSeleccionados);
    }

    public function articulosSeleccionados(Request $request){
    	return DB::transaction(function () use ($request) {
        	$this->validate($request,[
                'empleado' => 'required|not_in:0'
            ]);


        	// CONVERTIMOS A ARRAY EL REQUEST
        	$articulos = $request->all();
        	//OBTENEMOS EL EMPLEADO QUE REALIZA LA TRANSACCION
        	$empleado = data_get($articulos,'empleado');

        	//LA HORA DE LA TRANSACCION
        	$hora = data_get($articulos,'hora');

        	//LA FECHA DE LA TRANSACCION
        	$fecha = data_get($articulos,'fecha');

            //FECHA EN FORMATO mm/dd/yyyy
            $fecha2 = data_get($articulos,'fecha2');

        	//INDICE PARA SABER EL LOOP DE ARTICULOS
        	$cont = data_get($articulos,'indice');

        	//TIPO DE TRANSACCION
        	$tipo = data_get($articulos,'tipo');

        	//NOMBRE DEL ALMACENISTA
    		
    		$transaccion = [
        		'fecha' => $fecha,
                'fecha2' => $fecha2,
        		'hora' => $hora,
        		'tipo' => $tipo,
        		'empleado_id' => $empleado,
                'cantidad_articulos'=> 0,
        	];
        	//dd(count($articulos));
            $save = TransaccionAlmacen::create($transaccion);
        	if(count($articulos) > 6){
    	    	
    	    	//dd($transaccion);
    	    	$idTransaccion = $save->id;
    	    	//dd($cont);
                $cant_articulos = 0;
    	    	for ($i=0; $i < $cont; $i++) {
    	    		//BUSCANDO LOS ARTICULOS EN EL ARRAY DEL REQUEST
    	    		$articuloid = data_get($articulos, 'articulo'.$i);
    	    		$cantidad = data_get($articulos,'cantart'.$articuloid);
    	    		
    	    		if(!$cantidad == null){
                        $cant_articulos++;
    	    			//DISMINUIR LA EXISTENCIA EN ARTICULOS APARTIR DEL ID
    	    			$buscarArticulo = Articulo::find($articuloid);
    	    			//dd($buscarArticulo);
    	    			$existencia = $buscarArticulo->existencia;
    	    			$existencia = $existencia - $cantidad;

    	    			$articuloActualizado = [
    	    				'existencia' => $existencia,
    	    			];

    	    			$actualizarExistencia = Articulo::find($articuloid)->update($articuloActualizado);

    	    			$articulo_de_transaccion = [
    	    				'articulo_id' => $articuloid,
    	    				'transaccion_id' => $idTransaccion,
    	    				'cantidad' => $cantidad,
    	    			];

    	    			$saveArticulo_Transaccion = transaccion_tiene_articulo::create($articulo_de_transaccion);
    	    		}
    	    	}
                $transaccion = TransaccionAlmacen::find($idTransaccion);

                // Make sure you've got the Page model
                if($transaccion) {
                    $transaccion->cantidad_articulos = $cant_articulos;
                    $transaccion->save();
                }

                $this->createActivity(
                    auth()->user()->id,
                    'Salidas de Articulos',
                    'Se retiro '.$cant_articulos.' tipos de Articulos del Almacen'
                );
    	    	
    	    	return redirect()->back()->with('message', 'Se ha completado la transaccion');
    	    	//return $this->show();
        	}else{
        		return redirect()->back()->with('errorArticulo', 'Debes de seleccionar algun articulo para realizar una transaccion');
        	}
        });
    }
}
