<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Trabajo;
use App\Proveedor;
use App\registro_actividad;
use App\Gastos_varios;
use App\Cotizacion;
use App\Mano_obra;
use DB;

class trabajosController extends Controller
{
    public function createActivity($user,$catalogo,$descripcion){
        $actividad =  [
            'user_id' => $user,
            'catalogo' => $catalogo,
            'descripcion' => $descripcion,
        ];

        $save = registro_actividad::create($actividad);
    }


    public function busquedaPorNumeroTrabajo(Request $request){
        $trabajo_numero = $request->trabajo_numero;
        $data['trabajos'] = Trabajo::where('id',$trabajo_numero)->
                                    orderBy('created_at', 'desc')->paginate(10);

         $clientes['clientes'] = Cliente::All();
        $this->createActivity(
            auth()->user()->id,
            'Proyectos',
            'Busco el proyecto numero: '.$trabajo_numero
        );
        //dd($trabajos);
        //dd($data);
        return view('trabajos.showTrabajos',$data)->with($clientes)->
                                                    with(['pagado_status_selected' => '0'])->
                                                    with(['cliente_selected'=>'0']);
    }

    public function filtarProyectos(Request $request){

        $data['trabajos'] = Trabajo::All()->sortByDesc('created_at');
        $pagado_status_selected = $request->pagado_status_select;
        $cliente_selected = $request->id_cliente;

        if($cliente_selected != '0' and $pagado_status_selected == '0'){
            //
            //BUSCAR SOLO POR CLIENTE
            //
            $data['trabajos'] = Trabajo::orderBy('created_at', 'desc')->where('cliente_id',$request->id_cliente)->get();
        }
        elseif ($cliente_selected != '0' and $pagado_status_selected != '0') {
            //
            //BUSCAR POR CLIENTE Y STATUS DE PAGO
            //
            $data['trabajos'] = Trabajo::where('cliente_id',$request->id_cliente)->
                                        where('pagado_status',$request->pagado_status_select)->
                                        orderBy('created_at', 'desc')->get();
        }
        elseif ($cliente_selected == '0' and $pagado_status_selected != '0') {
            //
            // BUSCAR SOLO POR STATUS DE PAGO
            //
            $data['trabajos'] = Trabajo::where('pagado_status',$request->pagado_status_select)->
                                        orderBy('created_at', 'desc')->get();
        }
        elseif($cliente_selected != '0' and $pagado_status_selected != '0'){
            //
            // NO BUSCAR POR NADA
            //
            return $this->show();
        }

        
        $clientes['clientes'] = Cliente::All()->sortBy('nombre_cliente');
        $this->createActivity(
            auth()->user()->id,
            'Proyectos',
            'Filtro trabajos'
        );

        return view('trabajos.showTrabajos',$data)->with($clientes)->
                                                    with(['pagado_status_selected' => $pagado_status_selected])->
                                                    with(['cliente_selected'=>$cliente_selected]);
    }

    public function show(){
    	$data['trabajos'] = Trabajo::All()->sortByDesc('created_at');
        $clientes['clientes'] = Cliente::All()->sortBy('nombre_cliente');
        $this->createActivity(
            auth()->user()->id,
            'Proyectos',
            'Consulto todos los Proyectos'
        );
    	//dd($trabajos);
    	return view('trabajos.showTrabajos',$data)->with($clientes)->
                                                    with(['pagado_status_selected' => '0'])->
                                                    with(['cliente_selected'=>'0']);
    }

    public function crearForm(){
    	$data['clientes'] = Cliente::All();
        $this->createActivity(
            auth()->user()->id,
            'Proyectos',
            'Abrio un formulario para Agregar un Proyecto'
        );
    	return view('trabajos.crearTrabajo',$data);
    }

    public function editarProyecto($idProyecto){
        $data['clientes'] = Cliente::All();
        $trabajo = Trabajo::find($idProyecto);
        $this->createActivity(
            auth()->user()->id,
            'Proyectos',
            'Abrio un formulario para Editar Proyecto'
        );

        return view('trabajos.editarTrabajo',$data)->with(['trabajo' => $trabajo]);
    }

    public function guardarNotas(Request $request){
        $trabajo = Trabajo::find($request->idTrabajo);
        //dd($request->idTrabajo.' '.$request->proceso);
        $this->createActivity(
            auth()->user()->id,
            'Proyectos',
            'Cambio descripcion del trabajo: '.$trabajo->nombre_trabajo.' notas: '.$request->notas_trabajo
        );
        if($trabajo) {
            $trabajo->descripcion_trabajo = $request->descripcion_trabajo;
            $trabajo->save();
        }
    }

