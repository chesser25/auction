<?php

namespace App\Commands\Abstracts;

interface ICommand
{
    public function execute() : void;
}