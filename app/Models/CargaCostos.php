<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargaCostos extends Model
{
    use HasFactory;
    protected $table = 'carga_costos';

    protected $fillable = ['cod_empresa','periodo','fecha','debe','doc_sdo','haber','total','glosa','cta_cod','cta_nom','cc_nom','cotipo','conum','anno','activo','cc_cod'];
}
