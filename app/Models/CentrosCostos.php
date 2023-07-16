<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class CentrosCostos extends Model
{
    use HasFactory;
    protected $table = 'centros_costos';

    public function validar($datos){        

        $regla = array();
        $reglas = array(
            'cod_centro_costo' => ['required'],
            'nombre_centro_costo' => ['required']            
        );

        $messages = array(
            'cod_centro_costo.required' => 'El codigo es obligatorio.',
            'nombre_centro_costo.required' => 'El nombre es obligatorio.',
        );
        
        $validaciones = array_merge($reglas,$regla);
        $validator = Validator::make($datos,$validaciones,$messages);
        return $validator;
    }

    public function guardar($datos){

        $this->cod_centro_costo = $datos['cod_centro_costo'];
        $this->nombre = $datos['nombre_centro_costo'];
        $this->activo = $datos['activo'];
        $this->save();
    }

}
