<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class NoPageException extends Exception
{
    public function __construct($message = '', $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report()
    {
        
    }


    public function render()
    {
        abort(404, $this->message);
    }
}
