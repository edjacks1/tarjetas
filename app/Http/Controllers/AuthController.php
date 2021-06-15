<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests\Auth\RegisterFormRequest;
use App\Services\TokenService;

class AuthController extends Controller{

    private $request,$userModel;

    public function __construct(Request $request){
        $this->request   = $request;
        $this->userModel = new User();
        $this->tokenServ = new TokenService();
    }

    public function register(Request $request){
        // Validar los parametros de la peticion
        $formRequest  = new RegisterFormRequest($this->request);
        $formRequest  = $formRequest->request;
        // Almacenando al usuario
        User::create($formRequest->all());

        return response()->json([
            'status' => true, 
            'msg'    => "Se ha creado el usuario $request->first_name con exito."
        ]);
    }

    public function login(Request $request){
        // Validar los parametros de la peticion
        $this->validate($request, [
            'password'              => 'required',
            'email'                 => 'required'
        ]);

        $user = $this->userModel->checkUser( $this->request->all() );

        if( $user['status'] ){
            return response()->json([ 
                'status' => TRUE,
                'token'  => $this->tokenServ->generateJWT($user['data'])
            ], 200);
        }else{
            return response()->json([ 
                'status' => FALSE,
                'msg'    => 'Error el email o la contraseña son incorrectas.'
            ], 400);
        } 
    }
}
