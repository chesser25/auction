<?php

namespace App\Exceptions;

use Exception;

class UserIdAlreadyExistsException extends Exception
{
    protected $message = 'User exists with current id';
}