<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusInventarioMaterial extends Model
{
    protected $table = 'status_inventario_materiales'; 
    protected $fillable = ['id','nombre','descripcion','color'];
}
