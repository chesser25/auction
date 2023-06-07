<?php

namespace App\Models;

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
        $bid = $this->modelFactory->create(Bid::class);
        $bid->setAmount($amount);
        $bid->setBuyer($this);
        
        $auctionService->addBid($bid);
    }
}