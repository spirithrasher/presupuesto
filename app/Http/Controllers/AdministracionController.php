<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\PresupuestoImport;
use App\Imports\CostosImport;
use App\Models\User;
use App\Models\Perfiles;
use App\Models\ArchivosCarga;
use App\Models\RegistroCarga;
use App\Models\Presupuesto;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
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


    public function cargarpresupuesto(Request $request){
        
        if ($request->isMethod('post')) {
            
            $reglas = array(
                'file' => 'required|mimes:xls,xlsx',
                'periodo' => 'required',
                'estado' => 'required'
            );
            
            $validator = Validator::make($request->all(),$reglas);
            
            Log::info(__METHOD__."::".__LINE__." ::: ".print_r($validator->fails(),1));
            if ($validator->fails()) {
                return redirect('carga/presupuesto')
                            ->withErrors($validator)
                            ->withInput();
            }else{
                Log::info(__METHOD__."::".__LINE__." ::: ".print_r( $request->file(),1));
                Log::info(__METHOD__."::".__LINE__." ::: ".print_r($request->all(),1));
                $post = $request->all();
                $name = $request->file('file')->getClientOriginalName();
                $path = $request->file('file')->store('public/carga_presupuesto');

                $existeperiodo = RegistroCarga::where('periodo','=',$post['periodo'])->first();
                if(isset($existeperiodo->id)){
                    if($existeperiodo->estado == config("constants.CERRADA_NO")){
                        Presupuesto::where('carga_id','=',$existeperiodo->id)->delete();
                        ArchivosCarga::find($existeperiodo->archivo_id)->delete();
                        RegistroCarga::find($existeperiodo->id)->delete();

                        $archivo = new ArchivosCarga();
                        $archivo->name_file = $name;
                        $archivo->path = $path;
                        $archivo->tipo_carga = config("constants.PRESUPUESTO");
                        $archivo->user_carga = Auth::id();
                        $archivo->save();

                        $registrocarga = new RegistroCarga();
                        $registrocarga->archivo_id = $archivo->id;
                        $registrocarga->tipo_carga = config("constants.PRESUPUESTO");
                        $registrocarga->fecha_carga = date('Y-m-d');
                        $registrocarga->anno = date('Y');
                        $registrocarga->periodo = $post['periodo'];
                        $registrocarga->estado = $post['estado'];
                        $registrocarga->save();

                        $file = ArchivosCarga::find($archivo->id);
                        $import = Excel::import(new PresupuestoImport($registrocarga->id), $file->path);
                        Storage::delete($file->path);
                        return back()->with('success', 'Importación Exitosa');
                    }else{
                        return back()->with('success', 'El Periodo ya esta Cerrado');
                    }
                }else{

                    $archivo = new ArchivosCarga();
                    $archivo->name_file = $name;
                    $archivo->path = $path;
                    $archivo->tipo_carga = config("constants.PRESUPUESTO");
                    $archivo->user_carga = Auth::id();
                    $archivo->save();

                    $registrocarga = new RegistroCarga();
                    $registrocarga->archivo_id = $archivo->id;
                    $registrocarga->tipo_carga = config("constants.PRESUPUESTO");
                    $registrocarga->fecha_carga = date('Y-m-d');
                    $registrocarga->anno = date('Y');
                    $registrocarga->periodo = $post['periodo'];
                    $registrocarga->estado = $post['estado'];
                    $registrocarga->save();

                    $file = ArchivosCarga::find($archivo->id);
                    $import = Excel::import(new PresupuestoImport($registrocarga->id), $file->path);
                    Storage::delete($file->path);
                    return back()->with('success', 'Importación Exitosa');
                }
            }
            
        }
        $estado = array(config("constants.CERRADA_SI") => "Si",config("constants.CERRADA_NO") => "No" );
        return view('admin/cargarpresupuesto')
                ->with('estado',$estado);
    }

    public function listadocargapresupuesto(Request $request){
        if ($request->ajax()) {
            $data = RegistroCarga::select('id','periodo','fecha_carga','estado')->where('tipo_carga','=',config("constants.PRESUPUESTO"))->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('estado', function($row){
                        
                        $estado = ($row->estado == 1)? "Si":"No";
                        return $estado;
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
        }

        return view('admin/listadocargapresupuesto');
    }

    public function cargarcostos(Request $request){
        if ($request->isMethod('post')) {
            
            $reglas = array(
                'file' => 'required|mimes:xls,xlsx',
            );
            
            $validator = Validator::make($request->all(),$reglas);
            
            Log::info(__METHOD__."::".__LINE__." ::: ".print_r($validator->fails(),1));
            if ($validator->fails()) {
                return redirect('cargar/costos')
                            ->withErrors($validator)
                            ->withInput();
            }else{
                Log::info(__METHOD__."::".__LINE__." ::: ".print_r( $request->file(),1));
                Log::info(__METHOD__."::".__LINE__." ::: ".print_r($request->all(),1));
                $post = $request->all();
                $name = $request->file('file')->getClientOriginalName();
                $path = $request->file('file')->store('public/carga_costos');

                $archivo = new ArchivosCarga();
                $archivo->name_file = $name;
                $archivo->path = $path;
                $archivo->tipo_carga = config("constants.COSTOS");
                $archivo->user_carga = Auth::id();
                $archivo->save();

                $registrocarga = new RegistroCarga();
                $registrocarga->archivo_id = $archivo->id;
                $registrocarga->tipo_carga = config("constants.COSTOS");
                $registrocarga->fecha_carga = date('Y-m-d');
                $registrocarga->anno = date('Y');
                $registrocarga->periodo = isset($post['periodo'])?$post['periodo']:NULL;
                $registrocarga->estado = isset($post['estado'])?$post['estado']:NULL;
                $registrocarga->save();

                $file = ArchivosCarga::find($archivo->id);
                $import = Excel::import(new CostosImport(), $file->path);
                Storage::delete($file->path);
                return back()->with('success', 'Importación Exitosa');
                
            }
            
        }
        // $estado = array(config("constants.CERRADA_SI") => "Si",config("constants.CERRADA_NO") => "No" );
        return view('admin/cargarcostos');
    }


}
