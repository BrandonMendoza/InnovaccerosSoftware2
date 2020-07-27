<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones'; 

    protected $fillable = ['id','trabajo_id','id_gastos_varios','total_materiales','id_mano_obra','total_mano_obra','total_insumos','subtotal_materiales','subtotal_mano_obra','subtotal_insumos','ganancia_materiales','ganancia_mano_obra','ganancia_insumos','estado','completado','subtotal_general','total_gastos_varios','total_general','ganancia_general','iva','total_iva','descripcion_individual','cantidad','unidad_medida_id'];

    public function trabajo(){
        return $this->belongsTo('App\Trabajo');
    }

    public function unidad_medida(){
        return $this->belongsTo('App\Unidad_medida_cotizacion');
    }
}
