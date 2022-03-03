<?php

namespace App\Exceptions;

use Exception;

class IncorrectPasswordException extends Exception
{
    public $message = "Mot de passe incorrect";

    public function render($request, Exception $exception)
    {
        return view('login', [
            'error' => true,
        ]);
    }
}
