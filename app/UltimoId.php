<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UltimoId extends Model
{
    public $table = "ultimoid";

    protected $fillable = ['id', 'identificador', 'tabla'];
}
