<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\registro_actividad;

class proveedoresController extends Controller
{

	public function createActivity($user,$catalogo,$descripcion){
        $actividad =  [
            'user_id' => $user,
            'catalogo' => $catalogo,
            'descripcion' => $descripcion,
        ];

        $save = registro_actividad::create($actividad);
    }

    public function show(){
    	$data['proveedores'] = Proveedor::all();
    	$this->createActivity(
            auth()->user()->id,
            'Proveedores',
            'Consulto todos los Porveedores'
        );
    	return view('proveedores.showProveedores',$data);
    }

    public function eliminar($id){
    	$proveedorElminar = Proveedor::find($id);
    	$proveedorEliminar->delete();
    	$data['proveedores'] = Proveedor::all();
    	$this->createActivity(auth()->user()->id,'Proveedores','Elimino proveedor');
    	return redirect('/proveedores/show')->with('message','Se ha eliminado proveedor')->with($data);
    }


    public function insertar(Request $request){
    	$this->validate($request,[
            'nombre' => 'required',
            'sucursal' => 'required',
            'categoria' => 'required|not_in:0'
        ]);

        $proveedor =[
        	'foto' => null,
        	'nombre'=> $request->nombre ,
        	'sucursal'=> $request->sucursal,
        	'telefono'=> $request->telefono,
        	'email'=> $request->email,
        	'categoria'=> $request->categoria,
        	'notas'=> $request->notas,
        	'favorito'=> $request->favorito,
        ];

        $save = Proveedor::create($proveedor);
        $proveedorUpdate = [];

        if($request->hasFile('foto')){
            $foto = $request->file('foto');
            $fotoName = date('mdYHis') . uniqid().'.' .$foto->clientExtension();
            $destinationPath = public_path(). '/uploads/DocProveedores';
            $foto->move($destinationPath, $fotoName);
            $proveedorUpdate += [
                'foto' => $fotoName,
            ];
        }

        $update = Proveedor::find($save->id)->update($proveedorUpdate);

    	$this->createActivity(
            auth()->user()->id,
            'Proveedores',
            'creo proveedor :'.$proveedor['nombre']
        );


    	$data['proveedores'] = Proveedor::all();

    	return redirect('/proveedores/show')->with('message','Se ha agregado nuevo proveedor')->with($data);
     }
     public function actualizar(Request $request){
    	$this->validate($request,[
            'nombre' => 'required',
            'sucursal' => 'required',
            'categoria' => 'required|not_in:0'
        ]);

        $proveedor =[
        	'nombre'=> $request->nombre ,
        	'sucursal'=> $request->sucursal,
        	'telefono'=> $request->telefono,
        	'email'=> $request->email,
        	'categoria'=> $request->categoria,
        	'notas'=> $request->notas,
        	'favorito'=> $request->favorito,
        ];

       

        if($request->hasFile('foto')){
            $foto = $request->file('foto');
            $fotoName = date('mdYHis') . uniqid().'.' .$foto->clientExtension();
            $destinationPath = public_path(). '/uploads/DocProveedores';
            $foto->move($destinationPath, $fotoName);
            $proveedor += [
                'foto' => $fotoName,
            ];
        }

        $update = Proveedor::find($request->id)->update($proveedor);

    	$this->createActivity(
            auth()->user()->id,
            'Proveedores',
            'Edito la informacion de proveedor :'.$proveedor['nombre']
        );


    	return redirect('/proveedor/'.$request->id.'/perfil')->with('message','Se ha editado proveedor');
     }

    public function crear(){

    	$this->createActivity(
            auth()->user()->id,
            'Proveedores',
            'Abrio formulario para crear proveedor'
        );

    	return view('proveedores.crearProveedor');
     }

    public function editar($id){
    	$data['proveedor'] = Proveedor::find($id);

    	$this->createActivity(
            auth()->user()->id,
            'Proveedores',
            'Abrio formulario para editar proveedor :'.$data['proveedor']->nombre
        );

    	return view('proveedores.editarProveedor',$data);
     }


    public function perfilProveedor($id){
    	$data['proveedor'] = Proveedor::find($id);

    	$this->createActivity(
            auth()->user()->id,
            'Proveedores',
            'Consulto al proveedor'.$data['proveedor']->nombre
        );

    	return view('proveedores.perfilProveedor',$data);
     }
}
