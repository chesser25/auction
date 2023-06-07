<?php

namespace App\Factories\Abstracts;

use App\Services\Abstracts\BaseService;

interface IServiceFactory
{
    public function create(string $serviceClass, array $params = []) : ?BaseService;
}