<?php

namespace App\Factories;

use App\Exceptions\MissingRequiredParamsException;
use App\Factories\Abstracts\IServiceFactory;
use App\Services\Abstracts\BaseService;
use App\Services\Abstracts\IAuctionService;
use App\Services\AuctionService;

class ServiceFactory implements IServiceFactory
{
    public function create(string $serviceClass, array $params = []) : ?BaseService
    {
        switch($serviceClass)
        {
            case IAuctionService::class:
            case AuctionService::class:
                if(!isset($params['auction']))
                {
                    throw new MissingRequiredParamsException();
                }
                return new AuctionService($params['auction']);
        }
    }
}