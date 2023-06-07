<?php

namespace App\Services;

use App\Models\Abstracts\IBuyer;
use App\Models\Auction;
use App\Models\Bid;
use App\Services\Abstracts\BaseService;
use App\Services\Abstracts\IAuctionService;

class AuctionService extends BaseService implements IAuctionService
{
    private Auction $auction;
    private float $highestPrice;
    private IBuyer $winner;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
        $this->highestPrice = 0;
    }

    public function addBid(Bid $bid) : void
    {
        if($bid->getAmount() < $this->auction->getPrice())
        {
            return;
        }

        if($bid->getAmount() > $this->highestPrice)
        {
            $this->updateCurrentWinnerInfo($bid);
        }

        $this->auction->addBid($bid);
    }

    private function updateCurrentWinnerInfo(Bid $bid) : void
    {
        $this->highestPrice = $bid->getAmount();
        $this->winner = $bid->getBuyer();
    }

    public function start() : void
    {
        $this->auction->setWinner($this->winner);
        $winnerPrice = $this->getWinnerPrice();
        $this->auction->setWinnerPrice($winnerPrice);
    }

    private function getWinnerPrice() : int
    {
        $winnerPrice = 0;

        foreach($this->auction->getBids() as $bid)
        {
            $currentUserId = $bid->getBuyer()->getId();
            $bidAmount = $bid->getAmount();
            if(($bidAmount > $winnerPrice) && ($bidAmount < $this->highestPrice) && ($currentUserId != $this->winner->getId()))
            {
                $winnerPrice = $bidAmount;
            }
        }
        return $winnerPrice;
    }
}