<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use App\MaterialAcero;
use App\MaterialTipo;
use Carbon\Carbon;

class materialesController extends Controller
{
	public function show(){
		$data['materiales'] = Material::All();
        //dd($data);
		return view('materiales.show')->with($data);
	}
    
    public function Form($id = 0){
        $materialesTipos = MaterialTipo::All();
        $materialesAceros = MaterialAcero::All();

        $pagina = 'Agregar';
        if($id != 0){
            $pagina = 'Editar';
            $material = Material::find($id);
            return view('materiales.Form')  ->with(['material'=>$material])
                                            ->with(['pagina'=>$pagina])
                                            ->with(['materialesTipos'=>$materialesTipos])
                                            ->with(['materialesAceros'=>$materialesAceros]);
        }
        return view('materiales.Form')  ->with(['pagina'=>$pagina])
                                        ->with(['materialesTipos'=>$materialesTipos])
                                        ->with(['materialesAceros'=>$materialesAceros]);
    }

    public function insertForm(Request $request){
        //dd($request);
        $material = [
            'numero_parte' => $request->numero_parte,
            'tipo_material_id' => $request->tipo_material_id,
            'acero_id' => $request->acero_id,
            'peso_kg' => $request->peso_kg,
            'medida_1' => $request->medida_1,
            'medida_2' => $request->medida_2,
            'medida_3' => $request->medida_3,
            'medida_4' => $request->medida_4,
            'catalogo' => 1,
        ];

        if($request->id != 0){
            $material += ['id' => $request->id,];
            $save = Material::find($request->id)->update($material);

            $data['materialesAceros'] = Material::All();
            return redirect('/materiales/show')->with($data);
        }

        $save = Material::create($material);
        
        $data['materiales'] = Material::All();
        return redirect('/materiales/show')->with($data);
    }
}
