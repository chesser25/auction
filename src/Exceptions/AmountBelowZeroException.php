<?php

namespace App\Exceptions;

use Exception;

class AmountBelowZeroException extends Exception
{
    protected $message = 'Amount below zero.';
}