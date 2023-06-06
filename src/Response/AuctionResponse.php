<?php

namespace App\Response;

use App\Models\Abstracts\IBuyer;
use App\Response\Abstracts\Response;

class AuctionResponse extends Response
{
    private ?IBuyer $winner;
    private float $winnerPrice;

    public function __construct(?IBuyer $winner, float $winnerPrice)
    {
        $this->winner = $winner;
        $this->winnerPrice = $winnerPrice;
    }

    public function getWinner() : IBuyer
    {
        return $this->winner;
    }

    public function getWinnerPrice() : float
    {
        return $this->winnerPrice;
    }
}