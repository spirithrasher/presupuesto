<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Meses;

class MesesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meses::truncate();
        
        $datos = array('Enero' => '01',
                        'Febrero' => '02',
                        'Marzo' => '03', 
                        'Abril' => '04', 
                        'Mayo' => '05', 
                        'Junio' => '05', 
                        'Julio' => '06',
                        'Agosto' => '08',
                        'Septiembre' => '09',
                        'Octubre' => '10',
                        'Noviembre' => '11',
                        'Diciembre' => '12');
        
        foreach ($datos as $mes => $numero) {
            Meses::create([
                'mes' => $mes,
                'numero' => $numero 
            ]);
        }
    }
}
