<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class almacenController extends Controller
{
    public function show(){
    	return view('almacen.almacenMenu');
    }
}
