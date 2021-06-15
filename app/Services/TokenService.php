<?php

namespace App\Services;

//Exepciones
use Exception;
//JWT
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
//Modelos
use App\Models\User;

class TokenService {

    private $minutes = 60;

    function generateJWT(User $user) : string{
        $payload = [
            'iss' => "lumen-jwt",                   // algo hace.
            'sub' => $user,                         // Usuario.
            'iat' => time(),                        // Tiempo de cuando fue creado.
            'exp' => time() + (60 * $this->minutes) // Tiempo de expiracion.
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    }
    
    function validateToken( $token ) : array{
        //Validar que el token no venga nulo
        if( is_null($token) ){
            return [ 'status' => FALSE, 'msg' => 'Error mientras se obtenian las creedenciales del usario.' ];
        }
        try {
            $credentials  = JWT::decode($token, env('JWT_SECRET'), ['HS256']); //Decodifico el token
            $user         = User::find($credentials->sub->id);
        }catch(ExpiredException $e) {
            return ['status' => FALSE, 'msg' => 'El token ha expirado.']; //Mandar falso si no existe el recordar token cuando expira
        } catch(Exception $e) {
            return ['status' => FALSE, 'msg' => 'Error mientras se decodificaba el token.'];
        }

        if( is_null($user) ){
            return ['status' => FALSE, 'msg' => 'El token no coincide con ningun registro.'];
        }else{
            return ['status' => TRUE, 'data' => $user];
        }
    }
    
}