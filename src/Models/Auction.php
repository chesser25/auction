<?php

namespace App\Models;

use App\Models\Abstracts\IAuction;
use App\Models\Abstracts\IBuyer;
use App\Models\Abstracts\Model;
use App\Response\Abstracts\Response;
use App\Response\AuctionResponse;

class Auction extends Model implements IAuction
{
    private float $price;
    private array $bids;
    private float $highestPrice;
    private IBuyer $winner;

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
            $this->updateCurrentWinnerInfo($bid);
        }

        array_push($this->bids, $bid);
    }

    private function updateCurrentWinnerInfo(Bid $bid)
    {
        $this->highestPrice = $bid->getAmount();
        $this->winner = $bid->getBuyer();
    }

    public function start() : Response
    {
        return new AuctionResponse($this->getWinner(), $this->getWinnerPrice());
    }

    private function getWinner() : IBuyer
    {
        return $this->winner;
    }

    private function getWinnerPrice() : float
    {
        $winnerPrice = 0;

        foreach($this->bids as $bid)
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