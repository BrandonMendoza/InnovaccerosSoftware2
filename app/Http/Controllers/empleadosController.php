<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use App\Empleado;
use App\Deuda;
use App\Amonestacion;
use App\EmpleadoBaja;
use App\UltimoId;
use App\registro_actividad;
use App\Comentario_empleado;
use Redirect;
use DB;
use PDF;


class empleadosController extends Controller
{
    public function createActivity($user,$catalogo,$descripcion){
        $actividad =  [
            'user_id' => $user,
            'catalogo' => $catalogo,
            'descripcion' => $descripcion,
        ];

        $save = registro_actividad::create($actividad);
    }



    public function crearDeuda($id){
        $empleado_id = $id;
        return view('empleados.crearDeuda')->with(['empleado_id' => $empleado_id]);
    }

    public function editarDeuda($id){
        $data['deuda'] = Deuda::find($id);
        return view('empleados.editarDeuda')->with($data);
    }

    public function insertarDeuda(Request $request){
        $this->validate($request,[
            'monto' => 'required',
            'plazo' => 'required|not_in:0',
            'empleado_id' => 'required',
            'tipo' => 'required',
        ]);


        $deuda = [
            'monto' => $request->monto,
            'plazo' => $request->plazo,
            'empleado_id' => $request->empleado_id,
            'tipo' => $request->tipo,
            'pagado' => 'false',
            'restante_pagar' => $request->monto,
        ];

        if($request->deuda_id){
            $update = Deuda::find($request->deuda_id)->update($deuda);
        }
        else{
            $save = Deuda::create($deuda);    
        }
        
        return redirect('/empleado/'.$request->empleado_id.'/perfil');
    }

    public function imprimirAmonestacion($id){
        $amonestacion = Amonestacion::find($id);
      $data['empleado'] = Empleado::find($amonestacion->empleado_id);
      view()->share('amonestacion',$amonestacion);

      $pdf = PDF::loadView('empleados.imprimirAmonestacion',$data);

      
      $this->createActivity(
        auth()->user()->id,
        'Empleados',
        'Imprimio la amonestacion de el Empleado: '.$data['empleado']->nombre.' '.$data['empleado']->apellido1.' '.$data['empleado']->apellido2.' ('.$data['empleado']->clave.')'
      );


      return $pdf->stream('factura'.$id.'.pdf');
    }

    public function crearAmonestacion($id){

        $data['empleado'] = Empleado::find($id);

        return view('empleados.crearAmonestacion',$data);
    }

