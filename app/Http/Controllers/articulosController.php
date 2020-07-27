<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\registro_actividad;
use DB;

class articulosController extends Controller
{
    public function show(){
        $this->createActivity(
            auth()->user()->id,
            'Articulos de Almacen',
            'Consulto todos los Articulos de Almacen'
        );
    	$data['articulos'] = Articulo::all();
    	return view('almacen.articulos.show',$data);
    }

    public function createActivity($user,$catalogo,$descripcion){
        $actividad =  [
            'user_id' => $user,
            'catalogo' => $catalogo,
            'descripcion' => $descripcion,
        ];

        $save = registro_actividad::create($actividad);
    }

    public function crearForm(){
        $this->createActivity(
            auth()->user()->id,
            'Articulos de Almacen',
            'Abrio el formulario de Creacion de Articulo'
        );
    	return view('almacen.articulos.crearArticulo');
    }

    public function perfilArticulo($id){
    	$data['articulo'] = Articulo::find($id);
        $this->createActivity(
            auth()->user()->id,
            'Articulos de Almacen',
            'Consulto el Articulo: '.$data['articulo']->tipo.' '.$data['articulo']->descripcion
        );
    	return view('almacen.articulos.perfilArticulo',$data);
    }

    public function eliminarArticulo($id){


        $articulo = Articulo::find($id);
        $deleted = $articulo;
        $articulo->delete();
        $data['articulos'] = Articulo::all();
        $data['articulo'] = Articulo::find($id);
        $this->createActivity(
            auth()->user()->id,
            'Articulos de Almacen',
            'Elimino el Articulo: '.$deleted->tipo.' '.$deleted->descripcion
        );
    	return view('almacen.articulos.show',$data);
    }

    public function getArticulo($id){
        $data['articulo'] = Articulo::find($id);
        $this->createActivity(
            auth()->user()->id,
            'Articulos de Almacen',
            'Ingreso a Editar Articulo : '.$data['articulo']->tipo.' '.$data['articulo']->descripcion.' ('.$data['articulo']->clave.')'
        );
        return view('almacen.articulos.editarArticulo',$data);
    }

    public function actualizarArticulo(Request $request,$id){
        return DB::transaction(function () use ($id,$request) {
    	$this->validate($request,[
            'marca' => 'required',
            'categoria' => 'required|not_in:0',
            'tipos' => 'required|not_in:0',
            'descripcion' => 'required',
            'unidad_medida' => 'required',
            'existencia' => 'required',
            'minimo' => 'required',
        ]);
        
        /*-----> CREANDO CLAVE DE ARTICULO <--------------*/        
        $articulo = Articulo::find($id);
        $claveArticulo = $articulo->clave;

        $articuloActualizado = [
        	'marca' => $request->marca,
            'categoria' => $request->categoria,
            'tipo' => $request->tipos,
            'descripcion' => $request->descripcion,
            'unidad_medida' => $request->unidad_medida,
            'existencia' => $request->existencia,
            'minimo' => $request->minimo,
            'clave' => $claveArticulo,
            'numero_parte' => $request->numero_parte,
	    ];

        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $fotoDate = date('YmdHis');
            $fotoClave = $claveArticulo;
            $fotoName = $claveArticulo.'.'.$file->clientExtension();
            
            $destinationPath = public_path(). '/uploads/Almacen/Articulos';
            $file->move($destinationPath, $fotoName);

            $articuloActualizado += [
	        	'foto' => $fotoName,
	        ];
        }

	    $update = Articulo::find($id)->update($articuloActualizado);
    	$data['articulo'] = Articulo::find($id);
        $this->createActivity(
            auth()->user()->id,
            'Articulos de Almacen',
            'Termino de Editar Articulo : '.$data['articulo']->tipo.' '.$data['articulo']->descripcion.' ('.$data['articulo']->clave.')'
        );
    	return view('almacen.articulos.perfilArticulo',$data);
        });
    }


    public function insertarArticulo(Request $request){
    	/*
			"marca" => "Bbb"
      "categoria" => "MARCADOR"
      "tipos" => "GIS"
      "descripcion" => "Asdgfv"
      "unidad_medida" => "KILOS"
      "existencia" => "2"
      "minimo" => "2"
    	*/
        return DB::transaction(function () use ($request) {
        	$this->validate($request,[
                'marca' => 'required',
                'categoria' => 'required|not_in:0',
                'tipos' => 'required|not_in:0',
                'descripcion' => 'required',
                'unidad_medida' => 'required',
                'existencia' => 'required',
                'minimo' => 'required',
            ]);

            $articulo = [
            	'foto' => null,
            	'marca' => $request->marca,
                'categoria' => $request->categoria,
                'tipo' => $request->tipos,
                'descripcion' => $request->descripcion,
                'unidad_medida' => $request->unidad_medida,
                'existencia' => $request->existencia,
                'minimo' => $request->minimo,
                'clave' => 0,
                'numero_parte' =>$request->numero_parte,
            ];

            $save = Articulo::create($articulo);
            
            /*-----> CREANDO CLAVE DE ARTICULO <--------------*/
            $fechaArticulo = date('YmdHis');
            $claveArticulo = 'ART'.$save->id.''.$fechaArticulo;

            if($request->hasFile('foto')){
                $file = $request->file('foto');
                $fotoDate = date('YmdHis');
                $fotoClave = $claveArticulo;
                $fotoName = 'FOTO'.$fotoClave.'.'.$file->clientExtension();
                
                $destinationPath = public_path(). '/uploads/Almacen/Articulos';
                $file->move($destinationPath, $fotoName);

                $articulo = [
    	        	'foto' => $fotoName,
    	        	'marca' => $request->marca,
    	            'categoria' => $request->categoria,
    	            'tipo' => $request->tipos,
    	            'descripcion' => $request->descripcion,
    	            'unidad_medida' => $request->unidad_medida,
    	            'existencia' => $request->existencia,
    	            'minimo' => $request->minimo,
    	            'clave' => $claveArticulo,
                    'numero_parte' => $request->numero_parte,
    	        ];

    	        $update = Articulo::find($save->id)->update($articulo);
            }else{
                $articulo = [
                    'foto' => null,
                    'marca' => $request->marca,
                    'categoria' => $request->categoria,
                    'tipo' => $request->tipos,
                    'descripcion' => $request->descripcion,
                    'unidad_medida' => $request->unidad_medida,
                    'existencia' => $request->existencia,
                    'minimo' => $request->minimo,
                    'clave' => $claveArticulo,
                    'numero_parte' => $request->numero_parte,
                ];
                $update = Articulo::find($save->id)->update($articulo);
            }

            $this->createActivity(
                auth()->user()->id,
                'Articulos de Almacen',
                'Agrego un articulo nuevo : '.$request->tipos.' '.$request->descripcion.' ('.$claveArticulo.')'
            );


        	$data['articulos'] = Articulo::all();
        	return view('almacen.articulos.show',$data);
        });
    }
}
