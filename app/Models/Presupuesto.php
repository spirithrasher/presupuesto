<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    //PERIODO
    use HasFactory;
    protected $table = 'presupuesto';

    protected $fillable = ['cod_empresa','periodo','cuenta','centro_costo','monto','carga_id','anno'];
}
