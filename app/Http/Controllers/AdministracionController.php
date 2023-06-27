<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Perfiles;
use Illuminate\Support\Facades\Log;

class AdministracionController extends Controller
{
    //

    public function listadousers(Request $request){

        // if ($request->ajax()) {
        //     $data = User::select('id','name','email','habilitado')->get();
        //     return Datatables::of($data)
        //             ->addIndexColumn()
        //             ->addColumn('rol', function($row){
        //                 foreach($row->getRoleNames() as $v){
        //                     return $v;
        //                 }
        //             })
        //             ->addColumn('habilitado', function($row){
        //                 Log::info(__METHOD__."::".__LINE__." ::: ".print_r($row,1));
        //                 $estado = ($row->habilitado == 1)? "Habilitado":"Deshabilitado";
        //                 return $estado;
        //             })
        //             ->addColumn('actions', function($row){
                    
        //                 $btn = '<a class="btn btn-outline-primary" href='.route('admin.user.editar',["id" => $row->id]).' role="button">Editar</a> ';
        //                 if($row->habilitado == 1){
        //                     $btn .= '<a class="btn btn-outline-danger" href="'.route('admin.user.deshabilitar', ['id' => $row->id]).'" role="button">Deshabilitar</a> ';
        //                 }else{
        //                     $btn .= '<a class="btn btn-outline-success" href="'.route('admin.user.habilitar', ['id' => $row->id]).'" role="button">Habilitar</a> ';
        //                 }
                        
        //                 return $btn;
        //             })
        //             ->rawColumns(['actions'])
        //             ->make(true);
        // }

        return view('admin/listadousers');
    }

    public function registrarusers(Request $request){
        
        $user = new User();

        if ($request->isMethod('post')) {
            
            Log::info(__METHOD__."::".__LINE__."POST ENTRANTE ::: ".print_r($request->all(),1));
            $validator = Validator::make($request->all(), [
                            'name' => ['required', 'string', 'max:255'],
                            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                            'password' => ['required', 'string', 'min:8', 'confirmed'],
                            'perfil_id' => ['required']
                        ]);
            
            
            if ($validator->fails()) {
                
                Log::info(__METHOD__."::".__LINE__." VALIDATOR ::: ".print_r($validator->fails(),1));
                return redirect('admin/registrar/user')
                            ->withErrors($validator)
                            ->withInput();
            }else{
                
                Log::info(__METHOD__."::".__LINE__." POST A GUARDAR::: ".print_r($request->all(),1));
                $user->guardar($request->all());
                return redirect()->route('admin.listado.users')
                            ->with('success','Usuario creado correctamente.');
                

            }
            
        }

        $perfiles = Perfiles::select('id','name')->get(); 
        return view('admin/registrarusers')
                ->with('perfiles',$perfiles);

    }

}
