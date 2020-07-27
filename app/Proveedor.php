<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = ['id','foto','nombre','sucursal','telefono','email','categoria','notas','favorito'];
}