    public function guardarOrdenCompra(Request $request){

        $trabajo = Trabajo::find($request->idTrabajo);
        //dd($request->idTrabajo.' '.$request->proceso);
        $this->createActivity(
            auth()->user()->id,
            'Proyectos',
            'Cambio P.O. del proyecto: '.$trabajo->nombre_trabajo.'a : '.$request->orden_compra
        );
        if($trabajo){
            $trabajo->orden_compra = $request->orden_compra;
            $trabajo->save();
        }
    }

    public function guardarNumeroFactura(Request $request){
        
        $trabajo = Trabajo::find($request->idTrabajo);
        //dd($request->idTrabajo.' '.$request->proceso);
        $this->createActivity(
            auth()->user()->id,
            'Proyectos',
            'Cambio Numero de factura del proyecto: '.$trabajo->nombre_trabajo.'a : '.$request->numero_factura
        );
        if($trabajo){
            $trabajo->numero_factura = $request->numero_factura;
            $trabajo->save();
        }
    }

    

    public function insertarProceso(Request $request){
    	 $trabajo = Trabajo::find($request->idTrabajo);
    	 //dd($request->idTrabajo.' '.$request->proceso);
         $this->createActivity(
            auth()->user()->id,
            'Proyectos',
            'Cambio el proceso del Proyecto: '.$trabajo->nombre_trabajo.' a '.$request->proceso
        );
        if($trabajo) {
            $trabajo->proceso = $request->proceso;
            $trabajo->save();
        }
    }

    public function insertarPagoStatus(Request $request){
        $trabajo = Trabajo::find($request->idTrabajo);
        //dd($request->idTrabajo.' '.$request->proceso);
        $this->createActivity(
            auth()->user()->id,
            'Proyectos',
            'Cambio el status de pago del Proyecto: '.$trabajo->nombre_trabajo.' a '.$request->pagoStatus
        );
        if($trabajo) {
            $trabajo->pagado_status = $request->pagoStatus;
            $trabajo->save();
        }
    }

