<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    protected $table = 'procesos'; 

    protected $fillable = ['id','es_primero','es_ultimo','es_estatico','nombre','simbolo','color','texto_color','created_at','updated_at','porcentaje','activo','orden'];
}
