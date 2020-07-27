<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaccionAlmacen extends Model
{
    public $table = "transaccion_almacen";
    protected $fillable = ['id','fecha','fecha2','hora','tipo','empleado_id','trabajo','cantidad_articulos'];
    protected $guarded = [];

    public function empleado(){
        return $this->belongsTo('App\Empleado');
    }
}
