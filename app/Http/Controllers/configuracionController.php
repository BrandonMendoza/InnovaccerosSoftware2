<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use App\User;
use App\registro_actividad;

class configuracionController extends Controller
{
    public function show(Request $request){
    	
    		$data['empleados'] = Empleado::all();

    		$empleados = $data['empleados']->keyBy('id');
    		
    		$users = User::all();
    		foreach ($users as $user) {
    			foreach ($empleados as $empleado) {
    				if ($user->empleado_id == $empleado->id) {
    					$empleados->forget($user->empleado_id);
    				}
    			}
    		}

            $this->createActivity(
                auth()->user()->id,
                'Configuracion de Perfil',
                'Consulto sus datos de Perfil'
            );
    		return view('configuracion.configuracion')->with(['empleados' => $empleados]);
    }

    public function createActivity($user,$catalogo,$descripcion){
        $actividad =  [
            'user_id' => $user,
            'catalogo' => $catalogo,
            'descripcion' => $descripcion,
        ];

        $save = registro_actividad::create($actividad);
    }

    public function vincularUserEmpleado(Request $request){
        $user = User::find($request->user);

        $this->createActivity(
            auth()->user()->id,
            'Configuracion de Perfil',
            'Vinculo su cuenta a empleado'
        );

        if($user) {
            $user->empleado_id = $request->emp;
            $user->save();
        }
    }
}