    public function InsertarTrabajo(Request $request){
    	return DB::transaction(function () use ($request) {
			/* 
				"nombre_trabajo" => "construccion"
		      	"descripcion_trabajo" => "Construccion blab lasdflasdfoajsndfljn"
		      	"id_cliente" => "14000"
		      	"atencion_a" => "Saul goodman"
		      	"fecha_inicio" => "03/07/2018"
		      	"fecha_termino" => "03/31/2018"
		      	"tipoSubmit" => "salir"
			*/
		    $this->validate($request,[
	            'nombre_trabajo' => 'required',
	            'id_cliente' => 'required|not_in:0',
        	]);
        	/*
				'descripcion_trabajo','nombre_trabajo','id_cliente', 'fecha_inicio','fecha_termino','fecha_real_inicio','fecha_real_termino','status','atencion_a','cotizado'
        	*/

        	$trabajo = [
        		'descripcion_trabajo' => '',
        		'nombre_trabajo' => $request->nombre_trabajo,
        		'cliente_id' => $request->id_cliente,
        		'fecha_inicio' => $request->fecha_inicio,
        		'fecha_termino' => $request->fecha_termino,
        		'telefono_atencion' => $request->telefono_atencion,
        		'atencion_a' => $request->atencion_a,
        		'fecha_alternativa' => $request->fechaAlternativa,
                'dias_habiles' => $request->dias_habiles,
                'pagado_status' => 'No',
                'notas_trabajo' => '',
                'orden_compra' => $request->orden_compra,
                'tiempo_pago' => $request->tiempo_pago,
                'valides' => $request->valides,
        	];

        	
        	$this->createActivity(
                auth()->user()->id,
                'Proyectos',
                'Creo un nuevo Proyecto: '.$trabajo['nombre_trabajo']
            );
            
	    	if($request->tipoSubmit == 'cotizar'){
	    		//INICIAR LA VISTA COTIZAR CON LOS DATOS DE EL PROYECTO/TRABAJO CREADO
                $data['proveedores'] = Proveedor::All();
                $trabajo +=[
                    'status' => 'n/a',
                    'proceso' => 'Cotizando',
                    'cotizado' => 'Si',
                    'pagado_status' => 'No',
                ];
				$save = Trabajo::create($trabajo);
                return redirect('/cotizaciones/'.$save->id.'/nuevaCotizacionPorTrabajo');
	    		//return view('cotizaciones.crearCotizacion')->with($data)->with(['save' => $save]);
	    	}else{

	    		$trabajo +=[
	    			'status' => 'n/a',
	    			'proceso' => 'Cotizando',
	    			'cotizado' => 'Si',
                    'pagado_status' => 'No',
	    		];
	    		$save = Trabajo::create($trabajo);
                $trabajos['trabajos'] = Trabajo::All();


                  $gastosVarios = [
                    'gastos_admin_ganancia' => 10,
                    'gastos_admin_total'=> 0,
                    'desgaste_herramienta_ganancia'=> 10,
                    'desgaste_herramienta_total'=> 0,
                    'mantenimiento_ganancia'=> 10,
                    'mantenimiento_total'=> 0,
                    'seguridad_ganancia'=> 10,
                    'seguridad_total'=> 0,
                  ];

                  $saveGastosVarios = Gastos_varios::create($gastosVarios);

                  $mano_obra = [
                    'operador_cantidad' => 0,
                    'operador_hrs' => 0,
                    'operador_costo_hr' => 180,
                    'operador_subtotal' => 0,
                    'operador_total' => 0,
                    'tecnico_cantidad' =>  0,
                    'tecnico_hrs' => 0,
                    'tecnico_costo_hr' => 200,
                    'tecnico_subtotal' => 0,
                    'tecnico_total' => 0,
                  ];

                  $saveManoObra = Mano_obra::create($mano_obra);


                  $cotizacion = [
                    'trabajo_id' => $save->id,
                    'id_gastos_varios' => $saveGastosVarios->id,
                    'id_mano_obra' => $saveManoObra->id,
                    'total_materiales' => 0,
                    'total_mano_obra' => 0,
                    'total_insumos' => 0,
                    'subtotal_materiales' => 0,
                    'subtotal_mano_obra' => 0,
                    'subtotal_insumos' => 0,
                    'ganancia_materiales' => 0,
                    'ganancia_insumos' => 0,
                    'estado' => 'cotizado',
                    'completado' => 'false',
                    'subtotal_general' => 0,
                    'total_gastos_varios' => 0,
                    'ganancia_general' => 0,
                    'total_general' => 0,
                    'iva' => 0,
                    'total_iva' => 0,
                    'unidad_medida_id' => 1,
                  ];

                  $saveCotizacion = Cotizacion::create($cotizacion);

                
	    		return redirect('/cotizaciones/'.$save->id.'/cotizacionesProyecto')->with('message','Se ha guardado correctamente la cotizacion')->
                            with('message','Se ha creado Proyecto con exito');
	    	}
	    });
    }


    public function actualizarProyecto(Request $request,$idTrabajo){
        return DB::transaction(function () use ($request,$idTrabajo) {
            /* 
                "nombre_trabajo" => "construccion"
                "descripcion_trabajo" => "Construccion blab lasdflasdfoajsndfljn"
                "id_cliente" => "14000"
                "atencion_a" => "Saul goodman"
                "fecha_inicio" => "03/07/2018"
                "fecha_termino" => "03/31/2018"
                "tipoSubmit" => "salir"
            */
            $this->validate($request,[
                'nombre_trabajo' => 'required',
                'id_cliente' => 'required|not_in:0',  
            ]);
            /*
                'descripcion_trabajo','nombre_trabajo','id_cliente', 'fecha_inicio','fecha_termino','fecha_real_inicio','fecha_real_termino','status','atencion_a','cotizado'
            */

            $trabajo = [
                'nombre_trabajo' => $request->nombre_trabajo,
                'cliente_id' => $request->id_cliente,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_termino' => $request->fecha_termino,
                'telefono_atencion' => $request->telefono_atencion,
                'atencion_a' => $request->atencion_a,
                'fecha_alternativa' => $request->fechaAlternativa,
                'dias_habiles' => $request->dias_habiles,
                'orden_compra' => $request->orden_compra,
                'tiempo_pago' => $request->tiempo_pago,
                'valides' => $request->valides,
            ];

            $this->createActivity(
                auth()->user()->id,
                'Proyectos',
                'Edito un nuevo Proyecto: '.$trabajo['nombre_trabajo']
            );

            $updateTrabajo = Trabajo::find($idTrabajo)->update($trabajo);
            
            return redirect('/cotizaciones/'.$idTrabajo.'/cotizacionesProyecto')->with('message','Se ha guardado correctamente la cotizacion')->
                            with('message','Se ha editado Proyecto con exito');
        });
    }
}
