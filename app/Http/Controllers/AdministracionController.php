<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Perfiles;
use Illuminate\Support\Facades\Log;
use DataTables;

class AdministracionController extends Controller
{
    //

    public function listadousers(Request $request){

        if ($request->ajax()) {
            $data = User::select('id','name','email','perfil_id','habilitado')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('perfil_id', function($row){
                        
                        $perfil = $row->perfiles->name;
                        return $perfil;
                    })
                    ->addColumn('habilitado', function($row){
                        
                        $estado = ($row->habilitado == 1)? "Habilitado":"Deshabilitado";
                        return $estado;
                    })
                    ->addColumn('actions', function($row){
                    
                        $btn = '<a class="btn btn-outline-primary" href='.route('admin.editar.user',["id" => $row->id]).' role="button">Editar</a> ';
                        // if($row->habilitado == 1){
                        //     $btn .= '<a class="btn btn-outline-danger" href="'.route('admin.user.deshabilitar', ['id' => $row->id]).'" role="button">Deshabilitar</a> ';
                        // }else{
                        //     $btn .= '<a class="btn btn-outline-success" href="'.route('admin.user.habilitar', ['id' => $row->id]).'" role="button">Habilitar</a> ';
                        // }
                        
                        return $btn;
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
        }

        return view('admin/listadousers');
    }

    public function registrarusers(Request $request){
        
        $user = new User();

        if ($request->isMethod('post')) {
            
            Log::info(__METHOD__."::".__LINE__." POST ENTRANTE ::: ".print_r($request->all(),1));
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
                
                $user->guardar($request->all());
                return redirect()->route('admin.listado.users')
                            ->with('success','Usuario creado correctamente.');
                

            }
            
        }

        $perfiles = Perfiles::select('id','name')->get(); 
        return view('admin/registrarusers')
                ->with('perfiles',$perfiles);

    }

    public function editaruser(Request $request, $id){
        
        $user = User::find($id);

        if ($request->isMethod('post')) {
            
            Log::info(__METHOD__."::".__LINE__." ::: ".print_r($request->all(),1));
            $validator = $user->validaredit($request->all());
            
            if ($validator->fails()) {
                
                return redirect('admin/editar/user'.$id)
                            ->withErrors($validator)
                            ->withInput();
            }else{
                
                Log::info(__METHOD__."::".__LINE__." ::: ".print_r($request->all(),1));
                $user->guardaredicion($request->all());
                return redirect()->route('aadmin.listado.users')
                            ->with('success','Usuario editado correctamente.');
                

            }
            
        }
        $perfiles = Perfiles::select('id','name')->get(); 
        return view('admin/editarusers')
                    ->with('user',$user)
                    ->with('perfiles',$perfiles);

    }

    public function habilitaruser($id){

        $deshabilitado = User::find($id);
        $deshabilitado->habilitado = 1;
        $deshabilitado->save();

        return redirect()->route('admin.users')
                        ->with('success','Usuario habilitado correctamente.');
    }

    public function deshabilitaruser($id){

        $deshabilitado = USer::find($id);
        $deshabilitado->habilitado = 0;
        $deshabilitado->save();

        return redirect()->route('admin.users')
                        ->with('success','Usuario Deshabilitado correctamente.');
    }

}
