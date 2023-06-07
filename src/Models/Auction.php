<?php

namespace App\Models;

use App\Models\Abstracts\IBuyer;
use App\Models\Abstracts\Model;

class Auction extends Model
{
    private int $price;
    private int $winnerPrice;
    private IBuyer $winner;
    private array $bids;

    public function __construct(float $price)
    {
        $this->price = $price;
        $this->bids = [];
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getWinner() : IBuyer
    {
        return $this->winner;
    }

    public function setWinner(IBuyer $winner) : void
    {
        $this->winner = $winner;
    }

    public function getWinnerPrice() : int
    {
        return $this->winnerPrice;
    }
    
    public function setWinnerPrice(int $winnerPrice) : void
    {
        $this->winnerPrice = $winnerPrice;
    }

    public function getBids() : array
    {
        return $this->bids;
    }

    public function addBid(Bid $bid) : void
    {
        array_push($this->bids, $bid);
    }
}