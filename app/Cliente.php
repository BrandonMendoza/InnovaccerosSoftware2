<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes'; 

    protected $fillable = ['id','foto_cliente','clave_cliente','nombre_cliente', 'giro','tel_oficinas','contacto1','telefono1','contacto2','telefono2','email1','email2','direccion' ,'rfc','razon_social','codigo_postal'];
}


