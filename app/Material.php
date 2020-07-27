<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiales'; 

    protected $fillable = ['id','numero_parte','tipo_material_id','acero_id','peso_kg','longitud','anchura','espesor'];
}
