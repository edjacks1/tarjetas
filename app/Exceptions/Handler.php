<?php

namespace App\Exceptions;

//Servicios
use App\Services\CustomErrorService;
//Recursos
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;


class Handler extends ExceptionHandler
{
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if($exception instanceof ValidationException){
            return response()->json( $this->validationHandler($exception),400 );
        }elseif($exception instanceof ModelNotFoundException){
            return response()->json(null,402);
        }
        
        return parent::render($request, $exception);
    }

    private function validationHandler(Throwable $exception){
        $customErrorServ = new CustomErrorService($exception);
        $errors          = $customErrorServ->getCustomErrors();
        unset($customErrorServ);
        return [ 
            'status'  => FALSE,
            'type'    => 'FORM REQUEST ERROR',
            'errors'  => $errors
        ];
    }
}
