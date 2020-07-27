<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amonestacion extends Model
{
    public $table = "amonestaciones";
    protected $fillable = ['id','empleado_id','sancion','motivo','tipo'];
}
