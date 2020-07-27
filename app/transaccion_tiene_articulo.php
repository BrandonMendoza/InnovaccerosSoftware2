<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaccion_tiene_articulo extends Model
{
    public $table = "transaccion_tiene_articulo";
    protected $fillable = ['id','articulo_id','transaccion_id', 'cantidad'];

    public function articulo(){
        return $this->belongsTo('App\Articulo');
    }

    public function transaccion(){
        return $this->belongsTo('App\TransaccionAlmacen');
    }
}
