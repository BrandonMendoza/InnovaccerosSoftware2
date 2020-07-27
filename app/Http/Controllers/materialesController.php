<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use Carbon\Carbon;

class materialesController extends Controller
{
	public function show(){
		$data['materiales'] = Material::All();
		return view('materiales.materialesShow')->with($data);
	}
    public function crear(){
    	return view('materiales.crearMaterial');
    }

    public function editar($id){
        $material = Material::find($id);
        return view('materiales.editarMaterial')->with(['material'=>$material]);
    }
    public function actualizar(Request $request){
        $this->validate($request,[
            'tipo' => 'required|not_in:0',
            'descripcion' => 'required',
            'medidas' => 'required',
        ]);
        $material = [
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'medidas' => $request->medidas,
            'clave' => $request->clave,
        ];

        $save = Material::find($request->id)->update($material);
        return redirect('/materiales/show')->
                            with('message','Se ha creado Material con exito');
    }

    public function insertar(Request $request){

    	$this->validate($request,[
            'tipo' => 'required|not_in:0',
            'descripcion' => 'required',
            'medidas' => 'required',
        ]);

        $now = Carbon::now();
		$unique_code = $now->format('YmdHisu');

        $material = [
        	'tipo' => $request->tipo,
        	'descripcion' => $request->descripcion,
        	'medidas' => $request->medidas,
        	'clave' => $unique_code,
        ];

        $save = Material::create($material);
        return redirect('/materiales/show')->
                            with('message','Se ha creado Material con exito');

    }
}
