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

    public function insertForm(Request $request){
    	$acero = [
            'nombre' => $request->nombre,
            'simbolo' => $request->simbolo,
        ];
        if($request->id != 0){
        	$acero += ['id' => $request->id,];
        	$save = MaterialAcero::find($request->id)->update($acero);

        	$data['materialesAceros'] = MaterialAcero::All();
            return redirect('/materialesAceros/show')->with($data);
        }

        $save = MaterialAcero::create($acero);
    	
    	$data['materialesAceros'] = MaterialAcero::All();
		return redirect('/materialesAceros/show')->with($data);
        
    }
}
