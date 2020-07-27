<?php

namespace InnovaccerosSoftware;

use Illuminate\Database\Eloquent\Model;

class Superpassword extends Model
{
    protected $table = "superpasswords";

    protected $fillable = ['id','password'];
}
