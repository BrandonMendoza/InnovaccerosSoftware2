<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Gastos_varios;
use App\Cotizacion;
use App\cotizacion_tiene_material;
use App\Mano_obra;
use App\Insumo;
use App\Trabajo;
use App\Proveedor;
use App\registro_actividad;
use App\Unidad_medida_cotizacion;
use App\Mail\Mailtrap;
use DB;
use input;
use App;
use PDF;



class cotizacionesController extends Controller
{
     public function crearForm(){
      $this->createActivity(
            auth()->user()->id,
            'Cotizaciones',
            'Esta creando una nueva cotizacion'
        );
    	 return view('cotizaciones.crearCotizacion');
    }

    public function createActivity($user,$catalogo,$descripcion){
        $actividad =  [
            'user_id' => $user,
            'catalogo' => $catalogo,
            'descripcion' => $descripcion,
        ];

        $save = registro_actividad::create($actividad);
    }

    public function guardarDescripcionTrabajo(Request $request){
      $trabajo = Trabajo::find($request->idTrabajo);
      //descripcion_trabajo,'idTrabajo':idTrabajo
      //dd($request->idTrabajo.' '.$request->proceso);
      $this->createActivity(
        auth()->user()->id,
        'Proyectos',
        'agrego descripcion al proyecto: '.$trabajo->nombre_trabajo
      );
      $trabajo->descripcion_trabajo = $request->descripcion_trabajo;
      $trabajo->save();
    }

    public function guardarDescripcionIndividual(Request $request){
      $cotizacion = Cotizacion::find($request->idCotizacion);
      $this->createActivity(
        auth()->user()->id,
        'Cotizaciones',
        'agrego descripcion a la cotizacion: '.$cotizacion->id
      );
      $cotizacion->descripcion_individual= $request->descripcion_individual;
      $cotizacion->save();
    }

    public function guardarUnidadMedidaCotizacion(Request $request){
      $cotizacion = Cotizacion::find($request->idCotizacion);
      $this->createActivity(
        auth()->user()->id,
        'Cotizaciones',
        'Cambio Unidad de medida a la cotizacion: '.$cotizacion->id
      );
      $cotizacion->unidad_medida_id= $request->unidadMedida;
      $cotizacion->save();
    }

    public function guardarCantidadCotizacion(Request $request){
      $cotizacion = Cotizacion::find($request->idCotizacion);
      $this->createActivity(
        auth()->user()->id,
        'Cotizaciones',
        'Cambio Cantidad a la cotizacion: '.$cotizacion->id
      );
      $cotizacion->cantidad= $request->cantidad;
      $cotizacion->save();
    }

    public function guardarTipoCambio(Request $request){
      $trabajo = Trabajo::find($request->idTrabajo);
      //descripcion_trabajo,'idTrabajo':idTrabajo
      //dd($request->idTrabajo.' '.$request->proceso);
      $trabajo->tipo_cambio = $request->tipo_cambio;
      $trabajo->save();
    }

    public function enviarCotizacion(){

      /*
      $cotizacion = Cotizacion::find($idCotizacion);
      $proyecto = Trabajo::find($cotizacion->trabajo_id);
      view()->share('proyecto',$proyecto);
      view()->share('cotizacion',$cotizacion);
      $pdf = PDF::loadView('cotizaciones.factura');


      $pdf = PDF::loadView('cotizaciones.factura');



      Mail::send('cotizaciones.factura', array('key' => 'value'), function($message) use($pdf)
        {
            $message->from('brandontovar@msn.com', 'Brandon Mendoza');

            $message->to('brondontovar@gmail.com')->subject('Invoice');

            $message->attachData($pdf->output(), "invoice.pdf");
        });*/

        $objDemo = new \stdClass();
        $objDemo->demo_one = 'Demo One Value';
        $objDemo->demo_two = 'Demo Two Value';
        $objDemo->sender = 'SenderUserName';
        $objDemo->receiver = 'ReceiverUserName';
 
        Mail::to("brandontovar@msn.com")->send(new mailtrap($objDemo));
        //Mail::to('brandontovar@msn.com')->send(new Mailtrap());
        return "Tu email ha sido enviado Correctamente";
          /*
          $data = array(
            'name' => " Curso laravel",
          );
          Mail::send('emails.welcome', $data, function($message){

            $message->from('brandontovar@msn.com');
            $message->to('brandontovar@msn.com')->subject('test email curso laravel');
          });
          return "Tu email ha sido enviado Correctamente";*/


        

          $this->cotizacionesPorProyecto();
    }


