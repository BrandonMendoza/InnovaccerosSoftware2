<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Cliente;
use App\registro_actividad;
use App\Trabajo;

class clientesController extends Controller
{
    public function show(){
    	$data['clientes'] = Cliente::all();
    	$this->createActivity(
            auth()->user()->id,
            'Clientes',
            'Consulto todos los Clientes'
        );
    	return view('clientes.show',$data);
    }


    public function crearForm(){
    	return view('clientes.crearCliente');
    }


     public function createActivity($user,$catalogo,$descripcion){
        $actividad =  [
            'user_id' => $user,
            'catalogo' => $catalogo,
            'descripcion' => $descripcion,
        ];

        $save = registro_actividad::create($actividad);
    }

    public function insertarCliente(Request $request){
    	//dd($request);
		
		return DB::transaction(function () use ($request) {
    		$this->validate($request,[
	            'nombre_cliente' => 'required',
	            'giro' => 'required',
	            'tel_oficinas' => 'required',
        	]);
           
           $cliente = [
	        	'foto_cliente' => null,
	        	'nombre_cliente' => $request->nombre_cliente,
	            'giro' => $request->giro,
	            'tel_oficinas' => $request->tel_oficinas,
	            'contacto1' => $request->contacto1,
	            'telefono1' => $request->telefono1,
	            'email1' => $request->email1,
	            'contacto2' => $request->contacto2,
	            'telefono2' => $request->telefono2,
	            'email2' => $request->email2,
	            'clave_cliente' => null,
	            'direccion'=>$request->direccion,
	            'rfc'=>$request->rfc,
	            'razon_social'=>$request->razon_social,
	            'codigo_postal'=>$request->codigo_postal,
	        ];

	        $save = Cliente::create($cliente);

	        $fechaCliente = date('YmdHis');
        	$claveCliente = 'CLI'.$save->id.''.$fechaCliente;


        	if($request->hasFile('foto')){
	            $file = $request->file('foto');
	            $fotoDate = date('YmdHis');
	            $fotoClave = $claveCliente;
	            $fotoName = 'FOTO'.$fotoClave.'.'.$file->clientExtension();
	            
	            $destinationPath = public_path(). '/uploads/Clientes/'.$claveCliente;
	            $file->move($destinationPath, $fotoName);

	           $cliente = [
		        	'foto_cliente' => $fotoName,
		        	'nombre_cliente' => $request->nombre_cliente,
		            'giro' => $request->giro,
		            'tel_oficinas' => $request->tel_oficinas,
		            'contacto1' => $request->contacto1,
		            'telefono1' => $request->telefono1,
		            'email1' => $request->email1,
		            'contacto2' => $request->contacto2,
		            'telefono2' => $request->telefono2,
		            'email2' => $request->email2,
		            'clave_cliente' => $claveCliente,
		            'direccion'=>$request->direccion,
		            'rfc'=>$request->rfc,
		            'razon_social'=>$request->razon_social,
		            'codigo_postal'=>$request->codigo_postal,
		        ];

		        $update = Cliente::find($save->id)->update($cliente);
	        }else{
	            $cliente = [
	               'foto_cliente' => null,
		        	'nombre_cliente' => $request->nombre_cliente,
		            'giro' => $request->giro,
		            'tel_oficinas' => $request->tel_oficinas,
		            'contacto1' => $request->contacto1,
		            'telefono1' => $request->telefono1,
		            'email1' => $request->email1,
		            'contacto2' => $request->contacto2,
		            'telefono2' => $request->telefono2,
		            'email2' => $request->email2,
		            'clave_cliente' => $claveCliente,
		            'direccion'=>$request->direccion,
		            'rfc'=>$request->rfc,
		            'razon_social'=>$request->razon_social,
		            'codigo_postal'=>$request->codigo_postal,
	            ];
	            $update = Cliente::find($save->id)->update($cliente);
	        }
	        $this->createActivity(
	            auth()->user()->id,
	            'Clientes',
	            'Se creo un Nuevo Cliente: '.$request->nombre_cliente
        	);


	        return redirect('/clientes/show')->with('message', 'Se ha completado la transaccion');

        });    	
    }

    public function perfilCliente($id){
    	$data['cliente'] = Cliente::find($id);
    	$this->createActivity(
	        auth()->user()->id,
	        'Clientes',
	        'Ingreso al Perfil de un Cliente: '.$data['cliente']->nombre_cliente
        );

        $trabajos['trabajos'] = Trabajo::where('cliente_id',$data['cliente']->id)->orderBy('created_at', 'desc')->paginate(10);
    	return view('clientes.perfilCliente',$data)->with($trabajos);
    }

    public function editarCliente($id){
    	$data['cliente'] = Cliente::find($id);
    	return view('clientes.editarCliente',$data);
    }

    public function actualizarCliente(Request $request, $id){
    	
		
		return DB::transaction(function () use ($request, $id) {
    		$this->validate($request,[
	            'nombre_cliente' => 'required',
	            'giro' => 'required',
	            'tel_oficinas' => 'required',
        	]);

        	$oldCliente = Cliente::find($id);
        	
        	if($request->hasFile('foto')){
	            $file = $request->file('foto');
	            $fotoDate = date('YmdHis');
	            $fotoClave = $oldCliente->clave_cliente;
	            $fotoName = 'FOTO'.$fotoClave.'.'.$file->clientExtension();
	            
	            $destinationPath = public_path(). '/uploads/Clientes/'.$oldCliente->clave_cliente;
	            $file->move($destinationPath, $fotoName);

	           $cliente = [
		        	'foto_cliente' => $fotoName,
		        	'nombre_cliente' => $request->nombre_cliente,
		            'giro' => $request->giro,
		            'tel_oficinas' => $request->tel_oficinas,
		            'contacto1' => $request->contacto1,
		            'telefono1' => $request->telefono1,
		            'email1' => $request->email1,
		            'contacto2' => $request->contacto2,
		            'telefono2' => $request->telefono2,
		            'email2' => $request->email2,
		            'direccion'=>$request->direccion,
		            'rfc'=>$request->rfc,
		            'razon_social'=>$request->razon_social,
		            'codigo_postal'=>$request->codigo_postal,
		        ];
		        $update = Cliente::find($id)->update($cliente);

	        }else{
	        	$cliente = [
		        	'nombre_cliente' => $request->nombre_cliente,
		            'giro' => $request->giro,
		            'tel_oficinas' => $request->tel_oficinas,
		            'contacto1' => $request->contacto1,
		            'telefono1' => $request->telefono1,
		            'email1' => $request->email1,
		            'contacto2' => $request->contacto2,
		            'telefono2' => $request->telefono2,
		            'email2' => $request->email2,
		            'direccion'=>$request->direccion,
		            'rfc'=>$request->rfc,
		            'razon_social'=>$request->razon_social,
		            'codigo_postal'=>$request->codigo_postal,
		        ];

		        $update = Cliente::find($id)->update($cliente);
	        }
           
	        $this->createActivity(
	            auth()->user()->id,
	            'Clientes',
	            'Se edito Cliente: '.$request->nombre_cliente
        	);


	        return redirect('/clientes/show')->with('message', 'Se ha completado la transaccion');

        });    	
    }
}


