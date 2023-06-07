<?php

namespace App\Factories;

use App\Factories\Abstracts\IServiceFactory;
use App\Services\Abstracts\BaseService;
use App\Services\Abstracts\IAuctionService;
use App\Services\AuctionService;
use Exception;

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
        catch (\Exception $e)
        {
            throw new Exception('Required additional params to create instance');
        }
    }
}