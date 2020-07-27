<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialTipo extends Model
{
    protected $table = 'tipo_material'; 

    protected $fillable = ['id','nombre','simbolo','cantidad_datos','created_at','updated_at','deleted_at'];
}
