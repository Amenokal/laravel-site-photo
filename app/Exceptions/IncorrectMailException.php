<?php

namespace App\Exceptions;

use Exception;

class IncorrectMailException extends Exception
{
    public $message = "Email incorrect";

    public function render($request, Exception $exception)
    {
        return view('login', [
            'error' => true,
        ]);
    }

}
