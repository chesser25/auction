<?php

namespace App\Factories;

use App\Exceptions\MissingRequiredParamsException;
use App\Factories\Abstracts\IServiceFactory;
use App\Services\Abstracts\BaseService;
use App\Services\Abstracts\IAuctionService;
use App\Services\AuctionService;
use TypeError;

class ServiceFactory implements IServiceFactory
{
    public function create(string $serviceClass, array $params = []) : ?BaseService
    {
        try {
            switch($serviceClass)
            {
                case IAuctionService::class:
                case AuctionService::class:
                    return new AuctionService($params['auction']);
            }
        }
        catch (TypeError $e)
        {
            throw new MissingRequiredParamsException();
        }
    }
}