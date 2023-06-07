<?php

namespace App\Models;

use App\Exceptions\AmountBelowZeroException;
use App\Factories\Abstracts\IModelFactory;
use App\Models\Abstracts\IBuyer;
use App\Services\Abstracts\IAuctionService;

class Buyer extends User implements IBuyer
{
    private IModelFactory $modelFactory;
    public function __construct(IModelFactory $modelFactory, int $id, string $name)
    {
        parent::__construct($id, $name);
        $this->modelFactory = $modelFactory;
    }
    
    public function makeBid(IAuctionService $auctionService, int $amount) : void
    {
        if($amount < 0)
        {
            throw new AmountBelowZeroException();
        }

        $bid = $this->modelFactory->create(Bid::class);
        $bid->setAmount($amount);
        $bid->setBuyer($this);
        
        $auctionService->addBid($bid);
    }
}