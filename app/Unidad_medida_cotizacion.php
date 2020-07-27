<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad_medida_cotizacion extends Model
{
    public $table = "unidades_medida";
    protected $fillable = ['id','unidad_medida'];
}
