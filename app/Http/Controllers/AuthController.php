<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{

    public function register(Request $request){
        // Validar los parametros de la peticion
        $this->validate($request, [
            'phone_number'          => 'required',
            'first_name'            => 'required',
            'last_name'             => 'required',
            'password'              => 'required|confirmed',
            'email'                 => 'required|unique:users'
        ]);
        $request->merge(['password' => Hash::make($request->password)]);
        // Almacenando al usuario
        User::create($request->all());

        return response()->json([
            'status' => true, 
            'msg'    => "Se ha creado el usuario $request->first_name con exito."
        ]);
    }

}
