<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class RouteNotFoundException extends Exception
{
    public function render($request)
    {
        if($request->expectsJson()){
            return response([
             'errors' => 'Incorrect route!'
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
