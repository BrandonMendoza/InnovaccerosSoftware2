<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cotizacion_tiene_material extends Model
{
    public $table = "cotizacion_tiene_material";
    protected $fillable = ['id','id_cotizacion','uso','material_nombre','cantidad','costo_unitario','subtotal_costo','ganancia','total'];
}
