<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;
use App\Cliente;
use App\Proceso;
use App\Producto;
use Carbon\Carbon;
use App\ProyectoProducto;
use App\ProyectoProceso;
use App\ProyectoProcesoProducto;
use Auth;

class proyectosController extends Controller
{

    public function show(){
        //$proyecto = Proyecto::with('Procesos')->where('id',63)->first();

        //$productos = ProyectoProducto::
        //return $proyecto->getProgreso();
        //return $proyecto->Productos[0]->ProyectoProducto->getLastProyectoProceso();
    	$data['clientes'] = Cliente::All();
    	$data['productos'] = Producto::All();
        $data['procesos'] = Proceso::All();
		$data['proyectos'] = Proyecto::get();

		return view('proyectos.show')->with($data);
	}

    public function cargarTablasForm(Request $request){
        //consultamos todos los productos
        $proyectos = Proyecto::with(['Productos'])->find($request->id);
        return response()->json($proyectos);
    }

    public function getProgresoOrdenAbierta(Request $request){
        $proyectoProducto = ProyectoProducto::  with('getProyectoProcesoProducto.ProyectoProceso.Proceso')
                                                ->where('id',$request->id)
                                                ->first();
        return $proyectoProducto->loadAvance();
    }

    public function getProcesosFromProyecto(Request $request){
        $data['procesos'] = ProyectoProceso::where('proyecto_id',$request->proyecto_id)->with('Proceso')->get();
        
        $proyectoProducto = ProyectoProducto::  with('getProyectoProcesoProducto.ProyectoProceso.Proceso')
                                                ->where('id',$request->ordenAbierta_id)
                                                ->first();

        $data['lastProceso'] = $proyectoProducto->getLastProceso();
        return response()->json($data);
    }

    public function ordenesAbiertas(){
        $data = [  
            'clientes' => Cliente::All(),
            'procesos' => Proceso::All(),
            'OrdenesAbiertas' => ProyectoProducto::loadOrdenesAbiertasWithAll()
        ];
        return view('proyectosProductos.ordenesAbiertas')->with($data);
    }

	public function delete(Request $request){
        $proyecto = Proyecto::find($request->id);
        $proyecto->Productos()->detach();
        $proyecto->delete();
        //consultamos todos los procesos
        $proyectos = Proyecto::with(['Cliente'])->get();
        return response()->json($proyectos); //Fin
    }

    public function ordenAbiertaInsert(Request $request)
    {
        $ordenAbierta = [
            'cantidad' => $request->cantidad,
            'work_order' => $request->work_order,
            'item' => $request->item,
            'heat_number' => $request->heat_number,
        ];
        
        if($request->id != 0){
            //Si es editar
            $ordenAbierta += ['id' => $request->id];
            $save = ProyectoProducto::find($request->id)->update($ordenAbierta);
        }else{
            //Si es Agregar
            $save = ProyectoProducto::create($ordenAbierta);    
        }
        //consultamos todos los materialesClientes
        $ordenesAbiertas =  ProyectoProducto::loadOrdenesAbiertasWithAll();
        return response()->json($ordenesAbiertas); //Fin
    }

	public function insert()
    {
        /*Funcion para insertar o Actualizar un proyecto*/
        $proyecto = new Proyecto;

        /*Se le da formato a la fecha de entrega con Carbon*/
        request()->merge(['fecha_entrega' => Carbon::parse(request()->fecha_entrega)]);
        /*Aqui se actualiza/crea con la informacion que enviamos al request*/
        $proyecto = $proyecto   ->fill(request()->all())
                                ->updateOrCreate(['id' => request()->get('id')],$proyecto->toArray());

        /*Creando sus procesos*/
        if(request()->get('numero_parte') == ""){
            $proyecto->numero_parte = 'PY'.str_pad($proyecto->id + 1, 8, "0", STR_PAD_LEFT);
            $proyecto->crearProcesos();
            $proyecto->update();
        }

        /*Se agregan los productos que vienen en el request()*/
        if(request()->has('prod_id'))
            $proyecto->updateProductosByRequest(Auth::id());


        $proyectos = Proyecto::with(['Cliente'])->get();
        foreach ($proyectos as $key => $proyecto) {
            $proyecto->loadProgreso();
            $proyecto->loadTotalHrsLabor();
        }
        return response()->json($proyectos);

    }


}
