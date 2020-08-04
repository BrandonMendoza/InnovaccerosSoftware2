<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialCliente;
use App\Cliente;
use App\Material;
use App\Accesorio;

class materialesClientesController extends Controller
{
    public function getMaterialesClientesByCatalogoCliente(Request $request){
        return response()->json(MaterialCliente::   where('catalogo', $request->catalogo)->
                                                    where('cliente_id', $request->cliente_id)->
                                                    with(['Material','Material.Tipo_material','Accesorio'])->get());
    }

    public function getMaterialesClientes(Request $request){
        return response()->json(MaterialCliente::   where('cliente_id', $request->cliente_id)->
                                                    with(['Material','Material.Tipo_material'])->get());
    }

    public function getMaterialesAccesoriosClientes(Request $request){
        if($request->catalogo == 1){
            $accesoriosMateriales = Material::with(['Tipo_material'])->get();
        }else{
            $accesoriosMateriales = Accesorio::get();
        }
        return response()->json($accesoriosMateriales);
    }

    public function show(){
    	$data['clientes'] = Cliente::All();
        $data['materiales'] = Material::All();
        //$accesorios = Accesorio::All();
        //$materiales = Material::All();
        //$data['materiales'] = collect($materiales)->merge($accesorios);
        $data['materialesClientes'] = MaterialCliente::All();
        //dd($data);

		

		return view('materialesClientes.show')->with($data);
	}

	public function delete(Request $request){
		$materialCliente = MaterialCliente::find($request->id);
		$materialCliente->delete();

		return response()->json(MaterialCliente::with(['Cliente','Material','Material.Tipo_material'])->get());
	}

	public function insertForm(Request $request)
	{
		$materialCliente = [
            'material_id' => $request->material_id,
            'cliente_id' => $request->cliente_id,
            'numero_parte' => $request->numero_parte,
            'almacen' => $request->almacen,
            'locacion_almacen' => $request->locacion_almacen,
            'catalogo' => $request->catalogo,
        ];
        
        //Si es editar
        if($request->id != 0){
            $materialCliente += ['id' => $request->id];
            $save = MaterialCliente::find($request->id)->update($materialCliente);
            //Fin
        }else{
            //Si es Agregar
            $save = MaterialCliente::create($materialCliente);    
        }
        //consultamos todos los materialesClientes
        $MaterialesClientes = MaterialCliente::with(['Cliente','Material','Accesorio','Material.Tipo_material'])->get();
        return response()->json($MaterialesClientes); //Fin
	}


}
