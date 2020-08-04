<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventario_Material;
use App\Material;
use App\Cliente;
use App\MaterialCliente;
use App\StatusInventarioMaterial;
use Carbon\Carbon;
class inventariosMaterialesController extends Controller
{
    public function show(){
    	$data['clientes'] = Cliente::All();
    	$data['materiales_clientes'] = MaterialCliente::All();
		$data['inventariosMateriales'] = Inventario_Material::All();
        $data['statusInventariosMateriales'] = StatusInventarioMaterial::All();
		return view('inventariosMateriales.show')->with($data);
	}

	public function delete(Request $request){
        //Buscar y eliminar inventarioMaterial
        $inventarioMaterial = Inventario_Material::find($request->id);
        $inventarioMaterial->delete();

        //Obtener listado actualizado para mostrar en Show.blade.php
        $inventariosMateriales = Inventario_Material::with(['Cliente','Material_cliente','Material_cliente.Accesorio','Material_cliente.Material.Tipo_material','Material_cliente.Material.Acero','Status'])->get();
        return response()->json($inventariosMateriales);//Fin
    }

    public function editing(Request $request){
        $inventarioMaterial = Inventario_Material::find($request->id);
        switch ($request->editing) {
            case 0:
                $inventarioMaterial->is_editing = $request->editing;
                $inventarioMaterial->editing_at = null;
                $inventarioMaterial->update();
                return true;
                break;
            
            case 1:
                if($inventarioMaterial->is_editing == 0){
                    $inventarioMaterial->is_editing = $request->editing;
                    $inventarioMaterial->editing_at = Carbon::now();
                    $inventarioMaterial->update();
                    return true;
                }else{
                    return 0;
                }
                break;
        }
    }

	public function insertForm(Request $request)
	{

		$inventarioMaterial = [
			'cliente_id' => $request->cliente_id,
            'material_cliente_id' => $request->material_cliente_id,
            'status_id' => $request->status_id,
            'proyecto' => $request->proyecto,
            'tba' => $request->tba,
            'cantidad' => $request->cantidad,
            'item' => $request->item,
            'work_order' => $request->work_order,
            'plan_corte' => $request->plan_corte,
            'heat_number' => $request->heat_number,
        ];
        //Si el status es diferente a recibido borramos la fecha
        if($request->status_id == 2){
            if( $request->recibido_el == 0){
                $inventarioMaterial += ['recibido_el' => Carbon::now()] ;
            }
        }else{
            $inventarioMaterial += ['recibido_el' => null];
        }
        //Si es Editar agregar el id
        if($request->id != 0){
            $inventarioMaterial += ['id' => $request->id];
            $inventarioMaterial += ['is_editing' => 0];
            $save = Inventario_Material::find($request->id)->update($inventarioMaterial);
        }else{
            //Si es Agregar
            $save = Inventario_Material::create($inventarioMaterial);
        }
        //Obtener listado actualizado para mostrar en Show.blade.php
        $inventariosMateriales = Inventario_Material::with(['Cliente','Material_cliente.Accesorio','Material_cliente.Accesorio.Acero','Material_cliente','Material_cliente.Material.Tipo_material','Material_cliente.Material.Acero','Status'])->get();
        return response()->json($inventariosMateriales);//Fin
	}
}
