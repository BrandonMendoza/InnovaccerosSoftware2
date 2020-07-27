<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\registro_actividad;
use App\Superpassword;
use App\Empleado;

class usuariosController extends Controller
{
    public function show(){
    	$data['usuarios'] = User::all();
    	$empleados['empleados'] = Empleado::all();

    	return view('configuracion.usuarios')->with($data)->with($empleados);
    }


    public function createActivity($user,$catalogo,$descripcion){
        $actividad =  [
            'user_id' => $user,
            'catalogo' => $catalogo,
            'descripcion' => $descripcion,
        ];

        $save = registro_actividad::create($actividad);
    }

    public function crear(){
    	return view('configuracion.crearUsuario');
    }

    public function eliminar($id){
    	$usuario = User::find($id);
    	$this->createActivity(
            auth()->user()->id,
            'Usuarios',
            'Elimino al usuario: '.$usuario->name
        );

    	$usuario->delete();
    	$data['usuarios'] = User::all();
    	$empleados['empleados'] = Empleado::all();
    	//return view('configuracion.usuarios')->with($data);

    	return Redirect('/configuracion/usuarios/show')->with($data)->with('message','Se ha eliminado usuario')->with($empleados);
    }

    public function getUsuario($id){
    	$data['usuario'] = User::find($id);
    	return view('configuracion.editarUsuario')->with($data);
    }

    public function actualizarUsuario(Request $request){
    	if($request->password == null){
	    		$this->validate($request,[
	            'name' => 'required|string|max:255',
	            'rol' => 'required|not_in:0',
	            'email' => 'required|string|email|max:255',
        	]);

	    	$pass = Superpassword::pluck('password','id');
        	if($request->superpass == $pass['1']){
	           	User::find($request->id)->update([
	                'name' => $request->name,
	                'email' => $request->email,
	                'roles_id' => $request->rol
	            ]);
	        }

    	}

    	else{
    		$this->validate($request,[
	            'name' => 'required|string|max:255',
	            'rol' => 'required|not_in:0',
	            'email' => 'required|string|email|max:255',
	            'password' => 'required|string|min:6|confirmed',
	        ]);

	        $pass = Superpassword::pluck('password','id');
	        if($request->superpass == $pass['1']){
	           	User::find($request->id)->update([
	                'name' => $request->name,
	                'email' => $request->email,
	                'roles_id' => $request->rol,
	                'password' => bcrypt($request->password),
	            ]);
	        }
    	}
    	

    	

    	$empleados['empleados'] = Empleado::all();
        $data['usuarios'] = User::all();
    	return Redirect('/configuracion/usuarios/show')->with($data)->with('message','Se ha creado usuario')->with($empleados);
    }

    public function insertar(Request $request){

    	$this->validate($request,[
            'name' => 'required|string|max:255',
            'rol' => 'required|not_in:0',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

    	$pass = Superpassword::pluck('password','id');
        if($request->superpass == $pass['1']){
           	User::create([
                'name' => $request->name,
                'email' => $request->email,
                'roles_id' => $request->rol,
                'password' => bcrypt($request->password),
            ]);
        }

        $empleados['empleados'] = Empleado::all();
        $data['usuarios'] = User::all();
    	return Redirect('/configuracion/usuarios/show')->with($data)->with('message','Se ha creado usuario')->with($empleados);
    }

}
