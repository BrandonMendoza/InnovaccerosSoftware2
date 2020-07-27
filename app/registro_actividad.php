<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class registro_actividad extends Model
{

	protected $guarded = [];

	public $table = "registro_actividad";
	
    public function users(){
		return $this->belongsToMany(User::class);
	}
}
