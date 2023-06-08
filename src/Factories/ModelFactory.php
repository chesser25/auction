<?php

namespace App\Factories;

use App\Exceptions\AmountBelowZeroException;
use App\Exceptions\MissingRequiredParamsException;
use App\Exceptions\UserIdAlreadyExistsException;
use App\Factories\Abstracts\IModelFactory;
use App\Models\Abstracts\Model;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Buyer;

class ModelFactory implements IModelFactory
{
    private array $usersIds;
    public function __construct()
    {
        $this->usersIds = [];
    }

    public function create(string $modelClass, array $params = []) : ?Model
    {
        switch($modelClass)
        {
            case Auction::class:
                if(!isset($params['price']))
                {
                    throw new MissingRequiredParamsException();
                }
                if($params['price'] < 0)
                {
                    throw new AmountBelowZeroException();
                }
                return new Auction($params['price']);
            case Bid::class:
                return new Bid();
            case Buyer::class:
                if(!isset($params['id']))
                {
                    throw new MissingRequiredParamsException();
                }
                if(in_array($params['id'], $this->usersIds))
                {
                    throw new UserIdAlreadyExistsException();
                }
                array_push($this->usersIds, $params['id']);
                return new Buyer($this, $params['id'], $params['username']);
        }
    }
}