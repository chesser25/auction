<?php

namespace App\Exceptions;

use Exception;

class MissingRequiredParamsException extends Exception
{
    protected $message = 'Required additional params to create instance';
}