    public function eliminarCotizacion($idCotizacion){
      return DB::transaction(function () use ($idCotizacion) {
        $cotizacion = Cotizacion::find($idCotizacion);

        $idProyecto = $cotizacion->trabajo_id;

        $gastosVarios = Gastos_varios::find($cotizacion->id_gastos_varios);
        $gastosVarios->delete();

        $manoObra = Mano_obra::find($cotizacion->id_mano_obra);
        $manoObra->delete();

        $deleteMateriales = cotizacion_tiene_material::All()->where('id_cotizacion',$idCotizacion);
        foreach ($deleteMateriales as $material) {
          $deleteMaterial = cotizacion_tiene_material::find($material->id);
          $deleteMaterial->delete();
        }

        $deleteInsumos = Insumo::All()->where('id_cotizacion',$idCotizacion);
        foreach ($deleteInsumos as $insumo) {
          $deleteInsumo = Insumo::find($insumo->id);
          $deleteInsumo->delete();
        }

        $cotizacion->delete();

        $cotizaciones['cotizaciones'] = Cotizacion::All()->where('trabajo_id', $idProyecto);
        $proyecto = Trabajo::find($idProyecto);
        //dd($cotizaciones);
        $this->createActivity(
            auth()->user()->id,
            'Cotizaciones',
            'Elimino una cotizacion de el Proyecto '.$proyecto->nombre_trabajo
        );

        return redirect('/cotizaciones/'.$idProyecto.'/cotizacionesProyecto')->with($cotizaciones)->with(['idProyecto' => $idProyecto])->with('proyecto',$proyecto)->with('message','Se ha eliminado correctamente la cotizacion');
        });
    }

