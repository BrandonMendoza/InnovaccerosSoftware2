<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accesorio extends Model
{
    protected $table = 'accesorios'; 

    protected $fillable = ['id','acero_id','numero_parte','descripcion','peso_kg','catalogo','created_at','updated_at','deleted_at'];

    public function Acero()
    {
        return $this->hasOne('App\MaterialAcero','id','acero_id');
    }
}
