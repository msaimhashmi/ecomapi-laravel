<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ProductModelNotFoundException extends Exception
{
    public function render($request)
    {
        if($request->expectsJson()){
            return response([
             'errors' => 'Product Model Not Found!'
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