    public function actualizarCotizacion(Request $request, $idCotizacion){
      //dd($id);
      //$update = Empleado::find($nuevoId)->update($empleadoUpdate);
      return DB::transaction(function () use ($idCotizacion,$request) {
      $cotizacionGeneral = Cotizacion::find($idCotizacion);

      //dd($request);

      $gastosVarios = [
        'gastos_admin_ganancia' => $request->gastos_admin_ganancia,
        'gastos_admin_total'=>$request->gastos_admin_total,
        'desgaste_herramienta_ganancia'=>$request->herramienta_ganancia,
        'desgaste_herramienta_total'=>$request->herramienta_total,
        'mantenimiento_ganancia'=>$request->mantenimiento_ganancia,
        'mantenimiento_total'=>$request->mantenimiento_total,
        'seguridad_ganancia'=>$request->seguridad_ganancia,
        'seguridad_total'=>$request->seguridad_total,
      ];

      $updateGastosVarios = Gastos_varios::find($cotizacionGeneral->id_gastos_varios)->update($gastosVarios);
      $updateGastosVarios = Gastos_varios::find($cotizacionGeneral->id_gastos_varios);

      $mano_obra = [
        'operador_cantidad' => $request->operador_cantidad,
        'operador_hrs' => $request->operador_hrs,
        'operador_costo_hr' => $request->operador_costo_hr,
        'operador_subtotal' => $request->operador_subtotal,
        'operador_total' => $request->operador_total,
        'tecnico_cantidad' =>  $request->tecnico_cantidad,
        'tecnico_hrs' => $request->tecnico_hrs,
        'tecnico_costo_hr' => $request->tecnico_costo_hr,
        'tecnico_subtotal' => $request->tecnico_subtotal,
        'tecnico_total' => $request->tecnico_total,
      ];

      $updateManoObra = Mano_obra::find($cotizacionGeneral->id_mano_obra)->update($mano_obra);
      $updateManoObra = Mano_obra::find($cotizacionGeneral->id_mano_obra);


      $cotizacion = [
        'trabajo_id' => $request->id_proyecto,
        'id_gastos_varios' => $updateGastosVarios->id,
        'id_mano_obra' => $updateManoObra->id,
        'total_materiales' => $request->total_material,
        'total_mano_obra' => $request->mano_obra_total,
        'total_insumos' => $request->total_insumos_general,
        'subtotal_materiales' => $request->subtotal_material,
        'subtotal_mano_obra' => $request->mano_obra_subtotal,
        'subtotal_insumos' => $request->subtotal_insumos_general,
        'ganancia_materiales' => $request->ganancia_material,
        'ganancia_insumos' => $request->ganancia_insumos_general,
        'estado' => 'cotizado',
        'completado' => 'false',
        'subtotal_general' => $request->subtotal_general,
        'total_gastos_varios' => $request->gastos_varios_general,
        'ganancia_general' => $request->ganancia_general,
        'total_general' => $request->total_general,
        'iva' => $request->iva,
        'total_iva' => $request->total_iva,
      ];

      $updateCotizacion = Cotizacion::find($idCotizacion)->update($cotizacion);
      $updateCotizacion = Cotizacion::find($idCotizacion);
      
      $cotizacionRequest = $request->all();
      $counterMaterial = data_get($cotizacionRequest,'counter_material');

      
      $deleteMateriales = cotizacion_tiene_material::All()->where('id_cotizacion',$idCotizacion);
      foreach ($deleteMateriales as $material) {
        $deleteMaterial = cotizacion_tiene_material::find($material->id);
        $deleteMaterial->delete();
      }


      //DB::table('cotizacion_tiene_material')->All()->whereIn('id_cotizacion',$idCotizacion)->delete();
      //dd('hola');
      if($counterMaterial > 0){
        for ($i=0; $i < $counterMaterial; $i++) {

          $materialNombre = data_get($cotizacionRequest,'material_nombre_'.$i);

          if($materialNombre != null){
            $material = [
              'id_cotizacion' => $updateCotizacion->id,
              'uso' => data_get($cotizacionRequest,'material_uso_'.$i),
              'material_nombre' => data_get($cotizacionRequest,'material_nombre_'.$i),
              'cantidad' => data_get($cotizacionRequest,'material_cantidad_'.$i),
              'costo_unitario' => data_get($cotizacionRequest,'material_costounitario_'.$i),
              'subtotal_costo' => data_get($cotizacionRequest,'material_subtotal_'.$i),
              'ganancia' => data_get($cotizacionRequest,'material_ganancia_'.$i),
              'total' => data_get($cotizacionRequest,'material_total_'.$i),
            ];

            $updateMaterial_Cotizacion = cotizacion_tiene_material::create($material);
          }
        }
      }

      $deleteInsumos = Insumo::All()->where('id_cotizacion',$idCotizacion);
      foreach ($deleteInsumos as $insumo) {
        $deleteInsumo = Insumo::find($insumo->id);
        $deleteInsumo->delete();
      }


      $counterInsumos = data_get($cotizacionRequest,'counter_insumos');

      if($counterInsumos > 0){
        for ($i=0; $i < $counterInsumos; $i++) {

          $insumosNombre = data_get($cotizacionRequest,'insumo_nombre_'.$i);
          if($insumosNombre != null){
            $insumo = [
              'id_cotizacion' => $updateCotizacion->id,
              'concepto' => data_get($cotizacionRequest,'insumo_nombre_'.$i),
              'costo' => data_get($cotizacionRequest,'insumo_costo_'.$i),
              'subtotal' => data_get($cotizacionRequest,'insumo_subtotal_'.$i),
              'ganancia' => data_get($cotizacionRequest,'insumo_ganancia_'.$i),
              'total' => data_get($cotizacionRequest,'insumo_total_'.$i),
            ];
            $updateInsumo_Cotizacion = Insumo::create($insumo);
          }
        }
      }

      

      $proyecto = Trabajo::find($request->id_proyecto);

      $this->createActivity(
            auth()->user()->id,
            'Cotizaciones',
            'Modifico una cotizacion de el Proyecto '.$proyecto['nombre_trabajo']
        );
      return redirect('/cotizaciones/'.$request->id_proyecto.'/cotizacionesProyecto')->with('message','Se ha guardado correctamente la cotizacion');

      });
      
    }


