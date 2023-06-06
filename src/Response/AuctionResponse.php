<?php

namespace App\Response;

use App\Models\Buyer;

class AuctionResponse
{
    private ?Buyer $winner;
    private float $winnerPrice;

    public function __construct(?Buyer $winner, float $winnerPrice)
    {
        $this->winner = $winner;
        $this->winnerPrice = $winnerPrice;
    }

    public function getWinner() : Buyer
    {
        return $this->winner;
    }

    public function getWinnerPrice() : float
    {
        return $this->winnerPrice;
    }
}