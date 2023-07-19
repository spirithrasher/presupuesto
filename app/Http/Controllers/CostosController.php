<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meses;
use App\Models\Empresas;
use App\Models\CentrosCostos;
use App\Models\CargaCostos;
use Illuminate\Support\Facades\Log;


class CostosController extends Controller
{
    public function costosempresa(Request $request){
        
        $tablaResultado = array();
        if ($request->isMethod('post')) {

            Log::info(__METHOD__."::".__LINE__." ::: ".print_r($request->all(),1));
            $post = $request->all();
            $desdemes = (strlen($post['desde']) == 1)? '0'.$post['desde'] : $post['desde'];
            $desde = $post['annos'].$desdemes;
            $cargacostos = CargaCostos::where('periodo','=',$desde)->get();
            foreach($cargacostos as $cargacosto){
                $tablaResultado[$cargacosto->cod_empresa][$cargacosto->cc_cod]['ingresos'] = $cargacosto->haber;
                $tablaResultado[$cargacosto->cod_empresa][$cargacosto->cc_cod]['costos'] = $cargacosto->debe;
                $tablaResultado[$cargacosto->cod_empresa][$cargacosto->cc_cod]['total'] = $cargacosto->total;
            }

            // dd($tablaResultado);
        }
        
        $empresas = Empresas::all();
        $centrosCostos = CentrosCostos::all();
        $meses = Meses::all();
        $annos = array('2023');

        $datostabla = array();
        foreach($empresas as $e){
            foreach($centrosCostos as $cc){
                if($cc->cod_empresa == $e->cod_empresa){
                    $datostabla[$e->nombre][$cc->cod_centro_costo] = $cc->nombre;
                }else{
                    $datostabla[$e->nombre]= "";
                }
            }
        }

        return view('costos/costosempresas')
                ->with('tablaResultado',$tablaResultado)
                ->with('datosTabla',$datostabla)
                ->with('empresas',$empresas)
                ->with('centrosCostos',$centrosCostos)
                ->with('annos',$annos)
                ->with('meses',$meses);
    }
}