    public function editarCotizacionForm($idCotizacion){
      return DB::transaction(function () use ($idCotizacion) {
      $cotizacionGeneral = Cotizacion::find($idCotizacion);
      $data['proveedores'] = Proveedor::All();

      $materiales = cotizacion_tiene_material::All()->where('id_cotizacion',$idCotizacion);
      $countMateriales = count($materiales);

      $gastosVarios = Gastos_varios::find($cotizacionGeneral->id_gastos_varios);
      //dd($gastosVarios);

      $insumos = Insumo::All()->where('id_cotizacion',$idCotizacion);
      
      $countInsumos = count($insumos);

      $manoObra = Mano_obra::find($cotizacionGeneral->id_mano_obra);

      $save = Trabajo::find($cotizacionGeneral->trabajo_id);

      $this->createActivity(
        auth()->user()->id,
        'Cotizaciones',
        'Ingreso a Editar Proyecto'
      );

      return view('cotizaciones.editarCotizacion')->with(['cotizacionGeneral' => $cotizacionGeneral])
                                                  ->with('materiales',$materiales)
                                                  ->with('gastosVarios',$gastosVarios)
                                                  ->with('insumos',$insumos)
                                                  ->with('manoObra',$manoObra)
                                                  ->with(['countMateriales'=>$countMateriales])
                                                  ->with(['countInsumos'=>$countInsumos])
                                                  ->with(['save'=> $save])
                                                  ->with($data);

      });


    }

    public function cotizacionesPorProyecto($idProyecto){
      /*$pdf = App::make('dompdf.wrapper');
      $pdf->loadHTML('<h1>Test</h1>');
      return $pdf->stream();*/
      $cotizaciones['cotizaciones'] = Cotizacion::All()->where('trabajo_id', $idProyecto);
      $unidades_medida['unidades_medida'] = Unidad_medida_cotizacion::All();
      $proyecto = Trabajo::find($idProyecto);
      
      
      //dd($cotizaciones);
      $this->createActivity(
        auth()->user()->id,
        'Cotizaciones',
        'Consulto las cotizaciones de el Proyecto: '.$proyecto->nombre_trabajo
      );

      return view('cotizaciones.cotizacionesPorProyecto',$cotizaciones)->
              with(['idProyecto' => $idProyecto])->
              with('proyecto',$proyecto)->
              with($unidades_medida);
    }


    public function imprimirFactura(Request $request,$idCotizacion){
      $cotizacion = Cotizacion::find($idCotizacion);
      $proyecto = Trabajo::find($cotizacion->trabajo_id);
      
      $descripcion_renglones = explode("\n",(string)$proyecto->descripcion_trabajo);
      $loop = 0;


      view()->share('proyecto',$proyecto);
      view()->share('loop',$loop);
      view()->share('descripcion_renglones',$descripcion_renglones);
      view()->share('cotizacion',$cotizacion);

      if($request->moneda == 0){
        $pdf = PDF::loadView('cotizaciones.CosteoTemplate');
      }
      else{
        $pdf = PDF::loadView('cotizaciones.facturaDolares');
      }

      $this->createActivity(
        auth()->user()->id,
        'Cotizaciones',
        'Imprimio la cotizacion de el Proyecto: '.$proyecto['nombre_trabajo']
      );
      $pdf->setOptions(['dpi' => 130, 'defaultFont' => 'sans-serif']);
      //$pdf->stream($cotizacion->trabajo_id.'-'.$proyecto['nombre_trabajo'].'.pdf');
      
      return $pdf->stream($cotizacion->trabajo_id.'-'.$proyecto['nombre_trabajo'].'.pdf');
      
    }

