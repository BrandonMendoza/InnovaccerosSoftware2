<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Accesorio;
use App\Material;
use App\Cliente;
use App\Documento;
use Storage;

class productosController extends Controller
{
    

	public function create(){
		$data['productos'] = Producto::All();
		return view('productos.form')->with($data);
	}

	public function cargarTablasForm(Request $request){
		//consultamos todos los productos
		$productos = Producto::with(['Cliente','Accesorios','Materiales','Materiales.Tipo_material','Materiales.Acero'])->find($request->id);
        return response()->json($productos);
	}

	public function cargarTablaDocumentosForm(Request $request){
		$producto = Producto::with(['Documentos'])->find($request->id);
		return response()->json($producto);
	}

	public function descargarProductoDocumento($documento_id){
		$documento = Documento::find($documento_id);
		$path = storage_path('app\\'.$documento->url."\\".$documento->nombre_sistema);
		$headers = array('Content-Type'=> 'application/'.$documento->tipo_documento);
		$nombre_doc = $documento->nombre_usuario.'.'.$documento->tipo_documento;

		
		return response()->download($path,$nombre_doc,$headers);
	}

	public function deleteProductoDocumento(Request $request){
		$producto = Producto::find($request->producto_id);
		$producto->Documentos()->detach($request->documentos_id);
		$documento = Documento::find($request->documento_id);

		Storage::delete($documento->url."\\".$documento->nombre_sistema);
		$documento->delete();
		return response()->json($producto);
	}

	public function show(){
    	$data['accesorios'] = Accesorio::All();
    	$data['materiales'] = Material::All();
    	$data['clientes'] = Cliente::All();
		$data['productos'] = Producto::All();
		return view('productos.show')->with($data);
	}

	public function delete(Request $request){
        $producto = Producto::find($request->id);
        //Borramos todos los materiales del producto
        $producto->Materiales()->detach();
        $producto->Accesorios()->detach();
        //Borramos el producto
        $producto->delete();

        //consultamos todos los productos
        $productos = Producto::	with(['Cliente','Accesorios','Materiales','Materiales.Tipo_material','Materiales.Acero'])->get();
        return response()->json($productos); //Fin
    }

	

	public function insertDocument(Request $request){

		if($request->file('doc')){
			$producto = Producto::find($request->producto_id);
		    $doc = $request->file('doc');
		    $docDate = date('YmdHis');
	        $docNombre = 'dc-'.$docDate.'.'.$doc->clientExtension();
	        $nombreOriginal = $doc->getClientOriginalName();

	        $doc->storeAs('uploads\productos\\'.$producto->numero_parte.'\documentos', $docNombre);
	        //$doc->move(public_path('uploads\productos\\'.$producto->numero_parte.'\documentos'),$docNombre);
	        //Storage::put('uploads\productos\\'.$producto->numero_parte.'\documentos'.$docNombre, $doc);

	        $documento = [
	        	'nombre_usuario' => $request->nombre_usuario,
	        	'nombre_real' => $nombreOriginal,
	        	'nombre_sistema' => $docNombre,
	        	'tipo_documento' => $doc->getClientOriginalExtension(),
	        	'url'=> 'uploads\productos\\'.$producto->numero_parte.'\documentos',
	        ];

	        $save = Documento::create($documento);
	        $producto->Documentos()->attach($save->id);

	        return response()->json($save);
		}
		
	}

	public function insert(Request $request){
		$producto = [ 	
			'cliente_id' => $request->cliente_id,
			'numero_parte_cliente' => $request->numero_parte_cliente,
			'descripcion' => $request->descripcion, 
			'peso_kg' => $request->peso_kg,
			'peso_lbs' => $request->peso_lbs
		];
		//Verificamos el id para saber si estamos editando o estamos agregando
        if($request->id != 0){
        	//Si es editar
            $producto += ['id' => $request->id, 'numero_parte' => $request->numero_parte];
            $save = Producto::find($request->id)->update($producto);
        }else{
            //Si es Agregar
            $ultimoProducto = Producto::orderBy('created_at','DESC')->first();
            $producto += ['numero_parte' => 'PD'.str_pad($ultimoProducto->id + 1, 8, "0", STR_PAD_LEFT)];

            $save = Producto::create($producto);
            $request->id = $save->id;
	    }

	    $producto = Producto::with(['Accesorios','Materiales'])->find($request->id);
	    //Borramos todos los materiales del producto
       	$producto->Materiales()->detach();
        $producto->Accesorios()->detach();
        //Agregamos los materiales
        if($request->has('mat_id'))
        	$this->insertMats($request,$producto);
        //Agregamos los accesorios
        if($request->has('acc_id'))
        	$this->insertAccs($request,$producto);

        //consultamos todos los productos
        $productos = Producto::	with(['Cliente','Accesorios','Materiales','Materiales.Tipo_material','Materiales.Acero'])					->get();
        return response()->json($productos); //Fin
	}

	public function insertDocs(Request $request,$producto){
		//obtenemos las cantidades y los id de las tablas
        $doc_ids = $request->get('doc_id');
		$doc_files = $request->get('doc_file');
		//contamos la cantidad para poder hacer el loop
        $cant_doc = count($doc_ids);

		//Agregamos los documentos
        for ($i=0; $i < $cant_doc; $i++) {
	        $producto->Documentos()->attach($doc_ids[$i]);
        }
	}

	public function insertMats(Request $request,$producto){
		//obtenemos las cantidades y los id de las tablas
        $mat_ids = $request->get('mat_id');
		$mat_cants = $request->get('mat_cant');
		//contamos la cantidad para poder hacer el loop
        $cant_mat = count($mat_ids);

		//Agregamos los materiales
        for ($i=0; $i < $cant_mat; $i++) {
	        $producto->Materiales()->attach($mat_ids[$i], ['cantidad' => $mat_cants[$i]]);
        }
	}

	public function insertAccs(Request $request,$producto){
		//obtenemos las cantidades y los id de las tablas
		$acc_ids = $request->get('acc_id');
		$acc_cants = $request->get('acc_cant');
		//contamos la cantidad para poder hacer el loop
        $cant_acc = count($acc_ids);
		//Agregamos los Accesorios
        for ($i=0; $i < $cant_acc; $i++) {
	        $producto->Accesorios()->attach($acc_ids[$i], ['cantidad' => $acc_cants[$i]]);
        }
	}
}
