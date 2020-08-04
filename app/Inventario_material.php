<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario_material extends Model
{
    protected $table = 'Inventario_materiales'; 

    protected $fillable = ['id','material_cliente_id','cliente_id','status_id','orden_compra_id','proyecto','tba','cantidad','item','plan_corte','work_order','heat_number','created_at','updated_at','recibido_el','cantidad_faltante','is_editing'];

    public function Material_cliente()
    {
        return $this->hasOne('App\MaterialCliente','id','material_cliente_id');
    }

    public function Cliente()
    {
        return $this->hasOne('App\Cliente','id','cliente_id');
    }

    public function Status()
    {
        return $this->hasOne('App\StatusInventarioMaterial','id','status_id');
    }

    public function getPesoMaterial(){
        if($this->catalogo == 1){
            $pesoUnitario = $this->Material_cliente->Material->peso_kg;
            $pesoTotal =  (float)$pesoUnitario*(float)$this->cantidad;
        }else{
            $pesoUnitario = $this->Material_cliente->Accesorio->peso_kg;
            $pesoTotal =  (float)$pesoUnitario*(float)$this->cantidad;
        }
       
        return $pesoTotal;
    }
    
}
