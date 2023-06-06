<?php

namespace App\Factories;

use App\Factories\Abstracts\IModelFactory;
use App\Models\Abstracts\Model;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Buyer;
use Exception;

class ModelFactory implements IModelFactory
{
    private array $usersIds;
    public function __construct()
    {
        $this->usersIds = [];
    }

    public function create(string $modelClass, array $params = []) : ?Model
    {
        try {
            switch($modelClass)
            {
                case Auction::class:
                    return new Auction($params['price']);
                case Bid::class:
                    return new Bid();
                case Buyer::class:
                    if(in_array($params['id'], $this->usersIds))
                    {
                        throw new Exception('User exists with current id');
                    }
                    return new Buyer($this, $params['id'], $params['username']);
            }
        }
        catch (\Exception $e)
        {
            throw new Exception('Required additional params to create instance');
        }
    }
}