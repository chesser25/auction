<?php

namespace App\Models;

class Buyer
{
    private int $id;
    private string $name;

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function makeBid(Auction $auction, float $amount) : void
    {
        $bid = new Bid();
        $bid->setAmount($amount);
        $bid->setBuyer($this);
        
        $auction->addBid($bid);
    }
}