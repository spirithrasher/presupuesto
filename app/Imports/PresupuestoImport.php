<?php

namespace App\Imports;

use App\Models\Presupuesto;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;


class PresupuestoImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    private $registrocargaid = null;

    public function  __construct($registrocargaid){
        $this->registrocargaid = $registrocargaid;
    }

    public function model(array $row)
    {   
        Log::debug(__METHOD__."::".__LINE__." ROWS ::: ".print_r($row['cod_empresa'],1));

        $anno = substr($row['fecha'], 0, -2);
    
        return new Presupuesto([
            'cod_empresa' => $row['cod_empresa'],
            'periodo' => $row['fecha'],
            'cuenta' => $row['cuentas'],
            'centro_costo' => $row['c_costos'],
            'monto' => $row['monto'],
            'carga_id' => $this->registrocargaid,
            'anno' => $anno
        ]);
    }
}
