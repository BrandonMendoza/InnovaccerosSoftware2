<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\transaccion_tiene_articulo;
use App\TransaccionAlmacen;
use App\Empleado;
use App\Articulo;
use App\registro_actividad;
use Carbon\Carbon;

class historialTransaccionesController extends Controller
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
		//$transacciones['transacciones'] = TransaccionAlmacen::orderBy('created_at','desc')->get();
		$empleados['empleados'] = Empleado::All('id','nombre','apellido1','apellido2','clave');
		$transacciones = DB::table('transaccion_almacen')
								->select('*',
										'transaccion_almacen.id as id',
										'empleados.id as empleado_id',
										'empleados.nombre as empleado_nombre',
										'empleados.apellido1 as empleado_apellido1',
										'empleados.apellido2 as empleado_apellido2')
								->orderBy('transaccion_almacen.created_at','desc')
								->join('empleados', 'empleados.id', '=', 'transaccion_almacen.empleado_id')
								->paginate(10);
		//dd($transacciones);
		$this->createActivity(
            auth()->user()->id,
            'Historial de Movimientos',
            'Entro a Historial de Movimientos'
        );
		return view('almacen.entradasSalidas.historial', ['transacciones' => $transacciones])->with($empleados);
	}

	public function perfilTransaccion($id){
		//dd($id);
		$articulos['articulos'] = transaccion_tiene_articulo::all()->where('transaccion_id',$id);
		$transaccion['transaccion'] = TransaccionAlmacen::find($id);
		$this->createActivity(
            auth()->user()->id,
            'Historial de Movimientos',
            'Miro el Perfil de Movimiento del '.$transaccion['transaccion']->fecha.' con la hora '.$transaccion['transaccion']->hora
        );
		return view('almacen.entradasSalidas.transaccionPerfil',$articulos)->with($transaccion);
	}

	public function historialAlmacenFiltro(Request $request){
		//dd($request);

		if($request->empleado == '0' and $request->tipo == '0'){
			
			//CONSULTA GENERAL
			return $this->show();

		}elseif ($request->empleado != '0' and $request->tipo == '0' ) {
			
			//BUSCAR SOLO POR EMPLEADO
			return $this->showWithEmpleadoFilter($request->empleado);

		}elseif ($request->empleado != '0' and $request->tipo != '0' ) {
			
			//BUSCAR POR EMPLEADO Y TIPO
			return $this->showWithEmpleadoTipoFilter($request->empleado,$request->tipo);

		}elseif ($request->empleado == '0' and $request->tipo != '0' ) {
			
			//BUSCAR POR TIPO
			return $this->showWithTipoFilter($request->tipo);

		}
	}


	public function showWithEmpleadoFilter($empleadoid){
		//$transacciones['transacciones'] = TransaccionAlmacen::orderBy('created_at','desc')->get();

		$empleados['empleados'] = Empleado::All('id','nombre','apellido1','apellido2','clave');
		$transacciones = DB::table('transaccion_Almacen')
								->select('*',
										'transaccion_Almacen.id as id',
										'empleados.id as empleado_id',
										'empleados.nombre as empleado_nombre',
										'empleados.apellido1 as empleado_apellido1',
										'empleados.apellido2 as empleado_apellido2')
								->where('empleado_id',$empleadoid)
								->orderBy('transaccion_Almacen.created_at','desc')
								->join('empleados', 'empleados.id', '=', 'transaccion_Almacen.empleado_id')
								->paginate(10);
		//dd($transacciones);
		return view('almacen.entradasSalidas.historial', ['transacciones' => $transacciones])->with($empleados);
		//dd($transacciones);
	}

	public function showWithEmpleadoTipoFilter($empleadoid,$tipo){
		$empleados['empleados'] = Empleado::All('id','nombre','apellido1','apellido2','clave');
		$transacciones = DB::table('transaccion_Almacen')
								->select('*',
										'transaccion_Almacen.id as id',
										'empleados.id as empleado_id',
										'empleados.nombre as empleado_nombre',
										'empleados.apellido1 as empleado_apellido1',
										'empleados.apellido2 as empleado_apellido2')
								->where('empleado_id',$empleadoid)
								->where('transaccion_Almacen.tipo',$tipo)
								->orderBy('transaccion_Almacen.created_at','desc')
								->join('empleados', 'empleados.id', '=', 'transaccion_Almacen.empleado_id')
								->paginate(10);

		return view('almacen.entradasSalidas.historial', ['transacciones' => $transacciones])->with($empleados);
	}

	public function showWithTipoFilter($tipo){
		$empleados['empleados'] = Empleado::All('id','nombre','apellido1','apellido2','clave');
		$transacciones = DB::table('transaccion_Almacen')
								->select('*',
										'transaccion_Almacen.id as id',
										'empleados.id as empleado_id',
										'empleados.nombre as empleado_nombre',
										'empleados.apellido1 as empleado_apellido1',
										'empleados.apellido2 as empleado_apellido2')
								->where('transaccion_Almacen.tipo',$tipo)
								->orderBy('transaccion_Almacen.created_at','desc')
								->join('empleados', 'empleados.id', '=', 'transaccion_Almacen.empleado_id')
								->paginate(10);

		return view('almacen.entradasSalidas.historial', ['transacciones' => $transacciones])->with($empleados);
	}
    

		
}

