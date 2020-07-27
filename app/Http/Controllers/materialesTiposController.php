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

	public function Form($id = 0){
        $pagina = 'Agregar';
		if($id != 0){
            $pagina = 'Editar';
			$tipo = MaterialTipo::find($id);
			return view('materialesTipos.Form')->with(['tipo'=>$tipo])->with(['pagina'=>$pagina]);
		}
    	return view('materialesTipos.Form')->with(['pagina'=>$pagina]);
    }

    public function insertForm(Request $request){
    	$tipo = [
            'nombre' => $request->nombre,
            'simbolo' => $request->simbolo,
            'cantidad_datos' => $request->cantidad_datos,
        ];

        if($request->id != 0){

        	$tipo += ['id' => $request->id,];
        	$save = MaterialTipo::find($request->id)->update($tipo);
        	$data['materialesTipos'] = MaterialTipo::All();
			return redirect('/materialesTipos/show')->with($data);
        }

        $save = MaterialTipo::create($tipo);
    	$data['materialesTipos'] = MaterialTipo::All();
		return redirect('/materialesTipos/show')->with($data);
    }
}