    public function show(){
    	$data['empleados'] = Empleado::all();
        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Consulto todos los Empleados'
        );
    	return view('empleados.showEmpleados',$data);
    }

    public function crearForm(){
        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Entro en Agregar nuevo Empleado'
        );
    	return view('empleados.crearEmpleado');
    }

    public function insertarComentario($empleado_id, Request $request){
        
        $comentario = [
            'comentario' => $request->comentario,
            'user_id' => auth()->user()->id,
            'empleado_id' => $empleado_id,
        ];

        $save = Comentario_empleado::create($comentario);
        $data['empleado'] = Empleado::find($empleado_id);

        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Agrego un comentario al empleado : '.$data['empleado']->nombre.' '.$data['empleado']->apellido1.' '.$data['empleado']->apellido2.' ('.$data['empleado']->clave.'), Comentario: '.$request->comentario
        );

        return Redirect::back()->with('message','Operation Successful !');
    }

    public function getBajasEmpleados(){
        $data['empleados'] = Empleado::onlyTrashed()->get();
        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Consulto todos los Empleados Dados de Baja'
        );
        
        return view('empleados.showbajasEmpleado',$data);

    }

    public function empleadoPerfil($id){
        $data['empleado'] = Empleado::find($id);
        $comentarios['comentarios'] = Comentario_empleado::where('empleado_id',$id)->orderBy('created_at', 'desc')->paginate(5);
        $amonestaciones['amonestaciones'] = Amonestacion::where('empleado_id',$id)->orderBy('created_at', 'desc')->paginate(5);

        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Consulto la informacion del Empleado: '.$data['empleado']->nombre.' '.$data['empleado']->apellido1.' '.$data['empleado']->apellido2.' ('.$data['empleado']->clave.')'
        );
        return view('empleados.perfilEmpleado',$data)->with($comentarios)->with($amonestaciones);
    }

    public function empleadoPerfilBaja($id){
        $data['empleado'] = Empleado::onlyTrashed()
                ->where('id', $id)
                ->get();
                
        $comentarios['comentarios'] = Comentario_empleado::where('empleado_id',$id)->orderBy('created_at', 'desc')->paginate(5);

        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Consulto la informacion del Empleado Dado de Baja: '.$data['empleado'][0]->nombre.' '.$data['empleado'][0]->apellido1.' '.$data['empleado'][0]->apellido2.' ('.$data['empleado'][0]->clave.')'
        );
        return view('empleados.perfilEmpleadoBaja',$data)->with($comentarios);
    }

    public function altaEmpleado($id){
        $empleado = Empleado::withTrashed()
                            ->where('id', $id)
                            ->restore();

        $empleado = Empleado::find($id);

        $data['empleados'] = Empleado::onlyTrashed()->get();
        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Restauro al Empleado: '.$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2.' ('.$empleado->clave.')'
        );
        
        return view('empleados.showbajasEmpleado',$data);
    }

    public function actualizarAmonestacion(Request $request,$id){
        $this->validate($request,[
            'motivo' => 'required',
            'sancion' => 'required'
        ]);


        $amonestacion = [
            'empleado_id'=> $request->empleado_id,
            'motivo' =>$request->motivo,
            'tipo'=>$request->tipo,
            'sancion'=> $request->sancion,
        ];


        $update = Amonestacion::find($id)->update($amonestacion);
        //$save = Amonestacion::create($amonestacion);

        $data['empleado'] = Empleado::find($request->empleado_id);
        $comentarios['comentarios'] = Comentario_empleado::where('empleado_id',$request->empleado_id)->orderBy('created_at', 'desc')->paginate(5);
        $amonestaciones['amonestaciones'] = Amonestacion::where('empleado_id',$request->empleado_id)->orderBy('created_at', 'desc')->paginate(5);

        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Actualizo la informacion de una amonestacion para el empleado: '.$data['empleado']->nombre.' '.$data['empleado']->apellido1.' '.$data['empleado']->apellido2.' ('.$data['empleado']->clave.')'
        );
        return view('empleados.perfilEmpleado',$data)->with($comentarios)->with($amonestaciones);
    }

    public function insertarAmonestacion(Request $request){
        $this->validate($request,[
            'motivo' => 'required',
            'tipo' => 'required',
            'sancion' => 'required'
        ]);


        $amonestacion = [
            'empleado_id'=> $request->empleado_id,
            'motivo' =>$request->motivo,
            'tipo'=>$request->tipo,
            'sancion'=> $request->sancion,
        ];

        $save = Amonestacion::create($amonestacion);

        $data['empleado'] = Empleado::find($request->empleado_id);
        $comentarios['comentarios'] = Comentario_empleado::where('empleado_id',$request->empleado_id)->orderBy('created_at', 'desc')->paginate(5);
        $amonestaciones['amonestaciones'] = Amonestacion::where('empleado_id',$request->empleado_id)->orderBy('created_at', 'desc')->paginate(5);

        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Crea una amonestacion para el empleado: '.$data['empleado']->nombre.' '.$data['empleado']->apellido1.' '.$data['empleado']->apellido2.' ('.$data['empleado']->clave.')'
        );
        return Redirect('/empleado/'.$data['empleado']->id.'/perfil');
    }

    public function insertarRate(Request $request){
        $empleado = Empleado::find($request->id);
        $rate = ((int)$request->rate) + 1;
        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Califico al Empleado: '.$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2.' con: '.$rate.' Estrellas'
        );
        if($empleado) {
            $empleado->rate = $request->rate;
            $empleado->save();
        }
    }   

    public function eliminarEmpleado(Request $request,$id){
        return DB::transaction(function () use ($id,$request) {
        /*

        $empleadoUpdate += ['identificacion' => $fotoName,];

            */
        $empleadoBaja = [];
        $empleado = Empleado::find($id);
        if(!is_null($empleado->identificacion)){
            $empleadoBaja += ['identificacion' => $empleado->identificacion,];
        }

        if(!is_null($empleado->num_imss)){
            $empleadoBaja += ['num_imss' => $empleado->num_imss,];
        }

        if(!is_null($empleado->acta_nacimiento)){
            $empleadoBaja += ['acta_nacimiento' => $empleado->acta_nacimiento,];
        }

        if(!is_null($empleado->comprobante_domicilio)){
            $empleadoBaja += ['comprobante_domicilio' => $empleado->comprobante_domicilio,];
        }

        if(!is_null($empleado->rfc)){
            $empleadoBaja += ['rfc' => $empleado->rfc,];
        }

        if(!is_null($empleado->curp)){
            $empleadoBaja += ['curp' => $empleado->curp,];
        }

        if(!is_null($empleado->carta_no_antecedentes)){
            $empleadoBaja += ['carta_no_antecedentes' => $empleado->carta_no_antecedentes,];
        }

        if(!is_null($empleado->foto)){
            $empleadoBaja += ['foto' => $empleado->foto,];
        }
        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Elimino al Empleado: '.$empleado->nombre.' '.$empleado->apellido1.' '.$empleado->apellido2.' ('.$empleado->clave.')'
        );
        $empleado->delete();
        
        $data['empleados'] = Empleado::all();
        return view('empleados.showEmpleados',$data);
        });
    }

    public function getEmpleado($id){
        $data['empleado'] = Empleado::find($id);
        $subRoles = $data['empleado']->subRoles;
        $splitRoles['splitRoles'] = explode('-', $subRoles);

        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Entro a editar Empleado: '.$data['empleado']->nombre.' '.$data['empleado']->apellido1.' '.$data['empleado']->apellido2.' ('.$data['empleado']->clave.')'
        );
        return view('empleados.editarEmpleado',$data);
    }

    public function getAmonestacion($id){
        $data['amonestacion'] = Amonestacion::find($id);
        $empleado['empleado'] = Empleado::find($data['amonestacion']->empleado_id);

        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Entro a editar Amonestacion: '.$data['amonestacion']->id
        );
        return view('empleados.editarAmonestacion',$data)->with($empleado);
    }

    public function actualizarEmpleado(Request $request){
        //dd($request);
        return DB::transaction(function () use ($request) {

        $this->validate($request,[
            'nombre' => 'required',
            'apellido1' => 'required',
            'apellido2' => 'required',
            'fecha_entrada' => 'required',
            'fecha_nac' => 'required',
            'direccion' => 'required',
            'salario' => 'required',
            'puesto' => 'required|not_in:0'
        ]);
        
        /* EDAD*/
        $fechaNac = $request->fecha_nac;

        $edad = $this->getDiferenciaTiempo($fechaNac,1);
        
        /* TIEMPO EN LA EMPRESA*/
        $fechaIngreso = $request->fecha_entrada;
        $mesesTrabajando = $this->getDiferenciaTiempo($fechaIngreso,2);

        $empleados = [
            'nombre' => $request->nombre,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'fecha_entrada' => $request->fecha_entrada,
            'fecha_nac' => $request->fecha_nac,
            'tiempo_trabajando' => $mesesTrabajando,
            'edad' => $edad,
            'telefono1' => $request->telefono1,
            'telefono2' => $request->telefono2,
            'direccion' => $request->direccion,
            'email' => $request->email,
            'roles' => $request->puesto,
            'salario_semanal' => $request->salario,
            'num_imss' => $request->imss,
            'curp' => $request->curp,
            'rfc' => $request->rfc,
        ];

        //$save = Empleado::create($empleados);
        $empleadoUpdate = $empleados;
        /*-----> CREANDO CLAVE DE EMPLEADO <--------------*/
        $claveEmpleado = $request->clave;

        /*ADMINISTRANDO EL ULTIMO ID EN LA BD*/
        $ultimoEmpleado = $request->id;
        $nuevoId = $ultimoEmpleado;
        
        if ($request->file('identificacion')) {
            $file = $request->file('identificacion');
            $fotoDate = date('YmdHis');
            $fotoClave = $claveEmpleado;
            $fotoName = 'ID'.$nuevoId.''.$fotoDate.''.$fotoClave.'.'.$file->clientExtension();
            
            $destinationPath = public_path(). '/uploads/DocEmpleados/'.$claveEmpleado;
            $file->move($destinationPath, $fotoName);

            $empleadoUpdate += [
                'identificacion' => $fotoName,
            ];
        }
        //dd($empleadoUpdate);

        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $fotoDate = date('YmdHis');
            $fotoClave = $claveEmpleado;
            $fotoName = 'FOTO'.$nuevoId.''.$fotoDate.''.$fotoClave.'.'.$file->clientExtension();
            
            $destinationPath = public_path(). '/uploads/DocEmpleados/'.$claveEmpleado;
            $file->move($destinationPath, $fotoName);

            $empleadoUpdate += [
                'foto' => $fotoName,
            ];
        }
        
       

        $empleadoUpdate += [
                'clave' => $claveEmpleado,
            ];
        
        $this->createActivity(
            auth()->user()->id,
            'Empleados',
            'Edito la informacion de Empleado: '.$empleadoUpdate['nombre'].' '.$empleadoUpdate['apellido1'].' '.$empleadoUpdate['apellido2'].' ('.$claveEmpleado.')'
        );
        $update = Empleado::find($nuevoId)->update($empleadoUpdate);

        return redirect('/empleado/'.$nuevoId.'/perfil');
        });
    
    }

    public function insertarEmpleado(Request $request){

        return DB::transaction(function () use ($request) {
        /* VALIDACIONES */
        $this->validate($request,[
            'nombre' => 'required',
            'apellido1' => 'required',
            'apellido2' => 'required',
            'fecha_entrada' => 'required',
            'fecha_nac' => 'required',
            'direccion' => 'required',
            'salario' => 'required',
            'puesto' => 'required|not_in:0'
        ]);
        
        /* EDAD*/
        $fechaNac = $request->fecha_nac;

        $edad = $this->getDiferenciaTiempo($fechaNac,1);
        
        /* TIEMPO EN LA EMPRESA*/
        $fechaIngreso = $request->fecha_entrada;
        $mesesTrabajando = $this->getDiferenciaTiempo($fechaIngreso,2);
        
        //GUARDANDO LOS ROLES QUE SELECCIONO
        /*
        $roles = "";
        if($request->Tic){
            $roles = $roles."Tic";
        }
        if($request->maquina_de_rollo){

            $roles = $roles."-Maquina de Rollo";   
        }
        if($request->maquina_de_varilla){
            $roles = $roles."-Maquina de Varilla";
        }
        if($request->cortador){
            $roles = $roles."-Cortador";
        }

        if($request->rol){
            $roles = $request->rol;
        }

        */


        $empleados = [
            'foto' => null,
            'identificacion' => null,
            'num_imss' => $request->imss,
            'acta_nacimiento' => null,
            'comprobante_domicilio' => null,
            'rfc' => $request->rfc,
            'curp' => $request->curp,
            'carta_no_antecedentes' => null,
            'clave' => 0,
            'nombre' => $request->nombre,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'fecha_entrada' => $request->fecha_entrada,
            'fecha_nac' => $request->fecha_nac,
            'tiempo_trabajando' => $mesesTrabajando,
            'edad' => $edad,
            'telefono1' => $request->telefono1,
            'telefono2' => $request->telefono2,
            'direccion' => $request->direccion,
            'email' => $request->email,
            'roles' => $request->puesto,
            'salario_semanal' => $request->salario,
        ];

        $save = Empleado::create($empleados);
        $empleadoUpdate = [];
        /*-----> CREANDO CLAVE DE EMPLEADO <--------------*/
        $fechaEmpleado = date('YmdHis');
        $claveEmpleado = $save->id.''.$fechaEmpleado;

        /*ADMINISTRANDO EL ULTIMO ID EN LA BD*/
        $nuevoId = $save->id;;
        
        if ($request->file('identificacion')) {
            $file = $request->file('identificacion');
            $fotoDate = date('YmdHis');
            $fotoClave = $claveEmpleado;
            $fotoName = 'ID'.$nuevoId.''.$fotoDate.''.$fotoClave.'.'.$file->clientExtension();
            
            $destinationPath = public_path(). '/uploads/DocEmpleados/'.$claveEmpleado;
            $file->move($destinationPath, $fotoName);

            $empleadoUpdate += [
                'identificacion' => $fotoName,
            ];
        }
        //dd($empleadoUpdate);

            if($request->hasFile('foto')){
                $file = $request->file('foto');
                $fotoDate = date('YmdHis');
                $fotoClave = $claveEmpleado;
                $fotoName = 'FOTO'.$nuevoId.''.$fotoDate.''.$fotoClave.'.'.$file->clientExtension();
                
                $destinationPath = public_path(). '/uploads/DocEmpleados/'.$claveEmpleado;
                $file->move($destinationPath, $fotoName);

                $empleadoUpdate += [
                    'foto' => $fotoName,
                ];
            }
        
        

            $empleadoUpdate += [
                'clave' => $claveEmpleado,
            ];

            $this->createActivity(
                auth()->user()->id,
                'Empleados',
                'Agrego un nuevo Empleado: '.$empleados['nombre'].' '.$empleados['apellido1'].' '.$empleados['apellido2'].' ('.$claveEmpleado.')'
            );
            $update = Empleado::find($nuevoId)->update($empleadoUpdate);

    	   return redirect('empleados/show');
        });
    }

    public function getDiferenciaTiempo($date,$option){
        $fdate = $date;
        $tdate = date('m/d/Y');
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%y');
        $months =  $interval->format('%m');
        //dd($months);

        if($option==1){
            return $days;    
        }
        return $months;
    }


}
