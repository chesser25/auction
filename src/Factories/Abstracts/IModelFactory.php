<?php

namespace App\Factories\Abstracts;

use App\Models\Abstracts\Model;

interface IModelFactory
{
    public function create(string $modelClass, array $params = []) : ?Model;
}