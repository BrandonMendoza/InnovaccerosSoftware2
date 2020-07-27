<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use App\Empleado_nomina;
use Illuminate\Support\Collection;
use App\Nomina;
use App\Calendario_empleado;
use Carbon\Carbon;

class nominasController extends Controller
{

    public function show(){
        $data['nominas'] = Nomina::orderBy('created_at', 'desc')->paginate(10);;
    	return view('nominas.showNominas')->with($data);
    }

    public function crear(){

    	$empleados = Empleado::All();

    	$now = Carbon::now();
    	$nomina = [
    		'ano' => $now->year,
    		'mes' => $now->format('m'),
    		'semana' => $now->weekOfYear,
    		'total' => '0'
    	];
        $viernes = Carbon::now()->subDays(4)->format('d').'/'.$this->calcularMes((int)Carbon::now()->subDays(4)->format('m'));
        $sabado = Carbon::now()->subDays(3)->format('d').'/'.$this->calcularMes((int)Carbon::now()->subDays(3)->format('m'));
        $domingo = Carbon::now()->subDays(2)->format('d').'/'.$this->calcularMes((int)Carbon::now()->subDays(2)->format('m'));
        $lunes = Carbon::now()->subDays(1)->format('d').'/'.$this->calcularMes((int)Carbon::now()->subDays(1)->format('m'));
        $martes = Carbon::now()->format('d').'/'.$this->calcularMes((int)Carbon::now()->format('m'));
        $miercoles = Carbon::now()->addDays(1)->format('d').'/'.$this->calcularMes((int)Carbon::now()->subDays(1)->format('m'));
        $jueves = Carbon::now()->addDays(2)->format('d').'/'.$this->calcularMes((int)Carbon::now()->subDays(2)->format('m'));

    	$guardarNomina = Nomina::create($nomina);
    	$nomina = Nomina::find($guardarNomina->id);

    	foreach ($empleados as $id => $empleado) {
    		$nomina->empleados()->attach($empleado);
    	}

        $empleados = Empleado_nomina::All()->where('nomina_id',$nomina->id);

        foreach ($empleados as $key => $empleado) {
            $empleado->viernes_fecha = $viernes;
            $empleado->sabado_fecha = $sabado;
            $empleado->domingo_fecha = $domingo;
            $empleado->lunes_fecha =  $lunes;
            $empleado->martes_fecha = $martes;
            $empleado->miercoles_fecha = $miercoles;
            $empleado->jueves_fecha = $jueves;
            $empleado->save();
        }

    	return redirect('/nomina/'.$nomina->id.'/llenar');
    }

    public function llenar($id){
    	$nomina = Nomina::find($id);
    	return view('nominas.llenarNomina')->with(['nomina'=> $nomina]);
    }

    public function insertarHrsExtra(Request $request){
		$nomina = Nomina::find($request->nomina_id);
		$empleado = $nomina->empleados()->find($request->empleado_id);
		$empleado->pivot->hrs_extra = $request->hrs_extra;
		$empleado->pivot->save(); 
    }

    public function insertarFaltas(Request $request){
		$nomina = Nomina::find($request->nomina_id);
		$empleado = $nomina->empleados()->find($request->empleado_id);
		$empleado->pivot->faltas = $request->faltas;
		$empleado->pivot->save(); 
    }

    public function insertarRetardos(Request $request){
		$nomina = Nomina::find($request->nomina_id);
		$empleado = $nomina->empleados()->find($request->empleado_id);
		$empleado->pivot->retardos = $request->retardos;
		$empleado->pivot->save(); 
    }

    public function perfilNomina($nomina_id){
        $nomina = Nomina::find($nomina_id);
        return view('nominas.perfilNomina')->with(['nomina'=> $nomina]);
    }

    public function calcularMes($numero_mes){
        $meses = collect(["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"]);
        return $meses->get($numero_mes-1);
    }
}
