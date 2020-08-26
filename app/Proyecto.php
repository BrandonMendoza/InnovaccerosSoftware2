<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos'; 

    protected $fillable = ['id','cliente_id','peso_lbs','item','cantidad','status','cotizado','dias_habiles','pagado_status','descripcion','notas','titulo','work_order','plan_corte','heat_number','orden_compra','numero_factura','tipo_cambio','validez','deleted_at','created_at','updated_at','fecha_entrega','numero_parte','numero_parte_cliente','pintura_id','hrs_labor'];


    public function Cliente()
    {
        return $this->hasOne('App\Cliente','id','cliente_id');
    }

    public function Productos(){
        return $this->belongsToMany('App\Producto', 'proyecto_producto','proyecto_id', 'producto_id')
                    ->withPivot('id','cantidad','numero_parte_cliente','work_order','item','cantidad','heat_number','notas','hrs_labor','pintura_id','proceso_id')
                    ->using('App\ProyectoProducto')
                    ->as('ProyectoProducto')
                    ->withTimestamps();
    }

    public function Procesos(){
        return $this->belongsToMany('App\Proceso', 'proyectos_procesos')
                    ->withPivot('id','porcentaje','orden')
                    ->withTimestamps();
    }

    public function crearProcesos(){
        $procesos = Proceso::where('activo',1)->get();
        foreach ($procesos as $key => $proceso) {
            $this->Procesos()   ->attach($proceso->id, [   
                                    'porcentaje' => $proceso->porcentaje,
                                    'orden' => $proceso->orden,
                                    'es_ultimo' => $proceso->es_ultimo,
                                    'es_primero' => $proceso->es_primero,
                                    'es_estatico' => $proceso->es_estatico,    
                                ]);
        }
    }

    public function loadTotalHrsLabor(){
        $this['totalHrsLabor'] = $this->getTotalHrsLabor();
    }

    public function getTotalHrsLabor(){
        $productos = $this->productos;
        $totalHrsLabor = 0;
        foreach ($productos as $key => $producto) {
            $totalHrsLabor += $producto->getHrsLabor();
        }
        return number_format((float)$totalHrsLabor, 2, '.', '');
    }

    public function loadProgreso(){
        $this['progreso'] = $this->getProgreso();
    }

    public function getProgreso(){
        $sumaByProducto = 0;
        $sumaTotal = 0;
        $procesos = $this->procesos->where('es_estatico','!=',1)->sortBy('orden');
        $productos = $this->productos;
        $cantProductos = $productos->count();
        
        foreach ($productos as $key => $producto) {

            $lastProceso = $producto->ProyectoProducto->getLastProyectoProceso();
            //Si esta apenas comezado sera 0
            if($lastProceso->es_primero == 1){
                $sumaByProducto = 0;
                continue;
            }//si esta terminado sera 100 automaticamente
            elseif($lastProceso->es_ultimo == 1){
                $sumaByProducto = 100;
            }else{//si no es ninguno de los anteriores lo calculamos
                foreach ($procesos as $key => $proceso) {
                    if($proceso->pivot->id == $lastProceso->id){
                        $sumaByProducto += ($proceso->pivot->porcentaje/2);
                        break;
                    }else{
                        $sumaByProducto += $proceso->pivot->porcentaje;
                    }
                }    
            }


            $sumaTotal += $sumaByProducto;
            $sumaByProducto = 0;
        }
        return number_format((float)($sumaTotal/$cantProductos), 2, '.', '');
    }

    public function attachProyectoProductoProceso($user_id,$producto_id){
        $proyectoProductoAux = $this->getProyectoProductoById($producto_id);

        $proyectoProceso = $this->getFirstProceso();

        $proyectoProductoAux->ProyectoProcesoProducto()
                            ->attach($proyectoProductoAux->id,[   
                                'proyecto_proceso_id' => $proyectoProceso->id,
                                'user_id' => $user_id
                            ]);
    }

    public function getProyectoProductoById($id){
        return ProyectoProducto::   with('ProyectoProcesoProducto')   
                                    ->where([
                                        ['proyecto_id',$this->id],
                                        ['producto_id',$id]
                                    ])
                                    ->first();
    }

    public function getFirstProceso(){
        return  ProyectoProceso::   whereHas('Proceso', function ($query) {
                                        return $query->where('es_primero', '=', 1);
                                    })
                                    ->where('proyecto_id',$this->id)
                                    ->first();
    }


    public function updateProductosByRequest($user_id){
        //cargar Request como collection
        $request = collect(request());

        //contamos la cantidad para poder hacer el loop
        $cant_prod = count(collect($request)->get('prod_id'));

        /*obtener proceso n1*/        
        $proceso = $this->procesos->where('es_primero',1)->first();
        
        /*Se eliminan los productos que no hayan venido en el request*/
        $this->Productos()->where('id','!=',$request->get('prod_id'))->detach();

        /*loop por id de producto que viene en el request*/
        for ($i=0; $i < $cant_prod; $i++) {
            if(isset($request->get('prod_id')[$i])){
                $existe = false;
                /*Buscamos en cada producto del proyecto*/
                foreach ($this->productos as $proyectoProducto){
                    /*Se lo encontramos lo actualizamos*/
                    if( $request->get('prod_id')[$i] == $proyectoProducto->id){

                        $proyectoProducto->pivot->cantidad = $request->get('prod_cant')[$i];
                        $proyectoProducto->pivot->item = $request->get('prod_item')[$i];
                        $proyectoProducto->pivot->work_order = $request->get('prod_work_order')[$i];
                        $proyectoProducto->pivot->heat_number = $request->get('prod_heat_number')[$i];
                        $proyectoProducto->pivot->update();
                        $existe = true;
                    }
                }
                /*Si no lo encontramos lo agregamos y le damos los datos que vienen en el request*/
                if(!$existe){
                    $this   ->Productos()
                            ->attach($request->get('prod_id')[$i],
                            [   'cantidad' => $request->get('prod_cant')[$i],
                                'item' => $request->get('prod_item')[$i],
                                'work_order' => $request->get('prod_work_order')[$i],
                                'heat_number' => $request->get('prod_heat_number')[$i]]);

                    $this->attachProyectoProductoProceso($user_id,$request->get('prod_id')[$i]);
                }
            }
        }
    }
}
