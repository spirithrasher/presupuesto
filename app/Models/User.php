<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function perfiles(){

        return $this->hasOne('App\Models\Perfiles','id','perfil_id');
    }

    public function validaredit($datos){

        $rules = array();
        if(isset($datos['check_pass'])){
            $rules = array('password' => ['required', 'string', 'min:8', 'confirmed']);
        }
        

        $reglas = array(
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'perfil_id' => ['required']
        );
        
        $validaciones = array_merge($reglas,$rules);
        $validator = Validator::make($datos,$validaciones);
        return $validator;
    }

    public function guardar($datos){
        Log::info(__METHOD__."::".__LINE__." GUARDAR ::: ".print_r($datos,1));

        $this->name = (isset($datos['name']))? $datos['name'] : "";
        $this->email = (isset($datos['email']))? $datos['email'] : "";
        $this->password = (isset($datos['password']))? Hash::make($datos['password']) : "";
        $this->perfil_id = (isset($datos['perfil_id']))? $datos['perfil_id'] : "";
        $this->save();
    }


}
