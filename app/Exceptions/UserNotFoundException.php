<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    public function report()
    {
        //
    }

    public function render(\Illuminate\Http\Request $request)
    {
        dd($request->all());
        // return response(...);
    }
}
