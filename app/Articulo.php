<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
	public $table = "articulos";
    protected $fillable = ['id','clave','foto','descripcion','categoria','marca','unidad_medida','existencia','minimo','tipo','numero_parte'];
}
