<?php

namespace App\Models;

use App\Response\AuctionResponse;

class Auction
{
    private float $price;
    private array $bids;
    private float $highestPrice;

    public function __construct(float $price)
    {
        $this->price = $price;
        $this->bids = [];
        $this->highestPrice = 0;
    }

    public function addBid(Bid $bid) : void
    {
        if($bid->getAmount() < $this->price)
        {
            return;
        }

        if($bid->getAmount() > $this->highestPrice)
        {
            $this->highestPrice = $bid->getAmount();
        }

        array_push($this->bids, $bid);
    }

    public function start() : AuctionResponse
    {
        $winnerBuyer = null;
        $winnerPrice = 0;

        foreach($this->bids as $bid)
        {
            $bidAmount = $bid->getAmount();
            if(($bidAmount > $winnerPrice) && ($bidAmount < $this->highestPrice))
            {
                $winnerPrice = $bidAmount;
            }
            if($bidAmount == $this->highestPrice)
            {
                $winnerBuyer = $bid->getBuyer();
            }
        }
        return new AuctionResponse($winnerBuyer, $winnerPrice);
    }
}