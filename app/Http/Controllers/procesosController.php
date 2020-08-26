<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proceso;

class procesosController extends Controller
{
    public function show(){
		$data['procesos'] = Proceso::get();
		return view('procesos.show')->with($data);
	}

    public function cargarTablaProcesos(){
        $procesos = Proceso::get();
        return response()->json($procesos);
    }

    public function cargarTablaPorcentajes(){
        $procesos = Proceso::orderBy('orden', 'ASC')->where([['activo','=','1'],['es_estatico','=','0']])->get();
        return response()->json($procesos);
    }

    public function guardarPorcentajes(Request $request){
        //obtenemos las cantidades y los id de las tablas
        $ids = $request->get('idProceso');
        $porcentajes = $request->get('porcentaje');
        //contamos la cantidad para poder hacer el loop
        $cant = count($ids);
        
        //Actualizamos los porcentajes
        for ($i=0; $i < $cant; $i++) {
            $proceso = Proceso::find($ids[$i]);
            $proceso->porcentaje = $porcentajes[$i];
            $proceso->update();
        }
        
        $procesos = Proceso::get();
        return response()->json($procesos);//fin
    }

	public function delete(Request $request){
        $proceso = Proceso::find($request->id);

        $procesos = Proceso::where([['activo','=','1'],['es_estatico','=','0']])->orderBy('orden', 'DESC')->get();
        foreach ($procesos as $id => $procesoLoop) {
            $procesoLoop->orden--;
            $procesoLoop->update();
            if($procesoLoop->orden == $proceso->orden){
                break;
            }
        }
        if($proceso->porcentaje > 0 && $procesos->count() > 1){
            $randomProceso = Proceso::where([['activo','=','1'],['es_estatico','=','0']])->orderBy('orden', 'DESC')->first();
            $randomProceso->porcentaje += $proceso->porcentaje;
            $randomProceso->update();

        }

        $proceso->delete();
        //consultamos todos los procesos
        $procesos = Proceso::get();
        return response()->json($procesos); //Fin
    }
    public function cargarTablaOrdenModal(){
        $procesos = Proceso::where('activo',1)->orderBy('orden', 'DESC')->get();
        return response()->json($procesos);
    }

    /*Funcion para activar y desactivar proceso em base de datos*/
    public function activarDesactivar($activo,$idProceso){
        $proceso = Proceso::find($idProceso);
        $procesos = Proceso::   where([['activo','=','1'],['es_estatico','=','0']])->
                                orderBy('orden', 'DESC')->
                                get();
        //activar
        if($activo == 1 && $proceso->activo == 0){
            $ultimoProceso = Proceso::where('es_estatico',0)->orderBy('orden', 'DESC')->first();
            $proceso->orden = ($ultimoProceso->orden+1);
            $proceso->activo = 1;
            $proceso->porcentaje = 0;
            if($procesos->count() == 0){
                $proceso->porcentaje = 100;
            }
            $proceso->update();//Fin
        }
        //desactivar
        //si el proceso estaba activo y se desactiva
        elseif ($activo == 0 && $proceso->activo == 1) {
            //acomodamos el orden de los procesos
            foreach ($procesos as $id => $procesoLoop) {
                $procesoLoop->orden--;
                $procesoLoop->update();
                if($procesoLoop->id == $proceso->id){
                    break;
                }
            }
            $auxPorcentaje = $proceso->porcentaje;
            $proceso->orden = 0;
            $proceso->activo = 0;
            $proceso->porcentaje = 0;
            $proceso->update();//Fin


            $procesos = Proceso::   where([['activo','=','1'],['es_estatico','=','0']])->
                                    orderBy('orden', 'DESC')->
                                    get();
            $ultimoProceso = $procesos->first();
            //pasamos el porcentaje a otro proceso
            if($auxPorcentaje > 0 && $procesos->count() > 0){
                $ultimoProceso->porcentaje += $auxPorcentaje;
                $ultimoProceso->update();
            }

        }

        
    }

    public function updateOrder(Request $request){
        $procesos = $request->get('procesos');
        $count = count(collect($request)->get('procesos'));

        for ($i=0; $i < $count; $i++) {
            $proceso = Proceso::find($procesos[$i]['id']);
            $proceso->orden = $procesos[$i]['orden'];
            $proceso->update();
        }
    }

	public function insert(Request $request)
    {
        $proceso = [ 	
            'nombre' => $request->nombre, 
            'simbolo' => $request->simbolo, 
        	'color' => $request->color,
            'texto_color' => $request->texto_color,
        ];
        
        if($request->id != 0){
        	//Si es editar
            $proceso += ['id' => $request->id];
            $save = Proceso::find($request->id)->update($proceso);
            //activar o desactivar y ordenar
            $this->activarDesactivar($request->activo,$request->id);
        }else{
            if($request->activo == 1){
                $ultimoProceso = Proceso::orderBy('orden', 'DESC')->first();
                $proceso += [ 'orden' => ($ultimoProceso->orden+1)];
            }else{
                $proceso += [ 'orden' => 0];
            }
            //Si es Agregar
            $save = Proceso::create($proceso);    
        }
        //consultamos todos los materialesClientes
        $procesos = Proceso::get();
        return response()->json($procesos); //Fin
    }
}
