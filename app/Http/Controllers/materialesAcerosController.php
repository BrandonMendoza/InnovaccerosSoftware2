<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialAcero;

class materialesAcerosController extends Controller
{
   	public function show(){
		$data['materialesAceros'] = MaterialAcero::All();
		return view('materialesAceros.show')->with($data);
	}

	public function Form($id = 0){
        $pagina = 'Agregar';
		if($id != 0){
            $pagina = 'Editar';
			$acero = MaterialAcero::find($id);
			return view('materialesAceros.Form')->with(['acero'=>$acero])->with(['pagina'=>$pagina]);
		}
    	return view('materialesAceros.Form')->with(['pagina'=>$pagina]);
    }

     public function delete(Request $request){
        $materialAcero = MaterialAcero::find($request->id);
        $materialAcero->delete();

        //consultamos todos los materialesClientes
        $materialesAceros = MaterialAcero::get();
        return response()->json($materialesAceros); //Fin
    }

    public function insert(Request $request)
    {
        $materialAcero = [
            'nombre' => $request->nombre,
            'simbolo' => $request->simbolo,
        ];
        
        //Si es editar
        if($request->id != 0){
            $materialAcero += ['id' => $request->id];
            $save = MaterialAcero::find($request->id)->update($materialAcero);
            //Fin
        }else{
            //Si es Agregar
            $save = MaterialAcero::create($materialAcero);    
        }
        //consultamos todos los materialesClientes
        $materialesAceros = MaterialAcero::get();
        return response()->json($materialesAceros); //Fin
    }
}
