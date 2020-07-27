<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Material;

class ordenesCompraController extends Controller
{
    public function show(){
    	return view('ordenes_compra.ordenesShow');
    }

    public function crear(){
    	$materiales = Material::All();
    	$proveedores = Proveedor::All();
    	return view('ordenes_compra.ordenCrear')->
    			with(['proveedores' => $proveedores])->
    			with(['materiales'=>$materiales]);
    }

    public function insertar(Request $request){
    	dd($request);
    }

}
