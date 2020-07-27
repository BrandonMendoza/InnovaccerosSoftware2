<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maquinaria extends Model
{
    protected $fillable = ['foto','clave', 'categoria', 'tipo', 'color', 'marca','modelo', 'fecha', 'ultimo_serv', 'dias_sin_serv', 'alerta'];

}