    public function imprimirGrupos(Request $request){
      $proyecto = Trabajo::find($request->proyecto_id);
      $cotizaciones['cotizaciones'] = Cotizacion::All()->where('trabajo_id', $request->proyecto_id);
      $totalCotizacion = 0;
      foreach ($cotizaciones['cotizaciones'] as $id => $cotizacion) {

        if($request->moneda==1) {
          $cotizacion->total_general = $cotizacion->total_general/$proyecto->tipo_cambio;
        }

        $totalCotizacion += $cotizacion->total_general*$cotizacion->cantidad;
      }

      
      $descripcion_palabras = explode(" ",(string)$proyecto->descripcion_trabajo);
      $loop = 0;
      view()->share('proyecto',$proyecto);
      view()->share('loop',$loop);
      view()->share('descripcion_palabras',$descripcion_palabras);
      view()->share('cotizaciones',$cotizaciones['cotizaciones']);
      view()->share('totalCotizacion',$totalCotizacion);

      $pdf = PDF::loadView('cotizaciones.ImprimirGrupos');



      $this->createActivity(
        auth()->user()->id,
        'Cotizaciones',
        'Imprimio en grupos del Proyecto: '.$proyecto['nombre_trabajo']
      );
      $pdf->setOptions(['dpi' => 130, 'defaultFont' => 'sans-serif']);
      $pdf->stream('CotizacionGrupo -'.$proyecto['nombre_trabajo'].'.pdf');
      return $pdf->stream('CotizacionGrupo -'.$proyecto['nombre_trabajo'].'.pdf');
    }



    //PARA CREAR COTIZACIONES DIRECTAMENTE
    public function nuevaCotizacionDirecto($idProyecto){
      $save = Trabajo::find($idProyecto);
      $data['proveedores'] = Proveedor::All();


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
        'trabajo_id' => $idProyecto,
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
        'cantidad' => 1,
        'unidad_medida_id' => 1,
      ];

      $saveCotizacion = Cotizacion::create($cotizacion);
      //dd($idProyecto);
      $this->createActivity(
        auth()->user()->id,
        'Cotizaciones',
        'Abrio el crear Nueva Cotizacion de el Proyecto: '.$save->nombre_trabajo
      );
      
