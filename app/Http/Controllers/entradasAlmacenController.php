<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use App\Articulo;
use App\Empleado;
use App\transaccion_tiene_articulo;
use App\TransaccionAlmacen;
use App\registro_actividad;

class entradasAlmacenController extends Controller
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
        $this->createActivity(
            auth()->user()->id,
            'Entradas de Articulos',
            'Entro a Entrada de Articulos'
        );
		return view('almacen.entradasSalidas.entradas',$articulos);
    }

    public function articulosSeleccionados(Request $request){

        return DB::transaction(function () use ($request) {
    	// CONVERTIMOS A ARRAY EL REQUEST
    	$articulos = $request->all();
    	//OBTENEMOS EL EMPLEADO QUE REALIZA LA TRANSACCION
        
    	$empleado = auth()->user()->empleado_id;

    	//LA HORA DE LA TRANSACCION
    	$hora = data_get($articulos,'hora');

    	//LA FECHA DE LA TRANSACCION
    	$fecha = data_get($articulos,'fecha');

        //FECHA FORMATO mm/dd/yyy
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
            'cantidad_articulos' => 0,
    	];
    	
    	if(count($articulos) > 5){

	    	$save = TransaccionAlmacen::create($transaccion);

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
	    			$existencia = $existencia + $cantidad;

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
                'Entradas de Articulos',
                'Agrego existencia en '.$cant_articulos.' Articulos del Almacen'
            );
	    	return redirect()->back()->with('message', 'Se ha completado la transaccion');
    	}else{
    		return redirect()->back()->with('errorArticulo', 'Debes de seleccionar algun articulo para realizar una transaccion');
    	}
        });
    }
}
