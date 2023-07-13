<?php

namespace App\Imports;

use App\Models\CargaCostos;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class CostosImport implements ToModel,WithHeadingRow,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        if($row['cod_empresa'] != "" ){
            $fecha = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha']);
            Log::debug(__METHOD__."::".__LINE__." ROWS ::: ".print_r($row['cc_cod'],1));
            // Log::debug(__METHOD__."::".__LINE__." ROWS ::: ".print_r($row['vencimie'],1));
            // Log::debug(__METHOD__."::".__LINE__." ROWS ::: ".print_r($row['cofecha'],1));
            return new CargaCostos([
                'cod_empresa' => $row['cod_empresa'],
                'periodo' => $row['periodo'],
                'fecha' => $fecha->format('Y-m-d'),
                'debe' => $row['debe'],
                'doc_sdo' => $row['doc_sdo'],
                'haber' => $row['haber'],
                'total' => $row['total'],
                'glosa' => $row['glosacon'],
                'cta_cod' => $row['cta_cod'],
                'cta_nom' => $row['cta_nom'],
                'cc_nom' => $row['cc_nom'],
                'cc_cod' => $row['cc_cod'],
                'cotipo' => $row['cotipo'],
                'conum' => $row['conum'],
                'anno' => date('Y')
                // 'activo' => $row['']
            ]);
        }
        
        
    }

    public function rules(): array
    {
        return [
            // 'fecha' => 'dateformat:DD-MM-YYYY'
        ];
    }
}
