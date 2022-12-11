<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    public function report(Exception $e)
    {
        parent::report($e);
    }

    public function render($request, Exception $e)
    {
        if ($e instanceof NotFoundHttpException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
            return redirect('/notfound');
            //return \Response::json(['error' => 'Sorry, we can\'t find that.'], 404);
        }
        if ($e instanceof TokenMismatchException){
            /*if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Su sesion a expirado, ingrese de nuevo al sistema e intente de nuevo'
                ], $e->getStatusCode());
            };*/
            // Redirect to a form. Here is an example of how I handle mine
            return redirect($request->fullUrl())->with('csrf_error',"Su sesion a expirado, ingrese de nuevo al sistema e intente de nuevo.");
        }
        return parent::render($request, $e);
    }
}
