<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialTipo;

class materialesTiposController extends Controller
{
    public function show(){
		$data['materialesTipos'] = MaterialTipo::All();
		return view('materialesTipos.show')->with($data);
	}

    public function delete(Request $request){
        $materialTipo = MaterialTipo::find($request->id);
        $materialTipo->delete();

        //consultamos todos los materialesClientes
        $materialesTipos = MaterialTipo::get();
        return response()->json($materialesTipos); //Fin
    }
    
	public function Form($id = 0){
        $pagina = 'Agregar';
		if($id != 0){
            $pagina = 'Editar';
			$tipo = MaterialTipo::find($id);
			return view('materialesTipos.Form')->with(['tipo'=>$tipo])->with(['pagina'=>$pagina]);
		}
    	return view('materialesTipos.Form')->with(['pagina'=>$pagina]);
    }

    public function insert(Request $request)
    {
        $materialTipo = [
            'nombre' => $request->nombre,
            'simbolo' => $request->simbolo,
            'cantidad_datos' => $request->cantidad_datos,
        ];
        
        //Si es editar
        if($request->id != 0){
            $materialTipo += ['id' => $request->id];
            $save = MaterialTipo::find($request->id)->update($materialTipo);
            //Fin
        }else{
            //Si es Agregar
            $save = MaterialTipo::create($materialTipo);    
        }
        //consultamos todos los materialesClientes
        $materialesTipos = MaterialTipo::get();
        return response()->json($materialesTipos); //Fin
    }
}
