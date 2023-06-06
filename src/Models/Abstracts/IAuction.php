<?php

namespace App\Models\Abstracts;

use App\Response\Abstracts\Response;

interface IAuction
{
    public function start() : Response;
}