<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Maquinaria;
use App\ultimoId;
use App\registro_actividad;
use DateTime;
use Image;
use Storage;
use Illuminate\Support\Facades\DB;


class maquinariaController extends Controller
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
    	$data['maquinarias'] = Maquinaria::all();
        $index = 0;
        foreach ($data['maquinarias'] as $maquinaria) {
            $fdate = $maquinaria->ultimo_serv;
            $tdate = date('m/d/Y');
            $datetime1 = new DateTime($fdate);
            $datetime2 = new DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            $dss=$days;
            $data['maquinarias'][$index]->dias_sin_serv= $days;

            $index++;
        }
        
        $this->createActivity(
            auth()->user()->id,
            'Maquinaria y vehiculos',
            'Consulto todas las Maquinarias y Vehiculos'
        );
    	return view('maquinaria.show',$data);
    }

    public function crearForm(){
        $this->createActivity(
            auth()->user()->id,
            'Maquinaria y vehiculos',
            'Abrio formulario para Crear Nueva Maquinaria o Vehiculo'
        );
    	return view('maquinaria.crear');
    }

    public function insertarMaquinaria(Request $request){
        return DB::transaction(function () use ($request) {
        $this->validate($request,[
            'clave' => 'required',
            'categorias' => 'required|not_in:0',
            'tipos' => 'required|not_in:0',
            'color' => 'required|not_in:0',
            'marca' => 'required',
            'modelo' => 'required',
            'alerta' => 'required',
            'ultimoServicio' => 'required'
        ]);
        
		$fdate = $request->ultimoServicio;
		$tdate = date('m/d/Y');
		$datetime1 = new DateTime($fdate);
		$datetime2 = new DateTime($tdate);
		$interval = $datetime1->diff($datetime2);
		$days = $interval->format('%a');
		$dss=$days;

    	$maquinaria = [
            'foto' => 'none',
            'clave' => $request->clave,
            'categoria' => $request->categorias,
            'tipo' => $request->tipos,
            'color' => $request->color,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'fecha' => $tdate,
            'ultimo_serv' => $request->ultimoServicio,
            'dias_sin_serv' => $dss,
            'alerta' => $request->alerta,
        ];

        $save = Maquinaria::create($maquinaria);
        

        if($request->hasFile('foto')){

            /*CONSEGIR LA ULTIMA ID DE LA TABLA (EL QUE ACABAMOS DE AGREGAR*/
            $ultimaMaquinaria = $save->id;
            $nuevoId = $ultimaMaquinaria;

            $nuevoModelo = [
                'identificador' => $nuevoId,
                'tabla' =>'maquinarias',
            ];
            /* CLOSE*/

            $file = $request->file('foto');
            $fotoDate = date('YmdHis');
            $fotoClave = $request->clave;
            $fotoName = $nuevoId.''.$fotoDate.''.$fotoClave.'.'.$file->clientExtension();
            
            $destinationPath = public_path(). '/uploads/maquinaria';
            $file->move($destinationPath, $fotoName);

            $maquinariaUpdate = [
                'foto' => $fotoName,
                'clave' => $request->clave,
                'categoria' => $request->categorias,
                'tipo' => $request->tipos,
                'color' => $request->color,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'fecha' => $tdate,
                'ultimo_serv' => $request->ultimoServicio,
                'dias_sin_serv' => $dss,
                'alerta' => $request->alerta,
            ];


            $update = Maquinaria::find($nuevoId)->update($maquinariaUpdate);
        }



       $data['maquinarias'] = Maquinaria::all();
        $index = 0;
        foreach ($data['maquinarias'] as $maquinaria) {
            $fdate = $maquinaria->ultimo_serv;
            $tdate = date('m/d/Y');
            $datetime1 = new DateTime($fdate);
            $datetime2 = new DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            $dss=$days;
            $data['maquinarias'][$index]->dias_sin_serv= $days;

            $index++;
        }

        $this->createActivity(
            auth()->user()->id,
            'Maquinaria y vehiculos',
            'Agrego nueva Maquinaria : '.$maquinaria->marca.' '.$maquinaria->modelo.' ('.$maquinaria->clave.')'
        );
        
        return view('maquinaria.show',$data);
        });
    }

    public function eliminarMaquinaria($id){
        return DB::transaction(function () use ($id) {
        $monster=Maquinaria::find($id);

        $this->createActivity(
            auth()->user()->id,
            'Maquinaria y vehiculos',
            'Elimino la Maquinaria : '.$monster->marca.' '.$monster->modelo.' ('.$monster->clave.')'
        );
        $monster->delete();
        
        $data['maquinarias'] = Maquinaria::all();
        $index = 0;
        foreach ($data['maquinarias'] as $maquinaria) {
            $fdate = $maquinaria->ultimo_serv;
            $tdate = date('m/d/Y');
            $datetime1 = new DateTime($fdate);
            $datetime2 = new DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            $dss=$days;
            $data['maquinarias'][$index]->dias_sin_serv= $days;

            $index++;
        }

       
        
        return view('maquinaria.show',$data);
        });
    }

    public function getMaquinaria($id){
        $data['maquinaria'] = Maquinaria::all()->find($id);
        return view('maquinaria.editar',$data);
    }

    public function actualizarMaquinaria($id,Request $request){

        return DB::transaction(function () use ($id,$request) {
        $this->validate($request,[
            'categorias' => 'required|not_in:0',
            'tipos' => 'required|not_in:0',
            'color' => 'required|not_in:0',
            'marca' => 'required',
            'modelo' => 'required',
            'alerta' => 'required',
            'ultimoServicio' => 'required'
        ]);
        

        $fdate = $request->ultimoServicio;
        $tdate = date('m/d/Y');
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');
        $dss=$days;


        $maquinaria = [
            'categoria' => $request->categorias,
            'tipo' => $request->tipos,
            'color' => $request->color,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'ultimo_serv' => $request->ultimoServicio,
            'dias_sin_serv' => $dss,
            'alerta' => $request->alerta,
        ];

        $this->createActivity(
            auth()->user()->id,
            'Maquinaria y vehiculos',
            'Actualizo la informacion de la Maquinaria : '.$maquinaria['marca'].' '.$maquinaria['modelo']
        );


        $update = Maquinaria::find($id)->update($maquinaria);

        $data['maquinarias'] = Maquinaria::all();
        $index = 0;
        foreach ($data['maquinarias'] as $maquinaria) {
            $fdate = $maquinaria->ultimo_serv;
            $tdate = date('m/d/Y');
            $datetime1 = new DateTime($fdate);
            $datetime2 = new DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            $dss=$days;
            $data['maquinarias'][$index]->dias_sin_serv= $days;

            $index++;
        }
        
        return view('maquinaria.show',$data);
        });
    }

    public function categoriasFiltro(Request $request){
        $data['maquinarias'] = Maquinaria::All();
        //dd($request);
        if($request->categoriasFiltro != '0' and $request->tiposFiltro=='0'){
            $data['maquinarias'] = Maquinaria::all()->where('categoria',$request->categoriasFiltro);    
        }else{
            if ($request->categoriasFiltro == '0' and $request->tiposFiltro != '0') {
              $data['maquinarias'] = Maquinaria::all()->where('tipo',$request->tiposFiltro);      
            }elseif ($request->categoriasFiltro != '0' and $request->tiposFiltro != '0') {
                $data['maquinarias'] = Maquinaria::all()->where('tipo',$request->tiposFiltro)->
                                                          where('categoria',$request->categoriasFiltro);
            }
        }
        return view('maquinaria.show',$data);        
    }


    public function maquinariaBusqueda(Request $request){
        //dd($request->parametro);
        $data['maquinarias']= Maquinaria::where($request->busqueda,'like', '%'.$request->parametro.'%')->get();
        return view('maquinaria.show',$data);
    }
}
