<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario_empleado extends Model
{
    protected $table = 'comentarios_empleado';
    protected $fillable = ['id','comentario','user_id','empleado_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
