<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos'; 

    protected $fillable = ['id','id_cotizacion','concepto','costo','subtotal','ganancia','total'];
}
