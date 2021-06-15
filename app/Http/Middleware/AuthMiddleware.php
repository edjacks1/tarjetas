<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\TokenService;

class AuthMiddleware
{
    public function handle($request, Closure $next){
        $tokenService = new TokenService();

        $token         = $request->headers->get('authorization');
        $token         = (($token === '') ? NULL : $token);

        $RESPONSE = $tokenService->validateToken($token);
        
        if( $RESPONSE['status'] ){
            //Pongo el usuario autentificado en el request
            $request->auth = $RESPONSE['data'];
            return $next($request);
        }else{
            return response()->json($RESPONSE, 401); //Mando la informacion del error al front
        }
    }
}
