<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialAcero extends Model
{
    protected $table = 'aceros'; 

    protected $fillable = ['id','nombre','simbolo','deleted_at'];
}