      return redirect('/cotizaciones/'.$saveCotizacion->id.'/editar');
      //return view('cotizaciones.crearCotizacion')->with(['save' => $save])->with($data);
    }

    /*
    public function nuevaCotizacion($idProyecto){
      $save = Trabajo::find($idProyecto);
      $data['proveedores'] = Proveedor::All();
      
      //dd($idProyecto);
      $this->createActivity(
        auth()->user()->id,
        'Cotizaciones',
        'Abrio el crear Nueva Cotizacion de el Proyecto: '.$save->nombre_trabajo
      );
      return view('cotizaciones.crearCotizacion')->with(['save' => $save])->with($data);
    }*/



    public function insertarCotizacion(Request $request){
      return DB::transaction(function () use ($request) {

        //dd($request);

      $proyecto = Trabajo::find($request->id_proyecto);

      $proyecto->cotizado = 'Si';
      $proyecto->proceso = 'Cotizando';
      $proyecto->status = 'Esperando Aprobacion';
      $updateProyecto = Trabajo::find($request->id_proyecto)->update($proyecto->toArray());

      


      $gastosVarios = [
        'gastos_admin_ganancia' => $request->gastos_admin_ganancia,
        'gastos_admin_total'=>$request->gastos_admin_total,
        'desgaste_herramienta_ganancia'=>$request->herramienta_ganancia,
        'desgaste_herramienta_total'=>$request->herramienta_total,
        'mantenimiento_ganancia'=>$request->mantenimiento_ganancia,
        'mantenimiento_total'=>$request->mantenimiento_total,
        'seguridad_ganancia'=>$request->seguridad_ganancia,
        'seguridad_total'=>$request->seguridad_total,
      ];

      $saveGastosVarios = Gastos_varios::create($gastosVarios);

      $mano_obra = [
        'operador_cantidad' => $request->operador_cantidad,
        'operador_hrs' => $request->operador_hrs,
        'operador_costo_hr' => $request->operador_costo_hr,
        'operador_subtotal' => $request->operador_subtotal,
        'operador_total' => $request->operador_total,
        'tecnico_cantidad' =>  $request->tecnico_cantidad,
        'tecnico_hrs' => $request->tecnico_hrs,
        'tecnico_costo_hr' => $request->tecnico_costo_hr,
        'tecnico_subtotal' => $request->tecnico_subtotal,
        'tecnico_total' => $request->tecnico_total,
      ];

      $saveManoObra = Mano_obra::create($mano_obra);


      $cotizacion = [
        'trabajo_id' => $request->id_proyecto,
        'id_gastos_varios' => $saveGastosVarios->id,
        'id_mano_obra' => $saveManoObra->id,
        'total_materiales' => $request->total_material,
        'total_mano_obra' => $request->mano_obra_total,
        'total_insumos' => $request->total_insumos_general,
        'subtotal_materiales' => $request->subtotal_material,
        'subtotal_mano_obra' => $request->mano_obra_subtotal,
        'subtotal_insumos' => $request->subtotal_insumos_general,
        'ganancia_materiales' => $request->ganancia_material,
        'ganancia_insumos' => $request->ganancia_insumos_general,
        'estado' => 'cotizado',
        'completado' => 'false',
        'subtotal_general' => $request->subtotal_general,
        'total_gastos_varios' => $request->gastos_varios_general,
        'ganancia_general' => $request->ganancia_general,
        'total_general' => $request->total_general,
        'iva' => $request->iva,
        'total_iva' => $request->total_iva,
      ];

      $saveCotizacion = Cotizacion::create($cotizacion);
      
      $cotizacionRequest = $request->all();

      $counterMaterial = data_get($cotizacionRequest,'counter_material');
      if($counterMaterial > 0){
        for ($i=0; $i < $counterMaterial; $i++) {

          $materialNombre = data_get($cotizacionRequest,'material_nombre_'.$i);

          if($materialNombre != null){
            $material = [
              'id_cotizacion' => $saveCotizacion->id,
              'uso' => data_get($cotizacionRequest,'material_uso_'.$i),
              'material_nombre' => data_get($cotizacionRequest,'material_nombre_'.$i),
              'cantidad' => data_get($cotizacionRequest,'material_cantidad_'.$i),
              'costo_unitario' => data_get($cotizacionRequest,'material_costounitario_'.$i),
              'subtotal_costo' => data_get($cotizacionRequest,'material_subtotal_'.$i),
              'ganancia' => data_get($cotizacionRequest,'material_ganancia_'.$i),
              'total' => data_get($cotizacionRequest,'material_total_'.$i),
            ];
            $saveMaterial_Cotizacion = cotizacion_tiene_material::create($material);
          }
        }
      }


       $counterInsumos = data_get($cotizacionRequest,'counter_insumos');
      if($counterInsumos > 0){
        for ($i=0; $i < $counterInsumos; $i++) {

          $insumosNombre = data_get($cotizacionRequest,'insumo_nombre_'.$i);
          if($insumosNombre != null){
            $insumo = [
              'id_cotizacion' => $saveCotizacion->id,
              'concepto' => data_get($cotizacionRequest,'insumo_nombre_'.$i),
              'costo' => data_get($cotizacionRequest,'insumo_costo_'.$i),
              'subtotal' => data_get($cotizacionRequest,'insumo_subtotal_'.$i),
              'ganancia' => data_get($cotizacionRequest,'insumo_ganancia_'.$i),
              'total' => data_get($cotizacionRequest,'insumo_total_'.$i),
            ];
            $saveInsumo_Cotizacion = Insumo::create($insumo);
          }
        }
      }

      $this->createActivity(
        auth()->user()->id,
        'Cotizaciones',
        'Guardo Cotizacion de el Proyecto: '.$proyecto->nombre_trabajo
      );



    	return redirect('/cotizaciones/'.$request->id_proyecto.'/cotizacionesProyecto')->with('message','Se ha guardado correctamente la cotizacion');

      });
    }
}

