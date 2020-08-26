<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos'; 

    protected $fillable = ['id','documento_id','nombre_sistema','nombre_usuario','nombre_real','url','tipo_documento','deleted_at','created_at','updated_at'];
}
