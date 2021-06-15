<?php

namespace App\Servicios;

//Exepciones
use Exception;
//JWT
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
//Modelos
use App\Models\Usuario;

class TokenService {

    private $modeloUsuario;
    private $minutos = 60;

    public function __construct(){
        $this->modeloUsuario = new Usuario();
    }

    function generarJWT(Usuario $usuario) : string{
        $atributos = [
            'iss' => "lumen-jwt",                   // algo hace.
            'sub' => $usuario,                      // Usuario.
            'iat' => time(),                        // Tiempo de cuando fue creado.
            'exp' => time() + (60 * $this->minutos) // Tiempo de expiracion.
        ];
        return JWT::encode($atributos, env('JWT_SECRET'));
    }
    
    function validarToken( $token, $recordarToken) : array{
        //Validar que el token no venga nulo
        if( is_null($token) ){
            if( is_null($recordarToken) ){//Si no existe el recordar token mandar Falso
                return [ 'estatus' => FALSE, 'mensaje' => 'Error mientras se obtenian las creedenciales del usario.' ];
            }else{
                return $this->modeloUsuario->obtenerUsuarioPorRecordarToken($recordarToken); //Validar que el token exista regreso Estatus = True y Data como usuario
            }
        }

        try {
            $credenciales = JWT::decode($token, env('JWT_SECRET'), ['HS256']); //Decodifico el token
            $usuario      = Usuario::find($credenciales->sub->id);
        }catch(ExpiredException $e) {
            if( !is_null($recordarToken) ){
                return $this->modeloUsuario->obtenerUsuarioPorRecordarToken($recordarToken);  //Validar que el token exista regreso Estatus = True y Data como usuario
            }
            return ['estatus' => FALSE, 'mensaje' => 'El token ha expirado.']; //Mandar falso si no existe el recordar token cuando expira
        } catch(Exception $e) {
            return ['estatus' => FALSE, 'mensaje' => 'Error mientras se decodificaba el token.'];
        }

        if( is_null($usuario) ){
            return ['estatus' => FALSE, 'mensaje' => 'El token no coincide con ningun registro.'];
        }else{
            return ['estatus' => TRUE, 'data' => $usuario];
        }
    }
    
}