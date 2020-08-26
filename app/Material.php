<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiales'; 

    protected $fillable = ['id','numero_parte','peso_kg','tipo_material_id','acero_id','medida_1','medida_2','medida_3','medida_4','catalogo'];

    public function Acero()
    {
        return $this->hasOne('App\MaterialAcero','id','acero_id');
    }

    public function Tipo_material()
    {
        return $this->hasOne('App\MaterialTipo','id','tipo_material_id');
    }

    public function Productos(){
        return $this->belongsToMany('App\Producto', 'Productos_materiales', 'material_id','producto_id')->withPivot('cantidad');
    }

    public function getNombreMaterial()
    {
        $nombreMedidas = $this->Tipo_material->simbolo.'-';
        $nombreMedidas .= $this->medida_1.'x'.$this->medida_2;
        if( $this->medida_3 != null){
            $nombreMedidas .= 'x'.$this->medida_3;
            if( $this->medida_4 != null){
                $nombreMedidas .= 'x'.$this->medida_4;
            }
        }
        return $nombreMedidas;
    }


    
}
