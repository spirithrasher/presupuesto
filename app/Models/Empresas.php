<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Empresas extends Model
{
    use HasFactory;
    protected $table = 'empresas';

    public function validar($datos){        

        $regla = array();
        $reglas = array(
            'cod_empresa' => ['required'],
            'nombre_empresa' => ['required']            
        );

        $messages = array(
            'cod_empresa.required' => 'El codigo es obligatorio.',
            'nombre_empresa.required' => 'El nombre es obligatorio.',
        );
        
        $validaciones = array_merge($reglas,$regla);
        $validator = Validator::make($datos,$validaciones,$messages);
        return $validator;
    }

    public function guardar($datos){

        $this->cod_empresa = $datos['cod_empresa'];
        $this->nombre = $datos['nombre_empresa'];
        $this->activo = $datos['activo'];
        $this->save();
    }
}
