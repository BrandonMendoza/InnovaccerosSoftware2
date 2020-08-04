<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accesorio;
use App\MaterialAcero;

class accesoriosController extends Controller
{
     public function show(){
    	$data['materialesAceros'] = MaterialAcero::All();
		$data['accesorios'] = Accesorio::All();
		return view('accesorios.show')->with($data);
	}

	public function delete(Request $request){
		//buscar y eliminar
		$accesorio = Accesorio::find($request->id);
		$accesorio->delete();

		//Obtener listado actualizado para mostrar en Show.blade.php
        $accesorios = Accesorio::with(['Acero'])->get();
        return response()->json($accesorios);//Fin
	}

	public function insertForm(Request $request)
	{
		$accesorio = [
			'acero_id' => $request->acero_id,
            'numero_parte' => $request->numero_parte,
            'descripcion' => $request->descripcion,
            'peso_kg' => $request->peso_kg,
            'catalogo' => 2,
        ];
        //Si es Editar agregar el id
        if($request->id != 0){
            $accesorio += ['id' => $request->id];
            $save = Accesorio::find($request->id)->update($accesorio);
        }else{
            //Si es Agregar
            $save = Accesorio::create($accesorio);
        }
        //Obtener listado actualizado para mostrar en Show.blade.php
        $accesorios = Accesorio::with(['Acero'])->get();
        return response()->json($accesorios);//Fin
	}
}
